<div
	id="block-<?php echo $block_index; ?>"
	class="theme 
	<?php echo explode(';', $block['module_configuration']['color_palette'])[0]; ?> 
	<?php echo $block['module_configuration']['color_mode']; ?> 
	<?php if (explode(';', $block['module_configuration']['color_palette'])[0] === 'theme--neutral' && $block['module_configuration']['color_mode'] === 'theme--mode-light' && $block['module_configuration']['background'] === false) {
		echo 'theme--surface-secondary';
	}  ?>">

	<div class="js-module block-text-wphoto">

		<div class="block-text-wphoto__left" data-animate="fade-in-up" data-animate-mode="inside-module">

			<?php if (!empty($block['title'])): ?>

				<?php
				echo get_dynamic_heading(
					$block['title'],
					$block['heading_tag'],
					'block-text-wphoto__title font-heading-md theme__text--primary',
				);
				?>

			<?php endif; ?>

			<?php if (!empty($block['text'])): ?>
				<div class="block-text-wphoto__text font-body-md theme__text--primary">
					<?php echo $block['text']; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($block['source'])): ?>
				<div class="block-text-wphoto__source font-body-sm theme__text--secondary">
					<?php echo $block['source']; ?>
				</div>
			<?php endif; ?>

		</div>

		<div class="block-text-wphoto__right" data-animate="fade-in-up" data-animate-mode="inside-module">

			<?php if (!empty($block['image'])): ?>
				<div class="block-text-wphoto__img" data-src="<?php echo esc_url($block['image']); ?>">
					<div></div>
				</div>
			<?php endif; ?>

			<?php if (!empty($block['caption'])): ?>
				<div class="block-text-wphoto__img-caption font-body-sm theme__text--secondary">
					<?php echo $block['caption']; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>