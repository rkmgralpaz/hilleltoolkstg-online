<?php

$featured_news = get_field('featured_news_archive', 'news');
$title_size = get_field('title_size', 'news');
$template_class = get_field('layout_template', 'news');

if ($featured_news) {

    $delay = 100;

    echo '<div class="news__features ' . $template_class . ' ' . $title_size . '" data-animate="fade-in-up" data-animate-delay="'.$delay.'">';

    

    foreach ($featured_news as $index => $post) {

        setup_postdata($post);

        $item_class = 'news__featured-item news__featured-item-' . ($index + 1);

        $title = get_the_title();
        $link = get_field('link');
        $permalink = $link ?: get_the_permalink();
        $target = $link ? '_blank' : '_self';

        $icon_html = '';
        if ($link) {
            ob_start();
            get_template_part('icons/union');
            $icon_html = ob_get_clean();
        }

        $image = get_field('image');
        $blurb = get_field('blurb');
        $date = get_field('date') ? get_field('date') : get_the_date();
        $source = get_field('source');
        /* $output = $date;
        if ($date && $source) {
            $output .= ' — ' . $source;
        } elseif ($source) {
            $output = $source;
        } */
        if ($date && $source) {
            $output = $source.' — ' . $date;
        } elseif ($date && !$source) {
            $output = $date;
        } elseif (!$date && $source) {
            $output = $source;
        }else{
            $output = '';
        }


        /* 
        Nota: los news__item-tag como <div> no necesitan ser accesibles 
        porque el sistema de filtros ya cumple con todas las reglas de accesibilidad.
        */

        $terms = wp_get_post_terms(get_the_ID(), 'news_tag');
        $terms_html = '';
        $terms_counter = 0;
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $terms_counter ++;
                if($terms_counter <= 2){//muestra solo los 2 primeros terms
                    $terms_html .= "<div class='news__item-tag font-label-md theme__text--primary font-uppercase' data-value='{$term->slug}'>{$term->name}</div>";
                }
            }
        }

?>
        <a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" class="<?php echo $item_class; ?>">
            
            <div class="news__item-tag-list">
                <?php echo $terms_html; ?>
            </div>

            <h2 class="news__featured-item-title font-heading-md theme__text--primary">
                <?php echo $title; ?>
                <?php if ($icon_html) : ?>
                    <span class="news__featured-item-title-icon"><?php echo $icon_html; ?></span>
                <?php endif; ?>
            </h2>
            <div class="news__featured-item-details font-body-sm theme__text--secondary">
                <?php echo $output; ?>
            </div>
            <?php if ($image) { ?>
                <div class="image" data-src="<?php echo $image['url']; ?>">
                    <div class="image__inner"></div>
                </div>
            <?php } ?>
            <div class="news__featured-item-blurb font-body-md theme__text--secondary">
                <?php echo $blurb; ?>
                <?php if ($icon_html) : ?>
                    <span class="news__featured-item-title-icon"><?php echo $icon_html; ?></span>
                <?php endif; ?>
            </div>
        </a>
<?php
        //$delay += 100;
    }


    wp_reset_postdata();

    echo '</div>';
}
?>