<?php

$defaults = [
    'tooltip' => 'Film',
    'slug' => 'film',
];
$args = array_merge($defaults, $args);
extract($args);

$selected_format = $_GET['format'] ?? null;
$active_class = ($selected_format === $args['slug']) ? 'component-format--active' : '';

$href = ($selected_format === $args['slug'])
    ? build_url(['format' => null], [], 'format')
    : build_url(['format' => $args['slug']], [], 'format');
?>

<a href="<?= $href; ?>" class="component-format <?= $active_class; ?>">

    <?php include get_template_directory() . '/icons-resource-formats/' . $slug . '.php'; ?>

    <div class="component-format__tooltip font-label-md font-uppercase"><?php echo $tooltip; ?></div>

</a>