<?php get_header(); ?>

<?php

// Start the Loop.
while ( have_posts() ) : the_post();

?>

    <h1><?php echo get_the_title(); ?></h1>

<?php 

endwhile;

$posts = get_posts([
    'post_type'=> 'asdads',
    ''
]);
foreach($posts as $post){
    //$post->ID;
    update_field($post->ID, 'campo', 'valor');
}

?>

<?php get_footer(); ?>