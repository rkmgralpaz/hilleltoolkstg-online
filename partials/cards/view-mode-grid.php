<div class="page-cards-v2__view-mode-grid">

    <?php

    $card_colors = get_cards_color_by_filters();

    $card_posts = [];

    if(empty($current_filter)):
        $card_posts = get_field('all_view_posts','cards') ?: [];
        $card_settings = get_field('all_view_settings','cards');
        if(isset($card_settings['include_unselected_posts']) && $card_settings['include_unselected_posts']):
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

    foreach($card_posts as $post_id):
        
        $card_permalink = get_permalink($post_id);
        $card_title = get_the_title($post_id);
        $card_filters = wp_get_post_terms($post_id,'card_filters');
        if(!empty($card_filters)):
            $color_num = $card_colors[$card_filters[0]->slug]['num'];
            $date = 'Updated on '.get_the_date($post_id);
    ?>

    <div class="page-cards-v2__item page-cards-v2__card page-cards-v2__card--color-<?= $color_num; ?>">
        <div class="page-cards-v2__card-holder">
            <div class="page-cards-v2__card-title font-display-xs"><?= $card_title ?></div>
            <div class="page-cards-v2__card-filters font-label-md"><div><?= $card_filters[0]->name ?></div></div>
            <div class="page-cards-v2__card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none" aria-hidden="true">
                    <path class="svg-fill" d="M6.46971 4.93451C6.7626 4.64162 7.23736 4.64162 7.53026 4.93451C7.82299 5.22742 7.8231 5.70222 7.53026 5.99506L4.81053 8.71479H16.5C19.3995 8.71479 21.75 11.0653 21.75 13.9648C21.7498 16.8641 19.3994 19.2148 16.5 19.2148H12C11.5859 19.2148 11.2502 18.8789 11.25 18.4648C11.25 18.0506 11.5858 17.7148 12 17.7148H16.5C18.5709 17.7148 20.2498 16.0357 20.25 13.9648C20.25 11.8937 18.5711 10.2148 16.5 10.2148H4.81053L7.53026 12.9345L7.58202 12.9912C7.82216 13.2857 7.8048 13.7205 7.53026 13.9951C7.25569 14.2695 6.82087 14.2869 6.52635 14.0468L6.46971 13.9951L2.46971 9.99506C2.17687 9.70222 2.17698 9.22742 2.46971 8.93451L6.46971 4.93451Z" fill="#FAF2EB"/>
                </svg>
            </div>
        </div>
        <a href="<?= $card_permalink ?>" class="page-cards-v2__card-hit-area">
            <span class="sr-only">View more about: <?= $card_title ?></span>
        </a>
    </div>

    <?php
        endif;
    endforeach;
    ?>

</div>

