<?php
if (isset($block_external_content)):
	$block = $block_external_content;
	$button_1_params = $block_external_content['button_1'];
	$button_2_params = $block_external_content['button_2'];
	$button_3_params = $block_external_content['button_3'];
else:
	if (!isset($block['button_1'])):
		$block['button_1'] = 0;
	endif;
	if (!isset($block['button_2'])):
		$block['button_2'] = 0;
	endif;
	if (!isset($block['button_3'])):
		$block['button_3'] = 0;
	endif;
	$button_1_params = $block['button_1'] ? array(
		'html_text' => $block['button_1']['title'],
		'href' => $block['button_1']['url'],
		'target' => $block['button_1']['target'],
		'class' => 'btn--primary btn--large btn--icon-after',
		'icon' => 'chevron-right',
	) : 0;
	$button_2_params = $block['button_2'] ? array(
		'html_text' => $block['button_2']['title'],
		'href' => $block['button_2']['url'],
		'target' => $block['button_2']['target'],
		'class' => 'btn--secondary btn--large btn--icon-after',
		'icon' => 'chevron-right',
	) : 0;
	$button_3_params = $block['button_3'] ? array(
		'html_text' => $block['button_3']['title'],
		'href' => $block['button_3']['url'],
		'target' => $block['button_3']['target'],
		'class' => 'btn--secondary btn--large btn--icon-after',
		'icon' => 'chevron-right',
	) : 0;
endif;

$title_tag = (!empty($block['heading_tag']) && $block['heading_tag'] !== 'none') ? str_replace('header-', '', $block['heading_tag']) : 'div';
$title_tag_close = "</{$title_tag}>";
$data_animate = isset($block_remove_transitions) && $block_remove_transitions ? '' : 'fade-in-up';

?>

<div id="block-<?php echo $block_index; ?>" class="theme 

<?php echo explode(';', $block['module_color_settings']['color_palette'])[0]; ?> 

<?php echo $block['module_color_settings']['color_mode']; ?>

<?php if (explode(';', $block['module_color_settings']['color_palette'])[0] === 'theme--neutral' && $block['module_color_settings']['color_mode'] === 'theme--mode-light' && $block['module_color_settings']['background'] === false) {
	echo 'theme--surface-secondary';
}  ?>
">

	<?php
	$class_wmt = '';
	$class_wmb = '';

	if (isset($block['module_color_settings']['remove_margins']) && !empty($block['module_color_settings']['remove_margins'])) {

		$choices = $block['module_color_settings']['remove_margins'];


		if ($choices) {
			if (in_array('heading--wmt', $choices)) {
				$class_wmt = 'heading--wmt';
			}
			if (in_array('heading--wmb', $choices)) {
				$class_wmb = 'heading--wmb';
			}
		}
	}
	?>

	<div class="block-heading max-width 
		<?php echo $block['module_color_settings']['alignment']; ?>
		<?php echo $class_wmt . ' ' . $class_wmb; ?>

	">

		<div>

			<div class="block-heading__top">

				<div data-animate="<?php echo $data_animate; ?>">
					<?php if ($block['tagline']) { ?>
						<?php
						echo get_dynamic_heading(
							$block['tagline'],
							$block['heading_tag_tagline'],
							'block-heading__tagline theme__text--secondary font-label-md font-uppercase',
							['data-animate' => $data_animate,]
						);
						?>
					<?php } ?>

					<?php if ($block['title'] && isset($link_to_ancestor)) { ?>
						<a class="block-heading__title-link" href="<?php echo $link_to_ancestor; ?>">
							<<?php echo $title_tag; ?> class="block-heading__title theme__text--primary <?php echo $block['module_color_settings']['title']; ?>" data-animate="<?php echo $data_animate; ?>">
								<?php echo $block['title']; ?>
								<?php echo $title_tag_close; ?>
						</a>
					<?php } else if ($block['title']) { ?>

						<?php if (!empty($block['heading_tag']) && $block['heading_tag'] !== 'none') { ?>
							<?php
							echo get_dynamic_heading(
								$block['title'],
								$block['heading_tag'],
								'block-heading__title theme__text--primary ' . $block['module_color_settings']['title'],
								['data-animate' => $data_animate,]
							);
							?>

						<?php  } else { ?>

							<<?php echo $title_tag; ?> class="block-heading__title theme__text--primary <?php echo $block['module_color_settings']['title']; ?>" data-animate="<?php echo $data_animate; ?>">
								<?php echo $block['title']; ?>
								<?php echo $title_tag_close; ?>


							<?php  } ?>


						<?php } ?>

				</div>

				<div class="block-heading__wrap-body">
					<?php if ($block['text']) { ?>
						<div class="block-heading__text theme__text--primary font-body-md" data-animate="<?php echo $data_animate; ?>" data-animate-delay="200">
							<?php echo $block['text']; ?>
						</div>
					<?php } ?>

					<?php if ($block['note']) { ?>
						<div class="block-heading__note theme__text--secondary font-body-sm" data-animate="<?php echo $data_animate; ?>" data-animate-delay="200">
							<?php echo $block['note']; ?>
						</div>
					<?php } ?>
				</div>

			</div>

			<?php if ($block['button_1'] || $block['button_2'] || $block['button_3']) { ?>
				<div class="block-heading__bottom" data-animate="<?php echo $data_animate; ?>" data-animate-delay="300">

					<?php if (!empty($block['button_1'])): ?>
						<div>
							<?php
							if ($block['button_1']) {
								echo get_button($button_1_params);
							}
							?>
						</div>
					<?php endif; ?>

					<?php if (!empty($block['button_2'])): ?>
						<div data-animate="<?php echo $data_animate; ?>" data-animate-delay="400">
							<?php
							if ($block['button_2']) {
								echo get_button($button_2_params);
							}
							?>
						</div>
					<?php endif; ?>

					<?php if (!empty($block['button_3'])): ?>
						<div data-animate="<?php echo $data_animate; ?>" data-animate-delay="500">
							<?php
							if ($block['button_3']) {
								echo get_button($button_3_params);
							}
							?>
						</div>
					<?php endif; ?>

				</div>
			<?php } ?>

		</div>


	</div>

</div>