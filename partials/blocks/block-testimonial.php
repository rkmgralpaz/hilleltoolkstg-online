<div id="block-<?php echo $block_index; ?>" class="theme <?php echo explode(';',$block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>">

	<div class="js-module block-testimonial max-width">

		<div class="testimonial-slider" data-animate="fade-in-up" data-animate-mode="inside-module" data-animate-delay="100">

		<?php
		echo get_button(array(
			'class' => 'testimonial-slider__btn testimonial-slider__btn-prev btn--primary btn--large btn--icon-only',
			'icon' => 'chevron-left',
			'aria-label' => 'Previous'
		));
		?>		

		<div class="testimonial-slider__slides">
		
		<?php foreach ($block['testimonials'] as $i => $item) { ?>

			<div class="testimonial-slider__slide">

				<div>
					<div class="testimonial-slider__slide-body font-display-sm theme__text--primary">
						<?php echo $item['testimonial']; ?>
					</div>
					<div class="testimonial-slider__slider-bio">						
						<div class="font-body-md-bold theme__text--primary"><?php echo $item['name']; ?></div>	
						<div class="font-body-md theme__text--primary">				
							<span><?php echo $item['bio']; ?></span>						
						</div>
					</div>
				</div>

				<div class="testimonial-slider__slider-bottom font-label-xl theme__text--body">
					<?php echo $i+1; ?>/<?php echo sizeof($block['testimonials']) ?>
				</div>
				
			</div>
	 
		<?php } ?>

		</div>

		<?php
		echo get_button(array(
			'class' => 'testimonial-slider__btn testimonial-slider__btn-next btn--primary btn--large btn--icon-only',
			'icon' => 'chevron-right',
			'aria-label' => 'Next'
		));
		?>		

		</div>

	</div>

</div>
           