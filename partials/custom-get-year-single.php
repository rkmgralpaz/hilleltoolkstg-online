<?php

/**
 * Construye el payload normalizado para la single de Data Interactive.
 *
 * Estructura resultante:
 * [
 *   'post_id', 'year_title', 'year', 'total_incidents',
 *   'intro_text',
 *   'incidents_by_type' => ['subtitle','context'],
 *   'incidents' => [ {name,total,color}, ... ],
 *   'other_stats_subtitle',
 *   'other_stats' => [ {name,total,description,context}, ... ]
 * ]
 *
 * Notas:
 * - Colores: $fields['incldents_colors']['color_'.$key]
 * - Descripciones: $fields['other_stats_description'][$key]
 *   (fallback para "commencement_disruptions" -> "commencement_disruption")
 * - Contextos: $fields['other_stats_context'][$key.'_context']
 *
 * @param int $post_id
 * @return array
 */
function hillel_build_year_payload($post_id)
{
    $fmt = static function ($key) {
        return ucwords(str_replace('_', ' ', $key));
    };

    $year_title = get_the_title($post_id);

    // Campos del post (ACF) y fila de la tabla maestra
    $fields    = get_year_post_data($post_id);
    $table_row = get_years_data('data_table', 'single_year', $year_title, 'data_interactive');

    $fields    = is_array($fields) ? $fields : [];
    $table_row = is_array($table_row) ? $table_row : [];

    // Slices: posiciones 2..7 (incidents) y 8..11 (other stats)
    $keys             = array_keys($table_row);
    $incidents_keys   = array_slice($keys, 2, 6, true);
    $other_stats_keys = array_slice($keys, 8, 4, true);

    // Colores (soporta typo 'incldents_colors' y fallback correcto)
    $colors = [];
    if (isset($fields['incldents_colors']) && is_array($fields['incldents_colors'])) {
        $colors = $fields['incldents_colors'];
    } elseif (isset($fields['incidents_colors']) && is_array($fields['incidents_colors'])) {
        $colors = $fields['incidents_colors'];
    }

    // Suma para el gráfico de Incidents By Type (100% del gráfico)
    $incidents_graph_total = 0;
    foreach ($incidents_keys as $k) {
        if (isset($table_row[$k]) && $table_row[$k] !== '') {
            $incidents_graph_total += (int)$table_row[$k];
        }
    }

    // Header
    $out = [
        'post_id'           => $post_id,
        'year_title'        => $year_title,
        'year'              => $table_row['year'] ?? null,
        'total_incidents'   => isset($table_row['total_incidents']) ? (int)$table_row['total_incidents'] : null,
        'intro_text'        => $fields['intro_text'] ?? '',
        'incidents_by_type' => [
            'subtitle' => $fields['incidents_by_type']['subtitle'] ?? '',
            'context'  => $fields['incidents_by_type']['context']  ?? '',
        ],
    ];

    // Grand total for percent calculations (from table row)
    $grand_total = isset($table_row['total_incidents']) && $table_row['total_incidents'] !== ''
        ? (int)$table_row['total_incidents']
        : 0;

    // Incidents
    $out['incidents'] = [];
    $prev_post = hillel_get_previous_year_post($post_id);
    $prev_table_row = null;
    if ($prev_post) {
        $prev_fields = get_year_post_data($prev_post->ID);
        $prev_table_row = get_years_data('data_table', 'single_year', get_the_title($prev_post->ID), 'data_interactive');
        $prev_table_row = is_array($prev_table_row) ? $prev_table_row : [];
    }
    //$total_incidents = isset($table_row['total_incidents']) && $table_row['total_incidents'] !== '' ? (int)$table_row['total_incidents'] : 0;

    foreach ($incidents_keys as $k) {
        $total = isset($table_row[$k]) && $table_row[$k] !== '' ? (int)$table_row[$k] : null;

        // percent_of_total calculation: usar el TOTAL GENERAL si existe; fallback al total del gráfico
        $denominator = ($grand_total > 0) ? $grand_total : $incidents_graph_total;
        if ($denominator > 0 && $total !== null) {
            $percent_of_total_val = ($total / $denominator) * 100;
            $percent_of_total_str = rtrim(rtrim(number_format($percent_of_total_val, 1, '.', ''), '0'), '.') . '%';
        } else {
            $percent_of_total_str = null;
        }

        // trend_type and trend_percent calculation
        $trend_type = null;
        $trend_percent = null;
        if ($prev_post && $total !== null && isset($prev_table_row[$k]) && $prev_table_row[$k] !== '') {
            $prev_total = (int)$prev_table_row[$k];
            if ($prev_total > 0) {
                if ($total === $prev_total) {
                    // Cambio 0% → igual
                    $trend_type = 'equal';
                    $trend_percent = '0%';
                } else {
                    $delta = (($total - $prev_total) / $prev_total) * 100;
                    $abs_delta = abs($delta);
                    $percent_str = rtrim(rtrim(number_format($abs_delta, 1, '.', ''), '0'), '.');
                    $trend_type = ($total > $prev_total) ? 'increase' : 'decrease';
                    $trend_percent = $percent_str . '%';
                }
            }
        }

        $out['incidents'][] = [

            'name' => $k,
            'total' => $total,
            'color' => $colors['color_' . $k] ?? null,
            'percent_of_total' => $percent_of_total_str,
            'trend_type' => $trend_type,
            'trend_percent' => $trend_percent,
        
        ];

    }

    // === Ajuste para que el total de incidentes coincida con el total general ===
    // Sumar incidentes existentes
    $sum_incidents = array_sum(array_map(function($i){
        return is_numeric($i['total']) ? (int)$i['total'] : 0;
    }, $out['incidents']));

    // Si faltan casos para llegar al total general, agregar segmento "others" (gris)
    if ($grand_total > 0) {
        $missing_total = max(0, $grand_total - $sum_incidents);
        if ($missing_total > 0) {
            $others_pct_val = ($missing_total / $grand_total) * 100;
            $out['incidents'][] = [
                'name'             => 'others',
                'total'            => $missing_total,
                'color'            => '#C8CCD2', // gris (neutro)
                'percent_of_total' => rtrim(rtrim(number_format($others_pct_val, 1, '.', ''), '0'), '.') . '%',
                'trend_type'       => null,
                'trend_percent'    => null,
            ];
        }
    }

    // Other stats
    $out['other_stats_subtitle'] = $fields['other_stats_context']['subtitle'] ?? null;

    $out['other_stats'] = [];
    foreach ($other_stats_keys as $k) {
        // Fallback por inconsistencia singular/plural en tu snapshot:
        // table_row usa "commencement_disruptions"; descriptions venían como "commencement_disruption"
        $descKey = $k;
        if ($k === 'commencement_disruptions' && empty($fields['other_stats_description'][$k])) {
            $descKey = 'commencement_disruption';
        }

        $out['other_stats'][] = [
            'name'        => $fmt($k),
            'total'       => isset($table_row[$k]) && $table_row[$k] !== '' ? (int)$table_row[$k] : null,
            'description' => $fields['other_stats_description'][$descKey] ?? '',
            'context'     => $fields['other_stats_context'][$k . '_context'] ?? '',
        ];
    }

    return $out;
}

/**
 * Obtiene el post del año anterior a partir de un título "YYYY-YYYY".
 * Devuelve WP_Post o null si no existe.
 *
 * @param int $current_post_id
 * @return WP_Post|null
 */
if (!function_exists('hillel_get_previous_year_post')) {
    function hillel_get_previous_year_post(int $current_post_id) {
        $title = get_the_title($current_post_id);
        if (!preg_match('/(\d{4})\s*-\s*(\d{4})/', $title, $m)) {
            return null;
        }
        $y1 = (int)$m[1] - 1;
        $y2 = (int)$m[2] - 1;
        $prev_title = sprintf('%d-%d', $y1, $y2);

        $post_type = get_post_type($current_post_id);
        $prev = get_page_by_title($prev_title, OBJECT, $post_type);
        return ($prev instanceof WP_Post) ? $prev : null;
    }
}

/**
 * Calcula la variación porcentual vs. el año anterior usando `total_incidents`.
 * Devuelve un array con tipo y porcentaje o null si no hay datos.
 *
 * @param int $current_post_id
 * @return array|null { type: 'increase'|'decrease'|'equal', percent: '12.3', percent_txt: '12.3%', current, previous, prev_post_id, prev_title }
 */
if (!function_exists('hillel_get_prev_year_delta')) {
    function hillel_get_prev_year_delta(int $current_post_id) {
        if (!function_exists('hillel_build_year_payload')) return null;

        $current   = hillel_build_year_payload($current_post_id);
        $prev_post = hillel_get_previous_year_post($current_post_id);
        if (!$prev_post) return null;

        $previous  = hillel_build_year_payload($prev_post->ID);

        $curTotal  = (int)($current['total_incidents']  ?? 0);
        $prevTotal = (int)($previous['total_incidents'] ?? 0);
        if ($prevTotal <= 0) return null; // sin base válida

        // Igualdad → 0% y type 'equal'
        if ($curTotal === $prevTotal) {
            return [
                'type'        => 'equal',
                'percent'     => '0',
                'percent_txt' => '0%',
                'current'     => $curTotal,
                'previous'    => $prevTotal,
                'prev_post_id'=> $prev_post->ID,
                'prev_title'  => $previous['year_title'] ?? get_the_title($prev_post),
            ];
        }

        // Desde el AÑO ACTUAL vs PREVIO (mismo criterio que next)
        $delta       = (($curTotal - $prevTotal) / $prevTotal) * 100;
        $abs_delta   = abs($delta);
        $percent_str = rtrim(rtrim(number_format($abs_delta, 1, '.', ''), '0'), '.');

        $type = ($curTotal > $prevTotal) ? 'increase' : 'decrease';

        return [
            'type'        => $type,
            'percent'     => $percent_str,
            'percent_txt' => $percent_str . '%',
            'current'     => $curTotal,
            'previous'    => $prevTotal,
            'prev_post_id'=> $prev_post->ID,
            'prev_title'  => $previous['year_title'] ?? get_the_title($prev_post),
        ];
    }
}

/**
 * Obtiene el post del año siguiente a partir de un título "YYYY-YYYY".
 * Devuelve WP_Post o null si no existe.
 *
 * @param int $current_post_id
 * @return WP_Post|null
 */
if (!function_exists('hillel_get_next_year_post')) {
    function hillel_get_next_year_post(int $current_post_id) {
        $title = get_the_title($current_post_id);
        if (!preg_match('/(\d{4})\s*-\s*(\d{4})/', $title, $m)) {
            return null;
        }
        $y1 = (int)$m[1] + 1;
        $y2 = (int)$m[2] + 1;
        $next_title = sprintf('%d-%d', $y1, $y2);

        $post_type = get_post_type($current_post_id);
        $next = get_page_by_title($next_title, OBJECT, $post_type);
        return ($next instanceof WP_Post) ? $next : null;
    }
}

/**
 * Calcula la variación porcentual desde el año actual hacia el año siguiente (total_incidents).
 * Signo positivo = el año actual es mayor que el siguiente (increase).
 * Signo negativo = el año actual es menor que el siguiente (decrease).
 * Devuelve null si no hay año siguiente o si faltan datos válidos.
 *
 * @param int $current_post_id
 * @return array|null { type: 'increase'|'decrease'|'equal', percent: '12.3', percent_txt: '12.3%', current, next, next_post_id, next_title }
 */
if (!function_exists('hillel_get_next_year_delta')) {
    function hillel_get_next_year_delta(int $current_post_id) {
        if (!function_exists('hillel_build_year_payload')) {
            return null;
        }

        $current = hillel_build_year_payload($current_post_id);
        $next_post = hillel_get_next_year_post($current_post_id);
        if (!$next_post) return null;

        $next = hillel_build_year_payload($next_post->ID);

        $curTotal  = (int)($current['total_incidents'] ?? 0);
        $nextTotal = (int)($next['total_incidents']    ?? 0);
        if ($curTotal <= 0) return null; // evita división por cero

        // Igualdad → 0% y type 'equal'
        if ($curTotal === $nextTotal) {
            return [
                'type'        => 'equal',
                'percent'     => '0',
                'percent_txt' => '0%',
                'current'     => $curTotal,
                'next'        => $nextTotal,
                'next_post_id'=> $next_post->ID,
                'next_title'  => $next['year_title'] ?? get_the_title($next_post),
            ];
        }

        // Interpretación desde el año ACTUAL:
        // Valor positivo => el año actual es MAYOR que el siguiente (increase)
        // Valor negativo => el año actual es MENOR que el siguiente (decrease)
        $delta = (($curTotal - $nextTotal) / $curTotal) * 100;
        $abs_delta = abs($delta);
        $percent_str = rtrim(rtrim(number_format($abs_delta, 1, '.', ''), '0'), '.');

        $type = 'equal';
        if ($curTotal > $nextTotal) {
            $type = 'increase';
        } elseif ($curTotal < $nextTotal) {
            $type = 'decrease';
        }

        return [
            'type'        => $type,
            'percent'     => $percent_str,
            'percent_txt' => $percent_str . '%',
            'current'     => $curTotal,
            'next'        => $nextTotal,
            'next_post_id'=> $next_post->ID,
            'next_title'  => $next['year_title'] ?? get_the_title($next_post),
        ];
    }
}
