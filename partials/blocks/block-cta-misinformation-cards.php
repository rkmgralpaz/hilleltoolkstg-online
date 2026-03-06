<div
	class="js-module block-cta-misinformation-cards 
	<?php echo explode(';', $block['background_color'])[0]; ?>
	block-bannerh-container <?php echo !empty($block['in_a_box']) && $block['in_a_box'] === true ? 'block-bannerh-container-in-a-box' : 'block-bannerh-container-no-box'; ?>
	">

	<div class="block-bannerh__container 
	theme 
	<?php echo explode(';', $block['color_palette'])[0]; ?> 
	<?php echo $block['color_mode']; ?> 
	<?php if (

		(explode(';', $block['color_palette'])[0] === 'theme--neutral' && $block['color_mode'] === 'theme--mode-light')

		&& $block['background'] === false
	) {
		echo 'theme--surface-secondary';
	}  ?>"
		data-animate="fade-in-up" data-animate-mode="inside-module">

		<div class="block-bannerh__inner-container">
			<div class="block-bannerh__left <?php if ($block['image_position']) {
												echo 'block-bannerh__left--to-right';
											} ?>" data-animate="fade-in-up" data-animate-mode="inside-module">

				<div>
					<?php if (!empty($block['tagline'])): ?>
						<?php
						echo get_dynamic_heading(
							$block['tagline'],
							$block['heading_tag_tagline'],
							'block-bannerh__tag font-label-lg font-uppercase theme__text--secondary',
						);
						?>
					<?php endif; ?>

					<?php if (!empty($block['title'])): ?>
						<?php
						echo get_dynamic_heading(
							$block['title'],
							$block['heading_tag'],
							'block-bannerh__title theme__text--primary ' . $block['title_size'],
						);
						?>
					<?php endif; ?>
				</div>

				<?php if (!empty($block['text'])): ?>
					<div class="block-bannerh__text font-body-md theme__text--secondary">
						<?php echo $block['text']; ?>
					</div>
				<?php endif; ?>

				<div class="block-bannerh__buttons">
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

			<div class="block-bannerh__right" data-animate="fade-in-up" data-animate-mode="inside-module" data-animate-delay="100">

				<div class="block-bannerh__cards-wrapper">
					<div class="block-bannerh__cards-holder">
						<?php
						$flip_icon = get_button(array(
							'class' => 'btn--primary btn--large btn--icon-only card__icon',
							'icon' => 'back',
							'tag' => 'div',
						));
						$i = 0;
						$cards_html = array();
						$card_list = get_field('featured_view_posts', 'cards');
						$card_themes = array(
							'theme theme--pink theme--mode-bright',
							'theme theme--green theme--mode-dark',
							'theme theme--blue theme--mode-bright',
							'theme theme--pink theme--mode-dark',
						);
						$card_color = get_cards_color_by_filters();
						foreach ($card_list as $card):
							$i++;
							if ($i > 4):
								$i = 1;
							endif;
							$card_title = get_the_title($card);
							$card_permalink = get_permalink($card);
							$card_filters = wp_get_post_terms($card,'card_filters');
							$color_num = $card_color[$card_filters[0]->slug]['num'];
							$card_theme = $card_themes[($color_num - 1)];
							array_push($cards_html, "
									<div class='block-bannerh__card-outer'>
										<a href='{$card_permalink}' class='block-bannerh__card block-bannerh__card--t{$i} {$card_theme}'>
											<div class='card__title font-display-sm theme__text--primary'>{$card_title}</div>
											{$flip_icon}
										</a>
									</div>
								");
						endforeach;
						//$cards_html = implode('',array_reverse($cards_html));
						$cards_html = implode('', $cards_html);
						echo $cards_html;
						?>
					</div>
					<div class="block-bannerh__cards-arrows theme theme--neutral theme--mode-light theme--surface-secondary">
						<?php
						echo get_button(array(
							'class' => 'cards-arrows__arrow-btn cards-arrows__arrow-btn-prev btn--primary btn--small btn--icon-only',
							'icon' => 'chevron-left',
							'aria-label' => 'Previous card',
						));
						echo get_button(array(
							'class' => 'cards-arrows__arrow-btn cards-arrows__arrow-btn-next btn--primary btn--small btn--icon-only',
							'icon' => 'chevron-right',
							'aria-label' => 'Next card',
						));
						?>
					</div>
				</div>

			</div>
		</div>

	</div>

</div>