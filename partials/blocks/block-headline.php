<div class="theme <?php echo explode(';',$block['module_color_settings']['color_palette'])[0]; ?>">

	<div class="block-headline max-width <?php echo $block['module_color_settings']['color_mode']; ?> <?php echo $block['module_color_settings']['alignment']; ?>">

		<?php if($block['title']) { ?>
			<div class="block-headline__title theme__text--primary font-heading-lg" data-animate="fade-in-up">
				<?php echo $block['title'] ?>
			</div>
		<?php } ?>

		<?php if($block['text']) { ?>
			<div class="block-headline__text theme__text--primary font-heading-lg" data-animate="fade-in-up" data-animate-delay="200">
				<?php echo $block['text'] ?>
			</div>
		<?php } ?>

		<?php if ($block['button_1'] || $block['button_2'] || $block['button_3']) { ?>
			<div class="block-headline__bottom" data-animate="fade-in-up" data-animate-delay="300">

				<div>

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
		<?php } ?>

	</div>

</div>
           