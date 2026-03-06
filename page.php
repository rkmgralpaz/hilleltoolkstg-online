<?php get_header(); ?>

<?php

while ( have_posts() ) : the_post();

	include 'partials/page-header.php';

	include 'partials/global-modules.php';

endwhile;


?>


<?php get_footer(); ?>