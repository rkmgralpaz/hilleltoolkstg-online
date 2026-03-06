<?php

require 'constants.php';

if (isset($_GET['s'])):
    wp_redirect(BASE_URL);
    exit;
endif;

if (get_field('redirect_to_first_child')):
    $childrens = get_pages('child_of=' . get_the_ID() . '&sort_column=menu_order&post_status=publish');
    if (isset($childrens[0])):
        $url = get_permalink($childrens[0]->ID);
        wp_redirect($url);
        exit;
    endif;
elseif (get_post_type() == 'cards' && isset($GLOBALS['PATH_NAMES'][1])):
/* $url = str_replace('misconceptions','misconceptions/#',get_permalink());
    wp_redirect( $url );
    exit; */
endif;


$logo_src = TEMPLATE_DIR . 'assets/logo.json';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php
    $is_data_interactive = !empty($GLOBALS['PATH_NAMES'][0]) && $GLOBALS['PATH_NAMES'][0] == 'data-interactive';
    if (!$is_data_interactive):
        $page_title = wp_get_document_title();
    elseif (!empty($GLOBALS['PATH_NAMES'][1]) && $GLOBALS['PATH_NAMES'][1] == 'years-comparison'):
        $page_title = 'Compare up to Three Years of Campus Antisemitism Data - ' . get_bloginfo('title');
    elseif (!empty($GLOBALS['PATH_NAMES'][1]) && $GLOBALS['PATH_NAMES'][1] == 'sources'):
        $page_title = 'Sources of Interactive Data - ' . get_bloginfo('title');
    elseif (!empty($GLOBALS['PATH_NAMES'][1])):
        $page_title = 'Antisemitic Incidents on Campus by Year: ' . get_the_title() . ' - ' . get_bloginfo('title');
    else:
        $page_title = 'Antisemitic Incidents on Campus: Interactive Data - ' . get_bloginfo('title');
    endif;

    ?>

    <meta name="title" content="<?php echo $page_title; ?>">

    <title><?php echo $page_title; ?></title>

    <?php wp_head(); ?>

</head>

<?php

//--- convierte las body_class de wp a string
$body_classes = implode(' ', get_body_class());

if (!empty($_COOKIE['headerHidden']) && $_COOKIE['headerHidden'] == 1 && $GLOBALS['PATH_NAMES'][0] == 'misinformation' && isset($GLOBALS['PATH_NAMES'][1])) {
    $body_classes .= ' header-hide scrolled';
    unset($_COOKIE['headerHidden']);
}

?>

<body class="<?php echo $body_classes; ?>">

    <?php
    $ga_id = get_field('google_analytics_id', 'option');
    if (get_field('google_analytics_enabled', 'option') && $ga_id != ''):
        echo "
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src='https://www.googletagmanager.com/ns.html?id={$ga_id}'
        height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        ";
    endif;
    ?>

    <button id="skip-to-content-btn" class="skip-to-content-btn" aria-label="Skip to content">Skip to content</button>
    <button id="open-main-nav-btn" class="open-main-nav-btn" aria-label="Open Main Nav">Open Main Nav</button>

    <header id="site-header" class="js-module site-header unselectable">
        <a href="<?php echo get_home_url(); ?>" class="site-header__logo" data-src="<?php echo $logo_src; ?>" aria-label="Homepage">
            <!-- <dotlottie-player class="site-header__lottie-player" src="https://lottie.host/2de3fefc-0ee7-49df-8e4e-b5a3b664239f/jddVLG5Do0.json" background="transparent" speed="2"></dotlottie-player> -->
            <div class="site-header__lottie-player">

            </div>
            <svg class="site-header__logo-default" width="184" height="122" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 500 330">
                <path class="logo__bg" d="M-.6,18.3C-.6,8.4,7.5.3,17.4.3L373.5-.1c9.9,0,23.8,5.6,30.9,12.6l83.1,81.2c7.1,6.9,12.9,20.6,12.9,30.6v187.8c.1,9.9-8,18-17.9,18l-356.8.9c-9.9,0-23.8-5.5-31-12.4L12.5,240.1c-7.2-6.9-13-20.5-13-30.4V18.3Z" />
                <path class="logo__text" d="M469.6,257.1h-8v41.9h8v-41.9Z" />
                <path class="logo__text" d="M455.9,257.1h-8v41.9h8v-41.9Z" />
                <path class="logo__text" d="M429.9,259.4h-8.2l-15.1,39.6h8.2l3.5-9.5h14.8l3.5,9.5h8.4l-15.1-39.6ZM420.9,282.5l4.8-13.1,4.8,13.1h-9.7Z" />
                <path class="logo__text" d="M390.5,270.1c-.5-.3-1.7-.5-3-.5-2.8,0-5.2,1.4-6.4,3.5v-2.8h-8v28.8h8v-17.9c.6-2.6,2.8-4.1,5.5-4.1s2.9.3,4,1v-8Z" />
                <path class="logo__text" d="M354.9,269.5c-8.4,0-14.1,6.2-14.1,15.1s5.7,15,14.1,15,14.1-6.2,14.1-15-5.7-15.1-14.1-15.1ZM354.9,292.9c-4,0-6.2-3.5-6.2-8.2s2.2-8.3,6.2-8.3,6.2,3.5,6.2,8.3-2.2,8.2-6.2,8.2Z" />
                <path class="logo__text" d="M340,257.3c-1.2-.5-2.6-.8-4.4-.8-6.1,0-10.2,3.7-10.2,10.2v3.4h-4.7v6.4h4.7v22.4h7.9v-22.4h6v-6.4h-6v-2.9c0-2.6,1.5-4,3.9-4s2,.2,2.8.8v-6.8Z" />
                <path class="logo__text" d="M446.6,227.4c.8,5.9,5.8,9.2,12.8,9.2s11.8-3.5,11.8-9.3-2.6-7.2-7.7-8.4l-5.9-1.4c-1.8-.5-2.6-1.1-2.6-2.3,0-1.8,1.9-2.7,3.8-2.7s4,1.2,4.5,2.8h7.6c-1-5.4-5-8.9-12.2-8.9s-11.5,3.7-11.5,9.3,3.1,7.1,7.5,8.1l5.8,1.3c2,.5,2.9,1.2,2.9,2.4,0,1.9-1.6,2.8-4.1,2.8s-4.2-1.1-4.8-3.2h-7.9Z" />
                <path class="logo__text" d="M442.6,207.2h-8.1v18.3c-.6,2.5-2.7,4-5.2,4s-4.6-2.1-4.6-5.1v-17.2h-8v18.8c0,6.4,3.7,10.6,10.1,10.6s6.1-1.5,7.7-3.3v2.6h8v-28.8Z" />
                <path class="logo__text" d="M399.9,206.5c-3.1,0-5.9,1.5-7.2,3v-2.4h-8v39.4h8v-13c1.3,1.5,4.1,3,7.2,3,8.4,0,13.1-6.9,13.1-15s-4.8-15.1-13.1-15.1ZM398.1,229.7c-2.3,0-4.4-1.4-5.4-3.4v-9.5c1-1.9,3-3.4,5.4-3.4,4.3,0,6.9,3.5,6.9,8.1s-2.6,8.1-6.9,8.1Z" />
                <path class="logo__text" d="M361.1,210.2c-1.6-2.1-4.3-3.7-7.7-3.7s-5.9,1.2-7.3,3v-2.4h-8v28.8h8v-18.6c.5-2.4,2.4-3.7,4.5-3.7s4.1,2.1,4.1,5.2v17.1h8.1v-18.6c.5-2.4,2.4-3.7,4.4-3.7s4.1,2.1,4.1,5.2v17.1h8v-18.8c0-6.5-3.5-10.6-9.5-10.6s-6.8,1.6-8.7,3.7Z" />
                <path class="logo__text" d="M320.6,206.5c-6.6,0-11.3,4-12.1,9.2h7.6c.6-1.7,2-2.7,4.3-2.7,3.2,0,4.7,2,4.7,4.4v2.1c-1.2-.8-4.1-1.7-6.6-1.7-6.3,0-11.2,3.7-11.2,9.2s4.9,9.3,10.7,9.3,6.1-1.1,7-2.1v1.5h7.7v-18.4c0-6.9-4.4-11.1-12.1-11.1ZM325,228.1c-.7,1.5-2.9,2.5-5.2,2.5s-5.1-1-5.1-3.5,2.6-3.5,5.1-3.5,4.5,1,5.2,2.5v2.1Z" />
                <path class="logo__text" d="M270,216.2c0,12.1,7.9,20.4,18.4,20.4s15.1-5.5,16.6-13.5h-8.2c-1.4,3.7-3.8,6.1-8.4,6.1s-10.1-5.6-10.1-13.1,3.7-13.1,10.1-13.1,7,2.4,8.4,6.1h8.2c-1.5-7.9-7.2-13.4-16.6-13.4s-18.4,8.3-18.4,20.4Z" />
            </svg>
        </a>
        <nav id="site-nav" class="site-nav">
            <button class="site-nav-mobile__logo-wrapper" data-href="<?php echo BASE_URL; ?>" aria-label="Homepage">
                <svg class="site-nav-mobile__logo" width="184" height="122" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 500 330">
                    <path class="logo__bg" d="M-.6,18.3C-.6,8.4,7.5.3,17.4.3L373.5-.1c9.9,0,23.8,5.6,30.9,12.6l83.1,81.2c7.1,6.9,12.9,20.6,12.9,30.6v187.8c.1,9.9-8,18-17.9,18l-356.8.9c-9.9,0-23.8-5.5-31-12.4L12.5,240.1c-7.2-6.9-13-20.5-13-30.4V18.3Z" />
                    <path class="logo__text" d="M469.6,257.1h-8v41.9h8v-41.9Z" />
                    <path class="logo__text" d="M455.9,257.1h-8v41.9h8v-41.9Z" />
                    <path class="logo__text" d="M429.9,259.4h-8.2l-15.1,39.6h8.2l3.5-9.5h14.8l3.5,9.5h8.4l-15.1-39.6ZM420.9,282.5l4.8-13.1,4.8,13.1h-9.7Z" />
                    <path class="logo__text" d="M390.5,270.1c-.5-.3-1.7-.5-3-.5-2.8,0-5.2,1.4-6.4,3.5v-2.8h-8v28.8h8v-17.9c.6-2.6,2.8-4.1,5.5-4.1s2.9.3,4,1v-8Z" />
                    <path class="logo__text" d="M354.9,269.5c-8.4,0-14.1,6.2-14.1,15.1s5.7,15,14.1,15,14.1-6.2,14.1-15-5.7-15.1-14.1-15.1ZM354.9,292.9c-4,0-6.2-3.5-6.2-8.2s2.2-8.3,6.2-8.3,6.2,3.5,6.2,8.3-2.2,8.2-6.2,8.2Z" />
                    <path class="logo__text" d="M340,257.3c-1.2-.5-2.6-.8-4.4-.8-6.1,0-10.2,3.7-10.2,10.2v3.4h-4.7v6.4h4.7v22.4h7.9v-22.4h6v-6.4h-6v-2.9c0-2.6,1.5-4,3.9-4s2,.2,2.8.8v-6.8Z" />
                    <path class="logo__text" d="M446.6,227.4c.8,5.9,5.8,9.2,12.8,9.2s11.8-3.5,11.8-9.3-2.6-7.2-7.7-8.4l-5.9-1.4c-1.8-.5-2.6-1.1-2.6-2.3,0-1.8,1.9-2.7,3.8-2.7s4,1.2,4.5,2.8h7.6c-1-5.4-5-8.9-12.2-8.9s-11.5,3.7-11.5,9.3,3.1,7.1,7.5,8.1l5.8,1.3c2,.5,2.9,1.2,2.9,2.4,0,1.9-1.6,2.8-4.1,2.8s-4.2-1.1-4.8-3.2h-7.9Z" />
                    <path class="logo__text" d="M442.6,207.2h-8.1v18.3c-.6,2.5-2.7,4-5.2,4s-4.6-2.1-4.6-5.1v-17.2h-8v18.8c0,6.4,3.7,10.6,10.1,10.6s6.1-1.5,7.7-3.3v2.6h8v-28.8Z" />
                    <path class="logo__text" d="M399.9,206.5c-3.1,0-5.9,1.5-7.2,3v-2.4h-8v39.4h8v-13c1.3,1.5,4.1,3,7.2,3,8.4,0,13.1-6.9,13.1-15s-4.8-15.1-13.1-15.1ZM398.1,229.7c-2.3,0-4.4-1.4-5.4-3.4v-9.5c1-1.9,3-3.4,5.4-3.4,4.3,0,6.9,3.5,6.9,8.1s-2.6,8.1-6.9,8.1Z" />
                    <path class="logo__text" d="M361.1,210.2c-1.6-2.1-4.3-3.7-7.7-3.7s-5.9,1.2-7.3,3v-2.4h-8v28.8h8v-18.6c.5-2.4,2.4-3.7,4.5-3.7s4.1,2.1,4.1,5.2v17.1h8.1v-18.6c.5-2.4,2.4-3.7,4.4-3.7s4.1,2.1,4.1,5.2v17.1h8v-18.8c0-6.5-3.5-10.6-9.5-10.6s-6.8,1.6-8.7,3.7Z" />
                    <path class="logo__text" d="M320.6,206.5c-6.6,0-11.3,4-12.1,9.2h7.6c.6-1.7,2-2.7,4.3-2.7,3.2,0,4.7,2,4.7,4.4v2.1c-1.2-.8-4.1-1.7-6.6-1.7-6.3,0-11.2,3.7-11.2,9.2s4.9,9.3,10.7,9.3,6.1-1.1,7-2.1v1.5h7.7v-18.4c0-6.9-4.4-11.1-12.1-11.1ZM325,228.1c-.7,1.5-2.9,2.5-5.2,2.5s-5.1-1-5.1-3.5,2.6-3.5,5.1-3.5,4.5,1,5.2,2.5v2.1Z" />
                    <path class="logo__text" d="M270,216.2c0,12.1,7.9,20.4,18.4,20.4s15.1-5.5,16.6-13.5h-8.2c-1.4,3.7-3.8,6.1-8.4,6.1s-10.1-5.6-10.1-13.1,3.7-13.1,10.1-13.1,7,2.4,8.4,6.1h8.2c-1.5-7.9-7.2-13.4-16.6-13.4s-18.4,8.3-18.4,20.4Z" />
                </svg>
            </button>
            <?php

            echo get_nav();

            ?>
        </nav>
        <button class="site-header__nav-mobile-btn" aria-label="Main Nav">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="40" height="40" viewBox="0 0 40 40">
                <path d="M8,16h24" fill="none" stroke="black" stroke-width="1.5" />
                <path d="M8,24h24" fill="none" stroke="black" stroke-width="1.5" />
            </svg>
        </button>
        <div class="site-header__bg"></div>
    </header>



    <?php if (is_front_page()): ?>
        <h1 class="sr-only">Campus for All: Your Guide to Navigating Antisemitism on Campus</h1>
    <?php endif; ?>

    <main id="main-content" class="main-content">