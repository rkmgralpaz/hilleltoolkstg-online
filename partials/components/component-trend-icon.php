<?php
$defaults = [
    'type' => 'increase',
    'size' => 'small',
];
$args = array_merge($defaults, $args);
extract($args);

$type_class = 'component-trend-icon--' . $type;     // component-trend-icon--increase / component-trend-icon--decrease
$size_class = 'component-trend-icon--' . $size;     // component-trend-icon--small / component-trend-icon--large
$icon = null;
ob_start();
if ($type === 'equal') {
    get_template_part('icons/arrow-trend-equal');
} else {
    get_template_part('icons/arrow-trend', $type === 'increase' ? 'up' : 'down');
}
$icon = ob_get_clean();

$color = null;
if ($type === 'increase') {
    $color = '#FF1C20';
} elseif ($type === 'decrease') {
    $color = '#1C6C25';
} elseif ($type === 'equal') {
    $color = '#729AFD';
}
$bg = null;
if ($type === 'increase') {
    $bg = '#FCDCDC';
} elseif ($type === 'decrease') {
    $bg = '#DAEFD4';
} elseif ($type === 'equal') {
    $bg = '#D2DDF8';
}
?>

<div class="component-trend-icon <?= $type_class ?> <?= $size_class ?>" style="--trend-color: <?= $color ?>; --trend-bg: <?= $bg ?>;">
    <span class="component-trend-icon__circle">
        <span class="component-trend-icon__arrow"><?= $icon ?></span>
    </span>
</div>