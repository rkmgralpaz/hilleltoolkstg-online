<?php
    $src_xl = TEMPLATE_DIR.'assets/webanim_mq_xl.json'; 
    $src_md = TEMPLATE_DIR.'assets/webanim_mq_md.json'; 
    $src_xs = TEMPLATE_DIR.'assets/webanim_mq_sm.json';
?>
<div class="js-module block-home-animation">

    <div class="block-home-animation__lottie-xl" data-src="<?php echo $src_xl; ?>"></div>
    <div class="block-home-animation__lottie-md" data-src="<?php echo $src_md; ?>"></div>
    <div class="block-home-animation__lottie-xs" data-src="<?php echo $src_xs; ?>"></div>

    <?php

        $blurb = get_field('blurb');
        $button_1 = get_field('button_1');
        if(!isset($button_1['url'])):
            $button_1 = false;
        endif;
        $button_2 = get_field('button_2');
        if(!isset($button_2['url'])):
            $button_2 = false;
        endif;
        $button_3 = get_field('button_3');
        if(!isset($button_3['url'])):
            $button_3 = false;
        endif;
        $has_buttons = $button_1 || $button_2 || $button_3;
        $has_contents = $blurb != '' && $has_buttons;
        //
        if($has_contents):
    ?>

    <div class="block-home-animation__bottom">

        <?php if($blurb): ?>
        
            <div class="block-home-animation__text font-body-lg" data-animate="fade-in-up" data-animate-delay="100" data-animate-mode="inside-module">
            <?php the_field('blurb'); ?>
        </div>

        <?php 
            endif; 
            if($has_buttons):
        ?>

        <div class="block-home-animation__buttons theme theme--neutral theme--mode-light">
            <?php

                if($button_1):
                    echo get_button(
                        array(
                            'html_text' => $button_1['title'],
                            'href' => $button_1['url'],
                            'target' => $button_1['target'],
                            'class' => 'btn--primary btn--large btn--icon-after',
                            'icon' => 'chevron-right',
                            'data-animate' => 'fade-in-up',
                            'data-animate-delay' => '200',
                            'data-animate-mode' => 'inside-module',
                        )
                    );
                endif;

                if($button_2):
                    echo get_button(
                        array(
                            'html_text' => $button_2['title'],
                            'href' => $button_2['url'],
                            'target' => $button_2['target'],
                            'class' => 'btn--secondary btn--large btn--icon-after',
                            'icon' => 'chevron-right',
                            'data-animate' => 'fade-in-up',
                            'data-animate-delay' => '300',
                            'data-animate-mode' => 'inside-module',
                        )
                    );
                endif;

                if($button_3):
                    echo get_button(
                        array(
                            'html_text' => $button_3['title'],
                            'href' => $button_3['url'],
                            'target' => $button_3['target'],
                            'class' => 'btn--secondary btn--large btn--icon-after',
                            'icon' => 'chevron-right',
                            'data-animate' => 'fade-in-up',
                            'data-animate-delay' => '400',
                            'data-animate-mode' => 'inside-module',
                        )
                    );
                endif;
            ?>
        </div>

        <?php endif; ?>

    </div>

    <?php endif; ?>
  
</div>
           