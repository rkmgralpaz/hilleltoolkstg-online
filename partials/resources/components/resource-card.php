<?php
$type_link = get_field('type_link');
$link = get_field('link');
$file = get_field('file');
$card_href = '#';
$card_attrs = '';

if ($type_link === 'link' && is_array($link) && isset($link['url'])) {
    $card_href = esc_url($link['url']);
    $card_attrs = ' target="_blank"';
} elseif ($type_link === 'file' && $file) {
    $card_href = esc_url($file);
    $card_attrs = ' download';
}

?>

<?php
$topic_terms = get_the_terms(get_the_ID(), 'resources_topic');

$topic_color = '';
if (!empty($topic_terms) && !is_wp_error($topic_terms)) {
    $raw_color = get_field('color', 'term_' . $topic_terms[0]->term_id);
    $color_parts = explode('--', $raw_color);
    $topic_color = $color_parts[0]; // Extraer la parte antes del doble guion
}
$format_terms = get_the_terms(get_the_ID(), 'resources_format');
?>
<a href="<?php echo $card_href; ?>" <?php echo $card_attrs; ?> class="resource__card" data-animate="fade-up">

    <div class="resource__card-top">

        <div class="resource__card-title-top">
            <div class="resource__card-title font-heading-md theme__text--primary"><?php echo get_the_title(); ?></div>

            <div class="resource__card-format">
                <?php if (!empty($format_terms) && !is_wp_error($format_terms)) {
                    include get_template_directory() . '/icons-resource-formats/' . $format_terms[0]->slug . '.php';
                } ?>
            </div>

        </div>

        <div class="resource__card-author font-body-sm theme__text--secondary"><?php echo get_field('author'); ?></div>
        <div class="resource__card-secondary font-body-sm theme__text--secondary"><?php echo get_field('secondary_information'); ?></div>
    </div>

    <div class="resource__card-bottom">

        <div class="resource__card-topics">
            <?php if (!empty($topic_terms) && !is_wp_error($topic_terms)) : ?>
                <?php foreach ($topic_terms as $term) : ?>
                    <?php
                    $term_raw_color = get_field('color', 'term_' . $term->term_id);
                    $term_color_parts = explode('--', (string) $term_raw_color);
                    $term_color = $term_color_parts[0] ?? '';
                    ?>
                    <div class="resource__card-topic font-label-md font-uppercase resource__card-topic--<?php echo esc_attr($term_color); ?>">
                        <?php echo esc_html($term->name); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="resource__card-button">
            <?php
            $icon = 'arrow-45';

            if ($type_link === 'file' && $file) {
                $icon = 'arrow-down';
            } elseif ($type_link === 'link' && is_array($link) && isset($link['url'])) {
                $url = $link['url'];
                $is_internal = strpos($url, home_url()) === 0;
                $icon = $is_internal ? 'arrow-right' : 'arrow-45';
            }

            echo get_button(array(
                'tag' => 'button',
                'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
                'icon' => $icon,
            ));
            ?>
        </div>


    </div>

</a>
