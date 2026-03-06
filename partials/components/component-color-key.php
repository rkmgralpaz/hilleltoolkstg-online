<?php
$defaults = [
    'labels' => [],
    'clickable' => false,
    'group_orientation' => 'horizontal', // o 'vertical'
];
$args = array_merge($defaults, $args);
extract($args);

$group_class = $group_orientation === 'vertical' ? 'color-key--vertical' : 'color-key--horizontal';
$click_class = $clickable ? 'color-key--clickable js-color-key' : 'color-key--not-clickable';
$tag = $clickable ? 'button' : 'span';
?>
<div class="color-key <?= $group_class ?> <?= $click_class ?> theme--neutral theme--mode-light">
    <<?= $tag ?> class="color-key__item color-key__item-all" data-color="<?php echo '#332933'; ?>">
        <span class="color-key__item-dot" style="background-color: <?php echo '#332933'; ?>;"></span>
        <span class="color-key__item-text font-body-sm theme__text--primary">All</span>
    </<?= $tag ?>>
    <?php foreach ($labels as $item):
        $label = $item['label'];
        $color = $item['color'];

    ?>
        <<?= $tag ?> class="color-key__item" data-color="<?= $color ?>">
            <span class="color-key__item-dot" style="background-color: <?php echo $color ?>;"></span>
            <span class="color-key__item-text font-body-sm theme__text--primary"><?php echo $label ?></span>
        </<?= $tag ?>>
    <?php endforeach; ?>

</div>

<script>
    document.querySelectorAll('.color-key--clickable').forEach(colorKey => {
        const items = colorKey.querySelectorAll('.color-key__item');

        items.forEach(item => {
            const color = item.dataset.color;
            item.style.setProperty('--color-key-hover', color);
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                // Quitar la clase activa de todos los ítems
                items.forEach(i => i.classList.remove('is-active'));
                // Agregarla al ítem clickeado
                item.classList.add('is-active');
            });
        });
    });
</script>
<style>
    .color-key--clickable .color-key__item-all.is-active,
    .color-key--clickable .color-key__item-all:hover {
        color: var(--neutral-000);

        &.is-active .color-key__item-dot,
        &:hover .color-key__item-dot {
            background: transparent;
            border: 1px solid var(--neutral-000);
        }

        .color-key__item-text {
            color: var(--neutral-000);
        }
    }


    .color-key--clickable .color-key__item.is-active,
    .color-key--clickable .color-key__item:hover {
        background-color: var(--color-key-hover);
        border: 1px solid var(--color-key-hover);
        color: var(--theme-primary);
    }

    .color-key--clickable .color-key__item.is-active .color-key__item-dot,
    .color-key--clickable .color-key__item:hover .color-key__item-dot {
        background: transparent;
        border: 1px solid var(--neutral-900);
    }


    .color-key--clickable .color-key__item,
    .color-key--clickable .color-key__item .color-key__item-dot {
        transition: 0.3s ease;
    }
</style>