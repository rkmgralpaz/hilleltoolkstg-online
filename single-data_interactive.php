<?php get_header(); ?>
<?php

/**
 * @file single-data_interactive.php
 * 
 * @brief Single page of the Data Interactive section.
 * 
 * @version 1.0
 * 
 * @author Loyal Design
 */

if (get_post_field('post_name') == 'years-comparison') {

    include 'page-years-comparison.php';
} elseif (get_post_field('post_name') == 'sources') {

    include 'page-sources.php';
} else {

    include 'partials/data-interactive-data-processor.php';
    include 'partials/custom-get-year-single.php'; ?>

    <?php

    if (have_posts()) {
        while (have_posts()) {
            the_post();
            $data = hillel_build_year_payload(get_the_ID());
            $delta = hillel_get_prev_year_delta(get_the_ID());
            $delta_next = hillel_get_next_year_delta(get_the_ID());
            $incidents_custom = $data['incidents'];


    ?>

            <div class="max-width theme theme--neutral theme--mode-light data-interactive-single">

                <h1 class="data-interactive-single__title font-heading-lg theme__text--primary" data-animate="fade-in-up">Antisemitic Incidents on Campus by Year</h1>


                <!-- YEARS -->
                <?php include 'partials/nav-years.php'; ?>

                <!-- OVERVIEW -->
                <?php include 'partials/blocks/block-overview.php'; ?>

                <!-- INCIDENTS BY TYPE -->
                <?php include 'partials/blocks/block-incidents-by-type.php'; ?>

                <!-- OTHER STATS -->
                <?php include 'partials/blocks/block-other-stats.php'; ?>

                <!-- THE CONTEXT  -->
                <?php include 'partials/blocks/block-context.php'; ?>

                <!-- RELATED MEDIA -->
                <?php
                $module_title = get_field('title');
                $module_resources = get_field('resources');

                if (!empty($module_resources) && is_array($module_resources)) :
                    include get_template_directory() . '/partials/blocks/block-related-media-horizontal.php';
                endif;
                ?>


                <div class="data-interactive-single__back-btn-wrapper" data-animate="fade-up">
                    <?php
                    echo get_button(array(
                        'html_text' => 'Back to Overview',
                        'href' => BASE_URL . 'data-interactive/',
                        'class' => 'btn--secondary btn--large btn--icon-before',
                        'icon' => 'chevron-left',
                    ));
                    ?>

                    <?php
                    $current_year_range = get_the_title(get_the_ID());

                    echo get_button(array(
                        'html_text' => 'Compare Years',
                        'href' => BASE_URL . "data-interactive/years-comparison/?y=$current_year_range",
                        'class' => 'btn--secondary btn--large btn--icon-after',
                        'icon' => 'chevron-right',
                    ));
                    ?>
                </div>

            </div>


            </div>


            <?php

            include 'partials/data-interactive-bottom-text-note.php';

            ?>

<?php
        }
    }
}
?>

<?php get_footer(); ?>