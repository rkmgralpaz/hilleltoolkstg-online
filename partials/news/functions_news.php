<?php

// ------------------------------
// News Custom Query Modification
// ------------------------------

add_action('pre_get_posts', 'custom_posts_per_page_for_news');

function custom_posts_per_page_for_news($query)
{
    if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'news') {
        $query->set('posts_per_page', 6);
    }
}

/**
 * Agregar checkbox "show_image" a los items de la columna derecha (seleccionados) del relationship en ACF
 * Y excluir posts entre los 3 campos featured
 * Colocar en functions.php del tema
 */

// ============================================================================
// PARTE 1: EXCLUIR POSTS ENTRE LOS CAMPOS
// ============================================================================

add_filter('acf/fields/relationship/query', 'exclude_posts_between_featured_fields_v2', 10, 3);
add_filter('acf/fields/post_object/query', 'exclude_posts_between_featured_fields_v2', 10, 3);

function exclude_posts_between_featured_fields_v2($args, $field, $post_id) {
    // Solo aplicar a nuestros campos específicos
    $target_fields = ['featured_news_bottom_row', 'featured_news_left_column', 'featured_news_right_column', 'main_featured_news_item'];
    
    if (!in_array($field['name'], $target_fields)) {
        return $args;
    }
    
    $exclude_ids = [];
    
    // Durante AJAX, leer los valores que JavaScript envía
    if (defined('DOING_AJAX') && DOING_AJAX) {
        if (isset($_POST['excluded_posts'])) {
            $excluded_from_js = json_decode(stripslashes($_POST['excluded_posts']), true);
            if (is_array($excluded_from_js)) {
                //error_log("✅ Recibidos posts excluidos desde JS: " . implode(', ', $excluded_from_js));
                $exclude_ids = array_filter($excluded_from_js, 'is_numeric');
            }
        }
    }
    
    // Fallback: cargar desde DB si no hay valores desde JS
    if (empty($exclude_ids)) {
        $option_page_ids = ['option', 'news_archive'];
        
        foreach ($option_page_ids as $opt_id) {
            // main_featured_news_item
            if ($field['name'] !== 'main_featured_news_item') {
                $main_featured = get_field('main_featured_news_item', $opt_id);
                if ($main_featured) {
                    if (is_object($main_featured)) {
                        $exclude_ids[] = $main_featured->ID;
                    } elseif (is_numeric($main_featured)) {
                        $exclude_ids[] = $main_featured;
                    }
                }
            }
            
            // featured_news_left_column
            if ($field['name'] !== 'featured_news_left_column') {
                $left_posts = get_field('featured_news_left_column', $opt_id);
                if ($left_posts && is_array($left_posts)) {
                    foreach ($left_posts as $post) {
                        if (is_object($post)) {
                            $exclude_ids[] = $post->ID;
                        } elseif (is_numeric($post)) {
                            $exclude_ids[] = $post;
                        }
                    }
                }
            }
            
            // featured_news_right_column
            if ($field['name'] !== 'featured_news_right_column') {
                $right_posts = get_field('featured_news_right_column', $opt_id);
                if ($right_posts && is_array($right_posts)) {
                    foreach ($right_posts as $post) {
                        if (is_object($post)) {
                            $exclude_ids[] = $post->ID;
                        } elseif (is_numeric($post)) {
                            $exclude_ids[] = $post;
                        }
                    }
                }
            }
            
            // featured_news_bottom_row
            if ($field['name'] !== 'featured_news_bottom_row') {
                $right_posts = get_field('featured_news_bottom_row', $opt_id);
                if ($right_posts && is_array($right_posts)) {
                    foreach ($right_posts as $post) {
                        if (is_object($post)) {
                            $exclude_ids[] = $post->ID;
                        } elseif (is_numeric($post)) {
                            $exclude_ids[] = $post;
                        }
                    }
                }
            }
            
            if (!empty($exclude_ids)) {
                break;
            }
        }
    }
    
    // Aplicar exclusión
    if (!empty($exclude_ids)) {
        $exclude_ids = array_unique($exclude_ids);
        $exclude_ids = array_filter($exclude_ids);
        
        //error_log("✅ Excluyendo para {$field['name']}: " . implode(', ', $exclude_ids));
        
        $args['post__not_in'] = isset($args['post__not_in']) 
            ? array_merge($args['post__not_in'], $exclude_ids) 
            : $exclude_ids;
    }

    // Ordena los post por fecha
    $args['meta_key'] = 'date';
    $args['orderby'] = 'meta_value';
    $args['order'] = 'DESC';
    $args['meta_type'] = 'DATE'; // opcional, mejora precisión
    
    return $args;
}

// ============================================================================
// PARTE 2: CHECKBOXES Y JAVASCRIPT
// ============================================================================

add_action('acf/input/admin_footer', 'add_relationship_checkbox_to_right_column');

function add_relationship_checkbox_to_right_column() {
    ?>
    <style>
    .acf-relationship .values .acf-rel-item {
        display: flex !important;
        align-items: flex-start !important;
        padding: 5px 10px !important;
    }
    
    .acf-relationship-show-image-wrapper {
        position: realtive;
        z-index: 1;
        margin-right: 8px;
        margin-top: 4px;
        flex-shrink: 0;
        order: -1;
        position: relative;
        padding: 2px;
        padding-top: 12px;
        border: solid 1px white;
        border-radius: 5px;
        background-color: #29afea;
        /* background-image: url('data:image/png;base64,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'); */
        background-image: url('data:image/png;base64,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');
        background-repeat: no-repeat;
        background-size: contain;
    }
    .acf-relationship-show-image-wrapper.disabled{
        filter: grayscale(1) brightness(1.15);
    }
    @media (width < 783px) {
        .acf-relationship-show-image-wrapper {
            padding-top: 20px;
        }
    }
    
    .acf-relationship-show-image-wrapper label {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin: 0;
        line-height: 1;
        position: relative;
    }
    .acf-relationship-show-image-wrapper .checkbox-hit-area{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .acf-relationship-show-image-wrapper input[type="checkbox"] {
        opacity: 1 !important;
        filter: none !important;
        background-color: white !important;
    }
    [data-name="featured_news_bottom_row"] .acf-relationship-show-image-wrapper{
        width: 16px;
        height: 16px;
        padding: 2px;
    }
    [data-name="featured_news_bottom_row"] .acf-relationship-show-image-wrapper input[type="checkbox"] {
        opacity: 0 !important;
    }
    [data-name="featured_news_bottom_row"] .acf-relationship-show-image-wrapper:not(.disabled) input[type="checkbox"] {
        display: none;
    }

    /* .acf-relationship-show-image-wrapper:hover, */
    .acf-relationship-show-image-wrapper.checked {
        filter: none;
    }
    
    .acf-relationship-show-image {
        margin: 0 !important;
        cursor: pointer;
    }


    /* Tooltip customizado */
    .acf-checkbox-tooltip {
        position: absolute;
        top: -1px;
        left: calc(100% + 3px);
        /* transform: translateX(-50%); */
        margin-bottom: 8px;
        padding: 7px 10px;
        background: #fff;
        border: 1px solid #fff;
        border-radius: 5px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
        /* font-size: 12px; */
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0s, visibility 0s;
        color: black;
    }

    @media (width < 783px) {
        .acf-checkbox-tooltip {
            height: 33px;
        }
    }


    /* Mostrar tooltip al hacer hover - SIN delay */
    .acf-relationship-show-image-wrapper.hover .acf-checkbox-tooltip {
        opacity: 1;
        visibility: visible;
    }

    .acf-relationship.loading .choices li{
        opacity: 0 !important;
    }
    .acf-relationship.loading .choices{
        position: relative;
    }
    .acf-relationship.loading .choices:before{
        content: 'Reloading...';
        position: absolute;
        top: 10px;
        left: 10px;
        color: gray;
    }

    .relationship-preview{
        width: calc(100% - 32px);
        margin-left: 16px;
        padding-top: 16px;
        clear: both;
        user-select: none;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .relationship-preview-name{
        font-size: 1em;
        font-weight: 500;
        display: flex;
        gap: 5px;
        align-items: center;
        width: fit-content;
        cursor: pointer;
    }
    .relationship-preview-toggle{
        width: 20px;
        height: 20px;
        border-radius: 100%;
        background: #3e434a;
        display: flex;
        justify-content: center;
        align-items: center;
        transform: rotate(270deg);
        transition: transform 0.3s;
    }
    .relationship-preview--hide .relationship-preview-toggle{
        transform: rotate(90deg);
    }
    .relationship-preview-toggle svg{
        width: 10px;
        height: auto;
    }
    .relationship-preview-toggle svg *{
        fill: white;
        stroke: white;
    }


    .relationship-preview__preloader{
        font-size: 1.2em;
    }

    .relationship-preview__holder{
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 30px;
        min-height: 350px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 11px;
        padding: 30px;
        padding-bottom: 14px;
        background-color: #FAF2EB;
        color: #332933;
        border-radius: 0;
        border: solid 1px lightgray;
    }
    .relationship-preview__holder-bottom{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 30px;
        background-color: #FAF2EB;
        color: #332933;
        border-radius: 0;
        border: solid 1px lightgray;
        border-top: 0;
        padding: 30px;
        padding-bottom: 14px;
    }
    .relationship-preview__holder-bottom:empty{
        padding: 0;
        border: none;
        height: 0;
    }
    @media (width < 1240px) {
        .relationship-preview{
            max-width: 400px;
        }
        .relationship-preview__holder,
        .relationship-preview__holder-bottom{
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .relationship-preview__col:nth-of-type(1){
            order: 2;
            border-bottom: solid 1px lightgray;
        }
        .relationship-preview__col:nth-of-type(2){
            border-bottom: solid 1px lightgray;
            order: 1;
        }
        .relationship-preview__col:nth-of-type(3){
            order: 3;
        }
    }
    .relationship-preview__col{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .relationship-preview__item{
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: solid 1px lightgray;
    }
    .relationship-preview__item:last-of-type{
        border: none;
    }
    .relationship-preview__title{
        font-size: 14px;
        font-weight: bold;
        line-height: 1.3em;
    }
    .relationship-preview__title--large{
        font-size: 24px;
        font-family: serif;
        font-weight: normal;
        line-height: 1.15em;
    }
    .relationship-preview__date{
        font-size: 12px;
        color: gray;
    }
    .relationship-preview__item.relationship-preview__item--main{
        gap: 14px;
    }
    .relationship-preview__item.relationship-preview__item--main .relationship-preview__title,
    .relationship-preview__item.relationship-preview__item--main .relationship-preview__date{
        text-align: center;
    } 
    .relationship-preview__item-img{
        width: 100%;
        aspect-ratio: 767/500;
        overflow: hidden;
        border-radius: 10px;
        background-color: rgba(0,0,0,0.1);
    }
    .relationship-preview__item img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .relationship-preview__item:not(.relationship-preview__item--main) img{
        /* max-height: 130px; */
        .relationship-preview__item-img{
            aspect-ratio: 362/204;
        }
    }
    .relationship-preview__holder-bottom .relationship-preview__item{
        border: none;
    }
    .relationship-preview__holder-bottom .relationship-preview__item img{
        /* max-height: 160px; */
    }
    .relationship-preview__blurb,
    .relationship-preview__blurb p{
        font-size: 12px;
        color: gray;
    }
    .relationship-preview__blurb p{
        margin: 0;
        margin-bottom: 1em;
    }
    .relationship-preview__tags{
        display: flex;
        flex-wrap: wrap;
        gap: 3px
    }
    .relationship-preview__col:nth-of-type(2) .relationship-preview__tags{
        justify-content: center;
    }
    .relationship-preview__tags .item__tag{
        padding: 1px 4px;
        border-radius: 3px;
        background: gray;
        color: white;
        text-transform: uppercase;
        font-size: 10px;
        white-space: nowrap;
    }

    [data-name="featured_news_left_column"],
    [data-name="featured_news_right_column"],
    [data-name="featured_news_bottom_row"]{
        user-select: none;
    }

    .lds-ring,
    .lds-ring div {
        box-sizing: border-box;
    }
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 30px;
        height: 30px;
        color: gray;
    }
    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 28px;
        height: 28px;
        margin: 3px;
        border: 3px solid currentColor;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: currentColor transparent transparent transparent;
    }
    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }
    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }
    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }
    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }


    

    </style>
    
    <script type="text/javascript">
    (function($) {
        //console.log('🔷 Script de checkboxes cargado');

        if(!$('[data-name="featured_news_left_column"]').length) return false;

        // agrega el id seleccionado al post_object de los ACF
        acf.addAction('ready_field/type=post_object', function(field){
            const $select = field.$el.find('select');
            
            // Si ya hay un valor cargado al cargar la página:
            const initialID = $select.val();
            if(initialID) {
                $select.attr('data-id', initialID);
            }

            // Cuando cambia el valor del post object:
            $select.on('change', function(){
                const selectedID = $(this).val();
                $(this).attr('data-id', selectedID || '');
            });
        });
        
        // Función para obtener IDs seleccionados EXCEPTO del campo actual
        function getExcludedPostIds(exceptFieldName) {
            var allIds = [];
            
            // Obtener IDs de featured_news_left_column (solo si no es el campo actual)
            if (exceptFieldName !== 'featured_news_left_column') {
                $('[data-name="featured_news_left_column"] .values input[type="hidden"]').each(function() {
                    var val = $(this).val();
                    if (val && val !== '') {
                        allIds.push(val);
                    }
                });
            }
            
            // Obtener IDs de featured_news_right_column (solo si no es el campo actual)
            if (exceptFieldName !== 'featured_news_right_column') {
                $('[data-name="featured_news_right_column"] .values input[type="hidden"]').each(function() {
                    var val = $(this).val();
                    if (val && val !== '') {
                        allIds.push(val);
                    }
                });
            }

            // Obtener IDs de featured_news_bottom_row (solo si no es el campo actual)
            if (exceptFieldName !== 'featured_news_bottom_row') {
                $('[data-name="featured_news_bottom_row"] .values input[type="hidden"]').each(function() {
                    var val = $(this).val();
                    if (val && val !== '') {
                        allIds.push(val);
                    }
                });
            }
            
            // Obtener ID de main_featured_news_item (solo si no es el campo actual)
            if (exceptFieldName !== 'main_featured_news_item') {
                var mainFeatured = $('[data-name="main_featured_news_item"] select').val();
                if (mainFeatured && mainFeatured !== '') {
                    allIds.push(mainFeatured);
                }
            }
            
            return allIds;
        }
        
        // Interceptar peticiones AJAX de ACF para agregar los IDs excluidos
        $(document).ajaxSend(function(event, jqxhr, settings) {
            if (settings.data) {
                var dataStr = typeof settings.data === 'string' ? settings.data : '';
                
                // Detectar peticiones de ACF relationship o post_object
                if (dataStr.indexOf('action=acf') > -1 && 
                    (dataStr.indexOf('field_key=') > -1)) {
                    
                    // Extraer el field_key de la petición para saber qué campo está haciendo la búsqueda
                    var fieldKeyMatch = dataStr.match(/field_key=([^&]+)/);
                    var fieldKey = fieldKeyMatch ? fieldKeyMatch[1] : '';
                    
                    // Obtener el nombre del campo desde el DOM
                    var currentFieldName = '';
                    $('.acf-field-relationship, .acf-field-post-object').each(function() {
                        if ($(this).data('key') === fieldKey) {
                            currentFieldName = $(this).data('name');
                        }
                    });
                    
                    //console.log('🔍 Petición AJAX para campo:', currentFieldName);
                    
                    // Solo enviar IDs excluidos si es uno de nuestros campos
                    if (currentFieldName === 'featured_news_left_column' || 
                        currentFieldName === 'featured_news_right_column' || 
                        currentFieldName === 'featured_news_bottom_row' || 
                        currentFieldName === 'main_featured_news_item') {
                        
                        var excludedIds = getExcludedPostIds(currentFieldName);
                        if (excludedIds.length > 0) {
                            //console.log('📤 Enviando posts excluidos:', excludedIds);
                            settings.data += '&excluded_posts=' + encodeURIComponent(JSON.stringify(excludedIds));
                        } else {
                            //console.log('⚠️ No hay posts para excluir de este campo');
                        }
                    }
                }
            }
        });
        
        // Función para agregar checkboxes
        function addCheckboxesToSelectedItems() {
            //console.log('🔍 Buscando items en columna derecha...');
            
            $('.acf-field-relationship').each(function() {
                var $field = $(this);
                var fieldKey = $field.data('key');
                var fieldName = $field.data('name');
                
                //console.log('📦 Campo encontrado:', fieldName);
                
                if (fieldName !== 'featured_news_left_column' && fieldName !== 'featured_news_right_column' && fieldName !== 'featured_news_bottom_row') {
                    //console.log('⏭️ Saltando campo:', fieldName);
                    return;
                }
                
                //console.log('✅ Procesando campo:', fieldName);
                
                $field.find('.values .acf-rel-item').each(function() {
                    var $item = $(this);
                    var postId = $item.data('id');
                    
                    //console.log('📄 Item encontrado, ID:', postId);
                    
                    if ($item.find('.acf-relationship-show-image-wrapper').length > 0) {
                        //console.log('⏭️ Ya tiene checkbox, ID:', postId);
                        return;
                    }
                    
                    if (!postId) {
                        //console.log('⚠️ Item sin ID');
                        return;
                    }
                    
                    //console.log('➕ Agregando checkbox para post:', postId);
                    
                    var $checkboxTemp = $('<div class="acf-relationship-show-image-wrapper">' +
                        '<span class="acf-checkbox-tooltip">Check to show image</span>' +
                        '<label>' +
                            '<input type="checkbox" ' +
                                   'class="acf-relationship-show-image" ' +
                                   'data-post-id="' + postId + '" ' +
                                   'data-field-name="' + fieldName + '" ' +
                                   'disabled> <div class="checkbox-hit-area"></div>' +
                        '</label>' +
                    '</div>');
                    
                    $item.prepend($checkboxTemp);
                    
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'get_show_image_status',
                            post_id: postId,
                            nonce: '<?php echo wp_create_nonce("get_show_image"); ?>'
                        },
                        success: function(response) {
                            //console.log('✓ Respuesta AJAX para post ' + postId + ':', response);
                            
                            if (response.success) {
                                var checked = response.data.show_image ? 'checked' : '';
                                var hasImage = Boolean(response.data.has_image);
                                var disabled = hasImage ? '' : 'disabled';
                                var disabledHitArea = hasImage ? '' : '<div class="checkbox-hit-area"></div>';
                                if(hasImage){
                                    
                                }else{
                                    checked = 'disabled';
                                }
                                
                                var $checkboxReal = $('<div class="acf-relationship-show-image-wrapper '+checked+'">' +
                                    '<span class="acf-checkbox-tooltip">Check to show image</span>' +
                                    '<label>' +
                                        '<input type="checkbox" ' +
                                               'class="acf-relationship-show-image" ' +
                                               'data-post-id="' + postId + '" ' +
                                               'data-field-name="' + fieldName + '" ' +
                                               'data-has-image="' + hasImage + '" ' +
                                               disabled + ' ' +
                                               checked + '>' +
                                               disabledHitArea +
                                    '</label>' +
                                '</div>');
                                
                                $checkboxTemp.replaceWith($checkboxReal);
                                //console.log('✅ Checkbox agregado correctamente para post:', postId);
                            } else {
                                //console.log('❌ Error en respuesta AJAX');
                                $checkboxTemp.remove();
                            }
                        },
                        error: function(xhr, status, error) {
                            //console.log('❌ Error AJAX:', error);
                            $checkboxTemp.remove();
                        }
                    });
                });
            });
        }
        
        // Ejecutar al cargar
        $(document).ready(function() {
            //console.log('📱 DOM Ready');
            setTimeout(function() {
                //console.log('⏰ Ejecutando después de 1 segundo...');
                addCheckboxesToSelectedItems();
            }, 1000);
        });
        
        // Variable para controlar el debounce del refresh
        var refreshTimeout = null;
        var refreshTimeoutPreloader;

        function hidePreloader(){
            clearTimeout(refreshTimeoutPreloader);
            $('.acf-relationship').removeClass('loading');
        }
        function showPreloader(){
            clearTimeout(refreshTimeoutPreloader);
            $('.acf-relationship').addClass('loading');
            refreshTimeoutPreloader = setTimeout(() => {
                $('.acf-relationship').removeClass('loading');
            }, 1000);
        }

        
        // Función para refrescar todos los campos featured EXCEPTO el que se está modificando
        function refreshAllFeaturedFields(exceptFieldName) {
            // Cancelar cualquier refresh pendiente
            if (refreshTimeout) {
                clearTimeout(refreshTimeout);
            }

            showPreloader();

            // Programar el refresh con delay
            refreshTimeout = setTimeout(function() {
                //console.log('🔄 Refrescando campos featured (excepto:', exceptFieldName, ')');

                setTimeout(function() {
                    $('.acf-field-relationship').each(function() {
                        var $field = $(this);
                        var fieldName = $field.data('name');
                        if ((fieldName === 'featured_news_bottom_row' || fieldName === 'featured_news_left_column' || fieldName === 'featured_news_right_column') && fieldName !== exceptFieldName) {
                            //console.log('🔄 Refrescando relationship:', fieldName);
                            
                            var fieldKey = $field.data('key');
                            
                            if (typeof acf !== 'undefined' && acf.getField) {
                                var fieldObj = acf.getField(fieldKey);
                                if (fieldObj) {
                                    if (fieldObj.maybeFetch) {
                                        fieldObj.maybeFetch();
                                    }
                                    if (fieldObj.fetch) {
                                        fieldObj.fetch();
                                    }
                                }
                            }
                            
                            var $search = $field.find('.filters input[type="search"]');
                            if ($search.length && $search.val()) {
                                var searchVal = $search.val();
                                $search.val('').trigger('change').trigger('keyup');
                                setTimeout(function() {
                                    $search.val(searchVal).trigger('change').trigger('keyup');
                                }, 150);
                            } else if ($search.length) {
                                $search.val(' ').trigger('keyup');
                                setTimeout(function() {
                                    $search.val('').trigger('keyup');
                                }, 150);
                            }
                        }
                    });
                }, 200);
                
                setTimeout(function() {
                    $('.acf-field-post-object').each(function() {
                        var $field = $(this);
                        var fieldName = $field.data('name');
                        
                        if (fieldName === 'main_featured_news_item' && fieldName !== exceptFieldName) {
                            //console.log('🔄 Refrescando post object:', fieldName);
                            
                            var $select = $field.find('select');
                            if ($select.length && $select.data('select2')) {
                                var currentVal = $select.val();
                                
                                $select.select2('destroy');
                                
                                setTimeout(function() {
                                    var fieldKey = $field.data('key');
                                    if (typeof acf !== 'undefined' && acf.getField) {
                                        var fieldObj = acf.getField(fieldKey);
                                        if (fieldObj && fieldObj.initialize) {
                                            fieldObj.initialize();
                                            if (currentVal) {
                                                $select.val(currentVal).trigger('change');
                                            }
                                        }
                                    }
                                }, 200);
                            }
                        }
                    });
                }, 200);
            }, 200);
            refreshPreview();
        }

        $(document).on('change','.acf-relationship-show-image-wrapper input', function(e){
            var $this = $(this);
            if($this.is(':checked')){
                $this.parent().parent().addClass('checked');
            }else{
                $this.parent().parent().removeClass('checked');
            }
            //
        });

        $(document).on('mouseenter','.acf-relationship-show-image-wrapper input, .checkbox-hit-area', function(e){
            let $this = $(this);
            let $parent = $this.parent().parent();
            let $tooltip = $parent.find('.acf-checkbox-tooltip');
            $tooltip.html($this.is('input') ? 'Check to show image' : 'Open post to add image'); 
            $parent.addClass('hover');
        });
        $(document).on('mouseleave mousedown','.acf-relationship-show-image-wrapper input, .checkbox-hit-area', function(e){
            $(this).parent().parent().removeClass('hover');
        });
        

        $(document).on('click','.checkbox-hit-area', function(e){
            let postID = $(this).parent().find('input').attr('data-post-id');
            /* let result = confirm("There's no picture with this post.\n\nWanna open the post and add a picture?");
            if (result) {
                window.open(`http://campus4all-stg.local/wp-admin/post.php?post=${postID}&action=edit&classic-editor`,'_blank');
            } else {
                //console.log("cancel");
            } */
           window.open(`<?= get_home_url(); ?>/wp-admin/post.php?post=${postID}&action=edit&classic-editor`,'_blank');
        });
        
        // Ejecutar cuando se hace click para AGREGAR un item al relationship
        $(document).on('click', '[data-name="featured_news_bottom_row"] .choices .acf-rel-item, [data-name="featured_news_left_column"] .choices .acf-rel-item, [data-name="featured_news_right_column"] .choices .acf-rel-item', function() {
            var $field = $(this).closest('.acf-field-relationship');
            var fieldName = $field.data('name');
            //console.log('➕ Agregando item a:', fieldName);
            
            setTimeout(addCheckboxesToSelectedItems, 400);
            refreshAllFeaturedFields(fieldName);
        });
        
        // Ejecutar cuando se hace click para REMOVER un item del relationship
        $(document).on('mouseup', '[data-name="featured_news_bottom_row"] .values .acf-rel-item a.acf-icon.-minus, [data-name="featured_news_left_column"] .values .acf-rel-item a.acf-icon.-minus, [data-name="featured_news_right_column"] .values .acf-rel-item a.acf-icon.-minus', function() {
            var $field = $(this).closest('.acf-field-relationship');
            var fieldName = $field.data('name');
            //console.log('➖ Removiendo item de:', fieldName);
            
            refreshAllFeaturedFields(fieldName);
        });

        let isClicked = false;
        let isDragged = false;
        $(document).on('mousedown', '.checkbox-hit-area, .acf-relationship-show-image-wrapper, [data-name="featured_news_bottom_row"] .values-list li, [data-name="featured_news_left_column"] .values-list li, [data-name="featured_news_right_column"] .values-list li', function(){
            isClicked = true;
        });
        $(document).on('mousemove', '.checkbox-hit-area, .acf-relationship-show-image-wrapper, [data-name="featured_news_bottom_row"] .values-list li, [data-name="featured_news_left_column"] .values-list li, [data-name="featured_news_right_column"] .values-list li', function(){
            isDragged = isClicked;
        });
        $(document).on('mouseup', '.checkbox-hit-area, .acf-relationship-show-image-wrapper, [data-name="featured_news_bottom_row"] .values-list li, [data-name="featured_news_left_column"] .values-list li, [data-name="featured_news_right_column"] .values-list li', function(){
            if(isDragged){
                refreshPreview();
            }
            isClicked = false;
            isDragged = false;
        });
        /* let hitAreaMousedown = false;
        $(document).on('mousedown','.acf-relationship-show-image-wrapper, .checkbox-hit-area', function(e){
            hitAreaMousedown = true;
        });
        $(document).on('mouseup, mouseleave','.acf-relationship-show-image-wrapper, .checkbox-hit-area', function(e){
            if(hitAreaMousedown){
                var $field = $(this).closest('.acf-field-relationship');
                var fieldName = $field.data('name');
                //console.log('➖ Removiendo item de:', fieldName);
                refreshAllFeaturedFields(fieldName);
                hitAreaMousedown = false;
            }
        }); */
        
        
        // Refrescar cuando cambia el post object
        $(document).on('change', '[data-name="main_featured_news_item"] select', function() {
            //console.log('🔄 Cambio en main_featured_news_item');
            refreshAllFeaturedFields('main_featured_news_item');
        });
        
        // Manejar cambios en los checkboxes
        $(document).on('change', '.acf-relationship-show-image', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $checkbox = $(this);
            var postId = $checkbox.data('post-id');
            var isChecked = $checkbox.is(':checked');
            
            //console.log('🔄 Cambio en checkbox, Post ID:', postId, 'Checked:', isChecked);
            
            $checkbox.prop('disabled', true);

            refreshPreview();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'update_show_image_field',
                    post_id: postId,
                    show_image: isChecked ? '1' : '0',
                    nonce: '<?php echo wp_create_nonce("update_show_image"); ?>'
                },
                success: function(response) {
                    //console.log('✓ Actualización exitosa:', response);
                    $checkbox.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    //console.log('❌ Error al actualizar:', error);
                    alert('Error al actualizar el campo');
                    $checkbox.prop('checked', !isChecked);
                    $checkbox.prop('disabled', false);
                }
            });
        });
        

        $(document).on('click mousedown', '.acf-field-post-object[data-name="main_featured_news_item"]', function(e) {
            $('.select2-container--default .select2-search--dropdown').css({display:'block'})
        });

        // Prevenir propagación de clicks
        $(document).on('click mousedown', '.acf-relationship-show-image-wrapper, .acf-relationship-show-image-wrapper *', function(e) {
            e.stopPropagation();
        });

        document.addEventListener("visibilitychange", () => {
            //HERE
            if (document.visibilityState === "visible") {
                let ids = [];
                $('[data-name="featured_news_bottom_row"] .values-list .acf-relationship-show-image, [data-name="featured_news_left_column"] .values-list .acf-relationship-show-image, [data-name="featured_news_right_column"] .values-list .acf-relationship-show-image').each(function(){
                    ids.push(Number($(this).attr('data-post-id')));
                });
                //alert(ids)
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'get_news_show_image',
                        ids: ids.join(','),
                        nonce: '<?php echo wp_create_nonce("news_get_show_image"); ?>',
                    },
                    success: function(response) {
                        if (response.success) {
                            $('[data-name="featured_news_bottom_row"] .values-list .acf-relationship-show-image, [data-name="featured_news_left_column"] .values-list .acf-relationship-show-image, [data-name="featured_news_right_column"] .values-list .acf-relationship-show-image').each(function(){
                                let $this = $(this);
                                let id = Number($this.attr('data-post-id'));
                                response.data.forEach((p,i) => {
                                    if(id == p.id){
                                        let value = p.show_image == 'true' || p.show_image == '1' || p.show_image == 1;
                                        $this.prop('checked', value);
                                    }
                                }); 
                            });
                            refreshPreview();
                        } else {
                            console.error('Error:', response.data);
                            $refreshPreview.removeClass('loading');
                            $refreshPreview.html('Error:', response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });

            }
        });
        
        //--- preview ---//

        $('[data-name="featured_news_bottom_row"]').after(`
        <div id="relationship-preview" class="relationship-preview">
            <div class="relationship-preview-name">
                <span>Featured news preview</span>
                <div class="relationship-preview-toggle">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9393 8.00001L5.46967 2.53034L6.53033 1.46968L12.5303 7.46968L13.0607 8.00001L12.5303 8.53034L6.53033 14.5303L5.46967 13.4697L10.9393 8.00001Z" fill="#33312E"></path>
                    </svg>
                </div>
            </div>
            <div class="relationship-preview__holder"></div>
            <div class="relationship-preview__holder-bottom"></div>
        </div>`);

        var refreshPreviewTimeout;
        var $refreshPreview = $('#relationship-preview .relationship-preview__holder');
        var $refreshPreviewBottom = $('#relationship-preview .relationship-preview__holder-bottom');
        var refreshPreview = function(){
            clearTimeout(refreshPreviewTimeout);
            $refreshPreview.addClass('loading');
            $refreshPreview.html(`
            <span class="relationship-preview__preloader">
                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            </span>
            `);
            $refreshPreviewBottom.html('');
            refreshPreviewTimeout = setTimeout(() => {
                let ids = [];
                let idsByColum = [[],[],[],[]];
                ids.push(Number($('[data-name="main_featured_news_item"] select.select2-hidden-accessible').attr('data-id')));
                idsByColum[1].push(ids[0]);
                $('[data-name="featured_news_left_column"] .values-list li input[type="hidden"]').each(function(){
                    let value = Number($(this).val());
                    ids.push(value);
                    idsByColum[0].push(value);
                });
                $('[data-name="featured_news_right_column"] .values-list li input[type="hidden"]').each(function(){
                    let value = Number($(this).val());
                    ids.push(value);
                    idsByColum[2].push(value);
                });
                $('[data-name="featured_news_bottom_row"] .values-list li input[type="hidden"]').each(function(){
                    let value = Number($(this).val());
                    ids.push(value);
                    idsByColum[3].push(value);
                });
                /*  */
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'get_posts_data',
                        ids: ids.join(','),
                        nonce: '<?php echo wp_create_nonce("news_refresh_preview"); ?>',
                    },
                    success: function(response) {
                        if (response.success) {
                            let html_col_1 = '';
                            let html_col_2 = '';
                            let html_col_3 = '';
                            let html_col_4 = '';
                            //console.log('Posts:', response.data);
                            response.data.forEach((p,i) => {
                                if(p.source){
                                    p.date = p.source+' — '+p.date;
                                } 
                                let img = p.image && (i == 0 || Number(p.show_image) == 1) ? `<div class='relationship-preview__item-img'><img src='${p.image.sizes.large}' /></div>` : '';
                                if(idsByColum[1].includes(p.id)){
                                    html_col_2 += `<div class='relationship-preview__item relationship-preview__item--main'>
                                        <div class='relationship-preview__tags'>${p.terms_html}</div>    
                                        <div class='relationship-preview__title relationship-preview__title--large'>${p.title}</div>
                                        ${img}
                                        <div class='relationship-preview__date'>${p.date}</div>
                                        <div class='relationship-preview__blurb'>${p.blurb}</div>
                                    </div>`;
                                }else if(idsByColum[0].includes(p.id)){
                                    html_col_1 += `<div class='relationship-preview__item'>
                                        <div class='relationship-preview__tags'>${p.terms_html}</div>  
                                        ${img}  
                                        <div class='relationship-preview__title'>${p.title}</div>
                                        <div class='relationship-preview__date'>${p.date}</div>
                                    </div>`;
                                }else if(idsByColum[2].includes(p.id)){
                                    html_col_3 += `<div class='relationship-preview__item'>
                                        <div class='relationship-preview__tags'>${p.terms_html}</div>   
                                        ${img} 
                                        <div class='relationship-preview__title'>${p.title}</div>
                                        <div class='relationship-preview__date'>${p.date}</div>
                                    </div>`;
                                }else if(idsByColum[3].includes(p.id)){
                                    let img = p.image ? `<div class='relationship-preview__item-img'><img src='${p.image.sizes.large}' /></div>` : `<div class='relationship-preview__item-img'></div>`;
                                    html_col_4 += `<div class='relationship-preview__item'> 
                                        ${img} 
                                        <div class='relationship-preview__tags'>${p.terms_html}</div>  
                                        <div class='relationship-preview__title'>${p.title}</div>
                                        <div class='relationship-preview__date'>${p.date}</div>
                                    </div>`;
                                }
                            });
                            $refreshPreview.removeClass('loading');
                            let html = `
                                <div class='relationship-preview__col'>${html_col_1}</div>
                                <div class='relationship-preview__col'>${html_col_2}</div>
                                <div class='relationship-preview__col'>${html_col_3}</div>
                            `;
                            $refreshPreview.html(html);
                            $refreshPreviewBottom.html(html_col_4);
                        } else {
                            console.error('Error:', response.data);
                            $refreshPreview.removeClass('loading');
                            $refreshPreview.html('Error:', response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });

            },1000);
        }
        var collapsePreview = function(animation = true){
            $('#relationship-preview').toggleClass('relationship-preview--hide');
            let collapsed = $('#relationship-preview').hasClass('relationship-preview--hide');
            let h = collapsed ? 20 : $('.relationship-preview__holder').height()+$('.relationship-preview__holder-bottom').height();
            let time = animation ? 400 : 0;
            $('#relationship-preview').stop(true).animate({height: h}, time, function(){
                if(!collapsed){
                    $('#relationship-preview').css({height:'auto'});
                }
            });
            $('.relationship-preview__holder').stop(true).animate({opacity: Number(!collapsed)}, time);
            $('.relationship-preview__holder-bottom').stop(true).animate({opacity: Number(!collapsed)}, time);
            sessionStorage.setItem("newsPreviewCollapsed",collapsed);
        } 
        $('.relationship-preview-name').click(function(){
            collapsePreview(true);
        });
        if(sessionStorage.getItem("newsPreviewCollapsed") && sessionStorage.getItem("newsPreviewCollapsed") == 'true'){
            collapsePreview(false);
        }
        refreshPreview();
        
        //

        setTimeout(() => {
            var selectors = [
                '.acf-field-relationship[data-name="featured_news_left_column"]',
                '.acf-field-relationship[data-name="featured_news_right_column"]',
                '.acf-field-relationship[data-name="featured_news_bottom_row"]',
            ];
            $(selectors.join(',')).each(function(){
                $(this).mouseover();
            });
            $(document).unbind('mousemove.firstRun');
        },10);
        

    })(jQuery);
    </script>
    <?php
}

// ============================================================================
// PARTE 3: AJAX HANDLERS
// ============================================================================

add_action('wp_ajax_get_show_image_status', 'handle_get_show_image_status');

function handle_get_show_image_status() {
    check_ajax_referer('get_show_image', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $show_image = get_post_meta($post_id, 'show_image', true);
    $image = get_field('image', $post_id);
    $has_image = !empty($image) && isset($image['url']);
    
    //error_log("Get show_image for post {$post_id}: " . ($show_image ? 'true' : 'false'));
    
    wp_send_json_success([
        'post_id' => $post_id,
        'show_image' => $show_image ? true : false,
        'has_image' => $has_image,
    ]);
}

add_action('wp_ajax_update_show_image_field', 'handle_update_show_image_field');

function handle_update_show_image_field() {
    check_ajax_referer('update_show_image', 'nonce');
    
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permisos insuficientes');
        return;
    }
    
    $post_id = intval($_POST['post_id']);
    $show_image = sanitize_text_field($_POST['show_image']);
    
    update_post_meta($post_id, 'show_image', $show_image);
    
    //error_log("Updated show_image for post {$post_id}: {$show_image}");
    
    wp_send_json_success([
        'post_id' => $post_id,
        'show_image' => $show_image,
        'message' => 'Campo actualizado correctamente en el post'
    ]);
}


add_action('wp_ajax_get_posts_data', 'get_news_preview_posts_data');
function get_news_preview_posts_data() {

    check_ajax_referer('news_refresh_preview', 'nonce');
    
    // Verificamos permisos (solo admin)
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Not allowed');
    }

    // Verificamos el parámetro
    if (empty($_POST['ids'])) {
        wp_send_json_error('Missing IDs');
    }

    // Convertimos a array de enteros
    $ids = array_map('intval', explode(',', $_POST['ids']));

    // Obtenemos los posts
    $posts = get_posts([
        'post__in'  => $ids,
        'post_type' => 'any',
        'numberposts' => -1,
        'orderby' => 'post__in',
    ]);

    // Preparamos los datos a devolver
    $data = [];
    foreach ($posts as $p) {
        $terms = get_the_terms($p, 'news_tag');
        $terms_html = '';
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $terms_html .= "<div class='item__tag'>{$term->name}</div>";
            }
        }
        $data[] = [
            'id'    => $p->ID,
            'title' => get_the_title($p),
            'link'  => get_permalink($p),
            'type'  => $p->post_type,
            'date'  => get_field('date',$p),
            'source'  => get_field('source',$p),
            'blurb'  => get_field('blurb',$p),
            'image' => get_field('image',$p),
            'show_image' => get_field('show_image',$p),
            'terms_html' => $terms_html,
        ];
    }

    wp_send_json_success($data);
}


add_action('wp_ajax_get_news_show_image', 'get_news_show_image');
function get_news_show_image() {

    check_ajax_referer('news_get_show_image', 'nonce');
    
    // Verificamos permisos (solo admin)
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Not allowed');
    }

    // Verificamos el parámetro
    if (empty($_POST['ids'])) {
        wp_send_json_error('Missing IDs');
    }

    // Convertimos a array de enteros
    $ids = array_map('intval', explode(',', $_POST['ids']));

    // Obtenemos los posts
    $posts = get_posts([
        'post__in'  => $ids,
        'post_type' => 'any',
        'numberposts' => -1,
        'orderby' => 'post__in',
    ]);

    // Preparamos los datos a devolver
    $data = [];
    foreach ($posts as $p) {
        $data[] = [
            'id' => $p->ID,
            'show_image' => get_field('show_image',$p),
        ];
    }

    wp_send_json_success($data);
}


// ============================================================================
// PARTE 4: FUNCIÓN HELPER
// ============================================================================

function get_featured_news_with_image_status($column = 'left') {
    $field_name = $column === 'left' ? 'featured_news_left_column' : 'featured_news_right_column';
    $posts = get_field($field_name, 'option');
    
    if (!$posts) {
        return [];
    }
    
    $result = [];
    foreach ($posts as $post) {
        $result[] = [
            'post' => $post,
            'show_image' => get_post_meta($post->ID, 'show_image', true)
        ];
    }
    
    return $result;
}

?>