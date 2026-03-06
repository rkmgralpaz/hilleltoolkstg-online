<?php

//--- busca el numero de color ---//

function get_cards_color_by_filters(){

    //--- en el css se definen las paletas con números (1,2,3,4...)
    //--- en el field color de cada filtro la value viene con los datos '{color-name}--{color-num};{hexa}' por ejemplo: 'light-pink--1;#FFD3FF'
    //--- del field color extraemos en número para que tome la class del css

    $terms = get_terms('card_filters');
    /* 
    $term->name
    $term->slug
    $term->description
    $term->term_id
    $term->taxonomy
    $term->count
    */
    $result = [];
    //$num = 0;
    foreach($terms as $term){
        //$num++;
        $color = explode(';',get_field('color','term_'.$term->term_id));
        $num = explode('--',$color[0])[1];
        $result[$term->slug] = [
            'num' => $num,
            'slug' => $term->slug,
            'name' => $term->name,
            'id' => $term->term_id,
            'color' => $color[1],
        ];
    }
    return $result;
}


//--- cards relationship ---//


// 1. Agregar los data attributes a cada item del relationship
add_filter('acf/fields/relationship/result', function($text, $post, $field, $post_id) {
    
    // Solo aplicar a nuestro campo específico
    //if ($field['key'] !== 'field_6876c2048ed26') {
    if ($field['name'] === 'filter_views_posts') {
    
        // Obtener los términos de card_filters para este post
        $terms = wp_get_post_terms($post->ID, 'card_filters');
        $term_ids = [];
        $term_names = [];
        $term_colors = [];

        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $term_ids[] = $term->term_id;
                $term_names[] = $term->name;
            }
            $term_color = explode(';',get_field('color','term_'.$terms[0]->term_id));
            $term_colors[] = "<span class='relationship-item-card-color'></span>";
        }
        $term_colors_str = implode('',$term_colors);
        
        // Convertir a string separado por comas
        //$term_names_string = implode(',', $term_names);

        $term_ids_string = implode('-', $term_ids);//se aplica por class porque la nueva version de ACF elimina los atributos data
        
        // Agregar data attribute al HTML del item
        //$text = '<span data-card-filters="' . esc_attr($term_ids_string) . '" data-post-id="' . $post->ID . '"><span class="relationship-item-card-colors">'.$term_colors_str.'</span>' . $text . '</span>';

        $text = '<span class="card-id-'. $post->ID .' card-filters-' . $term_ids_string . ' card-with-filters" data-post-id="' . $post->ID . '"><span class="relationship-item-card-colors"><span class="relationship-item-card-color hexa-'.str_replace('#','',$term_color[1]).'"></span></span>' . $text . '</span>';

    }elseif ($field['name'] === 'featured_view_posts' || $field['name'] === 'all_view_posts' || $field['name'] === 'list_view_posts') {
        
        // Obtener los términos de card_filters para este post
        $terms = wp_get_post_terms($post->ID, 'card_filters');
        $term_ids = [];
        $term_colors = [];
        
        if ($terms && !is_wp_error($terms)) {
            /* foreach ($terms as $term) {
                $term_ids[] = $term->term_id;
                $term_color = explode(';',get_field('color','term_'.$term->term_id));
                $term_colors[] = "<span class='relationship-item-card-color' style='background-color:{$term_color[1]}'></span>";
            } */
            $term_ids[] = $terms[0]->term_id;
            $term_color = explode(';',get_field('color','term_'.$terms[0]->term_id));
            $term_colors[] = "<span class='relationship-item-card-color' style='background-color:{$term_color[1]}'></span>";
        }

        //$term_colors_str = implode('',$term_colors);

        //$text = $term_color[1].'<span data-card-filters="' . esc_attr($term_ids_string) . '" data-post-id="' . $post->ID . '"><span class="relationship-item-card-colors">'.$term_colors_str.'</span>' . $text . '</span>';
        $text = '<span data-card-filters="' . esc_attr($term_ids_string) . '" data-post-id="' . $post->ID . '"><span class="relationship-item-card-colors"><span class="relationship-item-card-color hexa-'.str_replace('#','',$term_color[1]).'" style="background-color:'.$term_color[1].'"></span></span>' . $text . '</span>';
    }

    return $text;
}, 10, 4);

// 2. Script JavaScript para mostrar/ocultar items
add_action('acf/input/admin_footer', function () {

    $filter_colors = json_encode(get_cards_color_by_filters());
    ?>
    <script type="text/javascript">
    (function($){
        
        // Variable para controlar cuando NO aplicar el filtro automáticamente
        var preventAutoFilter = false;
        
        // Función para filtrar items visualmente - SIN REACTIVACIÓN MANUAL
        function filterRelationshipItems($selectField) {
            var selectedTerm = $selectField.val();
            
            //console.log('Filtrando visualmente por término:', selectedTerm);
            
            // Encontrar el campo relationship en el mismo layout
            var $layout = $selectField.closest('[data-layout="group"]');
            var $relationshipField = $layout.find('[data-name="filter_views_posts"]');

            $layoutTitle = $layout.find('.acf-fc-layout-handle b');
            if($layoutTitle.length){
                $layoutTitle.html($selectField.find('option:selected').text());
            }
            
            if ($relationshipField.length) {
                
                // Encontrar todos los items en la lista de choices
                //var $allItems = $relationshipField.find('.choices-list [data-card-filters]');
                var $allItems = $relationshipField.find('.choices-list .card-with-filters');
                

                //console.log('Items encontrados en choices:', $allItems.length);
                
                // Si no hay items aún, no mostrar mensaje de "sin resultados"
                if ($allItems.length === 0) {
                    //console.log('⏳ No hay items cargados aún, esperando...');
                    hideNoResultsMessage($relationshipField);
                    return;
                }
                
                if (selectedTerm) {
                    var visibleCount = 0;
                    
                    // Filtrar por término específico
                    $allItems.each(function() {
                        var $item = $(this);
                        //var itemTerms = $item.attr('data-card-filters').split(',');
                        //var postId = $item.attr('data-post-id');

                        let classData = $item.attr('class').split(' ');
                        let itemTerms = classData[1] ? classData[1].split('card-filters-').join('').split('-') : [];
                        let postId = classData[0] ? classData[0].split('card-id-').join('') : 0;

                        if (itemTerms.includes(selectedTerm)) {
                            // Mostrar item
                            $item.closest('li').show();
                            visibleCount++;
                            //console.log('Mostrando post:', postId, 'términos:', itemTerms);
                        } else {
                            // Ocultar item
                            $item.closest('li').hide();
                            //console.log('❌ Ocultando post:', postId, 'términos:', itemTerms);
                        }
                    });
                    
                    //console.log('Items visibles:', visibleCount);
                    
                    // Mostrar mensaje solo si hay items cargados pero ninguno visible
                    if (visibleCount === 0) {
                        showNoResultsMessage($relationshipField, selectedTerm);
                    } else {
                        hideNoResultsMessage($relationshipField);
                    }
                    
                } else {
                    // Mostrar todos los items si no hay filtro
                    $allItems.closest('li').show();
                    hideNoResultsMessage($relationshipField);
                    //console.log('👁️ Mostrando todos los items');
                }
            } else {
                console.error('❌ No se encontró el campo relationship');
            }
        }
        
        // Función para mostrar mensaje de "sin resultados"
        function showNoResultsMessage($relationshipField, term) {
            hideNoResultsMessage($relationshipField);
            
            var $choicesList = $relationshipField.find('.choices-list');
            if ($choicesList.length) {
                $choicesList.prepend(
                    '<li class="no-results-message" style="padding: 15px; background: #fff3cd; border: 1px solid #ffc107; color: #856404; text-align: center; font-style: italic;">' +
                    '⚠️ No hay posts con el filtro seleccionado (Término ID: ' + term + ')' +
                    '</li>'
                );
            }
        }
        
        // Función para ocultar mensaje de "sin resultados"
        function hideNoResultsMessage($relationshipField) {
            $relationshipField.find('.no-results-message').remove();
        }
        
        // Event listeners para cambios en el select - USANDO REMOVE NATIVO DE ACF
        $(document).on('change', '[data-name="filter_views_filters"] select', function() {
            //console.log('Cambio detectado en select filter_views_filters');
            var $selectField = $(this);
            
            // Al cambiar filtro, SIEMPRE limpiar y filtrar (ignorar preventAutoFilter)
            var $layout = $selectField.closest('[data-layout="group"]');
            var $relationshipField = $layout.find('[data-name="filter_views_posts"]');
            hideNoResultsMessage($relationshipField);
            
            // NUEVO: Usar el botón remove nativo de ACF para limpiar selecciones
            var $removeButtons = $relationshipField.find('.values-list a[data-name="remove_item"]');
            
            //console.log('Botones remove encontrados:', $removeButtons.length);
            
            if ($removeButtons.length > 0) {
                // Hacer click en todos los botones remove
                $removeButtons.each(function(index) {
                    var $button = $(this);
                    setTimeout(function() {
                        $button.trigger('click');
                        //console.log('🧹 Click en remove button', index + 1);
                    }, index * 50); // Delay escalonado para evitar conflictos
                });
                
                // Aplicar filtro después de que todos los removes hayan terminado
                setTimeout(function() {
                    filterRelationshipItems($selectField);
                }, ($removeButtons.length * 50) + 200);
            } else {
                // Si no hay items seleccionados, aplicar filtro inmediatamente
                setTimeout(function() {
                    filterRelationshipItems($selectField);
                }, 100);
            }
        });
        
        // Backup event listener
        $(document).on('change', '[data-key*="filter_views_filters"] select', function() {
            //console.log('Cambio detectado en select (backup)');
            var $selectField = $(this);
            
            $selectField.data('changed', true);

            var $layout = $selectField.closest('[data-layout="group"]');
            var $relationshipField = $layout.find('[data-name="filter_views_posts"]');
            hideNoResultsMessage($relationshipField);
            
            var $removeButtons = $relationshipField.find('.values-list a[data-name="remove_item"]');
            
            //console.log('🔍 Botones remove encontrados (backup):', $removeButtons.length);
            
            if ($removeButtons.length > 0) {
                $removeButtons.each(function(index) {
                    var $button = $(this);
                    setTimeout(function() {
                        $button.trigger('click');
                        //console.log('Click en remove button (backup)', index + 1);
                    }, index * 50);
                });
                
                setTimeout(function() {
                    filterRelationshipItems($selectField);
                }, ($removeButtons.length * 50) + 200);
            } else {
                setTimeout(function() {
                    filterRelationshipItems($selectField);
                }, 100);
            }
        });
        

        $(document).ready(function() {

            var filterColors = <?= $filter_colors ?>;

            //console.log(filterColors);

            $('#card_filterschecklist li').each(function(){
                const $this = $(this);
                const id = $this.find('input').val();
                const found = Object.entries(filterColors).find(([key, item]) => item.id == id);
                const color = found[1].color ?? 'blue';
                $this.find('label').append(`<span style="width:11px;height:11px;border-radius:12px;background-color:${color};display:inline-block;vertical-align:middle;margin-left:5px;transform:translateY(-1px)"></span>`);
            });

            //inicializa los otros fields relationship
            $('[data-name="featured_view_posts"]').mouseover();
            $('[data-name="all_view_posts"]').mouseover();
            $('[data-name="list_view_posts"]').mouseover();

            //inicializa los filter views existentes
            
            $('[data-name="featured_view_posts"], [data-name="all_view_posts"], [data-name="list_view_posts"]').each(function(i){
                let $relationshipField = $(this);
                let interval = setInterval(function(){
                    let $choicesList = $relationshipField.find('.choices-list .acf-rel-item');
                    let $valueList = $relationshipField.find('.values-list .acf-rel-item');
                    if($choicesList.length > 0){
                        clearInterval(interval);
                        setTimeout(() => {
                            $choicesList.find('.relationship-item-card-color').each(function(){
                                let $color = $(this);
                                let color = '#'+$color.attr('class').split('hexa-')[1];
                                $color.css({backgroundColor: color});
                            });
                            $valueList.each(function(){
                                let $item = $(this);
                                let colorHTML = '';
                                $choicesList.each(function(){
                                    $chioceItem = $(this);
                                    if($item.data('id') == $chioceItem.data('id')){
                                        let $span = $chioceItem.find('.relationship-item-card-colors');
                                        if(!!$span[0]){
                                            colorHTML = $span[0].outerHTML;
                                        }
                                        return false;
                                    }
                                });
                                $item[0].insertAdjacentHTML('afterbegin',colorHTML);
                            });
                        }, 50);
                    }
                }, 250);
            });


            //inicializa los filter views que se agregan
            acf.addAction('append', function($el) {
                // Hook oficial de ACF cuando se agrega contenido
                let $filterViewsPosts = $el.find('[data-name="filter_views_posts"]');
                if($filterViewsPosts.length){
                    $el.find('[data-name="filter_views_posts"]').mouseover();
                    let n = 0;
                    let interval = setInterval(() => {
                        let $choicesList = $el.find('.choices-list .acf-rel-item');
                        if($choicesList.length){
                            $choicesList.find('.relationship-item-card-color').each(function(){
                                let $color = $(this);
                                let color = '#'+$color.attr('class').split('hexa-')[1];
                                $color.css({backgroundColor: color});
                            });
                            clearInterval(interval);
                        }else if(n < 40){
                            n++;
                        }else{
                            clearInterval(interval);
                        }
                    },250);
                    /* setTimeout(() => {
                        
                    },500); */
                }
            });
            
            //inicializa los filter views existentes
            $('[data-name="filter_views_posts"]').each(function(i){
                let $relationshipField = $(this);
                if($relationshipField.html().indexOf('row') !== -1){//verifica que no sea el duplicado de ACF
                    $relationshipField.mouseover();//forzamos el inicio
                    let attempts = 0;
                    let interval = setInterval(() => {
                        attempts++;
                        let $choicesList = $relationshipField.find('.choices-list .acf-rel-item');
                        if ($choicesList.length > 0) {
                            clearInterval(interval);
                            //
                            let $select = $relationshipField.parent().find('.acf-field-taxonomy select');
                            filterRelationshipItems($select);
                            //
                            let $valueList = $relationshipField.find('.values-list .acf-rel-item');
                            $choicesList.find('.relationship-item-card-color').each(function(){
                                let $color = $(this);
                                let color = '#'+$color.attr('class').split('hexa-')[1];
                                $color.css({backgroundColor: color});
                            });
                            //
                            $valueList.each(function(){
                                let $item = $(this);
                                let colorHTML = '';
                                $choicesList.each(function(){
                                    $chioceItem = $(this);
                                    if($item.data('id') == $chioceItem.data('id')){
                                        let $span = $chioceItem.find('.relationship-item-card-colors');
                                        if(!!$span[0]){
                                            colorHTML = $span[0].outerHTML;
                                        }
                                        return false;
                                    }
                                });
                                $item[0].insertAdjacentHTML('afterbegin',colorHTML);
                            });
                        }
                    }, 250);    
                }
            });  
            
        });
        
        var relationshipLoadObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && !preventAutoFilter) {
                    var $addedNodes = $(mutation.addedNodes);
                    
                    // Solo actuar si se agregaron items de choices (no values)
                    //var $choicesItems = $addedNodes.find('.choices-list [data-card-filters]');
                    var $choicesItems = $addedNodes.find('.choices-list .card-with-filters');
                    
                    if ($choicesItems.length > 0) {
                        //console.log('Nuevos items de choices detectados, verificando filtros activos');
                        
                        // Verificar si hay filtros seleccionados que necesiten aplicarse
                        $('[data-name="filter_views_filters"] select').each(function() {
                            var $select = $(this);
                            if ($select.val()) {
                                //console.log('Re-aplicando filtro para nuevos items de choices');
                                setTimeout(function() {
                                    filterRelationshipItems($select);
                                }, 100);
                            }
                        });
                    }
                }
            });
        });
        
        // Observar cambios en toda la página (para detectar cuando ACF carga items)
        relationshipLoadObserver.observe(document.body, {
            childList: true,
            subtree: true
        });

        const taxonomyBox = document.querySelector('#card_filterschecklist');
        if (taxonomyBox) {
            taxonomyBox.addEventListener('change', function (e) {
                if (e.target.type === 'checkbox') {
                    taxonomyBox.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                        if (cb !== e.target) cb.checked = false;
                    });
                }
            });
        }
        
    })(jQuery);
    </script>
    
    <style>

    /* Estilos para ocultar algunos controles de los filters en cada post de cards */

    #taxonomy-card_filters .category-tabs,
    #taxonomy-card_filters .taxonomy-add-new,
    #taxonomy-card_filters .wpseo-is-primary-term,
    #taxonomy-card_filters .wpseo-make-primary-term{
        display: none !important;
    }
    #taxonomy-card_filters .wpseo-primary-term > label {
        font-weight: 400 !important;
    }
    #taxonomy-card_filters .tabs-panel{
        border: none;
    }

    .taxonomy-card_filters .list-of-colors{
        margin-bottom: 50px !important;
    }
    .taxonomy-card_filters .wpseo-taxonomy-metabox-postbox{
        margin-top: 50px;
        display: none;
    }
    .taxonomy-card_filters .form-field.term-parent-wrap,
    .taxonomy-card_filters .form-field.term-description-wrap{
        display: none;
    }
    .filterschecklist-color-sq{
        width: 12px;
        height: 12px;
        border-radius: 12px;
        background-color: blue;
        display: inline-block;
    }

    /* Estilos para mejorar la experiencia visual */


    .acf-field-flexible-content[data-name='filter_views']{
        min-height: 700px;
    }
    .relationship-item-card-colors{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding-right: 5px;
        width: fit-content;
    }
    .relationship-item-card-color{
        width: 12px;
        height: 12px;
        border-radius: 12px;
        background: blue;
        transform: translateY(2px);
        border: solid 1px white;
    }

    [data-name='filter_views'] .acf-realtionship-large .acf-relationship .selection{
        height: 100%;
    }
    .acf-relationship [data-card-filters] {
        transition: opacity 0.3s ease;
    }
    
    .acf-relationship li:hidden {
        display: none !important;
    }
    
    .no-results-message {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    </style>
    <?php
});

// 3. Función para cambiar titulo en la row del flex content
function filter_views_content_title($title, $field, $layout, $i){
    // load name sub field
    $term_id = get_sub_field('filter_views_filters');
    if($term_id){
        $term = get_term( $term_id, 'card_filters' );
        $title = '<b>'.$term->name.'</b>';
    }
    //
    if (strlen($title) > 71) {
        $title = substr($title, 0, 71) . '...';
    }
    // return
    return str_replace("\'", "'", $title);
}
add_filter('acf/fields/flexible_content/layout_title/name=filter_views', 'filter_views_content_title', 10, 4);

// 4. Función para mostrar en frontend
function display_filter_views_content($source = 'auto') {
    if ($source === 'auto') {
        $filter_views = get_field('filter_views', 'option');
        
        if (!$filter_views) {
            $cards_posts = get_posts([
                'post_type' => 'cards',
                'posts_per_page' => 1,
                'meta_query' => [
                    [
                        'key' => 'filter_views',
                        'compare' => 'EXISTS'
                    ]
                ]
            ]);
            
            if ($cards_posts) {
                $filter_views = get_field('filter_views', $cards_posts[0]->ID);
                $source = $cards_posts[0]->ID;
            }
        } else {
            $source = 'option';
        }
    } else {
        $filter_views = get_field('filter_views', $source);
    }
    
    if ($filter_views) {
        echo '<div class="filter-views-container">';
        
        foreach ($filter_views as $layout) {
            if ($layout['acf_fc_layout'] == 'group') {
                $selected_filter = $layout['filter_views_filters'] ?? null;
                $related_posts = $layout['filter_views_posts'] ?? null;
                
                if ($related_posts) {
                    echo '<div class="filter-view-item">';
                    
                    if ($selected_filter) {
                        $filter_term = get_term($selected_filter);
                        if ($filter_term && !is_wp_error($filter_term)) {
                            echo '<h3>Filtro: ' . esc_html($filter_term->name) . '</h3>';
                        }
                    }
                    
                    echo '<div class="filtered-cards">';
                    foreach ($related_posts as $related_post) {
                        echo '<div class="card-item">';
                        echo '<h4><a href="' . get_permalink($related_post->ID) . '">' . get_the_title($related_post->ID) . '</a></h4>';
                        if (has_post_thumbnail($related_post->ID)) {
                            echo get_the_post_thumbnail($related_post->ID, 'medium');
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                    
                    echo '</div>';
                }
            }
        }
        
        echo '</div>';
    }
}

function card_modules_acf_flex_content_title($title, $field, $layout, $i)
{
    // backup default title
    $tmp_title = $title;
    // remove layout title from text
    $title = strip_tags(get_sub_field('title')) ?: strip_tags(get_sub_field('text'));
    if(empty($title)){
        $title = $tmp_title;
    }else{
        if (strlen($title) > 60) {
            $title = substr($title, 0, 60) . '...';
        }
        $title = "<b style='color:#aaaaaa'>{$tmp_title}:</b> {$title}";
    }
    // return
    return str_replace("\'", "'", $title);
}
add_filter('acf/fields/flexible_content/layout_title/name=card_modules', 'card_modules_acf_flex_content_title', 10, 4);


add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style(
        'acf-admin-icons',
        plugin_dir_url('advanced-custom-fields/acf.php') . 'assets/build/css/acf.css',
        [],
        '6.0'
    );
});

?>

