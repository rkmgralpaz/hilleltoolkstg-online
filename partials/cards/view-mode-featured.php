<div class="page-cards-v2__view-mode-featured">

    <div id="view-mode-featured-holder" class="page-cards-v2__view-mode-featured-holder">

    <?php

    $card_colors = get_cards_color_by_filters();
    $card_posts = get_field('featured_view_posts','cards') ?: [];
    $card_settings = get_field('featured_view_settings','cards');
    if(isset($card_settings['random_order']) && $card_settings['random_order']):
        shuffle($card_posts);
    endif;
    
    foreach($card_posts as $post_id):
        
        $card_permalink = get_permalink($post_id);
        $card_title = get_the_title($post_id);
        $card_filters = wp_get_post_terms($post_id,'card_filters');

        $term = get_term_by( 'slug', $current_filter, 'card_filters' );

        if(!empty($card_filters) && (empty($current_filter) || $card_filters[0]->slug == $current_filter)):
            $color_num = $card_colors[$card_filters[0]->slug]['num'];
            $date = 'Updated on '.get_the_date($post_id);
    ?>

    <div class="page-cards-v2__item page-cards-v2__item--not-fade page-cards-v2__card page-cards-v2__card--color-<?= $color_num; ?>">
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

    <div class="page-cards-v2__view-mode-featured-desktop-controls">
        <button class="page-cards-v2__view-mode-featured-desktop-prev-btn" aria-label="Previous Card group">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.06066 8.00001L10.5303 2.53034L9.46966 1.46968L3.46967 7.46968L2.93934 8.00001L3.46967 8.53034L9.46967 14.5303L10.5303 13.4697L5.06066 8.00001Z" fill="#33312E"></path>
            </svg>
        </button>
        <button class="page-cards-v2__view-mode-featured-desktop-next-btn" aria-label="Next Card group">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9393 8.00001L5.46967 2.53034L6.53033 1.46968L12.5303 7.46968L13.0607 8.00001L12.5303 8.53034L6.53033 14.5303L5.46967 13.4697L10.9393 8.00001Z" fill="#33312E"></path>
            </svg>
        </button>
    </div>

    <div class="page-cards-v2__view-mode-featured-mobile-controls">
        <button class="page-cards-v2__view-mode-featured-mobile-prev-btn" aria-label="Previous Card">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.06066 8.00001L10.5303 2.53034L9.46966 1.46968L3.46967 7.46968L2.93934 8.00001L3.46967 8.53034L9.46967 14.5303L10.5303 13.4697L5.06066 8.00001Z" fill="#33312E"></path>
            </svg>
        </button>
        <button class="page-cards-v2__view-mode-featured-mobile-next-btn" aria-label="Next Card">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9393 8.00001L5.46967 2.53034L6.53033 1.46968L12.5303 7.46968L13.0607 8.00001L12.5303 8.53034L6.53033 14.5303L5.46967 13.4697L10.9393 8.00001Z" fill="#33312E"></path>
            </svg>
        </button>
    </div>

</div>

