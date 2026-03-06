<?php
if (empty($module_related_media) || !is_array($module_related_media)) {
    return '';
}

$module = $module_related_media;
$title = $module['title'] ?? '';
$resources = isset($module['resources']) && is_array($module['resources']) ? array_filter($module['resources']) : [];
$resource_count = count($resources);
$show_navigation = $resource_count > 1;

ob_start();
?>
<div class="page-cards-single-v2__module page-cards-single-v2__module-related-media theme theme--neutral theme-mode-light" data-related-media-module>
    <div class="page-cards-single-v2__module-related-media__header">
        <?php if (!empty($title)) : ?>
            <div class="page-cards-single-v2__module-related-media__title font-heading-md">
                <?php echo esc_html($title); ?>
            </div>
        <?php endif; ?>

        <?php if ($show_navigation) : ?>
            <div class="page-cards-single-v2__module-related-media__nav" hidden>
                <?php
                echo get_button([
                    'tag' => 'button',
                    'type' => 'button',
                    'class' => 'page-cards-single-v2__module-related-media__nav-btn page-cards-single-v2__module-related-media__nav-btn--prev btn--primary btn--small btn--icon-only',
                    'icon' => 'chevron-left',
                    'aria-label' => 'Anterior',
                    'disabled' => 'disabled',
                ]);
                echo get_button([
                    'tag' => 'button',
                    'type' => 'button',
                    'class' => 'page-cards-single-v2__module-related-media__nav-btn page-cards-single-v2__module-related-media__nav-btn--next btn--primary btn--small btn--icon-only',
                    'icon' => 'chevron-right',
                    'aria-label' => 'Siguiente',
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($resources)) : ?>
        <div class="page-cards-single-v2__module-related-media__resources" data-related-media-slider>
            <?php
            global $post;
            foreach ($resources as $resource_id) {
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
<?php
return ob_get_clean();
