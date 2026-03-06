<?php
$defaults = [
    'label' => '',
];
$args = array_merge($defaults, $args);
extract($args);

?>
<?php
$tag = 'span';
?>
<<?= $tag ?> class="color-key__item theme--neutral theme--mode-light">
    <span class="color-key__item-dot" style="background-color: <?php echo $color ?>;"></span>
    <span class="color-key__item-text font-body-xs theme__text--primary"><?php echo $label ?></span>
</<?= $tag ?>>