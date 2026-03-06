<div class="custom-select-wrapper font-label-md theme__text--primary">
    <button id="select-toggle" class="custom-select-button font-label-md">
        <?php echo get_label($current_order); ?> <span class="arrow">
            <?php include get_template_directory() . '/icons/chevron-down.php'; ?>
        </span>
    </button>
    <div class="custom-select-options">
        <div data-value="alphabetically" data-url="<?= build_url(['orderby' => 'alphabetically'], [], 'sort'); ?>" class="font-label-md custom-option <?php echo is_selected('alphabetically'); ?>">ALPHABETICALLY</div>
        <div data-value="format" data-url="<?= build_url(['orderby' => 'format'], [], 'sort'); ?>" class="font-label-md custom-option <?php echo is_selected('format'); ?>">FORMAT</div>
        <div data-value="topic" data-url="<?= build_url(['orderby' => 'topic'], [], 'sort'); ?>" class="font-label-md custom-option <?php echo is_selected('topic'); ?>">TOPIC</div>
    </div>
</div>