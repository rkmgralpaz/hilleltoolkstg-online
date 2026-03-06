<?php 

$return_taxonomies_by_incident = (isset($_GET['incident']) && $_GET['incident'] != '') ;

if ( $return_taxonomies_by_incident) {

    $incident_get_slug = sanitize_text_field($_GET['incident']);

    $args = array(
        'post_type' => 'quiz_form',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    
    $quiz_forms = new WP_Query($args);

    $found_match = false;
	$url = 'https://campus4all.org/quiz-outcome-get-answers/';


    if ($quiz_forms->have_posts()) {

        while ($quiz_forms->have_posts()) {
            $quiz_forms->the_post();

            $incident_terms = wp_get_post_terms(get_the_ID(), 'incident_quiz');

            foreach ($incident_terms as $term) {
                if ($term->slug === $incident_get_slug) {
                    $found_match = true;
                    $url = get_the_title();
                    break 2;
                } 
            }
        }

    }

    //--------------------------//
    //--- append data to csv ---//
    //
    if(!isset($_COOKIE["quizform"])):
        setcookie("quizform", 'await', time()+15);//await 15 seconds to save new row
        require 'constants.php'; 
        date_default_timezone_set('America/Los_Angeles');
        $date = date('Y-m-d H:i:s');
        $fieldset = isset($_GET['fieldset']) ? $_GET['fieldset'].';'.$date : '—;—;—;—;—;'.$date;
        $myfile = fopen("./wp-content/themes/hillel-combating-antisemitism/spot-it.csv", "a") or die("Unable to open file!");
        fwrite($myfile, "\n". $fieldset);
        fclose($myfile);   
    endif; 
    //
    //--- append data to csv ---//
    //--------------------------//

    echo $url;
}

?>



