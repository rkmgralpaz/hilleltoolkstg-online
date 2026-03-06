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

include 'partials/data-interactive-data-processor.php'; ?>


<?php

if (have_posts()) : while (have_posts()) : the_post();

        $post_id    = get_the_ID();
        $year_title = get_the_title($post_id);

        // datos del post individual (campos ACF del año)
        $fields = get_year_post_data($post_id);

        // datos de la tabla maestra (post "landing" data_interactive)
        $table_row = get_years_data(
            'data_table',
            'single_year',
            $year_title,
            'data_interactive' // slug o ID del post landing
        );

        // snapshot combinado
        $snapshot = array(
            'post_id'     => $post_id,
            'year_title'  => $year_title,
            'table_row'   => $table_row,
            'post_fields' => $fields
        );

        // dump prolijo
        echo '<pre style="padding:12px;background:#111;color:#eee;white-space:pre-wrap;word-break:break-word;">';
        echo esc_html(json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        echo '</pre>';

    endwhile;
endif;

?>



