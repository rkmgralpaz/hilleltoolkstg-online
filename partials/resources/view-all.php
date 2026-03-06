<div class="grid-resources-wrap">

    <?php
    $filter = $_GET['filter'] ?? null;
    $format = $_GET['format'] ?? null;

    $args = array(
        'post_type' => 'resources',
        'posts_per_page' => -1,
    );

    if ($filter || $format) {
        $tax_query = array('relation' => 'AND');

        if ($filter) {
            $tax_query[] = array(
                'taxonomy' => 'resources_topic',
                'field'    => 'slug',
                'terms'    => $filter,
            );
        }

        if ($format) {
            $tax_query[] = array(
                'taxonomy' => 'resources_format',
                'field'    => 'slug',
                'terms'    => $format,
            );
        }

        $args['tax_query'] = $tax_query;
    }

    $search = $_GET['search'] ?? null;

    if ($search) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key'     => 'secondary_information',
                'value'   => $search,
                'compare' => 'LIKE',
            ),
            array(
                'key'     => 'author',
                'value'   => $search,
                'compare' => 'LIKE',
            ),
            array(
                'key'     => 'search_title',
                'value'   => $search,
                'compare' => 'LIKE',
            ),
        );
    }

    $orderby = $_GET['orderby'] ?? 'alphabetically';

    switch ($orderby) {
        case 'alphabetically':
            $args['meta_key'] = 'processed_title'; // Usar el campo meta oculto para la ordenación
            $args['orderby'] = 'meta_value';
            $args['order'] = 'ASC';
            break;

        case 'topic':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            $args['tax_query'][] = array(
                'taxonomy' => 'resources_topic',
                'field'    => 'slug',
                'terms'    => get_terms('resources_topic', array('fields' => 'slugs')),
                'operator' => 'IN'
            );
            break;
    }

    $taxonomy_grouping = null;
    if ($orderby === 'topic') {
        $taxonomy_grouping = 'resources_topic';
    } elseif ($orderby === 'format') {
        $taxonomy_grouping = 'resources_format';
    }

    if ($taxonomy_grouping) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy_grouping,
            'hide_empty' => false,
        ));

        $has_results = false; // Bandera para verificar si hay resultados

        foreach ($terms as $term) {
            $term_args = $args;
            $term_args['tax_query'][] = array(
                'taxonomy' => $taxonomy_grouping,
                'field'    => 'slug',
                'terms'    => $term->slug,
            );

            $term_query = new WP_Query($term_args);

            if ($term_query->have_posts()) {
                $has_results = true; // Marcar que hay resultados
    ?>
                <div class="grid-resources-wrap__group">
                    <h2 class="page-cards-v2__term-heading font-heading-xl"><?php echo esc_html($term->name); ?></h2>
                    <div class="grid-resources">
                        <?php while ($term_query->have_posts()) : $term_query->the_post(); ?>
                            <?php get_template_part('partials/resources/components/resource-card'); ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
            }
            wp_reset_postdata();
        }

        if (!$has_results) { // Mostrar mensaje si no hay resultados para ningún término
            ?>
            <div class="no-results font-body-sm theme__text--primary">
                No results for the selected topics.
                <a href="<?php echo esc_url(remove_query_arg(array('filter', 'format', 'search', 'orderby'))); ?>">Clear filters</a>
            </div>
        <?php
        }
    } else {
        $args['posts_per_page'] = -1; // Asegurar que se obtengan todos los posts
        $resources_query = new WP_Query($args);

        if ($resources_query->have_posts()) {
            echo '<div class="grid-resources">';
            while ($resources_query->have_posts()) {
                $resources_query->the_post();
                get_template_part('partials/resources/components/resource-card');
            }
            echo '</div>';

            wp_reset_postdata();
        } else {
        ?>
            <div class="no-results font-body-sm theme__text--primary">
                No results.
                <a href="<?php echo esc_url(remove_query_arg(array('filter', 'format', 'search', 'orderby'))); ?>">Clear filters</a>
            </div>
    <?php
        }
    }
    ?>

</div>