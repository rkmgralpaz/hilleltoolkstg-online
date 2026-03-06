<div id="block-<?php echo $block_index; ?>" class="theme theme-block-repeater-wicons <?php echo explode(';', $block['module_configuration']['color_palette'])[0]; ?> <?php echo isset($block['module_configuration']['color_mode']) ? $block['module_configuration']['color_mode'] : 'theme--light'; ?>">

	<div class="block-repeater-wicons max-width <?php echo $block['module_configuration']['options']; ?>">

		<div>
			<div>
				<?php if (!empty($block['tagline'])): ?>
					<?php
					echo get_dynamic_heading(
						$block['tagline'],
						$block['heading_tag_tagline'],
						'font-label-lg theme__text--secondary font-uppercase',
						['data-animate' => 'fade-in-up',]
					);
					?>
				<?php endif; ?>

				<?php if (!empty($block['title'])): ?>
					<?php
					echo get_dynamic_heading(
						$block['title'],
						$block['heading_tag'],
						'theme__text--primary ' . $block['module_configuration']['title_type'],
						['data-animate' => 'fade-in-up',]
					);
					?>
				<?php endif; ?>
			</div>

			<?php if (!empty($block['text'])): ?>
				<div class="block-repeater-wicons__main-text font-body-md theme__text--secondary" data-animate="fade-in-up" data-animate-delay="100">
					<?php echo $block['text']; ?>
				</div>
			<?php endif; ?>
		</div>


		<?php if (!empty($block['text_boxes'])): ?>
			<div class="block-repeater-wicons__bottom">

				<?php
				$counter = 1;

				foreach ($block['text_boxes'] as $card): ?>


					<div class="block-repeater-wicons__box" data-animate="fade-in-up" data-animate-delay="300">
						<div class="block-repeater-wicons__box-top">

							<?php if ((!empty($block['module_configuration']['options']) && !empty($card['icon']))  && $block['module_configuration']['options'] === 'block-repeater-wicons--wicons') { ?>

								<?php
								$icon_path = get_template_directory() . '/icons-module-cards/' . $card['icon'] . '.svg';

								if (file_exists($icon_path)) {
									$svg_content = file_get_contents($icon_path);
									if ($svg_content !== false) {
										echo '<div class="block-repeater-wicons__box-icon">';
										echo $svg_content;
										echo '</div>';
									} else {
										echo '<div class="block-repeater-wicons__box-icon"></div>';
									}
								} else {
									echo '<div class="block-repeater-wicons__box-icon"></div>';
								}
								?>

							<?php } elseif (!empty($block['module_configuration']['options']) && $block['module_configuration']['options'] === 'block-repeater-wicons--wnumbers') { ?>
								<div class="block-repeater-wicons__box-icon font-label-lg">
									<?php echo $counter; ?>
								</div>
								<?php $counter++; ?>
							<?php } ?>

							<?php if (!empty($card['tagline'])): ?>
								<?php
								echo get_dynamic_heading(
									$card['tagline'],
									$card['heading_tag_tagline'],
									'block-repeater-wicons__box-tagline font-label-lg theme__text--primary font-uppercase',
								);
								?>

							<?php endif; ?>

							<?php if (!empty($card['title'])): ?>
								<?php
								echo get_dynamic_heading(
									$card['title'],
									$card['heading_tag'],
									'block-repeater-wicons__box-title font-heading-md theme__text--primary',
								);
								?>
							<?php endif; ?>
						</div>

						<?php if (!empty($card['text'])): ?>
							<div class="block-repeater-wicons__box-text font-body-sm theme__text--secondary">
								<?php echo $card['text']; ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($card['buttons'])): ?>
							<div class="block-repeater-wicons__box-buttons">
								<?php foreach ($card['buttons'] as $button): ?>

									<?php
									echo get_button(array(
										'html_text' => $button['link']['title'],
										'href' =>  $button['link']['url'],
										'target' => $button['link']['target'],
										'class' => $button['type'] . ' btn--small btn--icon-after',
										'icon' => 'chevron-right',
									));
									?>

								<?php endforeach; ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>

</div>