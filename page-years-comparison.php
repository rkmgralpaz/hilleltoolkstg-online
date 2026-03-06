<div class="js-module page-years-comparison theme theme--pink theme--mode-neutral">


    <?php

    include 'partials/incidents-data.php';

    function get_sorted_array($data_array, $limit = null)
    {
        // 1. Clona el array y filtra valores vacíos.
        // Usamos array_filter() para eliminar elementos vacíos.
        $result = array_filter($data_array); 

        // 2. Ordena el clon.
        sort($result);

        // 3. Aplica el límite si se ha especificado ($limit > 0).
        if (is_int($limit) && $limit > 0) {
            // array_slice(array, offset, length)
            // Empezamos en el índice 0 y tomamos $limit elementos.
            $result = array_slice($result, 0, $limit);
        }
        
        // 4. Devuelve el array ordenado y limitado.
        return $result;
    }
    function is_used_year($year)
    {
        global $sorted_years;
        foreach($sorted_years as $y){
            if($y == $year){
                return true;
            }
        }
        return false;
    }
    function remove_year($original_array = [],$key_to_remove = 0)
    {
        if(empty($original_array)){
            return [];
        }
        // 1. Create a COPY of the array (simple assignment creates a copy for arrays)
        $copy_array = $original_array;
        // 2. Remove the item from the COPY
        unset($copy_array[$key_to_remove]);
        // Optional: Reindex the keys if you want a consecutive array (0, 1, 2...)
        $reindexed_copy = array_values($copy_array);
        //
        return implode(',',$reindexed_copy);

    }
    function update_url_param($param, $value = null, $url = null)
    {
        // Si no se pasa URL, usamos la actual
        if (!$url) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }

        // Parseamos la URL
        $parts = parse_url($url);

        // Parseamos los parámetros
        parse_str($parts['query'] ?? '', $query);

        // Agregamos/modificamos o eliminamos según el valor
        if ($value) {
            $query[$param] = $value;
        } else {
            unset($query[$param]);
        }

        // Reconstruimos la URL
        $new_url = $parts['path'];
        if (!empty($query)) {
            $new_url .= '?' . http_build_query($query);
        }

        return $new_url;
    }

    /* $y1 = $_GET['y1'] ?? '';
    $y2 = $_GET['y2'] ?? '';
    $y3 = $_GET['y3'] ?? ''; */
    $is_subtype = isset($_GET['subtype']);
    $y_param = explode(',',$_GET['y'] ?? '');
    $sorted_years = get_sorted_array($y_param,3);
    $sorted_years_total = count($sorted_years);
    $max_years = $sorted_years_total < 3 ? $sorted_years_total+1 : 3;
    

    //

    $years_selects = [];
    $max_value = 0;
    $subtypes_start_year_str = get_field('subtypes_start_year', 'data_interactive');
    $subtypes_start_year = (int)(explode('-', $subtypes_start_year_str)[0]);
    $subtypes_disclaimer_text = get_field('subtypes_disclaimer_text', 'data_interactive') .' '. $subtypes_start_year_str;

    for($j=0; $j<$max_years; $j++):
        $select_options = '';
        $hit = 0;
        $i = $j+1;
        $s_year = $sorted_years[$j] ?? 'no_year';
        foreach ($incidents_data as $row):
            $year = (int)(explode('-', $row['year'])[0]);
            //$append = $is_subtype && $year < $subtypes_start_year ? '*' : '';
            $append = '';
            if($is_subtype && $year < $subtypes_start_year):
                continue;
            endif;
            if ($row['year'] == $s_year):
                $select_options .= "<option value='{$row['year']}' selected>{$row['year']}{$append}</option>";
                $hit = 1;
                $max_value = max($max_value, (int)$row['total_incidents']);
            elseif (is_used_year($row['year'])):
                $select_options .= "<option value='{$row['year']}' disabled>{$row['year']}{$append}</option>";
            else:
                $select_options .= "<option value='{$row['year']}'>{$row['year']}{$append}</option>";
            endif;
        endforeach;
        $none_selected = $hit ? '' : 'selected disabled';
        array_push($years_selects, "
        <select name='select-{$i}' id='select-{$i}' class='page-comparison-years__select' data-target-param='y' aria-label='Add another year'>
            <option value='' class='placeholder'>Choose year</option>
            {$select_options}
        </select>
    ");
    endfor;

    $y_axis_zoom = (float)get_field('y_axis_zoom', 'data_interactive');

    //print_r($incidents_data);

    //

    $page_title = get_field('data_interactive_years_comparison_title', 'data_interactive');
    $blurb = get_field('data_interactive_years_comparison_blurb', 'data_interactive');


    $block_external_content = array(
        'module_color_settings' => array(
            'color_palette' => 'pink;',
            'color_mode' => 'bright',
            'alignment' => 'block--align-center',
            'title' => 'font-heading-lg'
        ),
        'title' => $page_title,
        'heading_tag' => 'h1',
        'text' => $blurb,
        'tagline' => '',
        'note' => '',
        'button_1' => 0,
        'button_2' => 0,
        'button_3' => 0
    );

    $block_index = 0;

    include 'partials/blocks/block-heading.php';
    //

    ?>

    <div class="page-years-comparison__content">

        <div class="page-years-comparison__tab-wrapper">
            <div class="page-years-comparison__tabs">
                <a class="page-years-comparison__tab-btn font-label-md <?php if (!$is_subtype) {
                                                                            echo 'page-years-comparison__tab-btn--selected';
                                                                        } ?>" href="<?php echo str_replace('%2C',',',htmlspecialchars(update_url_param('subtype', null))); ?>">Total Incidents</a>
                <a class="page-years-comparison__tab-btn font-label-md <?php if ($is_subtype) {
                                                                            echo 'page-years-comparison__tab-btn--selected';
                                                                        } ?>" href="<?php echo str_replace('%2C',',',htmlspecialchars(update_url_param('subtype', 1))); ?>">Incident Types</a>
            </div>
        </div>

        <div class="page-years-comparison__graphs">

            <div class="page-years-comparison__graphs-desktop" data-max-years="<?= $max_years ?>">

                <?php

                for($k=0; $k<$max_years; $k++):
                    $select_options = '';
                    $hit = 0;
                    $i = $k+1;
                    $add_selector_button = ($sorted_years_total < $max_years && $i == $max_years);
                    $s_year = $sorted_years[$k] ?? 'no_year';
                    foreach ($incidents_data as $row):
                        if ($row['year'] == $s_year):
                            $hit = 1;
                            include 'partials/years-comparison/year-desktop.php';
                        endif;
                    endforeach;
                    //
                    if($add_selector_button):
                        //echo 'hola';
                        include 'partials/years-comparison/year-desktop.php';
                    endif;
                    //
                endfor;
                

                ?>

            </div>

            <?php if ($is_subtype): ?>

                <div class="block-incidents-by-type__color-keys">
                    <div class="color-key color-key--horizontal color-key--not-clickable theme--neutral theme--mode-light">
                        <?php
                        foreach ($subtype_data as $subtype):
                            if ($subtype['name'] != 'all'):
                        ?>
                                <div class="color-key__item" data-index="0" data-percentage="13.9" data-label="<?= $subtype['title'] ?>">
                                    <div>
                                        <span class="color-key__item-dot"></span>
                                        <span class="color-key__item-text font-body-sm theme__text--primary"><?= $subtype['title'] ?></span>
                                    </div>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
        </div>

        <div class="page-years-comparison__disclaimer page-years-comparison__disclaimer--desktop font-body-xs theme__text--secondary"><?= $subtypes_disclaimer_text; ?></div>

    <?php endif; ?>

    <div class="page-years-comparison__graphs-mobile" data-max-years="<?= $max_years ?>">
        <?php

        for($k=0; $k<$max_years; $k++):
            $select_options = '';
            $hit = 0;
            $i = $k+1;
            $add_selector_button = ($sorted_years_total < $max_years && $i == $max_years);
            $s_year = $sorted_years[$k] ?? 'no_year';
            foreach ($incidents_data as $row):
                if ($row['year'] == $s_year):
                    $hit = 1;
                    include 'partials/years-comparison/year-mobile.php';
                endif;
            endforeach;
            //
            if($add_selector_button):
                //echo 'hola';
                include 'partials/years-comparison/year-mobile.php';
            endif;
            //
        endfor;

        ?>
    </div>

    <?php if ($is_subtype): ?>
        <div class="page-years-comparison__disclaimer page-years-comparison__disclaimer--mobile font-body-sm theme__text--secondary"><?= $subtypes_disclaimer_text; ?></div>
    <?php else: ?>
        <div>&nbsp</div>
    <?php endif; ?>

    </div>

</div>

<div class="page-years-comparison__back-btn-wrapper theme theme--neutral" data-animate="fade-up">
    <?php
    //
    echo get_button(array(
        'html_text' => 'Back to Overview',
        'href' => BASE_URL . 'data-interactive/',
        'class' => 'page-years-comparison__back-btn btn--secondary btn--large btn--icon-before',
        'icon' => 'chevron-left',
    ));

    /* 
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
        */

    /* $years = [$y1, $y2, $y3];
    rsort($years); */

    echo get_button(array(
        'html_text' => 'Go Deeper into a Year',
        'href' => get_site_url() . "/data-interactive/{$y_param[0]}/",
        'class' => 'btn--secondary btn--large btn--icon-after',
        'icon' => 'chevron-right',
    ));

    ?>
</div>

</div>

<?php

include 'partials/data-interactive-bottom-text-note.php';

?>

