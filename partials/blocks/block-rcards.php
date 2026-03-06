<div id="block-<?php echo $block_index; ?>" class="js-module block-rcards <?php echo explode(';', $block['background_color'])[0]; ?>">

	<div class="block-rcards-scroll-arrows max-width theme theme--neutral theme--mode-light <?php echo explode(';', $block['background_color'])[0]; ?>">

		<?php
		echo get_button(array(
			'class' => 'block-rcards-scroll-prev btn--primary btn--small btn--icon-after btn--icon-only',
			'icon' => 'chevron-left',
		));
		echo get_button(array(
			'class' => 'block-rcards-scroll-next btn--primary btn--small btn--icon-after btn--icon-only',
			'icon' => 'chevron-right',
		));
		?>
	</div>

	<div class="block-rcards-inner max-width <?php echo $block['show_as']; ?> <?php echo $block['card_options']; ?>" data-theme="<?php echo explode(';', $block['color_palette'])[0]; ?>">

		<div class="rcards <?php if (count($block['cards']) < 4) {
								echo 'rcards-few';
							}; ?>">

			<?php
			$counter = 1;

			foreach ($block['cards'] as $card): ?>
				<?php
				$class = '';

				if (empty($card['tagline']) && (empty($block['card_options']) || $card['icon'] === 'none')) {
					$class = 'rcards__box--only-title';
				} elseif (empty($card['tagline'])) {
					$class = 'rcards__box--only-icons';
				} elseif (empty($block['card_options']) || $card['icon'] === 'none') {
					$class = 'rcards__box--only-tagline';
				}
				?>
				<div class="rcards__box <?php echo $class; ?>" data-animate="fade-in-up" data-animate-mode="inside-module">

					<div class="rcards__box-top">
						<?php if (!empty($card['tagline']) || (!empty($block['card_options']) && !empty($card['icon']))): ?>
							<div>
								<?php if (!empty($card['tagline'])): ?>
									<?php
									echo get_dynamic_heading(
										$card['tagline'],
										$card['heading_tag_tagline'],
										'rcards__box-tagline font-label-lg theme__text--primary font-uppercase',
									);
									?>
								<?php endif; ?>

								<?php if ((!empty($block['card_options']) && !empty($card['icon']))  && $block['card_options'] === 'block-rcards--wicons') { ?>

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

								<?php } elseif (!empty($block['card_options']) && $block['card_options'] === 'block-rcards--wnumbers') { ?>
									<div class="rcards__box-icon font-label-lg">
										<?php echo $counter; ?>
									</div>
									<?php $counter++; ?>
								<?php } ?>

							</div>
						<?php endif; ?>


						<?php if (!empty($card['title'])): ?>
							<?php
							echo get_dynamic_heading(
								$card['title'],
								$card['heading_tag'],
								'rcards__box-title font-display-sm theme__text--primary',
							);
							?>
						<?php endif; ?>
					</div>

					<div class="rcards__box-bottom">
						<?php if (!empty($card['description'])): ?>
							<div class="rcards__box-text font-body-md theme__text--secondary">
								<?php echo $card['description']; ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($card['cta_link'])): ?>
							<div class="rcards__box-link">
								<?php
								echo get_button(array(
									'html_text' => $card['cta_link']['title'],
									'href' =>  $card['cta_link']['url'],
									'target' => $card['cta_link']['target'],
									'class' => 'btn--primary btn--large btn--icon-after',
									'icon' => 'chevron-right',
								));
								?>
							</div>
						<?php endif; ?>
					</div>

				</div>
			<?php endforeach; ?>

		</div>


	</div>

</div>