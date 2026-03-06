		
	</main>

	<footer class="footer theme theme--blue theme--mode-bright">

		<div class="max-width footer__content">

			<div class="footer__body">

				<div class="footer__left-side">

					<a class="footer__logo" href="<?php echo BASE_URL ?>" aria-label="Logo">
						<?php include realpath(__DIR__).'/partials/hillel-footer-logo.php'; ?>
					</a>

					<div class="footer__brand-details">
						<div class="footer__site-description font-body-md theme__text--primary">
							<?php echo get_field('footer_site_description', 'option') ?>
						</div>

						<div class="footer__powered-by font-body-md theme__text--primary">
							<div>
								Powered by
							</div>
							<a href="https://www.hillel.org/" target="blank">
								<?php include realpath(__DIR__).'/partials/hillel-footer-logo-2.php'; ?>
							</a>						
						</div>
					</div>

				</div>
			
				<div class="footer__navs">

					<div class="footer__nav footer__nav-1 font-body-md theme__text--primary">

						<?php if (get_field('footer_title_nav_1', 'option')) { ?>
							<div class="footer__title-nav theme__text--secondary">
								<?php echo get_field('footer_title_nav_1', 'option'); ?>
							</div>
						<?php } ?>
						
						<?php $nav = get_field('footer_nav_1', 'option'); ?>
						<?php foreach ( $nav as $link) { ?>
							<a href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
						<?php } ?>
					</div>
	
					<div class="footer__nav footer__nav-2 font-body-md theme__text--primary">
					<?php if (get_field('footer_title_nav_2', 'option')) { ?>
							<div class="footer__title-nav theme__text--secondary">
								<?php echo get_field('footer_title_nav_2', 'option'); ?>
							</div>
						<?php } ?>
					<?php $nav = get_field('footer_nav_2', 'option'); ?>
						<?php foreach ( $nav as $link) { ?>
							<a href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
						<?php } ?>
					</div>

				</div>
				
			</div>

			<div class="footer__copy font-body-md theme__text--primary">
				<?php echo get_field('footer_site_copy', 'option') ?>
			</div>

		</div>

	</footer>

	<?php wp_footer(); ?>
	</body>
</html>

