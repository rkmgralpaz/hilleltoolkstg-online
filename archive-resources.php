<?php get_header(); ?>

<?php

function build_url($changes = [], $remove = [], $context = null)
{
    $base_url = strtok($_SERVER['REQUEST_URI'], '?');
    $current_params = $_GET;

    // Eliminar 'orderby=topic' solo si el contexto es 'filters'
    if ($context === 'filters' && isset($current_params['orderby']) && $current_params['orderby'] === 'topic') {
        unset($current_params['orderby']);
    }

    // Condicional: Si el contexto es 'sort' y el valor enviado es 'topic', eliminar 'filter'
    if ($context === 'sort' && isset($changes['orderby']) && $changes['orderby'] === 'topic') {
        unset($current_params['filter']);
    }

    // Condicional: Si el contexto es 'format' y 'orderby' es 'format', eliminar 'orderby'
    if ($context === 'format' && isset($current_params['orderby']) && $current_params['orderby'] === 'format') {
        unset($current_params['orderby']);
    }

    // Condicional: Si el contexto es 'sort' y el valor enviado es 'format', eliminar 'format'
    if ($context === 'sort' && isset($changes['orderby']) && $changes['orderby'] === 'format') {
        unset($current_params['format']);
    }

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
    $final_url = $base_url . ($query_string ? '?' . $query_string : '');


    return $final_url;
}

$current_view = $_GET['view'] ?? 'featured';
$current_filter = $_GET['filter'] ?? '';
$is_search = isset($_GET['search']) && !empty($_GET['search']);
$search_param = $is_search ? $_GET['search'] : '';
$global_classes = $is_search ? 'page-cards-v2--is-seach' : '';

$title = get_field('title', 'resources');
$heading_tag = get_field('heading_tag', 'resources');

$blurb = get_field('blurb', 'resources');
if (!empty($current_filter)) {
    $current_filter_str = ucwords(str_replace(['-', '-'], ' ', $current_filter));
    $blurb .= "<h2 class='sr-only'>{$current_filter_str}</h2>";
}

$more_cards_btn = get_button(array(
    'html_text' => 'Show more',
    'class' => 'block-cards__more-cards-btn btn--secondary btn--large btn--icon-after',
));
$share_all_btn = get_button(array(
    'html_text' => 'Share cards',
    'class' => 'block-cards__share-all-btn btn--primary btn--large btn--icon-after',
    'icon' => 'share',
));
$groups = get_field('card_groups', 'cards');
$colors = ['', 'pink', 'green', 'blue', 'pink'];
$modes = ['', 'bright', 'dark', 'bright', 'dark'];

if ($is_search) {
    $global_classes .= ' page-cards-v2--search-mode';
    $search_value = $search_param;
    $placeholder = $search_param;
} else {
    $search_value = '';
    $placeholder = 'Type search here';
}

?>

<div class='js-module page-cards-v2 page-resources theme theme--neutral theme--mode-light <?= $global_classes; ?>'>

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
        'button_1' => 0,
        'button_2' => 0,
        'button_3' => 0
    );

    $block_index = 0;

    include 'partials/blocks/block-heading.php';

    ?>

    <div class="page-cards-v2__top-bar">

        <div class="page-cards-v2__top-bar-inner">

            <?php
            echo get_button(array(
                'tag' => 'button',
                'id' => 'open-search-form-btn',
                'class' => 'page-cards-v2__open-search-form-btn btn--small-- btn--icon-after btn--icon-only',
                'icon' => 'search',
                'aria-label' => 'Open search form',
            ));
            ?>

            <div class="page-cards-v2__top-bar-divider"></div>

            <div class="page-cards-v2__filters-scroller">

                <div class="page-cards-v2__filters font-label-md">

                    <div class="filters__label">FILTER BY</div>

                    <?php

                    $terms = get_terms(array(
                        'taxonomy' => 'resources_topic',
                        'hide_empty' => false,
                    ));

                    foreach ($terms as $filter):
                        $color = explode(';', get_field('color', 'term_' . $filter->term_id));

                        $filter_num = explode('--', $color[0])[1] ?? '1';
                        
                        if ($current_filter == $filter->slug):
                            $href = build_url([], ['filter', 'search']);
                            $filter_selected = 'btn--selected';
                        else:
                            $href = build_url(['filter' => $filter->slug], ['search'], 'filters');
                            $filter_selected = '';
                        endif;
                    ?>

                        <a href="<?= $href ?>" class="btn btn--tag <?= $color[0]; ?> unselectable btn--icon-before btn--show-icon-only-selected <?= $filter_selected; ?>" data-slug="<?= $filter->slug ?>">
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
            <?php require 'partials/resources/top-bar-secondary.php'; ?>
        </div>
    </div>

    <?php
    $is_featured = $current_view == 'featured' && !$is_search;
    $container_class = $is_featured ? 'page-cards-v2__card-container--featured' : '';
    ?>

    <div class="page-cards-v2__card-container <?= $container_class ?>">
        <?php require 'partials/resources/view-all.php'; ?>
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

<?php
$bottom_text_note = get_field('bottom_text_note', 'resources');
if(!empty($bottom_text_note)):
?>
<div class="data-interactive__text-bottom theme theme--neutral" data-animate='fade-in-up' data-animate-delay='0'>
    <div class="text-bottom__txt-wrapper">
        <div class="text-bottom__txt font-body-xs theme__text--primary">
            <?= $bottom_text_note; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>