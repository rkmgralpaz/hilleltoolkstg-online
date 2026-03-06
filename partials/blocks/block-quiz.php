<div 
	id="block-<?php echo $block_index; ?>" 
	class="block-quiz 
	<?php echo explode(';',$block['module_configuration']['background_color'])[0]; ?>
	">

	<div class="block-quiz__inner 
	theme max-width
	<?php echo explode(';',$block['module_configuration']['color_palette'])[0]; ?> 
	<?php echo $block['module_configuration']['color_mode']; ?> 
	<?php if ( 
		
		(explode(';', $block['module_configuration']['color_palette'])[0] === 'theme--neutral' && $block['module_configuration']['color_mode'] === 'theme--mode-light' ) ||

		(explode(';', $block['module_configuration']['color_palette'])[0] === 'theme--blue' && $block['module_configuration']['color_mode'] === 'theme--mode-neutral' )

		
		&& $block['module_configuration']['background'] === false ) 
		
		{ echo 'theme--surface-secondary'; }  ?>"
		data-animate="fade-in-up" 
		>

		<div>

			<div class="block-quiz__heading">
				<?php if (!empty($block['title'])): ?>
					<div class="block-quiz__title font-display-lg-2 theme__text--body">
						<?php echo $block['title']; ?>
					</div>
				<?php endif; ?>
		
				<?php if (!empty($block['text'])): ?>
					<div class="block-quiz__text theme__text--primary font-label-lg">
						<?php echo $block['text']; ?>
					</div>
				<?php endif; ?>
			</div>

			<div>
				<div class="font-body-xl">					
					<form class="quiz__form serif-display-m">

						<div class="quiz__form-top">
							<div>
								I recently
								<div class="quiz__select">
									<div class="quiz__select-label" data-default="age range">type of experience</div>
									<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E"/>
											</svg>
									</div>
									<select name="age-select" id="age-select" autocomplete="off" class="lowercase">
									<option value="44">Option 1</option>
										<option value="46">Option 2</option>
										<option value="88">Option 3</option>
									</select>
								</div>
								what might have been an antisemitic incident.
							</div>
							<div>
								It was
								<div class="quiz__select">
									<div class="quiz__select-label" data-default="age range">incident type</div>
									<div class="quiz__select-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E"/>
										</svg>
									</div>
									<select name="age-select" id="age-select" autocomplete="off" class="lowercase">
									<option value="44">Option 1</option>
										<option value="46">Option 2</option>
										<option value="88">Option 3</option>
									</select>
								</div>
								that targeted
								<div class="quiz__select">
									<div class="quiz__select-label" data-default="age range">who was affected</div>
									<div class="quiz__select-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E"/>
										</svg>
									</div>
									<select name="age-select" id="age-select" autocomplete="off" class="lowercase">
									<option value="44">Option 1</option>
										<option value="46">Option 2</option>
										<option value="88">Option 3</option>
									</select>
								</div>
							</div>
							<div>
								The incident occurred
								<div class="quiz__select">
									<div class="quiz__select-label" data-default="age range">place</div>
									<div class="quiz__select-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E"/>
										</svg>
									</div>
									<select name="age-select" id="age-select" autocomplete="off" class="lowercase">
										<option value="44">Option 1</option>
										<option value="46">Option 2</option>
										<option value="88">Option 3</option>
									</select>
								</div>
								and was committed by
								<div class="quiz__select">
									<div class="quiz__select-label" data-default="age range">person or group</div>
									<div class="quiz__select-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E"/>
										</svg>
									</div>
									<select name="age-select" id="age-select" autocomplete="off" class="lowercase">
										<option value="44">Option 1</option>
										<option value="46">Option 2</option>
										<option value="88">Option 3</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="quiz__form-bottom">
						<?php
							echo get_button(array(
								'html_text' => 'Find out',
								'class' => 'btn--primary btn--large btn--icon-after',
								'icon' => 'chevron-right',
							));
						?>	
						</div>

					</form>
				</div>
			</div>
		</div>

		<?php if (!empty($block['note'])): ?>
			<div class="block-quiz__note theme__text--secondary font-body-small">
				<?php echo $block['note']; ?>
			</div>
		<?php endif; ?>

		<div class="block-quiz__sending"></div>
	
	</div>

</div>