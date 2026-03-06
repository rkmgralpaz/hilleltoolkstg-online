<div class="page-cards-v2__view-mode-search">

    <?php

    $card_colors = get_cards_color_by_filters();

    $all_posts = get_posts(array(
        'post_type' => 'cards',
        'posts_per_page'=> -1,
    ));

    foreach($all_posts as $p):
        $post_id = $p->ID;
        $card_filters = wp_get_post_terms($post_id,'card_filters');
        $has_filters = !empty($card_filters);
        $like_title = $has_filters && strpos(strtolower($p->post_title),strtolower($search_param)) !== false;
        $like_tag = $has_filters && strpos(strtolower($card_filters[0]->slug),strtolower($search_param)) !== false;
        if($like_title || $like_tag):
            $card_permalink = get_permalink($post_id);
            $card_title = get_the_title($post_id);
            $color_num = $card_colors[$card_filters[0]->slug]['num'];
            $date = 'Updated on '.get_the_date($post_id);
    ?>

    <div class="page-cards-v2__item page-cards-v2__item-search page-cards-v2__item-search--color-<?= $color_num; ?>">       
        <div class="page-cards-v2__item-search-filters font-label-md">
            <div class="page-cards-v2__item-search-tag"><?= $card_filters[0]->name ?></div>
            <!-- <?= $date ?> -->
        </div>
        <a href="<?= $card_permalink ?>">
            <div class="page-cards-v2__item-search-title font-display-xs"><?= $card_title ?></div>
            <div class="page-cards-v2__item-search-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M12.4116 8.75L0.888886 8.75L0.888885 7.25L12.4116 7.25L8.35856 3.197L9.41922 2.13634L14.7525 7.46967L15.2829 8L14.7525 8.53033L9.41922 13.8637L8.35856 12.803L12.4116 8.75Z"></path>
                </svg>
            </div>
        </a>
    </div>

    <?php
        endif;
    endforeach;
    ?>

</div>

