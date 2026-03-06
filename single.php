<?php get_header(); ?>

<?php

// Start the Loop.
while ( have_posts() ) : the_post();

?>

    <h1><?php echo get_the_title(); ?></h1>

<?php 

endwhile;

?>

<?php get_footer(); ?>