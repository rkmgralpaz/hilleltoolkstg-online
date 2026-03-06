<?php get_header(); ?>

<?php

// Get module settings
$title_size = '';
$transition_duration = 5;
$title = get_the_title();
$date = get_field('date');
$source = get_field('source');
if(!empty($source)){
    $date = "{$source} — {$date}";
}
$image = get_field('image');
$blurb = get_field('blurb');
$external_link = get_field('link');

?>

<div class="js-module page-news-single theme theme--neutral theme--mode-light">

    <div class="page-news-single__intro max-width">

        <div>

            <div>

                <?php

                $terms = wp_get_post_terms(get_the_ID(), 'news_tag');
                $terms_html = '';
                $terms_counter = 0;
                if (!is_wp_error($terms) && !empty($terms)) {
                    foreach ($terms as $index =>$term) {
                        $terms_counter ++;
                        if($terms_counter <= 2){//muestra solo los 2 primeros terms
                            $terms_html .= "<div class='news__item-tag news__item-tag--num-{$terms_counter} font-label-md theme__text--primary font-uppercase' data-value='{$term->slug}'>{$term->name}</div>";
                            //en page-news.js se aplican las clases --color-filter... comparando el data-value con el input:checkbox value de los filtros
                        }
                    }
                }

                ?>

                <div class="news__item-tag-list" data-animate="fade-in-up" data-animate-delay="">
                    <?php echo $terms_html; ?>
                </div>

                <?php

                echo get_dynamic_heading(
                    $title,
                    'h1',
                    'theme__text--primary font-display-md',
                    ['data-animate' => 'fade-in-up']
                );
                ?>

                <div class="page-news-single__date theme__text--secondary font-body-sm" data-animate="fade-in-up" data-animate-delay="100">
                    <?php echo $date ?? ''; ?>
                </div>                

                <div class="page-news-single__text theme__text--secondary font-body-md" data-animate="fade-in-up" data-animate-delay="200">
                    <?php echo $blurb ?? ''; ?>
                </div>

            
                <div class="page-news-single__buttons" data-animate="fade-in-up" data-animate-delay="200">

                    <div>

                        <?php
                        echo get_button(array(
                            'html_text' =>  'Read more',
                            'href' =>  $external_link,
                            'target' =>  '',
                            'class' => 'btn--primary btn--large btn--icon-after',
                            'icon' => 'arrow-45',
                        ));
                        ?>

                    </div>

                    <div data-animate="fade-in-up" data-animate-delay="200">

                        <?php
                        echo get_button(array(
                            'html_text' =>  'Latest News from Campus',
                            'href' =>  BASE_URL.'news/',
                            'target' =>  '_blank',
                            'class' => 'btn--secondary btn--large btn--icon-after',
                            'icon' => 'arrow-right',
                        ));
                        ?>

                    </div>

                </div>
            

            </div>

            <div class="page-news-single__image" data-animate="fade-in-up" data-transition-duration="200">
                <?php
                if(!empty($image)):
                    echo "<img src='{$image['url']}' alt='' width='{$image['width']}' height='{$image['height']}' />";
                endif;
                ?>
            </div>

        </div>

    </div>

</div>

<div class="theme theme--neutral theme--mode-theme--mode-light js-module page-news single-bottom-news" data-animate="fade-in-up" data-animate-delay="100">
    <div class="max-width">
        <div class="news__posts">
            
            <div class="news__posts-title theme__text--primary font-heading-lg">
                More News from Campus
            </div>

            <?php
            wp_reset_postdata();
           
            $args = [
                'post_type'      => 'news',
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'date',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'paged'          => 1,
            ];

            $query = new WP_Query($args);

            remove_filter('posts_where', '__return_false', 10);

            if ($query->have_posts()): ?>
                <div class="news__posts-items">
                    <?php while ($query->have_posts()): $query->the_post();
                        get_template_part('partials/news/news', 'item');
                    endwhile; ?>
                </div>

                <?php
                
                echo get_button([
                    'html_text' => 'Latest News from Campus',
                    'href' => BASE_URL.'news/',
                    'target' => '',
                    'class' => 'news__posts-btn-load-more btn--secondary btn--large btn--icon-after',
                    'icon' => 'arrow-right',
                ]);
                
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