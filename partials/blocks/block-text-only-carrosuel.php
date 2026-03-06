<div id="block-<?php echo $block_index; ?>" class="js-module block-text-only-carrousel <?php echo explode(';', $block['background_color'])[0]; ?>">

	<div class="block-text-only-carrousel__inner max-width theme <?php echo explode(';', $block['color_palette'])[0]; ?>" data-animate="fade-in-up" data-animate-mode="inside-module" data-animate-delay="100">

		<?php if ($block['title']) { ?>

			<?php
			echo get_dynamic_heading(
				$block['title'],
				$block['heading_tag'],
				'block-text-only-carrousel__title font-body-md theme__text--primary',
			);
			?>

		<?php } ?>

		<div class="carrousel-only-text">

			<?php
			echo get_button(array(
				'class' => 'carrousel-only-text__btn carrousel-only-text__btn-prev btn--primary btn--large btn--icon-only',
				'icon' => 'chevron-left',
				'aria-label' => 'Previous'
			));
			?>

			<div class="carrousel-only-text__slides">

				<?php foreach ($block['slides'] as $i => $item) {

					$text_size = $item['title_size'];

				?>

					<div class="carrousel-only-text__slide">

						<!-- <div> -->
						<div class="carrousel-only-text__slide-pagination font-label-lg theme__text--primary">
							<?php echo $i + 1; ?>/<?php echo sizeof($block['slides']) ?>
						</div>
						<div class="carrousel-only-text__slide-description <?php echo $text_size; ?> theme__text--primary">
							<?php echo $item['description']; ?>
						</div>
						<!-- </div> -->

						<div class="carrousel-only-text__slide-bottom">
							<div class="font-body-md theme__text--primary">
								<?php echo $item['cta_text']; ?>
							</div>
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

				<?php } ?>

			</div>

			<?php
			echo get_button(array(
				'class' => 'carrousel-only-text__btn carrousel-only-text__btn-next btn--primary btn--large btn--icon-only',
				'icon' => 'chevron-right',
				'aria-label' => 'Next'
			));
			?>

		</div>

	</div>

</div>