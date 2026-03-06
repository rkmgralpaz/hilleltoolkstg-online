<div class="page-cards-v2__view-mode-list">

    <?php

    $card_colors = get_cards_color_by_filters();

    $card_posts = [];

    if(empty($current_filter)):
        $card_posts = get_field('list_view_posts','cards') ?: [];
        $card_settings = get_field('list_view_settings','cards');
        if($card_settings['include_unselected_posts']):
            while ( have_posts() ) : the_post();
                $tmp_id = get_the_ID();
                if(!in_array($tmp_id,$card_posts)):
                    $card_posts[] = $tmp_id;
                endif;
            endwhile;
        endif;
        if(isset($card_settings['random_order']) && $card_settings['random_order']):
            shuffle($card_posts);
        endif;
        //
    else:
        $filter_views = get_field('filter_views','cards');
        if(!empty($filter_views)):
            $term = get_term_by( 'slug', $current_filter, 'card_filters' );
            foreach($filter_views as $view):
                if($view['filter_views_filters'] == $term->term_id):
                    $card_posts = $view['filter_views_posts'];
                    $random_order = $view['random_order'];
                    $include_unselected_posts = $view['include_unselected_posts'];
                    if($include_unselected_posts):
                        $all_posts = get_posts(array(
                            'post_type' => 'cards',
                            'posts_per_page'=> -1,
                            'tax_query' => array(
                                array (
                                    'taxonomy' => 'card_filters',
                                    'field' => 'slug',
                                    'terms' => [$current_filter],
                                )
                            ),
                        ));
                        foreach($all_posts as $p):
                            $tmp_id = $p->ID;
                            if(!in_array($tmp_id,$card_posts)):
                                $card_posts[] = $tmp_id;
                            endif;
                        endforeach;
                    endif;
                    if($random_order):
                        shuffle($card_posts);
                    endif;
                    break;
                endif;
            endforeach;
        endif;
    endif;

    function extract_first_paragraph($html) {
        // Buscar el primer <p> y su contenido
        preg_match('/<p[^>]*>(.*?)<\/p>/is', $html, $matches);
        // Si se encontró un párrafo, devolver su contenido
        if (!empty($matches[1])) {
            return trim($matches[1]);
        }
        // Si no se encontró ningún párrafo, devolver cadena vacía
        return '';
    }

    foreach($card_posts as $post_id):
        
        $card_permalink = get_permalink($post_id);
        $card_title = get_the_title($post_id);
        $card_filters = wp_get_post_terms($post_id,'card_filters');
        if(!empty($card_filters)):
            $color_num = $card_colors[$card_filters[0]->slug]['num'];
            $date = 'Updated on '.get_the_date($post_id);
            $blurb = get_field('blurb_for_list_view',$post_id);
            if(empty($blurb) && !empty($modules = get_field('card_modules',$post_id))):
                foreach($modules as $module):
                    if($module['acf_fc_layout'] == 'highlight' || $module['acf_fc_layout'] == 'text'):
                        $blurb = extract_first_paragraph($module['text']);
                        break;
                    endif;
                endforeach;
            endif;
    ?>

    <div class="page-cards-v2__item page-cards-v2__item-list page-cards-v2__item-list--color-<?= $color_num; ?>">       
        <div class="page-cards-v2__item-list-filters font-label-md">
            <div class="page-cards-v2__item-list-tag"><?= $card_filters[0]->name ?></div>
            <!-- <?= $date ?> -->
        </div>
        <a href="<?= $card_permalink ?>">
            <div class="page-cards-v2__item-list-title font-display-xs"><?= $card_title ?></div>
            <div class="page-cards-v2__item-list-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M12.4116 8.75L0.888886 8.75L0.888885 7.25L12.4116 7.25L8.35856 3.197L9.41922 2.13634L14.7525 7.46967L15.2829 8L14.7525 8.53033L9.41922 13.8637L8.35856 12.803L12.4116 8.75Z"></path>
                </svg>
            </div>
        </a>
        <div class="page-cards-v2__item-list-blurb font-body-sm">
            <?= $blurb ?>
        </div>
    </div>

    <?php
        endif;
    endforeach;
    ?>

</div>



