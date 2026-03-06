<div id="block-<?php echo $block_index; ?>" class="js-module block-slideshow-wimages  <?php echo explode(';', $block['module_color_settings']['background_color'])[0]; ?>">

	<div class="block-slideshow-wimages__inner max-width theme <?php echo explode(';', $block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>" data-animate="fade-in-up" data-animate-mode="inside-module" data-animate-delay="100">


		<?php
		if (!empty($block['title'])) {
			echo get_dynamic_heading(
				$block['title'],
				$block['heading_tag'],
				'block-slideshow-wimages__title theme__text--primary'
			);
		}
		?>

		<div class="slideshow-wimages">

			<?php
			echo get_button(array(
				'class' => 'slideshow-wimages__btn slideshow-wimages__btn-prev btn--primary btn--large btn--icon-only',
				'icon' => 'chevron-left',
				'aria-label' => 'Previous'
			));
			?>

			<div class="slideshow-wimages__slides">

				<?php foreach ($block['slides'] as $i => $item) { ?>

					<div class="slideshow-wimages__slide">

						<div>

							<div>
								<div class="slideshow-wimages__pagination font-label-lg theme__text--primary">
									<?php echo $i + 1; ?>/<?php echo sizeof($block['slides']) ?>
								</div>
								<?php if (!empty($item['title'])): ?>
									<?php
									echo get_dynamic_heading(
										$item['title'],
										$item['heading_tag'],
										'slideshow-wimages__slide-title font-display-sm theme__text--primary',
									);
									?>

								<?php endif; ?>

								<?php if (!empty($item['description'])): ?>
									<div class="slideshow-wimages__slide-description font-body-md theme__text--secondary">
										<?php echo $item['description']; ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="slideshow-wimages__slide-wrap-img">
								<div class="slideshow-wimages__slide-img" data-src="<?php echo $item['image']; ?>">
									<div></div>
								</div>
								<?php if (!empty($item['image_credits'])): ?>
									<div class="slideshow-wimages__slide-img-credits font-body-sm theme__text--secondary">
										<?php echo $item['image_credits']; ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="slideshow-wimages__slide-left-bottom">
								<?php if (!empty($item['cta_text'])): ?>
									<div class="font-body-md theme__text--primary">
										<?php echo $item['cta_text']; ?>
									</div>
								<?php endif; ?>

								<?php
								if ($item['cta_link']) {
									echo get_button(array(
										'html_text' => $item['cta_link']['title'],
										'href' => $item['cta_link']['url'],
										'target' => $item['cta_link']['target'],
										'class' => 'btn--primary btn--large btn--icon-after',
										'icon' => 'chevron-right',
									));
								}
								?>
							</div>

						</div>

						<div class="slideshow-images__slide-right">

							<div>
								<div class="slideshow-wimages__slide-img" data-src="<?php echo $item['image']; ?>">
									<div></div>
								</div>

								<?php if (!empty($item['image_credits'])): ?>
									<div class="slideshow-wimages__slide-img-credits font-body-sm theme__text--secondary">
										<?php echo $item['image_credits']; ?>
									</div>
								<?php endif; ?>
							</div>

						</div>

					</div>

				<?php } ?>

			</div>

			<?php
			echo get_button(array(
				'class' => 'slideshow-wimages__btn slideshow-wimages__btn-next btn--primary btn--large btn--icon-only',
				'icon' => 'chevron-right',
				'aria-label' => 'Previous'
			));
			?>

		</div>

	</div>

</div>