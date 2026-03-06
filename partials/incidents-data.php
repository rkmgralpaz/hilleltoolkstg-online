<?php

include 'data-interactive-data-processor.php';

$incidents_data = get_years_data();
$subtype_data = function_exists('hillel_get_subtype_list') ? hillel_get_subtype_list() : [
    ['name' => 'all',                 'title' => 'All'],
    ['name' => 'social_media_email',  'title' => 'Social Media/Email'],
    ['name' => 'article_publication', 'title' => 'Article/Publication'],
    ['name' => 'hate_speech',         'title' => 'Hate Speech'],
    ['name' => 'vandalism_graffiti',  'title' => 'Vandalism/Graffiti'],
    ['name' => 'physical_harassment', 'title' => 'Harassment'],
    ['name' => 'assault',             'title' => 'Assault'],
    ['name' => 'others',              'title' => 'Other'],
];
foreach ($subtype_data as &$subtype_item) { // ← Usamos referencia
    $field = get_field($subtype_item['name'] . '_graph', 'data_interactive');
    $subtype_item['subtitle'] = $field['subtitle'] ?? '';
    $subtype_item['text'] = $field['text'] ?? '';
    $subtype_item['points'] = [];
}
unset($subtype_item); // ← buena práctica al usar referencias

echo get_incident_colors_css_vars();
