<?php
/**
 * @file data-interactive-data-processor.php
 * 
 * @brief Module with functions that extract and process
 * data for the Data Interactive section.
 * 
 * @version 1.1.1
 * 
 * @author Loyal Design
 */

/*<-----| CSV PROCESSING |----->*/

/**
 * @brief Retrieves data from a CSV file and stores it in a matrix.
 */
function get_data_from_csv(string $csv_url) : array
{
    $upload_dir = wp_upload_dir();
    $file_path  = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $csv_url);

    $file_data = [];

    if ( file_exists($file_path) ) {
        if (($csv_file = fopen($file_path, 'r')) !== false) {
            // Saltear cabecera
            fgetcsv($csv_file, 0, ';');

            while (($data_line = fgetcsv($csv_file, 1000, ';')) !== false) {
                $file_data[] = $data_line;
            }

            fclose($csv_file);
        }
    }

    return $file_data;
}



/*<-----| END CSV PROCESSING |----->*/

/*<-----| DATA INTERACTIVE SECTION HANDLING |----->*/

/**
 * @brief Writes data in Data Interactive landing page.
 */
function write_data_in_page(array $data_matrix, string $table_field_name, string | int $post_id) : void
{
    foreach($data_matrix as $matrix_row)
    {
        $table_row = array(
            'year' => $matrix_row[0],
            'total_incidents' => $matrix_row[1],
            'social_media_email' => $matrix_row[2],
            'article_publication' => $matrix_row[3],
            'hate_speech' => $matrix_row[4],
            'vandalism_graffiti' => $matrix_row[5],
            'physical_harassment' => $matrix_row[6],
            'assault' => $matrix_row[7],
            'bds_votes' => $matrix_row[8],
            'anti_israel_legislation' => $matrix_row[9],
            'commencement_disruptions' => $matrix_row[10],
            'encampments' => $matrix_row[11]
        );
        add_row($table_field_name, $table_row, $post_id);
    }
}

/**
 * @brief Deletes the data from a table in a post.
 */
function clear_data_table(string $field_name, string | int $post_id) : void
{
    reset_rows();

    if(have_rows($field_name, $post_id))
    {
        $row_number = count(get_field($field_name, $post_id));

        while(have_rows($field_name, $post_id))
        {
            the_row();

            delete_row($field_name, $row_number--, $post_id);
        }
    }
}

/**
 * @brief Creates new posts in the Data Interactive section
 * if they do not already exist.
 */
function create_year_posts(array $titles_list) : void
{
    $existing_year_posts = get_posts(array(
        'post_type' => 'data_interactive',
        'post_status' => array('publish', 'draft'),
        'posts_per_page' => -1
    ));

    $existing_year_posts_titles = array();

    foreach($existing_year_posts as $existing_post)
    {
        array_push($existing_year_posts_titles, $existing_post->post_title);
    }

    foreach($titles_list as $title)
    {
        if(!in_array($title, $existing_year_posts_titles))
        {
            wp_insert_post(array(
                'post_title' => $title,
                'post_type' => 'data_interactive',
                'post_status' => 'draft'
            ));
        }
    }
}

/**
 * @brief Writes data in each post of the Data Interactive section.
 */
function update_year_posts_data(array $data_matrix) : void
{
    $year_posts = get_posts(array(
        'post_type' => 'data_interactive',
        'post_status' => array('publish', 'draft'),
        'posts_per_page' => -1
    ));

    foreach($data_matrix as $row)
    {
        foreach($year_posts as $year_post)
        {
            if($row[0] == $year_post->post_title)
            {
                $year_data_incidents = array(
                    'total_incidents' => $row[1],
                    'social_media_email' => $row[2],
                    'article_publication' => $row[3],
                    'hate_speech' => $row[4],
                    'vandalism_graffiti' => $row[5],
                    'physical_harassment' => $row[6],
                    'assault' => $row[7]
                );

                $year_data_other_stats = array(
                    'bds_votes' => $row[8],
                    'anti_israel_legislation' => $row[9],
                    'commencement_disruptions' => $row[10],
                    'encampments' => $row[11]
                );

                update_field('year_data_incidents', $year_data_incidents, $year_post->ID);
                update_field('year_data_other_stats', $year_data_other_stats, $year_post->ID);

                break;
            }
        }
    }
}

/**
 * @brief Imports the data from a CSV file into the backend of the
 * Data Interactive section. Also creates posts for each year in the
 * Data Interactive section if they don't exist.
 */
function import_csv_data(string $csv_filepath, string $table_field_name, string | int $post_id) : void
{
    if(!empty(get_field($table_field_name, $post_id)))
    {
        clear_data_table($table_field_name, $post_id);
    }

    $csv_data = get_data_from_csv($csv_filepath);

    write_data_in_page($csv_data, $table_field_name, $post_id);

    $years_list = array();

    foreach($csv_data as $row)
    {
        array_push($years_list, $row[0]);
    }

    create_year_posts($years_list);

    update_year_posts_data($csv_data);
}

/*<-----| END DATA INTERACTIVE SECTION HANDLING |----->*/

/*<-----| GET DATA INTERACIVE SECTION DATA |----->*/

/**
 * @brief Gets year data from the table in the Data Interactive landing page.
 * Can be set to return data of all years or of a single year.
 * 
 * @param[in] $mode A string that sets the function in one of two modes.
 * 
 * Use syntax:
 * 
 * get_years_data() to get data of every year,
 * get_years_data(mode: 'single_year', year: 'xxxx–xx') to get data of specific year.
 * 
 * @return array $years_data An array with the requested data.
 * @return null If error is raised due to wrong parameter input.
 */
function get_years_data(string $table_field_name = 'data_table',
                        string $mode = 'all_years',
                        string | null $year = null,
                        string | int $post_id = 'data_interactive') : array | null
{
    if($mode == 'all_years')
    {
        $years_data = array();

        if(have_rows($table_field_name, $post_id))
        {
            reset_rows();
            while(have_rows($table_field_name, $post_id))
            {
                the_row();

                $row_data = array(
                    'year' => get_sub_field('year'),
                    'total_incidents' => get_sub_field('total_incidents'),
                    'social_media_email' => get_sub_field('social_media_email'),
                    'article_publication' => get_sub_field('article_publication'),
                    'hate_speech' => get_sub_field('hate_speech'),
                    'vandalism_graffiti' => get_sub_field('vandalism_graffiti'),
                    'physical_harassment' => get_sub_field('physical_harassment'),
                    'assault' => get_sub_field('assault'),
                    'bds_votes' => get_sub_field('bds_votes'),
                    'anti_israel_legislation' => get_sub_field('anti_israel_legislation'),
                    'commencement_disruptions' => get_sub_field('commencement_disruptions'),
                    'encampments' => get_sub_field('encampments')
                );

                array_push($years_data, $row_data);
            }
        }
    }

    elseif($mode == 'single_year')
    {
        if($year != null)
        {
            if(have_rows($table_field_name, $post_id))
            {
                reset_rows();
                while(have_rows($table_field_name, $post_id))
                {
                    the_row();

                    if(get_sub_field('year') == $year)
                    {
                        $years_data = array(
                            'year' => get_sub_field('year'),
                            'total_incidents' => get_sub_field('total_incidents'),
                            'social_media_email' => get_sub_field('social_media_email'),
                            'article_publication' => get_sub_field('article_publication'),
                            'hate_speech' => get_sub_field('hate_speech'),
                            'vandalism_graffiti' => get_sub_field('vandalism_graffiti'),
                            'physical_harassment' => get_sub_field('physical_harassment'),
                            'assault' => get_sub_field('assault'),
                            'bds_votes' => get_sub_field('bds_votes'),
                            'anti_israel_legislation' => get_sub_field('anti_israel_legislation'),
                            'commencement_disruptions' => get_sub_field('commencement_disruptions'),
                            'encampments' => get_sub_field('encampments')
                        );
                    }
                }
            }
        }
        
        else
        {
            echo 'Error: year parameter can not be null in single_year mode';
            $years_data = null;
        }
    }

    else
    {
        echo 'Error: wrong mode parámeter';
        $years_data = null;
    }

    return $years_data;
}

/**
 * @brief Gets the subtitle and text for the graph of every incident subtype
 * from the Data Interactive landing page.
 */
function get_incident_subtypes_texts(string | int $post_id = 'data_interactive') : array
{
    $graph_texts = array(
        'all' => array(
            'subtitle' => get_field('all_graph_subtitle', $post_id),
            'text' => get_field('all_graph_text', $post_id)
        ),
        'social_media_email' => array(
            'subtitle' => get_field('social_media_email_graph_subtitle', $post_id),
            'text' => get_field('social_media_email_graph_text', $post_id)
        ),
        'article_publication' => array(
            'subtitle' => get_field('article_publication_graph_subtitle', $post_id),
            'text' => get_field('article_publication_graph_text', $post_id)
        ),
        'hate_speech' => array(
            'subtitle' => get_field('hate_speech_graph_subtitle', $post_id),
            'text' => get_field('hate_speech_graph_text', $post_id)
        ),
        'vandalism_graffiti' => array(
            'subtitle' => get_field('vandalism_graffiti_graph_subtitle', $post_id),
            'text' => get_field('vandalism_graffiti_graph_text', $post_id)
        ),
        'physical_harassment' => array(
            'subtitle' => get_field('physical_harassment_graph_subtitle', $post_id),
            'text' => get_field('physical_harassment_graph_text', $post_id)
        ),
        'assault' => array(
            'subtitle' => get_field('assault_graph_subtitle', $post_id),
            'text' => get_field('assault_graph_text', $post_id)
        )
    );

    return $graph_texts;
}

/**
 * @brief Gets the all the data from the Data Interactive year posts fields
 * and stores it in an array along with the colors of the incidents subtypes.
 */
function get_year_post_data(string | int $post_id) : array
{
    $year_post_data = array(
        'intro_text' => get_field('intro_text', $post_id),
        'incidents_by_type' => get_field('incidents_by_type', $post_id),
        'incldents_colors' => array(
            'color_social_media_email' => '#AD86DA',
            'color_article_publication' => '#6E91FF',
            'color_hate_speech' => '#F9C7F6',
            'color_vandalism_graffiti' => '#76B29F',
            'color_physical_harassment' => '#FFC36A',
            'color_assault' => '#BE875C',
            'color_others' => '#C8CCD2'
        ),
        'other_stats_description' => array(
            'bds_votes' => get_field('additional_stats_bds_votes_description', 'data_interactive'),
            'anti_israel_legislation' => get_field('additional_stats_anti_israel_legislation_description', 'data_interactive'),
            'commencement_disruption' => get_field('additional_stats_commencement_disruptions_description', 'data_interactive'),
            'encampments' => get_field('additional_stats_encampments_description', 'data_interactive')
        ),
        'other_stats_context' => get_field('other_stats', $post_id)
    );

    return $year_post_data;
}

function get_incident_colors_css_vars(){
    $incidents_colors = get_year_post_data(0);
    $i=1;
    $css = '<style>
    :root{
    --incident-subtype-colors-0: #332933;';
    foreach ($incidents_colors['incldents_colors'] as $key => $value) {
        $css .= "--incident-subtype-colors-{$i}: {$value};";
        $i++;
    }
    $css .= '
    }
    </style>';
    return $css;
}
/*<-----| END GET DATA INTERACIVE SECTION DATA |----->*/
?>
