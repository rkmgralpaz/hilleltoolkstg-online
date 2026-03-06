<div class="block-tiles max-width">

    <?php

    $year_posts = get_posts(array(
        'post_type' => 'data_interactive',
        'post_status' => array('publish', 'draft'),
        'posts_per_page' => -1
    ));
    $years = [];
    foreach($year_posts as $y_post):
        if(preg_match('/^\d{4}-\d{4}$/', $y_post->post_name)):
            array_push($years,$y_post->post_name);
        endif;
    endforeach;
    rsort($years);//ordena los años del más reciente al más antiguo

    $args = [
        'custom_class' => 'component-tile-year theme theme--pink theme--mode-bright',
        'title' => get_field('color_box_year_data', 'data_interactive')['color_box_year_data_title'],
        'heading_tag' => 'h2',
        'blurb' => get_field('color_box_year_data', 'data_interactive')['color_box_year_data_blurb'],
        'link' => get_site_url() . "/data-interactive/{$years[0]}/",
        'img' => get_template_directory_uri() . '/assets-data-interactives/tile-year.svg'
    ];
    get_template_part('partials/components/component', 'tile', $args);
    ?>

    <?php
    $arg = [
        'custom_class' => 'component-tile-comparisson theme theme--blue theme--mode-bright',
        'title' => get_field('color_box_compare_years', 'data_interactive')['color_box_compare_years_title'],
        'heading_tag' => 'h2',
        'blurb' => get_field('color_box_compare_years', 'data_interactive')['color_box_compare_years_blurb'],
        'link' => get_site_url() . "/data-interactive/years-comparison/?y={$years[0]},{$years[1]},{$years[2]}",
        'img' => get_template_directory_uri() . '/assets-data-interactives/tile-comparisson.svg'
    ];
    get_template_part('partials/components/component', 'tile', $arg);

    ?>

</div>