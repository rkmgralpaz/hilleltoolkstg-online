<div class="theme <?php echo explode(';', $block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>

<?php



if ((explode(';', $block['module_color_settings']['color_palette'])[0] === 'theme--neutral' && $block['module_color_settings']['color_mode'] === 'theme--mode-light')

	&& explode(';', $block['module_color_settings']['background_color'])[0] === 'bg-neutral-200'
) {
	echo 'theme--surface-secondary';
}  ?>">

	<div class="js-module block-image-carousel max-width" data-carousel='<?php echo json_encode($block['slides']); ?>'>

		<div class="block-bannerv__left" data-animate="fade-in-up" data-animate-mode="inside-module">
			<div>
				<?php if (!empty($block['tagline'])): ?>
					<?php
					echo get_dynamic_heading(
						$block['tagline'],
						$block['heading_tag_tagline'],
						'block-bannerv__tag font-label-lg font-uppercase theme__text--secondary',
					);
					?>
				<?php endif; ?>

				<?php if (!empty($block['title'])): ?>
					<?php
					echo get_dynamic_heading(
						$block['title'],
						$block['heading_tag'],
						'block-bannerv__title theme__text--primary ' . $block['module_color_settings']['title_size'],
					);
					?>
				<?php endif; ?>
			</div>

			<?php if (!empty($block['text'])): ?>
				<div class="block-bannerv__text font-body-md theme__text--secondary">
					<?php echo $block['text']; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="carousel" data-animate="fade-in-up" data-animate-mode="inside-module">

			<?php
			echo get_button(array(
				'class' => 'carousel__btn carousel__btn-prev btn--primary btn--large  btn--icon-only',
				'icon' => 'chevron-left',
				'aria-label' => 'Previous'
			));
			?>

			<?php
			echo get_button(array(
				'class' => 'carousel__btn carousel__btn-next btn--primary btn--large  btn--icon-only',
				'icon' => 'chevron-right',
				'aria-label' => 'Next'
			));
			?>

			<div class="carousel__main-wrapper">

				<div class="carousel__image-wrapper carousel__image-wrapper-1">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper carousel__image-wrapper-2">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper carousel__image-wrapper-3">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper carousel__image-wrapper-4">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper carousel__image-wrapper-5">
					<div class="carousel__image-holder">

					</div>
				</div>


				<div class="carousel__image-wrapper-aux carousel__image-wrapper-1-aux">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper-aux carousel__image-wrapper-2-aux">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper-aux carousel__image-wrapper-3-aux">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper-aux carousel__image-wrapper-4-aux">
					<div class="carousel__image-holder">

					</div>
				</div>

				<div class="carousel__image-wrapper-aux carousel__image-wrapper-5-aux">
					<div class="carousel__image-holder">

					</div>
				</div>

			</div>

		</div>

		<div class="carousel__responsive">

			<div class="carousel__responsive-slides">

				<?php foreach ($block['slides'] as $slide) { ?>

					<div class="carousel__responsive-slide carousel__responsive-slide--fade">
						<img src="<?php echo $slide['image'] ?>" alt="Image 1">
						<div class="carousel__responsive-slide-caption font-body-sm theme__text--secondary">
							<?php echo $slide['description'] ?>
						</div>
					</div>

				<?php } ?>

			</div>

			<div class="navigation"></div>

		</div>


	</div>

</div>