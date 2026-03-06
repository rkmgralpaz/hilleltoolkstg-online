<?php
$block_color_pallete = explode(';', $block['module_configuration']['color_palette'])[0];
$block_classes = 'js-module block-multi-photo-hero theme ';
$block_classes .= $block_color_pallete . ' ';
$block_classes .= 'theme--mode-light ';
//$block_classes .= $block['module_configuration']['color_mode'].' ';
/* if ($block_color_pallete === 'theme--neutral' && $block['module_configuration']['color_mode'] === 'theme--mode-light' && $block['module_configuration']['background'] === false ): 
    $block_classes .= 'theme--surface-secondary '; 
endif; */
if ($block['module_configuration']['background'] === false):
    $block_classes .= 'theme--surface-secondary ';
endif;
if ($block['module_configuration']['animated']):
    $block_classes .= 'block-multi-photo-hero--animated ';
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
    <div class="block-multi-photo-hero__texts">

        <?php
        echo get_dynamic_heading(
            $block['title'],
            $block['heading_tag'],
            'block-multi-photo-hero__title font-display-lg-2 theme__text--primary',
            [
                'data-animate' => 'fade-in-up',
                'data-animate-delay' =>  100,
            ]
        );
        ?>


        <div class="block-multi-photo-hero__copy font-body-lg theme__text--secondary" data-animate="fade-in-up" data-animate-delay="200">
            <?php echo $block['text']; ?>
        </div>
        <?php if ($has_buttons): ?>
            <div class="block-multi-photo-hero__buttons" data-animate="fade-in-up" data-animate-delay="300">
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

    <div class="block-multi-photo-hero__images">
        <div class="images__image images__image--1">
            <div class="image__img"></div>
        </div>
        <div class="images__image images__image--2">
            <div class="image__img"></div>
        </div>
        <div class="images__image images__image--3">
            <div class="image__img"></div>
        </div>
    </div>

    <div class="images-for-preload">
        <?php echo $images_for_preload_html; ?>
    </div>

</div>