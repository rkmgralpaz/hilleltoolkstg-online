<?php

$year_titles = [];
$args = [
    'post_type'      => 'data_interactive',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
];
$query = new WP_Query($args);

$current_post_id = get_the_ID();

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $title = get_the_title();
        $link = get_permalink();
        $post_id = get_the_ID();

        preg_match('/(\d{4})-(\d{4})/', $title, $matches);
        if (!empty($matches)) {
            $start_year = (int)$matches[1];
            $end_year = (int)$matches[2];
            $year_titles[] = [
                'title'      => $title,
                'link'       => $link,
                'start_year' => $start_year,
                'end_year'   => $end_year,
                'post_id'    => $post_id,
            ];
        }
    }
}
wp_reset_postdata();

usort($year_titles, function ($a, $b) {
    return $a['start_year'] <=> $b['start_year'];
});
?>


<div class="data-interactive-single__control-years-wrapper">
    <?php
    echo get_button(array(
        'class' => 'data-interactive-single__arrow-btn data-interactive-single__prev-btn btn--secondary btn--small btn--icon-only',
        'icon'  => 'chevron-left',
        'aria-label' => 'Scroll left',
        'tag' => 'button'
    ));

    echo get_button(array(
        'class' => 'data-interactive-single__arrow-btn data-interactive-single__next-btn btn--secondary btn--small btn--icon-only',
        'icon'  => 'chevron-right',
        'aria-label' => 'Scroll right',
        'tag' => 'button'
    ));
    ?>
    <div class="data-interactive-single__control-years" data-animate="fade-in-up" data-animate-delay="100">
        <?php foreach ($year_titles as $year): ?>
            <?php
            $active_class = ($year['post_id'] === $current_post_id) ? ' active' : '';
            ?>
            <div class="data-interactive-single__year <?= $active_class ?>">
                <a href="<?= esc_url($year['link']); ?>" class="data-interactive-single__year-link">
                    <?= esc_html($year['title']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="data-interactive-single__control-years-separator" data-animate="fade-in-up" data-animate-delay="200">

</div>
