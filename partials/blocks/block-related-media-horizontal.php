<?php

if (empty($module_resources) || !is_array($module_resources)) {
    return;
}

$module_resources = array_filter($module_resources);
$resource_count = count($module_resources);

$show_navigation = $resource_count > 1;

$button_size = $button_size ?? 'large';
$button_style = $button_style ?? 'secondary';
$title_size = $title_size ?? 'font-heading-xl';
?>

<div class="js-module block-related-media-horizontal theme theme--neutral theme-mode-light">
    <div class="block-related-media-horizontal__header">
        <?php if (!empty($module_title)) : ?>
            <div class="block-related-media-horizontal__title <?php echo esc_attr($title_size); ?>">
                <?php echo esc_html($module_title); ?>
            </div>
        <?php endif; ?>

        <?php if ($show_navigation) : ?>
            <div class="block-related-media-horizontal__nav" hidden>
                <?php
                echo get_button([
                    'tag' => 'button',
                    'type' => 'button',
                    'class' => "block-related-media-horizontal__nav-btn block-related-media-horizontal__nav-btn--prev btn--{$button_style} btn--{$button_size} btn--icon-only",
                    'icon' => 'chevron-left',
                    'aria-label' => 'Anterior',
                    'disabled' => 'disabled',
                ]);
                echo get_button([
                    'tag' => 'button',
                    'type' => 'button',
                    'class' => "block-related-media-horizontal__nav-btn block-related-media-horizontal__nav-btn--next btn--{$button_style} btn--{$button_size} btn--icon-only",
                    'icon' => 'chevron-right',
                    'aria-label' => 'Siguiente',
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($module_resources)) : ?>
        <div class="block-related-media-horizontal__resources">
            <?php
            global $post;
            foreach ($module_resources as $resource_id) {
                $resource_post = get_post($resource_id);
                if (!$resource_post) {
                    continue;
                }

                $post = $resource_post;
                setup_postdata($post);
                get_template_part('partials/resources/components/resource-card');
            }
            wp_reset_postdata();
            ?>
        </div>
    <?php endif; ?>
</div>