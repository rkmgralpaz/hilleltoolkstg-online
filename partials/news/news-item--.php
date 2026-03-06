<?php
$link = get_field('link');
$permalink = $link ?: get_the_permalink();
$target = $link ? '_blank' : '_self';
$title = get_the_title();

$icon_html = '';
if ($link) {
    ob_start();
    get_template_part('icons/union');
    $icon_html = ob_get_clean();
}

$delay = 100;

?>


<a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" class="news__posts-item" data-animate="fade-in-up" data-animate-delay="<?php echo $delay; ?>">

    <?php
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
                //en page-news.js se aplican las clases --color-filter... comparando el data-value con el input:checkbox value de los filtros
            }
        }
    }

    ?>

    <div class="news__item-tag-list">
        <?php echo $terms_html; ?>
    </div>

    <div class="news__item-details font-body-sm theme__text--secondary">
        <?php echo esc_html($output); ?>
    </div>

    <h2 class="news__item-title font-heading-md theme__text--primary">
        <?php echo $title; ?>
        <?php if ($icon_html) : ?>
            <span class="news__item-title-icon"><?php echo $icon_html; ?></span>
        <?php endif; ?>
    </h2>

    <div class="news__item-blurb font-body-sm theme__text--secondary">
        <?php echo get_field('blurb'); ?>
    </div>

</a>

<?php
// $delay += 100;
?>