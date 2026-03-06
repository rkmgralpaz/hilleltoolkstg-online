<?php
$defaults = [
    'type' => 'increase', // or 'decrease'
    'layout' => 'single-line', // or 'double-line'
    'percent' => '',
    'text' => '',
    'size' => 'small',
];
$args = array_merge($defaults, $args);
extract($args);

if ($type === 'increase') {
    $color = '#FF1C20';
} elseif ($type === 'decrease') {
    $color = '#1C6C25';
} elseif ($type === 'equal') {
    $color = '#4B7EFD';
}

$trend_icon_args = [
    'type' => $type,
    'size' => 'small',
];

$wrapper_class = 'component-trend-data component-trend-data--' . $type . ' component-trend-data--' . $layout . ' component-trend-data--' . $size;
?>

<div class="<?php echo $wrapper_class; ?>">
    <div class="component-trend-data__content">
        <div class="component-trend-data__icon">
            <?php get_template_part('partials/components/component', 'trend-icon', $trend_icon_args); ?>
        </div>
        <span class="component-trend-data__percent" style="color: <?php echo $color; ?>"><?php echo $percent; ?></span>
    </div>
    <span class="component-trend-data__description  theme__text--secondary"><?php echo $text; ?></span>

</div>