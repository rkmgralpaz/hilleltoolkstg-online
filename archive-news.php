<?php get_header(); ?>


<?php

function should_display_featured_news()
{
    $no_tag_selected = !isset($_GET['news-tag']) || empty($_GET['news-tag']);
    $no_search_term = !isset($_GET['search']) || empty($_GET['search']);
    return $no_tag_selected && $no_search_term;
}


?>

<div class="theme theme--neutral theme--mode-theme--mode-light js-module page-news">
    <div class="max-width">

        <div class="news__header">
            <?php echo get_dynamic_heading(get_field('title', 'news'), get_field('heading_tag', 'news'), 'theme__text--primary font-heading-lg custom-class'); ?>
        </div>

        <form class="news__filters" action="" method="get" aria-labelledby="filter-title" autocomplete="off">
            <div class="news__filters-bar">
                <div class="news__filters-bar-title font-label-md theme__text--primary font-uppercase">
                    Filter by
                </div>

                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'news_tag',
                    'hide_empty' => true,
                ));

                $selected_tags = isset($_GET['news-tag']) ? explode(',', $_GET['news-tag']) : [];
                ?>

                <div>
                    <h2 id="filter-title" class="sr-only">Filter News by Tags</h2>

                    <ul class="news__filters-list">
                        <?php

                        $filter_n = 0;
                        foreach ($terms as $term) :
                            $filter_n++;
                            if ($filter_n > 5):
                                $filter_n = 1;
                            endif;
                        ?>
                            <li>
                                <label class="news__filter news__filter--num-<?php echo $filter_n; ?> font-label-md theme__text--primary font-uppercase" title="Filter by <?php echo esc_attr($term->name); ?>">
                                    <input
                                        type="checkbox"
                                        name="tag[]"
                                        value="<?php echo esc_attr($term->slug); ?>"
                                        aria-checked="<?php echo in_array($term->slug, $selected_tags) ? 'true' : 'false'; ?>"
                                        aria-labelledby="filter-<?php echo esc_attr($term->slug); ?>"
                                        <?php echo in_array($term->slug, $selected_tags) ? 'checked' : ''; ?>>
                                    <span class="news__filter-label" id="filter-<?php echo esc_attr($term->slug); ?>">
                                        <?php if (in_array($term->slug, $selected_tags)) {
                                            get_template_part('icons/close'); // Ruta al archivo del SVG
                                        } ?>
                                        <?php echo esc_html($term->name); ?>
                                    </span>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>


            </div>

            <div class="news__filters-search">
                <div class="news__filters-search-title font-label-md theme __text--primary font-uppercase">
                    <div class="news__filters-search-icon">
                        <?php get_template_part('icons/search-news'); ?>
                    </div>

                </div>
                <div class="news__filters-search-wrap">

                    <input
                        type="search"
                        name="search"
                        class="news__filters-search-input font-label-md theme __text--primary font-uppercase"
                        placeholder="Type your search"
                        value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>"
                        aria-label="Search news articles"
                        autocomplete="off">

                    <button type="button" class="clear-search-button" aria-label="Clear search">
                        <?php get_template_part('icons/close'); ?>
                    </button>

                </div>
            </div>

        </form>

        <?php if (should_display_featured_news()) : ?>

            <?php get_template_part('partials/news/news', 'featured'); ?>

        <?php endif;  ?>

        <div class="news__posts">
            <?php if ($title_more_news = get_field('title_more_news', 'news')): ?>
                <?php if (should_display_featured_news()) : ?>
                    <div class="news__posts-title theme__text--primary font-heading-lg" data-animate="fade-in-up">
                        <?php echo $title_more_news; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            //$exclude_ids = should_display_featured_news() ? get_field('featured_news_archive', 'news') : [];
            $exclude_ids = [];
            if(should_display_featured_news()){
                if(!empty($main_news_id = get_field('main_featured_news_item', 'news'))){
                    array_push($exclude_ids, $main_news_id);
                }
                if(!empty($left_columns_news_arr = get_field('featured_news_left_column', 'news'))){
                    foreach($left_columns_news_arr as $p_id){
                        array_push($exclude_ids, $p_id);
                    }
                }
                if(!empty($right_columns_news_arr = get_field('featured_news_right_column', 'news'))){
                    foreach($right_columns_news_arr as $p_id){
                        array_push($exclude_ids, $p_id);
                    }
                }
                if(!empty($bottom_row_arr = get_field('featured_news_bottom_row', 'news'))){
                    foreach($bottom_row_arr as $p_id){
                        array_push($exclude_ids, $p_id);
                    }
                }
            }
            $search_term = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
            $news_tag = isset($_GET['news-tag']) ? explode(',', $_GET['news-tag']) : [];

            $args = [
                'post_type'      => 'news',
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'date',
                'posts_per_page' => 6,
                'post__not_in'   => $exclude_ids,
                'post_status'    => 'publish',
                'paged'          => $paged,
                'tax_query'      => [],
                'meta_query'     => [],
            ];

            /* if (!empty($search_term)) {
                add_filter('posts_where', function ($where) use ($search_term, $wpdb) {
                    $title_search = $wpdb->prepare("{$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($search_term) . '%');
                    $blurb_search = $wpdb->prepare(
                        "EXISTS (SELECT 1 FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_key = 'blurb' AND {$wpdb->postmeta}.meta_value LIKE %s AND {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)",
                        '%' . $wpdb->esc_like($search_term) . '%'
                    );
                    $where .= " AND ({$title_search} OR {$blurb_search})";
                    return $where;
                }, 10, 2);
            } */

            if (!empty($search_term)) {
                add_filter('posts_where', function ($where) use ($search_term, $wpdb) {
                    $title_search = $wpdb->prepare("{$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like($search_term) . '%');
                    $blurb_search = $wpdb->prepare(
                        "EXISTS (SELECT 1 FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_key = 'blurb' AND {$wpdb->postmeta}.meta_value LIKE %s AND {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)",
                        '%' . $wpdb->esc_like($search_term) . '%'
                    );
                    $source_search = $wpdb->prepare(
                        "EXISTS (SELECT 1 FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_key = 'source' AND {$wpdb->postmeta}.meta_value LIKE %s AND {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID)",
                        '%' . $wpdb->esc_like($search_term) . '%'
                    );
                    $where .= " AND ({$title_search} OR {$blurb_search} OR {$source_search})";
                    return $where;
                }, 10, 2);
            }

            if (!empty($news_tag)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'news_tag',
                    'field'    => 'slug',
                    'terms'    => $news_tag,
                ];
            }

            $args['tax_query']['relation'] = 'OR';
            $args['meta_query']['relation'] = 'OR';

            $query = new WP_Query($args);

            remove_filter('posts_where', '__return_false', 10);

            if ($query->have_posts()): ?>
                <div class="news__posts-items">
                    <?php while ($query->have_posts()): $query->the_post();
                        get_template_part('partials/news/news', 'item');
                    endwhile; ?>
                </div>

                <?php
                $next_page = $paged + 1;
                if ($next_page <= $query->max_num_pages):
                    echo get_button([
                        'html_text' => 'Load more',
                        'href' => get_pagenum_link($next_page),
                        'target' => 'self',
                        'class' => 'next-page-url news__posts-btn-load-more btn--secondary btn--large btn--icon-after',
                        'icon' => 'plus',
                    ]);
                endif;
            else: ?>

                <div class="news__posts-no-results">
                    <div class="theme__text--primary font-body-md">
                        No results found para la busqueda <em>“<?php echo esc_html($search_term); ?>”</em>
                    </div>
                </div>



            <?php endif;
            wp_reset_postdata();
            ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>