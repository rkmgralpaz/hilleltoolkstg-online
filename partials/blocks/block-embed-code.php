<div class="block-embed-code theme theme--neutral">
	<?php
		$max_width = $block['module_configuration']['max_width'] ? 'max-width:'.$block['module_configuration']['max_width'].'px' : '';
	?>
	<div class="block-embed-code__wrapper <?php echo implode(' ',$block['module_configuration']['remove_margins']); ?> <?php echo $block['module_configuration']['align']; ?>" style="<?php echo $max_width; ?>">
		<?php
			echo $block['code'];
		?>
	</div>
</div>
           