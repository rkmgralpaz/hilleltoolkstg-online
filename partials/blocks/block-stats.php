<div class="block-stats-wrap theme <?php echo $block['color_palette']; ?>">

	<div class="block-stats max-width">

	<?php $counter = 1; ?>

	<?php foreach ($block['stats'] as $stat): ?>

		<?php 
			$class = '';
			if ( $block['color_palette'] === 'theme--multicolor-neutral' ) {
				if ( $counter === 1 ) {
					$class = "theme--multicolor-mode-blue";
				} else {
					$class = "theme--multicolor-mode-green";
				}
			}
		?>

		<div class="block-stats__item <?php echo $class; ?>">

			<div class="block-stats__value theme__text--body font-display-xl" data-animate="fade-in-up">
				<?php echo $stat['value']; ?>
			</div>

			<div class="block-stats__bottom" data-animate="fade-in-up" data-animate-delay="100">

				<div class="block-stats__description font-body-xl theme__text--primary">
					<?php echo $stat['description']; ?>
				</div>
		
				<div class="block-stats__source theme__text--secondary font-body-sm">
					<?php echo $stat['source']; ?>
				</div>

			</div>

		</div>
	
	<?php $counter++; ?>
	<?php endforeach; ?>

	</div>

</div>
           