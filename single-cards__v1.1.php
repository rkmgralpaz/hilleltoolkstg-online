<?php get_header(); ?>

<?php


$title = get_field('title', 'cards');
$heading_tag = get_field('heading_tag', 'cards');

$blurb = get_field('blurb', 'cards');
$more_cards_btn = get_button(array(
    'html_text' => 'Show more',
    'class' => 'block-cards__more-cards-btn btn--secondary btn--large btn--icon-after',
    //'icon' => 'chevron-right',
));
$share_all_btn = get_button(array(
    'html_text' => 'Share cards',
    'class' => 'block-cards__share-all-btn btn--primary btn--large btn--icon-after',
    'icon' => 'share',
));
$groups = get_field('card_groups', 'cards');
$colors = ['', 'pink', 'green', 'blue', 'pink'];
$modes = ['', 'bright', 'dark', 'bright', 'dark'];

$arrow_prev = get_button(array(
    'class' => 'block-cards__arrow-btn block-cards__arrow-btn-prev btn--primary btn--large btn--icon-only',
    'icon' => 'chevron-left',
    'aria-label' => 'Previous card',
));
$arrow_next = get_button(array(
    'class' => 'block-cards__arrow-btn block-cards__arrow-btn-next btn--primary btn--large btn--icon-only',
    'icon' => 'chevron-right',
    'aria-label' => 'Next card',
));

$mobile_prev = get_button(array(
    'html_text' => 'Previous Card',
    'class' => 'mobile-controls__prev-btn btn--tertiary btn--icon-before',
    'icon' => 'chevron-left',
));
$mobile_next = get_button(array(
    'html_text' => 'Next Card',
    'class' => 'mobile-controls__next-btn btn--tertiary btn--icon-after',
    'icon' => 'chevron-right',
));
$flip_icon = get_button(array(
    'class' => 'btn--primary btn--large btn--icon-only',
    'icon' => 'back',
    'tag' => 'div',
));
$share_link = get_button(array(
    'class' => 'share-link__btn btn--primary btn--large btn--icon-only',
    'icon' => 'share'
));

/* $cards_html = "

<div class='page-cards js-module theme theme--pink theme--mode-neutral'>

    <div class='block-heading max-width block--align-center'>
	<div>
		<div class='block-heading__top'>
			<div class='block-heading__title theme__text--primary font-heading-md' data-animate='fade-in-up'>
				{$title}
			</div>			
			<div class='block-heading__text theme__text--primary font-body-md' data-animate='fade-in-up' data-animate-delay='200'>
				{$blurb}
			</div>
		</div>
		<div class='block-heading__bottom' data-animate='fade-in-up' data-animate-delay='300'>
			<div data-animate='fade-in-up' data-animate-delay='400'>			
            	{$more_cards_btn}
			</div>
			<div data-animate='fade-in-up' data-animate-delay='500'>
                {$share_btn}
			</div>
		</div>	
	</div>
</div>

"; */

?>

<div class='page-cards js-module theme theme--pink theme--mode-neutral'>

    <?php

    $block_external_content = array(
        'module_color_settings' => array(
            'color_palette' => 'pink;',
            'color_mode' => 'bright',
            'alignment' => 'block--align-center',
            'title' => 'font-heading-lg'
        ),
        'title' => $title,
        'heading_tag' => 'none',
        'text' => $blurb,
        'tagline' => '',
        'note' => '',
        /* 
        'button_1' => array(
            'html_text' => 'Show more cards',
            'class' => 'more-cards-btn btn--primary btn--large btn--icon-after',
            'icon' => 'chevron-right',
        ),
        'button_2' => array(
            'html_text' => 'Share',
            'class' => 'share-btn btn--secondary btn--large btn--icon-after',
            'icon' => 'chevron-right',
        ), */
        'button_1' => 0,
        'button_2' => 0,
        'button_3' => 0
    );

    $block_index = 0;

    $block_remove_transitions = 1;
    $block_classes = 'heading--wmt heading--wmb block-heading--opacity-0';

    include 'partials/blocks/block-heading.php';


    $card_list = get_field('cards', 'cards');

    $cards_html = "";

    $total_cards = count($card_list);

    $cards_classes = 'block-cards--visible';

    $cards_html .= "

    <div class='block block-cards js-module has-card-displaced block-cards--total-{$total_cards} {$cards_classes}'>
        
        <div class='block-cards__bottom-area theme theme--neutral theme--mode-light'>
        </div>
    
        <div class='block-cards__wrapper'>
            <div class='block-cards__inner'>
    ";

    $card_num = 0;
    $index = 0;
    foreach ($card_list as $card):
        $card_num++;
        $index++;
        if ($card_num > 4):
            $card_num = 1;
        endif;
        $card_slug = get_post($card)->post_name;
        if($card_slug == $GLOBALS['PATH_NAMES'][1]):
            $card_title = get_the_title($card);
            $card_resources = get_field('buttons', $card);
            if (!isset($card_resources['text']) || $card_resources['text'] == ''):
                $card_resources['title'] = '';
                $card_resources['text'] = '';
            endif;
            $card_color = $colors[$card_num];
            $card_mode = $modes[$card_num];
            $card_back_mode = $card_color == 'blue' ? str_replace('bright', 'light', $card_mode) : $card_mode;
            $card_text = str_replace('font-large', 'font-heading-md', get_field('text', $card));
            $heading_tagCard = get_field('heading_tag', $card);
            $class_started = 'card--displaced card--opacity-1';
        else:
            $card_title = '';
            $card_resources = array(
                'title' => '',
                'text' => '',
            );
            $card_color = $colors[$card_num];
            $card_mode = $modes[$card_num];
            $card_back_mode = $card_color == 'blue' ? str_replace('bright', 'light', $card_mode) : $card_mode;
            $card_text = '';
            $heading_tagCard = '';
            $class_started = '';
        endif;
        
        $card_heading_front = get_dynamic_heading(
            $card_title,
            $heading_tagCard,
            'face-front__title font-display-sm'
        );
        $card_heading_back = get_dynamic_heading(
            $card_title,
            $heading_tagCard,
            'title__str'
        );

        $close_btn = get_button(array(
            'class' => 'card__close-btn btn--primary btn--small btn--icon-after btn--icon-only',
            'icon' => 'close',
            'aria-label' => 'Close and flip card',
        ));
        $cards_html .= "
        <div id='card{$card}' class='block-cards__card block-cards--card-hidden block-cards--card-{$card_num} {$class_started}' data-slug='{$card_slug}' data-card-num='{$index}'>
            <div class='card__holder'>
                <div class='card__outer'>
                    <div class='card__inner'>
                        <div class='card__face card--front theme theme--{$card_color} theme--mode-{$card_mode} theme__text--primary'>
                            
                            ".str_replace('h1','div',$card_heading_front)."
                            
                            <div class='face-front__icon'>
                            {$flip_icon}
                            </div>
                        </div>
                        <div class='card__face card--back theme theme--{$card_color} theme--mode-{$card_back_mode} theme__text--primary'>
                            <div class='card__scroller'>
                                <div class='face-back__left'>
                                    <div class='face-back__title font-display-sm face-back--elem-fadeable'>
                                        {$card_heading_back}
                                        <div class='block-cards__share-link face-back__copy-link' data-slug='{$card_slug}'>
                                            {$share_link}
                                            <div class='block-cards__share-link-options'>
                                                <div class='font-body-sm'>Share on:</div>
                                                <ul class='share-link-options__ul font-body-sm'>
                                                    <li><button class='share-link-options__btn' data-type='facebook' aria-label='Share on Facebook'>Facebook</button></li>
                                                    <li><button class='share-link-options__btn' data-type='twitter' aria-label='Share on X'>X</button></li>
                                                    <li><button class='share-link-options__btn' data-type='copy' aria-label='Copy Link' data-txt-def='Copy Link' data-txt-copied='Link Copied!'>Copy Link</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='face-back__text-bottom face-back--elem-fadeable'>
                                        <div class='face-back__title-source font-label-md'>{$card_resources['title']}</div>
                                        <div class='face-back__text-source font-body-sm'>{$card_resources['text']}</div>
                                    </div>
                                </div>
                                <div class='face-back__right'>
                                    <div class='face-back__text-right face-back--elem-fadeable'>
                                        <div class='font-body-sm'>
                                            {$card_text}
                                        </div>
                                    </div>
                                </div>
                                <div class='face-back__text-bottom-mobile font-body-md face-back--elem-fadeable '>
                                    <div class='face-back__title-source font-label-lg'>{$card_resources['title']}</div>
                                    <div class='face-back__text-source'>{$card_resources['text']}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class='card__area-btn ' aria-label='Flip card'></button>
                <div class='card__mobile-bg-buttons theme theme--{$card_color} theme--mode-{$card_back_mode}'></div>
                <div class='theme theme--{$card_color} theme--mode-{$card_back_mode}'>
                {$close_btn}		
                </div>		
                <!-- <div class='block-cards__share-link card__share-link-mobile theme theme--{$card_color} theme--mode-{$card_back_mode}' data-slug='{$card_slug}'>
                    {$share_link}
                    <div class='copy-link__message font-body-sm'>link copied!</div>
                </div> -->
            </div>
        </div>
        ";

    endforeach;

    $cards_html .= "
            </div>
            <div class='block-cards__desktop-counter font-body-sm'>Hola Mundo!</div>
        </div>
        
        <div class='block-cards__mobile-controls-wrapper'>
            {$mobile_prev}
            <div class='mobile-controls__num'></div>
            {$mobile_next}
        </div>
        <div class='block-cards__arrows-wrapper theme theme--pink theme--mode-bright' data-default-theme='theme theme--pink theme--mode-bright'>
            {$arrow_prev}
            {$arrow_next}
            <div class='block-cards__flipped-num block-cards__flipped-num--mobile'>01/08</div>
        </div>
    </div>
    ";

    echo $cards_html;

    ?>
</div>
<div class="block-cards__desktop-mb"></div>

<?php get_footer(); ?>