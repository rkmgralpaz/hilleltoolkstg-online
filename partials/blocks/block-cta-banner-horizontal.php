<div
	class="js-module block-bannerh
	<?php echo explode(';', $block['background_color'])[0]; ?>
	block-bannerh-container <?php echo !empty($block['in_a_box']) && $block['in_a_box'] === true ? 'block-bannerh-container-in-a-box' : 'block-bannerh-container-no-box'; ?>
	">

	<div class="block-bannerh__container 
	theme 
	<?php echo explode(';', $block['color_palette'])[0]; ?> 
	<?php echo $block['color_mode']; ?> 
	<?php if (

		(explode(';', $block['color_palette'])[0] === 'theme--neutral' && $block['color_mode'] === 'theme--mode-light')

		&& $block['background'] === false
	) {
		echo 'theme--surface-secondary';
	}  ?>"
		data-animate="fade-in-up" data-animate-mode="inside-module">

		<div class="block-bannerh__inner-container">
			<div class="block-bannerh__left <?php if ($block['image_position']) {
												echo 'block-bannerh__left--to-right';
											} ?>" data-animate="fade-in-up" data-animate-mode="inside-module">

				<div>
					<?php if (!empty($block['tagline'])): ?>
						<?php
						echo get_dynamic_heading(
							$block['tagline'],
							$block['heading_tag_tagline'],
							'block-bannerh__tag font-label-lg font-uppercase theme__text--secondary',
						);
						?>
					<?php endif; ?>

					<?php if (!empty($block['title'])): ?>
						<?php
						echo get_dynamic_heading(
							$block['title'],
							$block['heading_tag'],
							'block-bannerh__title theme__text--primary ' . $block['title_size'],
						);
						?>
					<?php endif; ?>
				</div>

				<?php if (!empty($block['text'])): ?>
					<div class="block-bannerh__text font-body-md theme__text--secondary">
						<?php echo $block['text']; ?>
					</div>
				<?php endif; ?>

				<div class="block-bannerh__buttons">
					<?php
					if ($block['button_1']) {
						echo get_button(array(
							'html_text' => $block['button_1']['title'],
							'href' => $block['button_1']['url'],
							'target' => $block['button_1']['target'],
							'class' => 'btn--primary btn--large btn--icon-after',
							'icon' => 'chevron-right',
						));
					}
					?>
					<?php
					if ($block['button_2']) {
						echo get_button(array(
							'html_text' => $block['button_2']['title'],
							'href' => $block['button_2']['url'],
							'target' => $block['button_2']['target'],
							'class' => 'btn--secondary btn--large btn--icon-after',
							'icon' => 'chevron-right',
						));
					}
					?>
					<?php
					if ($block['button_3']) {
						echo get_button(array(
							'html_text' => $block['button_3']['title'],
							'href' => $block['button_3']['url'],
							'target' => $block['button_3']['target'],
							'class' => 'btn--secondary btn--large btn--icon-after',
							'icon' => 'chevron-right',
						));
					}
					?>
				</div>

			</div>

			<div class="block-bannerh__right" data-animate="fade-in-up" data-animate-mode="inside-module">

				<?php if (!empty($block['image'])): ?>
					<div class=" block-bannerh__img" data-src="<?php echo esc_url($block['image']); ?>">
						<div></div>
					</div>
				<?php endif; ?>

			</div>
		</div>

	</div>

</div>