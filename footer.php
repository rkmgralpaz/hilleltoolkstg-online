	</main>

	<footer class="footer theme theme--blue theme--mode-bright">

		<div class="max-width footer__content">

			<div class="footer__body">

				<div class="footer__left-side">

					<a class="footer__logo" href="<?php echo BASE_URL ?>" aria-label="Logo">
						<?php include realpath(__DIR__) . '/partials/hillel-footer-logo.php'; ?>
					</a>

					<div class="footer__brand-details">
						<div class="footer__site-description font-body-md theme__text--primary">
							<?php echo get_field('footer_site_description', 'option') ?>
						</div>

						<div class="footer__powered-by font-body-md theme__text--primary">
							<div>
								Powered by
							</div>
							<a href="https://www.hillel.org/" target="blank" aria-label="Hillel Website">
								<?php include realpath(__DIR__) . '/partials/hillel-footer-logo-2.php'; ?>
							</a>
						</div>
					</div>

				</div>

				<div class="footer__navs">

					<div class="footer__nav footer__nav-1 font-body-md theme__text--primary">

						<?php $nav = get_field('footer_nav_1', 'option'); ?>
						<?php foreach ($nav as $link) { ?>
							<a target="<?php echo $link['link']['target']; ?>" href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
						<?php } ?>
					</div>

					<div class="footer__nav footer__nav-2 font-body-md theme__text--primary">

						<?php $nav = get_field('footer_nav_2', 'option'); ?>
						<?php foreach ($nav as $link) { ?>
							<a target="<?php echo $link['link']['target']; ?>" href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
						<?php } ?>
					</div>

					<div class="footer__social">
						<?php
						echo get_button(array(
							'html_text' => 'Follow us on Instagram',
							'href' => get_field('instagram_url', 'option'),
							'target' => '_blank',
							'class' => 'btn--primary btn--large btn--icon-before',
							'icon' => 'instagram',
						));
						?>
					</div>

				</div>

			</div>

			<div class="footer__copy font-body-md theme__text--primary">
				<?php echo get_field('footer_site_copy', 'option') ?>
			</div>

		</div>

	</footer>

	<!-- Global incident popup for mobile (reuses tooltip content) -->
	<div class="incident-popup incident-popup--hidden theme theme--neutral theme--mode-light" hidden>
		<div class="incident-popup__overlay"></div>
		<div class="incident-popup__content">
			<div class="incident-popup__handle" aria-hidden="true"></div>
			<!-- Tooltip content will be cloned and injected here -->
			<div class="incident-popup__tooltip-container"></div>
		</div>
	</div>

	<div id="cookies-banner" class="theme theme--neutral theme--dark cookies-banner max-width cookies-banner--hide">

		<div class="cookies-banner__text theme__text--secondary font-body-sm">
			To make this site work properly, we sometimes place small data files called cookies on your device. By choosing to continue to use this site without changing your cookie setting, we will assume that you are consenting to receive cookies.
		</div>

		<div class="cookies-banner__btns">
			<?php
			echo get_button(array(
				'html_text' => 'I understand',
				'class' => 'btn--primary btn--large',
				'id' => 'cookies-banner__consent',
				'aria-label' => 'Cookie Consent Ok'
			));
			?>
			<?php
			echo get_button(array(
				'html_text' => 'Cookie Policy',
				'href' => 'https://www.hillel.org/cookie-policy/',
				'target' => 'blank',
				'class' => 'btn--secondary btn--large',
				'aria-label' => 'Cookie Policy'
			));
			?>
		</div>

	</div>
	<?php wp_footer(); ?>



	<script type="text/javascript" src="https://cdn-cookieyes.com/client_data/fa68b8da34be4e431c6d3125/script.js" id="cookieyes-script-js"></script>
	</body>

	</html>