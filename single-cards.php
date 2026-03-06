<?php get_header(); ?>

<?php

// Start the Loop.
while (have_posts()) : the_post();

    $card_color = get_cards_color_by_filters();
    $color_pelettes = [
        ['color' => 'theme--pink theme--mode-light theme__text--primary'],
        ['color' => 'theme--green theme--mode-light theme__text--primary'],
        ['color' => 'theme--blue theme--mode-light theme__text--primary'],
        ['color' => 'theme--neutral theme--mode-bright theme__text--primary'],
    ];
    $card_id = get_the_ID();
    $card_permalink = get_permalink();
    $card_title = get_the_title();
    $card_filters = wp_get_post_terms($card_id, 'card_filters');
    $modules = get_field('card_modules');
    if (!empty($card_filters)):
        $color_num = $card_color[$card_filters[0]->slug]['num'];
        $color_theme = $color_pelettes[($color_num - 1)];
        $date = 'Updated on ' . get_the_date();
        $tag = get_button(array(
            'html_text' => $card_filters[0]->name,
            'tag' => 'div',
            'class' => 'page-cards-single-v2__tag btn--tag disabled',
        ));
        $share_btn = get_button(array(
            'class' => 'page-cards-single-v2__share-btn btn--primary btn--large btn--icon-only',
            'icon' => 'share'
        ));
?>

        <div class="js-module page-cards-single-v2">

            <div class="page-cards-single-v2__content theme <?= $color_theme['color'] ?> page-cards-single-v2__content--color-num-<?= $color_num ?>">

                <?php
                if (!empty($_COOKIE['prevCardsURL'])) {
                    $close_url = $_COOKIE['prevCardsURL'];
                    unset($_COOKIE['prevCardsURL']);
                } else {
                    $close_url = get_post_type_archive_link('cards');
                }
                echo get_button(array(
                    'href' => $close_url,
                    'target' => 'self',
                    'class' => 'page-cards-single-v2__close-btn btn--primary btn--large btn--icon-after btn--icon-only',
                    'icon' => 'close',
                    'aria-label' => 'Back to cards',
                ));
                ?>

                <div class="page-cards-single-v2__content-inner">

                    <div class="page-cards-single-v2__content-header">
                        <?= $tag ?>
                        <div class="page-cards-single-v2__title font-display-md"><?= $card_title ?></div>
                        <div class="page-cards-single-v2__share-wrapper">
                            <?= $share_btn ?>
                            <div class="page-cards-single-v2__share-menu font-body-sm">
                                <div>Share on:</div>
                                <ul>
                                    <li><a href="<?= get_facebook_share_url(); ?>" target="_blank">Facebook</a></li>
                                    <li><a href="<?= get_twitter_share_url(); ?>">X</a></li>
                                    <li><button class='copy-link-btn'>Copy Link</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <?php

                    $html = "";
                    if (!empty($modules)):
                        foreach ($modules as $module):
                            if ($module['acf_fc_layout'] == 'highlight'):
                                $html .= "
                                <div class='page-cards-single-v2__module page-cards-single-v2__module-highlight font-heading-sm'>
                                    {$module['text']}
                                </div>
                                ";
                            elseif ($module['acf_fc_layout'] == 'text'):
                                $html .= "
                                <div class='page-cards-single-v2__module page-cards-single-v2__module-text font-body-sm'>
                                    {$module['text']}
                                </div>
                                ";
                            elseif ($module['acf_fc_layout'] == 'podcast'):
                                $html .= "
                                <div class='page-cards-single-v2__module page-cards-single-v2__module-podcast'>
                                    <div class='module__label font-label-md'>{$module['label']}</div>
                                    <div class='module__title font-heading-md'>{$module['title']}</div>
                                ";
                                if (!empty($module['podcast_url'])):
                                    $html .= "<div class='page-cards-single-v2__podcast-player' data-podcast='{$module['podcast_url']}'></div>";
                                endif;
                                $html .= "</div>";
                            elseif ($module['acf_fc_layout'] == 'video'):
                                $html .= "
                                <div class='page-cards-single-v2__module page-cards-single-v2__module-video'>
                                    <div class='module__label font-label-md'>{$module['label']}</div>
                                    <div class='module__title font-heading-md'>{$module['title']}</div>
                                ";
                                if (!empty($module['video_url']) && !empty($module['poster_image'])):
                                    $play_btn = get_button(array(
                                        'class' => 'page-cards-single-v2__video-player-btn btn--primary btn--large btn--icon-only',
                                        'icon' => 'play',
                                        'tag' => 'button',
                                        'aria-label' => 'Play video'
                                    ));
                                    $html .= "
                                    <div class='page-cards-single-v2__video-player-with-btn theme theme--neutral theme--mode-neutral' data-video='{$module['video_url']}'>
                                        <div class='page-cards-single-v2__video-player-poster-img' data-src='{$module['poster_image']['url']}'></div>
                                        {$play_btn}
                                    </div>";
                                elseif (!empty($module['video_url'])):
                                    $html .= "<div class='page-cards-single-v2__video-player' data-video='{$module['video_url']}'></div>";
                                endif;
                                $html .= "</div>";
                            elseif ($module['acf_fc_layout'] == 'additional_links'):
                                $html .= "
                                <div class='page-cards-single-v2__module page-cards-single-v2__module-additional-links'>
                                    <div class='module__title font-heading-md'>{$module['title']}</div>
                                    <div class='module__list font-body-sm'>{$module['text']}</div>
                                </div>
                                ";
                            elseif ($module['acf_fc_layout'] == 'related_media'):
                                // Preparar variables para el módulo
                                $module_title = $module['title'] ?? '';
                                $module_resources = $module['resources'] ?? [];
                                $button_size = 'small';
                                $button_style = 'primary';
                                $title_size = 'font-heading-md';

                                // Capturar el output del include
                                ob_start();
                                include get_template_directory() . '/partials/blocks/block-related-media-horizontal.php';
                                $html .= ob_get_clean();
                                continue;
                            endif;
                        endforeach;
                    endif;
                    echo $html;
                    ?>
                </div>

                <!-- ### -->

                <div class="page-cards-single-v2__flip-container page-cards-single-v2__flip-container-color-<?= $color_num ?>">
                    <div class="page-cards-single-v2__card">
                        <div class="page-cards-single-v2__front">
                            <div class="page-cards-v2__card-holder">
                                <div class="page-cards-v2__card-title font-display-xs"><?= $card_title ?></div>
                                <div class="page-cards-v2__card-filters font-label-md">
                                    <div><?= $card_filters[0]->name ?></div>
                                </div>
                                <div class="page-cards-v2__card-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none" aria-hidden="true">
                                        <path class="svg-fill" d="M6.46971 4.93451C6.7626 4.64162 7.23736 4.64162 7.53026 4.93451C7.82299 5.22742 7.8231 5.70222 7.53026 5.99506L4.81053 8.71479H16.5C19.3995 8.71479 21.75 11.0653 21.75 13.9648C21.7498 16.8641 19.3994 19.2148 16.5 19.2148H12C11.5859 19.2148 11.2502 18.8789 11.25 18.4648C11.25 18.0506 11.5858 17.7148 12 17.7148H16.5C18.5709 17.7148 20.2498 16.0357 20.25 13.9648C20.25 11.8937 18.5711 10.2148 16.5 10.2148H4.81053L7.53026 12.9345L7.58202 12.9912C7.82216 13.2857 7.8048 13.7205 7.53026 13.9951C7.25569 14.2695 6.82087 14.2869 6.52635 14.0468L6.46971 13.9951L2.46971 9.99506C2.17687 9.70222 2.17698 9.22742 2.46971 8.93451L6.46971 4.93451Z" fill="#FAF2EB" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="page-cards-single-v2__back">
                            <!--  -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

<?php

    endif;
endwhile;

?>

<?php get_footer(); ?>