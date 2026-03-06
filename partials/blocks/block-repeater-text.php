<div id="block-<?php echo $block_index; ?>" class="max-width block-repeater-text-container <?php echo !empty($block['module_configuration']['in_a_box']) && $block['module_configuration']['in_a_box'] === true ? 'block-repeater-text-container-box' : ''; ?> <?php echo explode(';', $block['module_configuration']['background_color'])[0]; ?>">

	<div class="theme theme-block-repeater-text <?php echo explode(';', $block['module_configuration']['color_palette'])[0]; ?> <?php echo isset($block['module_configuration']['color_mode']) ? $block['module_configuration']['color_mode'] : 'theme--light'; ?>">

		<div class="block-repeater-text">

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
							'theme__text--primary ' . $block['module_configuration']['title_size'],
							['data-animate' => 'fade-in-up',]
						);
						?>
					<?php endif; ?>
				</div>

				<?php if (!empty($block['text'])): ?>
					<div class="font-body-md theme__text--secondary" data-animate="fade-in-up" data-animate-delay="100">
						<?php echo $block['text']; ?>
					</div>
				<?php endif; ?>
			</div>


			<?php if (!empty($block['text_boxes'])): ?>
				<div class="block-repeater-text__bottom">
					<?php foreach ($block['text_boxes'] as $text_box): ?>
						<div class="block-repeater-text__box" data-animate="fade-in-up" data-animate-delay="300">

							<div>
								<?php if (!empty($text_box['tagline'])): ?>
									<?php
									echo get_dynamic_heading(
										$text_box['tagline'],
										$text_box['heading_tag_tagline'],
										'font-label-md theme__text--secondary font-uppercase',
									);
									?>
								<?php endif; ?>

								<?php if (!empty($text_box['title'])): ?>
									<?php
									echo get_dynamic_heading(
										$text_box['title'],
										$text_box['heading_tag'],
										'font-heading-md theme__text--primary',
									);
									?>
								<?php endif; ?>
							</div>

							<?php if (!empty($text_box['text'])): ?>
								<div class="block-repeater-text__box-text font-body-sm theme__text--secondary">
									<?php echo $text_box['text']; ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($text_box['buttons'])): ?>
								<div class="block-repeater-text__box-buttons">
									<?php foreach ($text_box['buttons'] as $button): ?>

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

</div>