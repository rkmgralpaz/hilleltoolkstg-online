<div id="block-<?php echo $block_index; ?>" class="theme <?php echo explode(';', $block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>">

	<div class="js-module block-video max-width">

		<?php if (!empty($block['title']) || !empty($block['text'])): ?>

		<div class="block-video__top">

			<?php
			if (!empty($block['title'])) {
				echo get_dynamic_heading(
					$block['title'],
					!empty($block['heading_tag']) && $block['heading_tag'] !== 'none' ? $block['heading_tag'] : null,
					'block-video__title font-heading-md theme__text--primary',
					[
						'data-animate' => 'fade-in-up',
						'data-animate-mode' => 'inside-module',
					]
				);
				
			}
			?>


			<?php if (!empty($block['text'])): ?>
				<div class="block-video__text font-body-md theme__text--primary" data-animate="fade-in-up" data-animate-delay="100" data-animate-mode="inside-module">
					<?php echo $block['text']; ?>
				</div>
			<?php endif; ?>

		</div>

		<?php endif; ?>

		<?php
		$video_url = $block['url'];
		$cover_image = '';
		if (!empty($block['cover_image'])) {
			$cover_image = $block['cover_image'];
		}
		?>

		<div class="video" data-animate="fade-in-up" data-animate-delay="200" data-animate-mode="inside-module">

			<div class="video__cover">
				<div class="video__cover-image"
					<?php if (!empty($cover_image)) : ?>
					data-src="<?php echo esc_url($cover_image); ?>"
					<?php endif; ?>>
				</div>
				<?php
				echo get_button(array(
					'class' => 'video__play-icon btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'play',
					'aria-label' => 'Play'
				));
				?>
			</div>

			<iframe src="<?php echo esc_url($video_url); ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="video__iframe" style="display: none;"></iframe>

		</div>

	</div>

</div>