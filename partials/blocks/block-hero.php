<?php
if (!isset($block_id)):
    $block_id = 'block-hero-' . uniqid();
endif;

// Get module settings
$module_settings = $block['module_settings'] ?? array();
$color_palette = $module_settings['color_palette'];
$title_size = $module_settings['title_size'];
$transition_duration = isset($module_settings['transition_duration']) ? intval($module_settings['transition_duration']) : 5;
?>

<div id="<?php echo esc_attr($block_id); ?>" class="js-module block-hero theme <?php echo explode(';', $color_palette)[0] ?> theme--mode-light">

    <div class="block-hero__intro max-width">

        <div>

            <div>

                <?php
                echo get_dynamic_heading(
                    $block['title'],
                    $block['heading_tag'] ?? 'h1',
                    'theme__text--primary ' . $title_size,
                    ['data-animate' => 'fade-in-up']
                );
                ?>

                <div class="block-hero__image block-hero__image--mobile" data-animate="fade-in-up" data-transition-duration="<?php echo esc_attr($transition_duration); ?>">

                    <?php
                    $pictures = $block['pictures'] ?? array();
                    if (!empty($pictures)):
                        foreach ($pictures as $index => $picture):
                            $is_first = $index === 0;
                    ?>
                            <div class="block-hero__image-bg <?php echo $is_first ? 'active' : ''; ?>" data-src="<?php echo is_array($picture) ? $picture['url'] : $picture; ?>"></div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="657" height="486" viewBox="0 0 657 486" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M657 0H0V486H657V0ZM3.6 46.8V316.541C3.6 327.551 7.80365 338.145 15.3522 346.16L126.614 464.292C137.498 475.848 152.669 482.4 168.544 482.4H610.2C634.059 482.4 653.4 463.059 653.4 439.2V180.042C653.4 165.621 647.99 151.724 638.241 141.099L524.913 17.5928C516.731 8.67602 505.184 3.6 493.083 3.6H46.8C22.9413 3.6 3.6 22.9413 3.6 46.8Z" fill="white" />
                    </svg>

                </div>

                <div class="block-hero__text theme__text--secondary font-body-md" data-animate="fade-in-up" data-animate-delay="100">
                    <?php echo $block['text'] ?? ''; ?>
                </div>

                <?php if (isset($block['button_1']) || isset($block['button_2']) || isset($block['button_3'])) { ?>
                    <div class="block-hero__buttons" data-animate="fade-in-up" data-animate-delay="400">

                        <div>

                            <?php
                            if (isset($block['button_1']) && $block['button_1']) {
                                echo get_button(array(
                                    'html_text' =>  $block['button_1']['title'],
                                    'href' =>  $block['button_1']['url'],
                                    'target' =>  $block['button_1']['target'],
                                    'class' => 'btn--primary btn--large btn--icon-after',
                                    'icon' => 'chevron-right',
                                ));
                            }
                            ?>

                        </div>

                        <div data-animate="fade-in-up" data-animate-delay="600">

                            <?php
                            if (isset($block['button_2']) && $block['button_2']) {
                                echo get_button(array(
                                    'html_text' =>  $block['button_2']['title'],
                                    'href' =>  $block['button_2']['url'],
                                    'target' =>  $block['button_2']['target'],
                                    'class' => 'btn--secondary btn--large btn--icon-after',
                                    'icon' => 'chevron-right',
                                ));
                            }
                            ?>

                        </div>

                        <div data-animate="fade-in-up" data-animate-delay="800">
                            <?php
                            if (isset($block['button_3']) && $block['button_3']) {
                                echo get_button(array(
                                    'html_text' =>  $block['button_3']['title'],
                                    'href' =>  $block['button_3']['url'],
                                    'target' =>  $block['button_3']['target'],
                                    'class' => 'btn--secondary btn--large btn--icon-after',
                                    'icon' => 'chevron-right',
                                ));
                            }
                            ?>
                        </div>

                    </div>
                <?php } ?>

            </div>

            <div class="block-hero__image block-hero__image--desktop" data-animate="fade-in-up" data-transition-duration="<?php echo esc_attr($transition_duration); ?>">
                <?php
                $pictures = $block['pictures'] ?? array();
                if (!empty($pictures)):
                    foreach ($pictures as $index => $picture):
                        $is_first = $index === 0;
                ?>
                        <div class="block-hero__image-bg <?php echo $is_first ? 'active' : ''; ?>" data-src="<?php echo is_array($picture) ? $picture['url'] : $picture; ?>"></div>
                <?php
                    endforeach;
                endif;
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="657" height="486" viewBox="0 0 657 486" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M657 0H0V486H657V0ZM3.6 46.8V316.541C3.6 327.551 7.80365 338.145 15.3522 346.16L126.614 464.292C137.498 475.848 152.669 482.4 168.544 482.4H610.2C634.059 482.4 653.4 463.059 653.4 439.2V180.042C653.4 165.621 647.99 151.724 638.241 141.099L524.913 17.5928C516.731 8.67602 505.184 3.6 493.083 3.6H46.8C22.9413 3.6 3.6 22.9413 3.6 46.8Z" fill="white" />
                </svg>
            </div>

        </div>

    </div>

</div>