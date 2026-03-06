<?php

/**
 * @file archive-data_interactive.php
 * 
 * @brief Options page of the Data Interactive section.
 * 
 * @version 1.0
 * 
 * @author Loyal Design
 */

get_header();

include 'partials/incidents-data.php';
?>


<!-- MAIN GRAPH -->
<?php include 'partials/blocks/block-data-interactive-main-graphs.php'; ?>

<!-- BLOCK TILES -->
<?php include 'partials/blocks/block-tiles.php'; ?>

<!-- BLOCK ADDITIONAL STATS -->
<?php include 'partials/blocks/block-additional-stats.php'; ?>

<!-- BOTTOM TEXT NOTE -->
<?php include 'partials/data-interactive-bottom-text-note.php'; ?>

<?php


get_footer();
?>