<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>


<div class="theme theme--blue theme--mode-dark">
	<div class="heading max-width">
		<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="heading__cta">

			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>

			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA Long Text',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--blue theme--mode-light">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>

<div class="theme theme--blue theme--mode-bright">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--blue theme--mode-dark">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--pink theme--mode-light">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--pink theme--mode-bright">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--pink theme--mode-dark">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--orange theme--mode-light">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--orange theme--mode-bright">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--orange theme--mode-dark">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>	

<div class="theme theme--green theme--mode-light">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--green theme--mode-bright">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>		

<div class="theme theme--green theme--mode-dark">

	<div class="cards-cluster max-width">
	
		<div class="cards-cluster__heading">
			<div class="cards-cluster__tagline font-label-xl theme__text--secondary font-uppercase">
				at a glance
			</div>
			<div class="cards-cluster__title font-heading-2xl theme__text--primary">
				What to do if you have experienced an antisemitic incident
			</div>
		</div>
	
		<div class="cards-cluster__cards">
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Document what happened with words, pictures, etc.
					</div>
					<div class="card__text font-body-md theme__text--body">
						With a focus on tax efficiency, we’ll strive to help you navigate complex tax laws and regulations.
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Carefully review your school’s code of conduct and discrimination/harassment policies.
					</div>
					<div class="card__text font-body-md theme__text--body">
						Discover whether the incident is covered by your school’s policies and what you can do to report it. 
					</div>
				</div>
			</div>	

			
			<div class="card">
				<div class="card__top">
					<div class="card__icon">
						<?php include 'icons/book.php'; ?>
					</div>
					
				</div>
				<div class="card__bottom">
					<div class="card__title font-heading-sm theme__text--primary">
						Reach out to your local Hillel staff for guidance.  
					</div>
					<div class="card__text font-body-md theme__text--body">
						Hillel International has expert attorneys who can provide free support through the CALL system.
					</div>
				</div>
			</div>	
		</div>
	
		<div class="cards-cluster__cta">
		<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--primary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
	
				<?php
					echo get_button(array(
						'html_text' => 'Beautiful CTA Long Text',
						'href' => '#',
						'target' => 'self',
						'class' => 'btn--secondary btn--large btn--icon-after',
						'icon' => 'chevron-right',
					));
				 ?>
		</div>
	
	
	
	</div>

</div>	

<div class="theme theme--blue theme--mode-light">
	<div class="heading max-width">
		<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--blue theme--mode-bright">
	<div class="heading max-width">
		<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--blue theme--mode-dark">
	<div class="heading max-width">
		<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--pink theme--mode-light">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--pink theme--mode-bright">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--pink theme--mode-dark">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--orange theme--mode-light">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--orange theme--mode-bright">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--orange theme--mode-dark">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--green theme--mode-light">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--green theme--mode-bright">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>

<div class="theme theme--green theme--mode-dark">
	<div class="heading max-width">
	<div class="heading__details">
			<div class="font-label-lg theme__text--primary font-uppercase">
			tagline here
			</div>
			<div class="heading__title font-display-lg theme__text--primary">
			Here goes a display text. Keep it shorter than 2 lines.
			</div>
			<div class="heading__blurb font-body-xl theme__text--body">
			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.
			</div>
			<div class="buttons">
			
			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--primary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>	
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--secondary btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 		 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--large btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>		 
			 <?php
				echo get_button(array(
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--subtle btn--small btn--icon-after btn--icon-only',
					'icon' => 'chevron-right',
				));
			 ?>				 				 
			</div>

			<div>
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--large btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>		
			<?php
				echo get_button(array(
					'html_text' => 'Beautiful CTA',
					'href' => '#',
					'target' => 'self',
					'class' => 'btn--tertiary btn--small btn--icon-after',
					'icon' => 'chevron-right',
				));
			 ?>	
		 	
			</div>
	
			</div>
		</div>
	</div>
</div>


<!-- 

<br><br><br><br>

<div class="block--theme-pink block--mode-light">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div>

<div class="block--theme-pink block--mode-bright">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div>

<div class="block--theme-pink block--mode-dark">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div>

<br><br><br><br>

<div class="block--theme-orange block--mode-light">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div>

<div class="block--theme-orange block--mode-bright">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div>

<div class="block--theme-orange block--mode-dark">
	<div class="font-display-lg block__text-primary">
		Lorem ipsum siat amet 
	</div>
	<div class="font-display-lg block__text-body">
		Lorem ipsum siat amet 
	</div>
</div> -->

<!-- <div class="font-display-xs">
	Lorem ipsum siat amet 
</div>
<div class="font-display-sm">
	Lorem ipsum siat amet 
</div>
<div class="font-display-md">
	Lorem ipsum siat amet 
</div>
<div class="font-display-lg">
	Lorem ipsum siat amet 
</div>

<div class="font-heading-xs">
	Lorem ipsum siat amet 
</div>
<div class="font-heading-sm">
	Lorem ipsum siat amet 
</div>
<div class="font-heading-md">
	Lorem ipsum siat amet 
</div>
<div class="font-heading-lg">
	Lorem ipsum siat amet 
</div>
<div class="font-heading-xl">
	Lorem ipsum siat amet 
</div>
<div class="font-heading-2xl">
	Lorem ipsum siat amet 
</div>

<div class="font-body-xs">
	Lorem ipsum siat amet 
</div>

<div class="font-body-sm">
	Lorem ipsum siat amet 
</div>

<div class="font-body-md">
	Lorem ipsum siat amet 
</div>

<div class="font-body-lg">
	Lorem ipsum siat amet 
</div>

<div class="font-body-xl">
	Lorem ipsum siat amet 
</div>

<div class="font-label-sm">
	Lorem ipsum siat amet 
</div>
<div class="font-label-md">
	Lorem ipsum siat amet 
</div>
<div class="font-label-lg">
	Lorem ipsum siat amet 
</div>
<div class="font-label-xl">
	Lorem ipsum siat amet 
</div>
-->


<?php endwhile; ?>


<?php get_footer(); ?> 