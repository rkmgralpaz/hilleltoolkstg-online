<?php get_header(); ?>


<?php

while (have_posts()) : the_post();

	// include 'partials/blocks/block-home-animation.php'; 
?>


	<?php include 'partials/global-modules.php'; ?>

<?php
	
endwhile;


?>


<?php get_footer(); ?>