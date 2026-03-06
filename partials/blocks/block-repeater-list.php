<div id="block-<?php echo $block_index; ?>" class="max-width block-repeater-list-container <?php echo !empty($block['module_configuration']['in_a_box']) && $block['module_configuration']['in_a_box'] === true ? 'block-repeater-list-container-box' : ''; ?> <?php echo explode(';', $block['module_configuration']['background_color'])[0]; ?>">

	<div class="theme theme-block-repeater-list <?php echo explode(';', $block['module_configuration']['color_palette'])[0]; ?> <?php echo isset($block['module_configuration']['color_mode']) ? $block['module_configuration']['color_mode'] : 'theme--light'; ?>">

		<div class="block-repeater-list">

			<?php if (!empty($block['tagline']) || !empty($block['title']) || !empty($block['text'])): ?>

				<div class="block-repeater-list__top">
					<div>
						<?php if (!empty($block['tagline'])): ?>
							<div>
								<?php
								echo get_dynamic_heading(
									$block['tagline'],
									$block['heading_tag_tagline'],
									'font-label-lg theme__text--secondary font-uppercase',
									['data-animate' => 'fade-in-up',]
								);
								?>
							</div>
							<?php endif; ?>

							<?php if (!empty($block['title'])): ?>
								<?php
								echo get_dynamic_heading(
									$block['title'],
									$block['heading_tag'],
									'theme__text--primary ' . $block['module_configuration']['title_size'],
									[
										'data-animate' => 'fade-in-up',

									]
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

			<?php endif; ?>


			<?php if (!empty($block['text_lists'])): ?>
				<div class="block-repeater-list__bottom">
					<?php foreach ($block['text_lists'] as $text_box): ?>
						<div class="block-repeater-list__box" data-animate="fade-in-up" data-animate-delay="300">
							<?php if (!empty($text_box['title'])): ?>
								<?php
								echo get_dynamic_heading(
									$text_box['title'],
									$text_box['heading_tag'],
									'block-repeater-list__box-title font-heading-md theme__text--primary',
								);
								?>
							<?php endif; ?>
							<?php if (!empty($text_box['text'])): ?>
								<div class="block-repeater-list__box-text font-body-md theme__text--primary">
									<?php echo $text_box['text']; ?>
								</div>
							<?php endif; ?>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>