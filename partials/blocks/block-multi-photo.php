<?php
$animated = 0;

$block_classes = 'js-module block-multi-photo theme theme--neutral ';
$block_classes .= $block['module_configuration']['color_mode'] . ' ';
if ($block['module_configuration']['color_mode'] === 'theme--mode-light' && $block['module_configuration']['background'] === false):
    $block_classes .= 'theme--surface-secondary ';
endif;
if ($block['module_configuration']['animated']):
    $block_classes .= 'block-multi-photo--animated ';
endif;
$images_for_preload_html = "";
foreach ($block['images'] as $image):
    if ($image && isset($image['url'])):
        $images_for_preload_html .= "<div class='image-for-preload' data-src='{$image['url']}'></div>";
    endif;
endforeach;
$has_button_1 = $block['button_1'] && isset($block['button_1']['url']);
$has_button_2 = $block['button_2'] && isset($block['button_2']['url']);
$has_buttons = $has_button_1 || $has_button_2;
?>

<div id="block-<?php echo $block_index; ?>" class="<?php echo $block_classes; ?>">
    <div class="block-multi-photo__texts">
        

            <?php
            echo get_dynamic_heading(
                $block['title'],
                $block['heading_tag'],
                'block-multi-photo__title font-display-md theme__text--primary',
                [
                    'data-animate' => 'fade-in-up',
                    'data-animate-delay' =>  100,
                ]
            );
            ?>



        <div class="block-multi-photo__copy font-body-lg theme__text--secondary" data-animate="fade-in-up" data-animate-delay="200">
            <?php echo $block['text']; ?>
        </div>
        <?php if ($has_buttons): ?>
            <div class="block-multi-photo__buttons" data-animate="fade-in-up" data-animate-delay="300">
                <?php
                if ($has_button_1):
                    echo get_button(array(
                        'html_text' => $block['button_1']['title'],
                        'href' => $block['button_1']['url'],
                        'target' => $block['button_1']['target'],
                        'class' => 'btn--primary btn--large btn--icon-after',
                        'icon' => 'chevron-right',
                    ));
                endif;
                if ($has_button_2):
                    echo get_button(array(
                        'html_text' => $block['button_2']['title'],
                        'href' => $block['button_2']['url'],
                        'target' => $block['button_2']['target'],
                        'class' => 'btn--secondary btn--large btn--icon-after',
                        'icon' => 'chevron-right',
                    ));
                endif;
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($block['module_configuration']['animated']): ?>

        <div class="block-multi-photo__images">
            <div class="images__image images__image--1">
                <div class="image__img"></div>
            </div>
            <div class="images__image images__image--2">
                <div class="image__img"></div>
            </div>
            <div class="images__image images__image--3">
                <div class="image__img"></div>
            </div>
            <div class="images__image images__image--4">
                <div class="image__img"></div>
            </div>
            <div class="images__image images__image--5">
                <div class="image__img"></div>
            </div>
        </div>

    <?php else: ?>

        <div class="block-multi-photo__images">
            <div class="images__group images__group-1">
                <div class="images__image images__image--1">
                    <div class="image__img"></div>
                </div>
                <div class="images__image images__image--2">
                    <div class="image__img"></div>
                </div>
            </div>
            <div class="images__group images__group-2">
                <div class="images__image images__image--3">
                    <div class="image__img"></div>
                </div>
                <div class="images__image images__image--4">
                    <div class="image__img"></div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="images-for-preload">
        <?php echo $images_for_preload_html; ?>
    </div>

</div>