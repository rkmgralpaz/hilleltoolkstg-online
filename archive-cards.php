<?php get_header(); ?>

<?php

function build_url($changes = [], $remove = []) {
    $base_url = strtok($_SERVER['REQUEST_URI'], '?');
    $current_params = $_GET;
    
    foreach ($changes as $param_key => $param_value) {
        if ($param_value === null || $param_value === '') {
            unset($current_params[$param_key]);
        } else {
            $current_params[$param_key] = $param_value;
        }
    }
    
    foreach ($remove as $remove_key) {
        unset($current_params[$remove_key]);
    }
    
    $query_string = http_build_query($current_params);
    return $base_url . ($query_string ? '?' . $query_string : '');
}

$current_view = $_GET['view'] ?? 'featured';
$current_filter = $_GET['filter'] ?? '';
$is_search = isset($_GET['search']) && !empty($_GET['search']);
$search_param = $is_search ? $_GET['search'] : '';
$global_classes = $is_search ? 'page-cards-v2--is-seach' : '';

$title = get_field('title', 'cards');
$heading_tag = get_field('heading_tag', 'cards');

$blurb = get_field('blurb', 'cards');
if(!empty($current_filter)){
    $current_filter_str = ucwords(str_replace(['-','-'],' ',$current_filter));
    $blurb .= "<h2 class='sr-only'>{$current_filter_str}</h2>";
}

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

if($is_search ){
    $global_classes .= ' page-cards-v2--search-mode'; 
    $search_value = $search_param;
    $placeholder = $search_param;
}else{
    $search_value = '';
    $placeholder = 'Type search here';
}

/* 
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
*/

?>

<div class='js-module page-cards-v2 theme theme--pink theme--mode-neutral <?= $global_classes; ?>'>

    <?php

    $block_external_content = array(
        'module_color_settings' => array(
            'color_palette' => 'pink;',
            'color_mode' => 'bright',
            'alignment' => 'block--align-center',
            'title' => 'font-heading-lg'
        ),
        'title' => $title,
        'heading_tag' => $heading_tag,
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

    include 'partials/blocks/block-heading.php'; 

    ?>

    <div class="page-cards-v2__top-bar">

        <div class="page-cards-v2__top-bar-inner">

            <!-- <div class="page-cards-v2__top-bar-space"></div> -->

            <?php
            echo get_button(array(
                'tag' => 'button',
                'id' => 'open-search-form-btn',
                'class' => 'page-cards-v2__open-search-form-btn btn--small-- btn--icon-after btn--icon-only',
                'icon' => 'search',
                'aria-label' => 'Open search form',
            ));
            ?>

            <div class="page-cards-v2__view-wrapper">
                <div class="page-cards-v2__view-holder">
                    <?php $view_btn_selected = strtolower($current_view) == 'featured' ? 'page-cards-v2__view-btn--selected' : ''; ?>
                    <a href="<?= build_url([],['view','search']) ?>" id="view-btn-fun" class="page-cards-v2__view-btn <?= $view_btn_selected; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="14" viewBox="0 0 24 14" fill="none">
                            <path class="svg-stroke" d="M22.1627 8.29048C22.7155 9.62506 23 11.0555 23 12.5H15.3H8.7L1 12.5C1 11.0555 1.28452 9.62506 1.83732 8.29048C2.39013 6.9559 3.20038 5.74327 4.22182 4.72183C5.24327 3.70038 6.4559 2.89013 7.79048 2.33733C9.12506 1.78452 10.5555 1.5 12 1.5C13.4445 1.5 14.8749 1.78452 16.2095 2.33733C17.5441 2.89013 18.7567 3.70038 19.7782 4.72183C20.7996 5.74327 21.6099 6.9559 22.1627 8.29048Z" stroke="#FAF2EB" stroke-width="1.5" stroke-linejoin="round"/>
                            <path class="svg-stroke" d="M12 12.5007L19.7917 4.70898" stroke="#FAF2EB" stroke-width="1.5"/>
                            <path class="svg-stroke" d="M12 12.0423L4.66667 4.70898" stroke="#FAF2EB" stroke-width="1.5"/>
                            <path class="svg-stroke" d="M12 1.5V12.5" stroke="#FAF2EB" stroke-width="1.5"/>
                        </svg>
                        <span class="font-label-md">Featured</span>  
                    </a>
                    <?php $view_btn_selected = strtolower($current_view) == 'all' ? 'page-cards-v2__view-btn--selected' : ''; ?>
                    <a href="<?= build_url(['view' => 'all'], ['search']) ?>" id="view-btn-grid" class="page-cards-v2__view-btn <?= $view_btn_selected; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <rect class="svg-stroke" x="1" y="1" width="16" height="16" stroke="#332933" stroke-width="1.5" stroke-linejoin="round"/>
                            <path class="svg-stroke" d="M9 1.33398V17.0007" stroke="#332933" stroke-width="1.5"/>
                            <path class="svg-stroke" d="M1 9.16602L16.6667 9.16602" stroke="#332933" stroke-width="1.5"/>
                        </svg>
                        <span class="font-label-md">All</span>  
                    </a>
                    <?php $view_btn_selected = strtolower($current_view) == 'list' ? 'page-cards-v2__view-btn--selected' : ''; ?>
                    <a href="<?= build_url(['view' => 'list'], ['search']) ?>" id="view-btn-list" class="page-cards-v2__view-btn <?= $view_btn_selected; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect class="svg-stroke" x="4.25" y="13.4121" width="16" height="6.58824" stroke="#332933" stroke-width="1.5" stroke-linejoin="round"/>
                            <rect class="svg-stroke" x="4.25" y="4" width="16" height="6.58824" stroke="#332933" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <span class="font-label-md">List</span>  
                    </a>
                </div>

            </div>

            <div class="page-cards-v2__top-bar-divider"></div>

            <div class="page-cards-v2__filters-scroller">

                <div class="page-cards-v2__filters font-label-md">
                    
                    <div class="filters__label">FILTER BY</div>

                    <?php

                    
                    $filters_views = get_field('filter_views','cards');

                    foreach($filters_views as $row):
                        $filter = get_term( $row['filter_views_filters'], 'card_filters' );
                        $color = explode(';',get_field('color','term_'.$filter->term_id));
                        $filter_num = explode('--',$color[0])[1];
                        if($current_filter == $filter->slug):
                            $href = build_url([], ['filter','search']);
                            $filter_selected = 'btn--selected';
                        else:
                            $href = build_url(['filter' => $filter->slug], ['search']);
                            $filter_selected = '';
                        endif;
                    ?>
                        
                        <a href="<?= $href ?>" class="btn btn--tag btn--num-<?= $filter_num ?> unselectable btn--icon-before btn--show-icon-only-selected <?= $filter_selected; ?>" data-slug="<?= $filter->slug ?>">
                            <div class="btn__icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 6.93934L12.4697 2.46967L13.5303 3.53033L9.06066 8L13.5303 12.4697L12.4697 13.5303L8 9.06066L3.53033 13.5303L2.46967 12.4697L6.93934 8L2.46967 3.53033L3.53033 2.46967L8 6.93934Z" fill="#33312E"></path>
                                </svg>
                            </div>
                            <span class="btn__text"><?= $filter->name ?></span>
                        </a>
                
                    <?php

                    endforeach;
                    
                    ?>

                    <div class="filters__last-space"></div>

                </div>

            </div>

            <div class="page-cards-v2__top-bar-color-area"></div>

            <div class="page-cards-v2__search-form-desktop-wrapper">
                
                <form id="cards-search-form-desktop" class="page-cards-v2__search-form-desktop" role="search" action="">
                    <label for="cards-search-field-desktop" class="sr-only">Search</label>
                    <input type="search" id="cards-search-field-desktop" class="font-body-md page-cards-v2__search-form-desktop-field" value="<?= $search_value ?>" placeholder="<?= $placeholder ?>" aria-label="Search cards" autocomplete="off" />
                    <?php
                    echo get_button(array(
                        'html_text' => 'Search',
                        'tag' => 'button',
                        'class' => 'page-cards-v2__search-form-desktop-submit-btn btn--secondary btn--small btn--icon-after btn--icon-only',
                        'icon' => 'arrow-right',
                        'aria-label' => 'Submit search',
                        'type' => 'submit'
                    ));
                    ?>
                </form>
                <button class="page-cards-v2__search-form-desktop-close-btn" aria-label="Clase search form">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M8 6.93934L12.4697 2.46967L13.5303 3.53033L9.06066 8L13.5303 12.4697L12.4697 13.5303L8 9.06066L3.53033 13.5303L2.46967 12.4697L6.93934 8L2.46967 3.53033L3.53033 2.46967L8 6.93934Z" fill="#33312E"></path>
                    </svg>
                </button>
                <div class="page-cards-v2__search-form-desktop-icon">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 6.25C14.5 8.87335 12.3733 11 9.74999 11C7.12664 11 4.99999 8.87335 4.99999 6.25C4.99999 3.62665 7.12664 1.5 9.74999 1.5C12.3733 1.5 14.5 3.62665 14.5 6.25ZM16 6.25C16 9.70178 13.2018 12.5 9.74999 12.5C8.337 12.5 7.03352 12.0311 5.98668 11.2404L1.20099 15.816L0.164398 14.7318L4.90537 10.199C4.02686 9.12253 3.49999 7.74779 3.49999 6.25C3.49999 2.79822 6.29821 0 9.74999 0C13.2018 0 16 2.79822 16 6.25Z" fill="#33312E"></path>
                    </svg>
                </div>
            </div>

        </div>

    </div>

    <?php
        $is_featured = $current_view == 'featured' && !$is_search;
        $container_class = $is_featured ? 'page-cards-v2__card-container--featured' : '';
    ?>

    <div class="page-cards-v2__card-container <?= $container_class ?>">

        <?php

        if($is_search):
            require 'partials/cards/view-search.php';
        elseif($current_view == 'all'):
            require 'partials/cards/view-mode-grid.php';
        elseif($current_view == 'list'):
            require 'partials/cards/view-mode-list.php';
        elseif($is_featured):
            require 'partials/cards/view-mode-featured.php';
        endif;

        ?>


    </div>

    <div class="page-cards-v2__search-form-mobile-wrapper">       
        <form id="cards-search-form-mobile" class="page-cards-v2__search-form-mobile" role="search" action="">
            <label for="cards-search-field-mobile" class="sr-only">Search</label>
            <input type="search" id="cards-search-field-mobile" class="font-body-md page-cards-v2__search-form-mobile-field" value="<?= $search_value ?>" placeholder="<?= $placeholder ?>" aria-label="Search cards" autocomplete="off" />
            <?php
            echo get_button(array(
                'html_text' => 'Search',
                'tag' => 'button',
                'class' => 'sr-only page-cards-v2__search-form-mobile-submit-btn btn--secondary btn--small btn--icon-after btn--icon-only',
                'icon' => 'arrow-right',
                'aria-label' => 'Submit search',
                'type' => 'submit'
            ));
            ?>
        </form>
        <button class="page-cards-v2__search-form-mobile-close-btn" aria-label="Clase search form">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M8 6.93934L12.4697 2.46967L13.5303 3.53033L9.06066 8L13.5303 12.4697L12.4697 13.5303L8 9.06066L3.53033 13.5303L2.46967 12.4697L6.93934 8L2.46967 3.53033L3.53033 2.46967L8 6.93934Z" fill="#33312E"></path>
            </svg>
        </button>
        <div class="page-cards-v2__search-form-mobile-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 6.25C14.5 8.87335 12.3733 11 9.74999 11C7.12664 11 4.99999 8.87335 4.99999 6.25C4.99999 3.62665 7.12664 1.5 9.74999 1.5C12.3733 1.5 14.5 3.62665 14.5 6.25ZM16 6.25C16 9.70178 13.2018 12.5 9.74999 12.5C8.337 12.5 7.03352 12.0311 5.98668 11.2404L1.20099 15.816L0.164398 14.7318L4.90537 10.199C4.02686 9.12253 3.49999 7.74779 3.49999 6.25C3.49999 2.79822 6.29821 0 9.74999 0C13.2018 0 16 2.79822 16 6.25Z" fill="#33312E"></path>
            </svg>
        </div>
        <button id="open-search-form-mobile-btn" class="page-cards-v2__search-form-mobile-btn">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="svg-fill" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 6.25C14.5 8.87335 12.3733 11 9.74999 11C7.12664 11 4.99999 8.87335 4.99999 6.25C4.99999 3.62665 7.12664 1.5 9.74999 1.5C12.3733 1.5 14.5 3.62665 14.5 6.25ZM16 6.25C16 9.70178 13.2018 12.5 9.74999 12.5C8.337 12.5 7.03352 12.0311 5.98668 11.2404L1.20099 15.816L0.164398 14.7318L4.90537 10.199C4.02686 9.12253 3.49999 7.74779 3.49999 6.25C3.49999 2.79822 6.29821 0 9.74999 0C13.2018 0 16 2.79822 16 6.25Z" fill="#33312E"></path>
            </svg>
        </button>
    </div>

</div>


<?php get_footer(); ?>