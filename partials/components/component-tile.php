<?php
$defaults = [
  'custom_class' => '',
  'title' => '',
  'heading_tag' => 'none',
  'blurb' => '',
  'link' => '',
  'img' => '',
];
$args = array_merge($defaults, $args);
extract($args);
?>

<a href="<?= esc_url($link); ?>" class="component-tile <?= esc_attr($custom_class); ?>" data-animate="fade-up">

  <div class="component-tile__wrap">
    <div class="component-tile__top">
      <h2 class="component-tile__title font-heading-lg theme__text--primary"><?= $title; ?></h2>

      <div class="component-tile__button">
        <?php
        echo get_button(array(
          'tag' => 'div',
          'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
          'icon' => 'chevron-right',
        ));
        ?>
      </div>
    </div>

    <?php if ($img): ?>
      <div class="component-tile__img">
        <?php if (filter_var($img, FILTER_VALIDATE_URL)): ?>
          <img src="<?= esc_url($img); ?>" alt="">
        <?php else: ?>
          <?= wp_get_attachment_image($img, 'full'); ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>


  <div class="component-tile__blurb font-body-md theme__text--primary"><?= $blurb; ?></div>
</a>