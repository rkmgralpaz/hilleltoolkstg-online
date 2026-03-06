<?php 

/**
 * Template Name: Outcome Quiz
 *
 * Description: Outcome Quiz
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post();  ?>

	<div class="block-outcome-quiz theme theme--blue theme--mode-neutral">

	<?php
	$cards = get_field('cards');

	$container_class = '';
	$parent_class = 'block-outcome-quiz--wcards';

	if ($cards) {
		$cards_count = count($cards);
		if ($cards_count == 2) {
			$container_class = 'block-outcome-quiz--cards-two';
		} elseif ($cards_count == 3) {
			$container_class = 'block-outcome-quiz--cards-three';
		} else {
			$container_class = 'block-outcome-quiz--cards-four';
		}
	} else {
		$parent_class = 'block-outcome-quiz--no-cards';
	}
	?>

		<div class="block-outcome-quiz__inner max-width <?php echo $parent_class; ?>" data-animate="fade-in-special">

			<div class="block-outcome-quiz__top">
				<?php if (!empty(get_field('title'))): ?>
					<div class="block-outcome-quiz__main-title font-display-md theme__text--body">
						<?php echo get_field('title'); ?>
					</div>
				<?php endif; ?>
		
				<?php if (!empty(get_field('blurb'))): ?>
					<div class="block-outcome-quiz__main-blurb font-body-md theme__text--secondary">
						<?php echo get_field('blurb'); ?>
					</div>
				<?php endif; ?>

				<?php if (get_field('button_1') || get_field('button_2') || get_field('button_3')) { ?>
				<div class="block-outcome-quiz__buttons">
					<?php if (!empty(get_field('button_1'))): ?>
					<div>
						<?php 
							if (get_field('button_1')) {					
								echo get_button(array(
									'html_text' => get_field('button_1')['title'],
									'href' => get_field('button_1')['url'],
									'target' => get_field('button_1')['target'],
									'class' => 'btn--primary btn--large btn--icon-after',
									'icon' => 'chevron-right',
								));					
							}
						?>
					</div>
					<?php endif; ?>
					<div>
						<?php 
							if (get_field('button_2')) {					
								echo get_button(array(
									'html_text' => get_field('button_2')['title'],
									'href' => get_field('button_2')['url'],
									'target' => get_field('button_2')['target'],
									'class' => 'btn--secondary btn--large btn--icon-after',
									'icon' => 'chevron-right',
								));					
							}
						?>
					</div>
					<div>
						<?php 
							if (get_field('button_3')) {					
								echo get_button(array(
									'html_text' => get_field('button_3')['title'],
									'href' => get_field('button_3')['url'],
									'target' => get_field('button_3')['target'],
									'class' => 'btn--secondary btn--large btn--icon-after',
									'icon' => 'chevron-right',
								));					
							}
						?>
					</div>
				</div>
			<?php } ?>
			</div>

			<?php if ($cards) : ?>
				<div class="block-outcome-quiz__cards <?php echo $container_class; ?>" data-animate="fade-in-up">
					<?php foreach ($cards as $card) : ?>
						<div class="block-outcome-quiz__card">
							<div class="block-outcome-quiz__card-title-logo"> 
								<div class="font-label-lg theme__text--primary font-uppercase"><?php echo $card['tagline']; ?></div>

								<?php if ( !empty($card['icon']) ) { ?> 

									<div class="block-outcome-quiz__card-icon">
	
									<?php
										$icon_path = get_template_directory() . '/icons-module-cards/' . $card['icon'] . '.svg';
	
										if (file_exists($icon_path)) {
											$svg_content = file_get_contents($icon_path);
											if ($svg_content !== false) {
												echo '<div class="rcards__box-icon">';
												echo $svg_content;
												echo '</div>';
											} else {
												echo '<div class="rcards__box-icon"></div>';
											}
										} else {
											echo '<div class="rcards__box-icon">Icono no encontrado.</div>';
										}
									?>
		
									</div>

								<?php } ?>

							</div>
							<div>
								<div class="font-body-md theme__text--secondary"><?php echo $card['text']; ?></div>										
								<?php
								if (!empty($card['link'])) {
									echo get_button(array(
										'html_text' => $card['link']['title'],
										'href' =>  $card['link']['url'],
										'target' => $card['link']['target'],
										'class' => 'btn--tertiary btn--large btn--icon-after',
										'icon' => 'chevron-right',
									));
								}
								?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if (!empty(get_field('note'))): ?>
				<div class="block-outcome-quiz__bottom font-body-md theme__text--secondary">
					<?php echo get_field('note'); ?>
				</div>
			<?php endif; ?>

		</div>

		<?php include 'partials/global-modules.php'; ?>

	</div>


<?php endwhile; ?>


<?php get_footer(); ?>