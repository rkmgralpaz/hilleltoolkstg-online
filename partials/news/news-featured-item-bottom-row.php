<?php
$title = get_the_title($post_id);
$link = get_field('link', $post_id);
$permalink = $link ?: get_the_permalink($post_id);
$target = $link ? '_blank' : '_self';
$icon_html = '';
if ($link) {
    ob_start();
    get_template_part('icons/union');
    $icon_html = ob_get_clean();
}
$image = get_field('image', $post_id);
$blurb = get_field('blurb', $post_id);
$date = get_field('date', $post_id) ? get_field('date', $post_id) : get_the_date($post_id);
$source = get_field('source', $post_id);
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
$terms = wp_get_post_terms($post_id, 'news_tag');
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
<article class="news__item-wrapper news__item-wrapper-1">
    <a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" class="">
        
        <div class="image" data-src="<?php echo $image['url']; ?>">
            <div class="image__inner"></div>
        </div>

        <div class="news__item-tag-list">
            <?php echo $terms_html; ?>
        </div>

        <h2 class="news__featured-item-title font-heading-md theme__text--primary">
            <?php echo $title;?>
            <?php if ($icon_html) : ?>
                <span class="news__featured-item-title-icon"><?php echo $icon_html; ?></span>
            <?php endif; ?>
        </h2>
        <div class="news__featured-item-details font-body-sm theme__text--secondary">
            <?php echo $output; ?>
        </div>
        
    </a>
</article>

