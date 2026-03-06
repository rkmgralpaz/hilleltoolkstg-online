<div id="block-<?php echo $block_index; ?>" class="theme <?php echo explode(';', $block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>">
	<div class="js-module block-accordion max-width">
		<?php
		echo get_dynamic_heading(
			$block['title'],
			$block['heading_tag'],
			'block-accordion__title theme__text--body font-display-lg',
			[
				'data-animate' => 'fade-in-up',
				'data-animate-mode' => 'inside-module',
			]
		);
		?>

		<div class="accordion">

			<?php $row_number = 1; ?>
			<?php foreach ($block['accordion_list'] as $item) { ?>

				<details data-animate="fade-in-up" data-animate-mode="inside-module">
					<summary>
						<span class="accordion__title font-body-lg  theme__text--primary">
							<span class="accordion__row"><?php echo $row_number; ?></span>						
							<?php
							echo get_dynamic_heading(
								$item['title'],
								$item['heading_tag'],
								'font-body-lg  theme__text--primary'
							);
							?>
						</span>
						<span class="accordion__icon">
							<?php
							echo get_button(array(
								'class' => 'btn--primary btn--large btn--icon-only',
								'icon' => 'chevron-down',
								'aria-label' => 'Expand content'
							));
							?>
						</span>
					</summary>
					<div class="accordion__content font-body-md theme__text--secondary">
						<?php echo $item['text']; ?>
					</div>
				</details>

			<?php
				$row_number++;
			}
			?>

		</div>

	</div>
</div>