<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>


	<?php

	$experiences = get_terms(array(
		'taxonomy' => 'experience_quiz',
		'hide_empty' => false,
	));

	$incidents = get_terms(array(
		'taxonomy' => 'incident_quiz',
		'hide_empty' => false,
	));

	$affecteds = get_terms(array(
		'taxonomy' => 'affected_quiz',
		'hide_empty' => false,
	));

	$places = get_terms(array(
		'taxonomy' => 'place_quiz',
		'hide_empty' => false,
	));

	$committeds = get_terms(array(
		'taxonomy' => 'committed_quiz',
		'hide_empty' => false,
	));


	?>


	<div
		class="block-quiz js-module
	<?php echo explode(';', get_field('module_configuration')['background_color'])[0]; ?>
	">

		<div class="block-quiz__inner
	theme max-width
	<?php echo explode(';', get_field('module_configuration')['color_palette'])[0]; ?> 
	<?php echo get_field('module_configuration')['color_mode']; ?> 
	<?php if (

		(explode(';', get_field('module_configuration')['color_palette'])[0] === 'theme--neutral' && get_field('module_configuration')['color_mode'] === 'theme--mode-light') ||

		(explode(';', get_field('module_configuration')['color_palette'])[0] === 'theme--blue' && get_field('module_configuration')['color_mode'] === 'theme--mode-neutral')


		&& get_field('module_configuration')['background'] === false
	) {
		echo 'theme--surface-secondary';
	}  ?>"
			data-animate="fade-in-up">

			<div>

				<div class="block-quiz__heading">
					<?php if (!empty(get_field('title'))): ?>

						<?php
						echo get_dynamic_heading(
							get_field('title'),
							get_field('heading_tag'),
							'block-quiz__title font-display-lg-2 theme__text--body',
						);
						?>

					<?php endif; ?>

					<?php if (!empty(get_field('text'))): ?>
						<div class="block-quiz__text theme__text--primary font-label-lg">
							<?php echo get_field('text'); ?>
						</div>
					<?php endif; ?>
				</div>

				<div>
					<div class="font-body-xl">
						<form id="quiz-form" class="quiz__form serif-display-m">

							<div class="quiz__form-top">
								<div>
									I recently
									<div class="quiz__select">
										<div class="quiz__select-label" data-default="">type of experience</div>
										<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E" />
											</svg>
										</div>
										<select name="experience-select" id="experience-select" autocomplete="off" class="lowercase">

											<option value="type of experience">type of experience</option>

											<?php if (!empty($experiences)) { ?>

												<?php foreach ($experiences as $term) { ?>
													<option value="<?php echo $term->slug; ?>">
														<?php echo $term->name; ?>
													</option>

												<?php } ?>

											<?php } ?>

										</select>
									</div>
									what might have been an antisemitic incident.
								</div>
								<div>
									It was
									<div class="quiz__select">
										<div class="quiz__select-label" data-default="">incident type</div>
										<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E" />
											</svg>
										</div>
										<select name="incident-select" id="incident-select" autocomplete="off" class="lowercase">

											<option value="incident type">incident type</option>

											<?php if (!empty($incidents)) { ?>

												<?php foreach ($incidents as $term) { ?>
													<option value="<?php echo $term->slug; ?>">
														<?php echo $term->name; ?>
													</option>

												<?php } ?>

											<?php } ?>

										</select>
									</div>
									that targeted
									<div class="quiz__select">
										<div class="quiz__select-label" data-default="">who was affected.</div>
										<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E" />
											</svg>
										</div>
										<select name="affected-select" id="affected-select" autocomplete="off" class="lowercase">

											<option value="who was affected">who was affected</option>

											<?php if (!empty($affecteds)) { ?>

												<?php foreach ($affecteds as $term) { ?>
													<option value="<?php echo $term->slug; ?>">
														<?php echo $term->name; ?>.
													</option>

												<?php } ?>

											<?php } ?>

										</select>
									</div>
								</div>
								<div>
									The incident occurred
									<div class="quiz__select">
										<div class="quiz__select-label" data-default="age range">place</div>
										<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E" />
											</svg>
										</div>
										<select name="place-select" id="place-select" autocomplete="off" class="lowercase">

											<option value="place">place</option>

											<?php if (!empty($places)) { ?>

												<?php foreach ($places as $term) { ?>
													<option value="<?php echo $term->slug; ?>">
														<?php echo $term->name; ?>
													</option>

												<?php } ?>

											<?php } ?>

										</select>
									</div>
									and was committed by
									<div class="quiz__select">
										<div class="quiz__select-label" data-default="age range">person or group.</div>
										<div class="quiz__select-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z" fill="#33312E" />
											</svg>
										</div>
										<select name="committed-select" id="committed-select" autocomplete="off" class="lowercase">

											<option value="person or group">person or group</option>

											<?php if (!empty($committeds)) { ?>

												<?php foreach ($committeds as $term) { ?>
													<option value="<?php echo $term->slug; ?>">
														<?php echo $term->name; ?>.
													</option>

												<?php } ?>

											<?php } ?>

										</select>
									</div>
								</div>
							</div>

							<div class="quiz__form-bottom">
								<?php
								echo get_button(array(
									'html_text' => 'Find Out',
									'class' => 'btn--primary btn--large btn--icon-after',
									'icon' => 'chevron-right',
									'type' => 'submit'
								));
								?>
							</div>

						</form>
					</div>
				</div>
			</div>

			<?php if (!empty(get_field('note'))): ?>
				<div class="block-quiz__note theme__text--secondary font-body-sm">
					<?php echo get_field('note'); ?>
				</div>
			<?php endif; ?>

			<div class="block-quiz__sending"></div>

		</div>

	</div>



<?php endwhile; ?>

<?php get_footer(); ?>