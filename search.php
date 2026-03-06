<?php get_header(); ?>

<?php

	$str_search = str_replace("\'","'",$_GET['s']);
	$post_type_list = array('events','team','page');
	//
	$query_args = array(
		'post_type' => $post_type_list,
		//'exclude_post_type' => array('attachment','revision','venues'),
		'post_status' => array('publish'),
		'orderby'=> array('type'=>'ASC', 'title'=>'ASC'),
		//'title_filter' => $str_search,
		//'title_filter_relation' => 'OR',
		'relation' => 'OR',
		'meta_query' => array(
			'relation' => 'OR',
			array('key' => 'default_title', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'default_to_search', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'text', 'compare' => 'LIKE','value' => $str_search),
			
			//
			/* array('key' => 'homepage_modules_$_title', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_text', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_text_column_1', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_text_column_2', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_items_$_text', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_items_$_title_column_1', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_items_$_title_column_2', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_items_$_text_column_1', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'homepage_modules_$_items_$_text_column_2', 'compare' => 'LIKE','value' => $str_search),
			//
			array('key' => 'additional_content_$_title', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'additional_content_$_text', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'additional_content_$_text_column_1', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'additional_content_$_text_column_2', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'additional_content_$_people_$_name', 'compare' => 'LIKE','value' => $str_search),
			array('key' => 'additional_content_$_people_$_position_and_institution', 'compare' => 'LIKE','value' => $str_search), */
		),
	);
	$query = new WP_Query($query_args);

// Start the Loop.
while ( $query->have_posts() ) : $query->the_post();

?>

    <h1><?php echo get_the_title(); ?></h1>

<?php 

	$status_results = $query->found_posts ? $query->found_posts.' search results for “'.str_replace("\'","'",$_GET['s']).'”' : 'No results for “'.str_replace("\'","'",$_GET['s']).'”';

endwhile;

?>

<?php get_footer(); ?>

