<?php

/**
 * Template Name: Landing
 *
 * Description: Landing
 */

get_header(); ?>

<?php while (have_posts()) : the_post();  ?>

	<div class="js-module block-landing theme <?php echo explode(';', get_field('color_palette'))[0]; ?> theme--mode-light">

		<div class="block-landing__intro max-width">

			<div>

				<div>

					<?php
					echo get_dynamic_heading(
						get_field('title'),
						get_field('heading_tag'),
						'theme__text--primary ' . get_field('title_size'),
						['data-animate' => 'fade-in-up',]
					);
					?>


					<div class="block-landing__image block-landing__image--mobile" data-animate="fade-in-up">

						<div class="block-landing__image-bg" data-src="<?php echo get_field('image'); ?>"></div>
						<svg xmlns="http://www.w3.org/2000/svg" width="657" height="486" viewBox="0 0 657 486" fill="none">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M657 0H0V486H657V0ZM3.6 46.8V316.541C3.6 327.551 7.80365 338.145 15.3522 346.16L126.614 464.292C137.498 475.848 152.669 482.4 168.544 482.4H610.2C634.059 482.4 653.4 463.059 653.4 439.2V180.042C653.4 165.621 647.99 151.724 638.241 141.099L524.913 17.5928C516.731 8.67602 505.184 3.6 493.083 3.6H46.8C22.9413 3.6 3.6 22.9413 3.6 46.8Z" fill="white" />
						</svg>

					</div>


					<div class="block-landing__text theme__text--secondary font-body-sm" data-animate="fade-in-up" data-animate-delay="100">
						<?php echo get_field('text') ?>
					</div>

					<?php if (get_field('button_1') || get_field('button_2') || get_field('button_3')) { ?>
						<div class="block-landing__buttons" data-animate="fade-in-up" data-animate-delay="400">

							<div>

								<?php
								if (get_field('button_1')) {
									echo get_button(array(
										'html_text' =>  get_field('button_1')['title'],
										'href' =>  get_field('button_1')['url'],
										'target' =>  get_field('button_1')['target'],
										'class' => 'btn--primary btn--large btn--icon-after',
										'icon' => 'chevron-right',
									));
								}
								?>

							</div>

							<div data-animate="fade-in-up" data-animate-delay="600">

								<?php
								if (get_field('button_2')) {
									echo get_button(array(
										'html_text' =>  get_field('button_2')['title'],
										'href' =>  get_field('button_2')['url'],
										'target' =>  get_field('button_2')['target'],
										'class' => 'btn--secondary btn--large btn--icon-after',
										'icon' => 'chevron-right',
									));
								}
								?>

							</div>

							<div data-animate="fade-in-up" data-animate-delay="800">
								<?php
								if (get_field('button_3')) {
									echo get_button(array(
										'html_text' =>  get_field('button_3')['title'],
										'href' =>  get_field('button_3')['url'],
										'target' =>  get_field('button_3')['target'],
										'class' => 'btn--secondary btn--large btn--icon-after',
										'icon' => 'chevron-right',
									));
								}
								?>
							</div>

						</div>
					<?php } ?>

				</div>

				<div class="block-landing__image block-landing__image--desktop" data-animate="fade-in-up">
					<div class="block-landing__image-bg" data-src="<?php echo get_field('image'); ?>"></div>
					<svg xmlns="http://www.w3.org/2000/svg" width="657" height="486" viewBox="0 0 657 486" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M657 0H0V486H657V0ZM3.6 46.8V316.541C3.6 327.551 7.80365 338.145 15.3522 346.16L126.614 464.292C137.498 475.848 152.669 482.4 168.544 482.4H610.2C634.059 482.4 653.4 463.059 653.4 439.2V180.042C653.4 165.621 647.99 151.724 638.241 141.099L524.913 17.5928C516.731 8.67602 505.184 3.6 493.083 3.6H46.8C22.9413 3.6 3.6 22.9413 3.6 46.8Z" fill="white" />
					</svg>
				</div>

			</div>

		</div>

		<?php include 'partials/global-modules.php'; ?>

	</div>


<?php endwhile; ?>


<?php get_footer(); ?>