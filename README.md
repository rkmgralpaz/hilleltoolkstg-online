# hilleltoolkstg-online

Theme principal del sitio WordPress Hillel Toolkit Staging.

## Desarrollo Local

- **Proyecto Local**: `/Users/rebecakarenmossetto/Local Sites/hilleltoolkstg-online/app/public/wp-content/themes/hillel-combating-antisemitism/`
- **URL local**: http://hilleltoolkstg-online.local
- **Theme name**: hillel-combating-antisemitism

## Workflow

1. **Cambios en GitHub**: Se hacen vía Claude o manualmente en este repo
2. **Pull local**: `git pull origin main` desde `~/github-repos/hilleltoolkstg-online`
3. **Deploy a producción**: FTP manual al servidor de producción

## Scripts disponibles

```bash
# Compilar Sass (watch mode)
npm run sass

# Instalar dependencias
npm install
```

## Estructura del Theme

Este theme usa:
- **Sass** para estilos (`scss/style.scss` → `style.css`)
- Archivos compilados no se commitean a GitHub

## Notas

- `node_modules/` está excluido del repo (ver `.gitignore`)
- Mismo theme que campus4allorg (hillel-combating-antisemitism)
- Después de hacer `git pull`, si hay cambios en `package.json`, correr `npm install`
