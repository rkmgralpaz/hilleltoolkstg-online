#!/bin/bash

# Habilitar depuración para detectar errores si ocurren
set -e

# === Configurables (override via env when running) ===
# Defaults keep current project behavior; override like:
# SCSS_DIR_ROOT="assets/scss" JS_DIR_ROOT="src/js/layouts" PHP_DIR_ROOT="template-parts" MAIN_JS_FILE="src/js/main.js" ./create-module-files.sh my-block
: "${SCSS_DIR_ROOT:=scss/main}"
: "${JS_DIR_ROOT:=js/js-modules}"
: "${PHP_DIR_ROOT:=partials}"
: "${MAIN_JS_FILE:=js/main.js}"
# ================================================

# Verificar si se pasó un argumento (nombre)
if [ -z "$1" ]; then
    echo "Error: Debes proporcionar un nombre."
    exit 1
fi

# Preguntar si es un módulo, una página o un componente
read -p "¿Es un módulo, una página o un componente? (module/page/component): " TYPE
TYPE=$(echo "$TYPE" | tr '[:upper:]' '[:lower:]') # Convertir a minúsculas

if [[ "$TYPE" != "module" && "$TYPE" != "page" && "$TYPE" != "component" ]]; then
    echo "Error: Opción inválida. Usa 'module', 'page' o 'component'."
    exit 1
fi

NAME="$1"

# Validar el nombre (que no contenga caracteres raros)
if [[ ! "$NAME" =~ ^[a-zA-Z0-9_-]+$ ]]; then
    echo "Error: El nombre contiene caracteres no válidos."
    exit 1
fi

# Configurar rutas según el tipo
case "$TYPE" in
  page)
    PREFIX="page"
    PATH_PREFIX="pages"
    SCSS_IMPORT_FILE="${SCSS_DIR_ROOT}/_pages.scss"
    ;;
  module)
    PREFIX="block"
    PATH_PREFIX="blocks"
    SCSS_IMPORT_FILE="${SCSS_DIR_ROOT}/_blocks.scss"
    ;;
  component)
    PREFIX="component"
    PATH_PREFIX="components"
    SCSS_IMPORT_FILE="${SCSS_DIR_ROOT}/_components.scss"
    ;;
esac

# Rutas de los archivos (basadas en configurables)
SCSS_FILE="${SCSS_DIR_ROOT}/${PATH_PREFIX}/_${PREFIX}-${NAME}.scss"
JS_FILE="${JS_DIR_ROOT}/${PATH_PREFIX}/${PREFIX}-${NAME}.js"
PHP_FILE="${PHP_DIR_ROOT}/${PATH_PREFIX}/${PREFIX}-${NAME}.php"

# Crear directorios si no existen
mkdir -p "${SCSS_DIR_ROOT}/${PATH_PREFIX}" "${JS_DIR_ROOT}/${PATH_PREFIX}" "${PHP_DIR_ROOT}/${PATH_PREFIX}"

# Crear archivo SCSS
if [ ! -f "$SCSS_FILE" ]; then
    echo " " > "$SCSS_FILE"
    echo "Archivo SCSS creado: $SCSS_FILE"
else
    echo "El archivo SCSS ya existe: $SCSS_FILE"
fi

# Crear archivo JS
if [ ! -f "$JS_FILE" ]; then
    echo -e "const startModule = (block) => {\n  block.classList.add('loaded');\n};\n\nexport { startModule };" > "$JS_FILE"
    echo "Archivo JS creado: $JS_FILE"
else
    echo "El archivo JS ya existe: $JS_FILE"
fi

# Crear archivo PHP
if [ ! -f "$PHP_FILE" ]; then
    touch "$PHP_FILE"
    echo "Archivo PHP creado: $PHP_FILE"
else
    echo "El archivo PHP ya existe: $PHP_FILE"
fi

# Añadir importación SCSS al archivo correspondiente
IMPORT_LINE="@forward '${PATH_PREFIX}/${PREFIX}-${NAME}';"
if ! grep -q "$IMPORT_LINE" "$SCSS_IMPORT_FILE"; then
    echo -e "\n$IMPORT_LINE" >> "$SCSS_IMPORT_FILE"
    echo "Importación SCSS añadida: $IMPORT_LINE"
else
    echo "La importación SCSS ya existe: $IMPORT_LINE"
fi

# Añadir módulo al main.js
JS_MODULE_ENTRY="{ selector: '.${PREFIX}-${NAME}', src: './layouts/${PATH_PREFIX}/${PREFIX}-${NAME}.js?ver='+siteVersion },"
if ! grep -q "$JS_MODULE_ENTRY" "$MAIN_JS_FILE"; then
    sed -i '' "/jsModules: \[/a\\
    $JS_MODULE_ENTRY
    " "$MAIN_JS_FILE"
    echo "Entrada JS añadida a ${MAIN_JS_FILE}: $JS_MODULE_ENTRY"
else
    echo "La entrada JS ya existe en ${MAIN_JS_FILE}."
fi

# Mensaje de éxito
echo "¡${PREFIX^} '${NAME}' creado exitosamente! 🚀"