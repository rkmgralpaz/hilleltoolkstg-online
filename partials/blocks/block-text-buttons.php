<div id="block-<?php echo $block_index; ?>" class="theme <?php echo explode(';',$block['module_color_settings']['color_palette'])[0]; ?> <?php echo $block['module_color_settings']['color_mode']; ?>">

	<div class="block-text-buttons max-width">

		<div class="block-text-buttons__text theme__text--primary font-display-md" data-animate="fade-in-up" data-animate-delay="200">
			<?php echo $block['text'] ?>
		</div>

		<div class="block-text-buttons__bottom">

			<div data-animate="fade-in-up" data-animate-delay="300">
			<?php 
			 if ($block['button_1']) {
					echo get_button(array(
						'html_text' => $block['button_1']['title'],
						'href' => $block['button_1']['url'],
						'target' => $block['button_1']['target'],
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
			 }
			 ?>
			</div>

			<div data-animate="fade-in-up" data-animate-delay="400">
			<?php 
			 if ($block['button_2']) {
					echo get_button(array(
						'html_text' => $block['button_2']['title'],
						'href' => $block['button_2']['url'],
						'target' => $block['button_2']['target'],
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
			}
			?>
			</div>

			<div data-animate="fade-in-up" data-animate-delay="500">
			<?php 
			if ($block['button_3']) {
				echo get_button(array(
					'html_text' => $block['button_3']['title'],
					'href' => $block['button_3']['url'],
					'target' => $block['button_3']['target'],
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			}
			?>
			</div>

		</div>

	</div>

</div>
           