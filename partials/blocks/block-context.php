<?php


$context_data = get_field('context');
$items = isset($context_data['items']) ? $context_data['items'] : [];

if (empty($items)) {
    return;
}

?>

<div class="js-module block-context" data-total-items="<?php echo count($items); ?>" data-animate="fade-in-up">

    <div class="block-context__images">
        <?php if ($items): ?>
            <?php foreach ($items as $index => $layout): ?>
                <?php

                if ($layout['acf_fc_layout'] !== 'item') continue;

                $image = isset($layout['image']) ? $layout['image'] : null;
                $caption = isset($layout['caption']) ? $layout['caption'] : '';
                ?>
                <?php if ($image): ?>
                    <div class="block-context__image <?php echo $index === 0 ? 'is-active' : ''; ?>" data-index="<?php echo $index; ?>">
                        <img
                            src="<?php echo esc_url($image['url']); ?>"
                            alt="<?php echo esc_attr($image['alt'] ?: $caption); ?>"
                            loading="lazy"
                            width="<?php echo $image['width']; ?>"
                            height="<?php echo $image['height']; ?>" />
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($items): ?>
            <?php foreach ($items as $index => $layout): ?>
                <?php
                if ($layout['acf_fc_layout'] !== 'item') continue;
                $caption = isset($layout['caption']) ? $layout['caption'] : '';
                ?>
                <?php if ($caption): ?>
                    <div class="block-context__image-caption font-body-sm theme__text--primary <?php echo $index === 0 ? 'is-active' : ''; ?>" data-index="<?php echo $index; ?>">
                        <?php echo wp_kses_post($caption); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <div class="block-context__content theme theme--neutral theme--mode-light">
        <?php
        echo get_dynamic_heading(
            isset($context_data['title']) ? $context_data['title'] : '',
            isset($context_data['heading_tag']) ? $context_data['heading_tag'] : 'header-h2',
            'font-heading-xl theme__text--primary',
        );
        ?>

        <div class="block-context__content-wrapper">
            <div class="block-context__details">
                <?php if ($items): ?>
                    <?php foreach ($items as $index => $layout): ?>
                        <?php
                        if ($layout['acf_fc_layout'] !== 'item') continue;

                        $title = isset($layout['title']) ? $layout['title'] : '';
                        $description = isset($layout['description']) ? $layout['description'] : '';
                        ?>
                        <div class="block-context__detail-item <?php echo $index === 0 ? 'is-active' : ''; ?>" data-index="<?php echo $index; ?>">
                            <?php if ($title): ?>
                                <div class="block-context__details-title font-heading-xl theme__text--primary">
                                    <?php echo wp_kses_post($title); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <div class="block-context__details-text font-body-md theme__text--primary">
                                    <?php echo wp_kses_post($description); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if ($items && count($items) > 1): ?>
                <div class="block-context__controls">
                    <div class="block-context__dots">
                        <?php foreach ($items as $index => $layout): ?>
                            <?php if ($layout['acf_fc_layout'] !== 'item') continue; ?>
                            <button
                                class="block-context__dot <?php echo $index === 0 ? 'is-active' : ''; ?>"
                                data-index="<?php echo $index; ?>"
                                aria-label="Go to slide <?php echo $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <button class="block-context__play-pause" aria-label="Pause autoplay">
                        <span class="block-context__icon-pause">
                            <?php include(get_template_directory() . '/assets/icon-pause-2.svg'); ?>
                        </span>
                        <span class="block-context__icon-play">
                            <?php include(get_template_directory() . '/assets/icon-play-2.svg'); ?>
                        </span>
                    </button>

                    <div class="block-context__navigation">
                        <?php
                        echo get_button(array(
                            'tag' => 'button',
                            'class' => 'btn--secondary btn--small btn--icon-only block-context__prev',
                            'icon' => 'chevron-left',
                        ));
                        ?>
                        <?php
                        echo get_button(array(
                            'tag' => 'button',
                            'class' => 'btn--secondary btn--small btn--icon-only block-context__next',
                            'icon' => 'chevron-right',
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>