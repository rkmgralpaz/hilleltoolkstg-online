<?php

$password_enabled = get_field('password_enabled', 'timeline');
$password = get_field('password', 'timeline');
if ($password == ''):
	$password_enabled = false;
	setcookie("c4atl", '', time() + 1);
endif;

if ($password_enabled && (!isset($_COOKIE["c4atl"]) || $_COOKIE["c4atl"] != $password) && isset($_GET['validate']) && isset($_POST['timeline-access-pass']) && $_POST['timeline-access-pass'] == $password):
	setcookie("c4atl", $password, time() + 3600 * 10);
	wp_redirect(home_url() . '/timeline/');
	exit;
elseif ($password_enabled && (!isset($_COOKIE["c4atl"]) || $_COOKIE["c4atl"] != $password) && isset($_GET['validate'])):
	wp_redirect(home_url() . '/timeline/?err');
	exit;
endif;

get_header();

$free_pass = false;

if (!$free_pass && $password_enabled && ((!isset($_COOKIE["c4atl"]) || $_COOKIE["c4atl"] != $password) && (!isset($_POST['timeline-access-pass']) || $_POST['timeline-access-pass'] != $password))):


?>

	<style>
		#timeline-access {
			min-height: 100dvh;
			padding: 80px 40px;
			padding-top: 200px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		#timeline-access-form {
			display: flex;
			gap: 12px;
			height: 64px;
		}

		#timeline-access-pass {
			background: white;
			border: solid 1px var(--neutral-900);
			border-radius: 30px;
			padding: 5px 20px;
			width: 225px;
		}

		#timeline-access-message {
			padding-top: 14px;
			color: var(--neutral-900);
			width: 262px;
			text-align: left;
		}

		#timeline-access-message.error {
			color: red;
			width: 260px;
		}
	</style>

	<div id="timeline-access">

		<form action="<?php echo BASE_URL ?>timeline/?validate" id="timeline-access-form" method="POST" class='theme theme--neutral theme--mode-theme--mode-light'>

			<input id="timeline-access-pass" class="font-body-md" name="timeline-access-pass" type="password" />
			<?php
			echo get_button(array(
				'html_text' => 'Enter',
				'class' => 'btn btn--primary btn--large btn--icon-after',
				'icon' => 'chevron-right',
				'id' => 'timeline-access-submit',
				'type' => 'submit',
			));
			?>

		</form>
		<?php
		if (isset($_GET['err'])):
			echo '<div id="timeline-access-message" class="error font-body-sm">Password Error!</div>';
		else:
			echo '<div id="timeline-access-message" class="font-body-sm">Enter Password</div>';
		endif;
		?>

	</div>

<?php

else:


	$filters = get_terms('timeline_filters', 'timeline');
	$filter_buttons_html = "";
	$filter_n = 0;
	foreach ($filters as $term):
		$filter_n++;
		if ($filter_n > 5):
			$filter_n = 1;
		endif;
		$filter_buttons_html .= get_button(array(
			'html_text' => $term->name,
			//'href' => '#',
			//'target' => 'self',
			'class' => "btn--tag btn--num-{$filter_n} unselectable btn--icon-before btn--show-icon-only-selected",
			'data-slug' => $term->slug,
			'data-filter' => $filter_n,
			'icon' => 'close'
		));
	endforeach;
	//
	$jump_to = get_field('jump_to', 'timeline');
	$years_buttons_html = "";
	foreach ($jump_to as $item):
		$years_buttons_html .= get_button(array(
			'html_text' => get_field('year_period', $item->ID),
			//'href' => '#',
			//'target' => 'self',
			'class' => 'btn--tag unselectable',
			'data-slug' => $item->post_name,
			'data-id' => $item->ID,
			//'icon' => 'close'
		));
	endforeach;

	$global_modules = array(array(
		'acf_fc_layout' => 'cta_banner_vertical',
		'in_a_box' => 0,
		'image_position' => '',
		'background_color' => 'bg-transparent;#00000000',
		'color_palette' => 'theme--neutral;#BDBBB8',
		'color_mode' => 'theme--mode-light',
		'background' => 1,
		'title_size' => 'font-display-sm',
		'tagline' => get_field('tagline', 'timeline'),
		'title' => get_field('title', 'timeline'),
		'heading_tag' => get_field('heading_tag', 'timeline'),
		'heading_tag_tagline' => '',
		'text' => get_field('blurb', 'timeline'),
		'image' => '',
		'button_1' => '',
		'button_2' => '',
		'button_3' => '',
	));

	include 'partials/global-modules.php';

	$note = get_field('note', 'timeline');

?>

	<div class="js-module page-timeline">
		<div class="timeline__filters-and-jumps theme theme--neutral" data-animate='fade-in-up' data-animate-delay='100'>
			<div class="timeline__filters font-label-md">
				<div class="filters__label">FILTER BY</div>
				<?php echo $filter_buttons_html; ?>
			</div>
			<div class="timeline__jumps font-label-md theme theme--neutral">
				<div class="jumps__label">JUMP TO</div>
				<?php echo $years_buttons_html; ?>
			</div>
		</div>

		<div class="page-timeline__scroller theme theme--neutral">
			<div class="page-timeline__items-wrapper">

				<div class="page-timeline__dots-line-mobile-v2-wrapper" data-animate='fade-in-up' data-animate-delay='100'>
					<div class="page-timeline__dots-line-mobile-v2"></div>
				</div>

				<?php

				$timeline = get_field('timeline', 'timeline');

				foreach ($timeline as $post_id):

					$image = get_field('image', $post_id);
					$image_caption = linkify(get_field('image_caption', $post_id));
					$image_icon = get_button(array(
						'class' => 'image__hover-icon btn--primary btn--large btn--icon-after btn--icon-only',
						'icon' => 'expand',
						'tag' => 'div'
					));
					$image_html = "";
					$image_html_mobile = "";
					$image_mobile_class = "";
					if (isset($image['url'])):
						$portrait = $image['width'] / $image['height'] <= 1.2;
						$image_mobile_class = $portrait ? 'portrait' : '';
						$aspect_ratio_mobile = $portrait ? 1.2 : $image['width'] / $image['height'];
						$image_html = "<button class='item__image' aria-label='Open Image' style='aspect-ratio:{$image['width']}/{$image['height']}'><div class='image__img' data-src='{$image['url']}'></div><div class='image__caption'>{$image_caption}</div>{$image_icon}</button>";
						//--> deprecated //$image_html_mobile = "<button class='item__image' aria-label='Open Image' style='aspect-ratio:{$aspect_ratio_mobile}'><div class='image__img {$image_mobile_class}' data-src='{$image['url']}'></div><div class='image__caption'>{$image_caption}</div>{$image_icon}</button>";
						$image_html_mobile = "<button class='item__image {$image_mobile_class}' aria-label='Open Image' style='aspect-ratio:{$image['width']}/{$image['height']}'><div class='image__img {$image_mobile_class}' data-src='{$image['url']}'></div><div class='image__caption'>{$image_caption}</div>{$image_icon}</button>";
					endif;
					//$post_id = get_the_ID();
					$post_filter = wp_get_post_terms($post_id, 'timeline_filters');
					$filter_n = 0;
					$filter_num = 0;
					foreach ($filters as $term):
						$filter_n++;
						if ($term->term_id == $post_filter[0]->term_id):
							$filter_num = $filter_n;
						endif;
					endforeach;
				?>

					<article class="page-timeline__item" data-id="<?php echo $post_id; ?>" data-filter-num="<?php echo $filter_num; ?>" data-filter="<?php echo $post_filter[0]->slug; ?>" data-animate='fade-in-up' data-animate-delay='100'>
						<div class="item__top-area">

							<?php
							echo get_dynamic_heading(
								get_field('year_period', $post_id),
								get_field('heading_tag', $post_id),
								'item__year font-display-xs',
							);
							?>

							<?php echo $image_html; ?>
						</div>
						<div class="item__circle" data-filter-num="<?php echo $filter_num; ?>"></div>
						<div class="item__bottom-area">
							<?php echo $image_html_mobile; ?>
							<?php
							echo get_dynamic_heading(
								get_the_title($post_id),
								get_field('heading_tag', $post_id),
								'item__title font-heading-md',
							);
							?>
							<div class="item__text font-body-sm">
								<?php echo get_field('text', $post_id); ?>
							</div>
						</div>
						</article>

				<?php

				endforeach;

				?>
			</div>
		</div>

		<div class="page-timeline__scroll-buttons  theme theme--neutral" data-animate='fade-in-fast' data-animate-delay='100'>
			<?php

			echo get_button(array(
				'class' => 'scroll-buttons__btn btn--left btn--primary btn--large btn--icon-after btn--icon-only',
				'icon' => 'chevron-left',
			));
			echo get_button(array(
				'class' => 'scroll-buttons__btn btn--right btn--primary btn--large btn--icon-after btn--icon-only',
				'icon' => 'chevron-right',
			));

			?>
		</div>

		<div class="timeline__text-bottom theme theme--neutral" data-animate='fade-in-up' data-animate-delay='200'>
			<div class="text-bottom__txt-wrapper">
				<div class="text-bottom__txt font-body-xs theme__text--primary">
					<?php echo $note; ?>
				</div>
			</div>
		</div>

		<div class="timeline__image-modal theme theme--neutral theme--mode-dark">
			<div class="image-modal__container">
				<?php
				echo get_button(array(
					'class' => 'image-modal__close-btn btn--primary btn--large btn--icon-after btn--icon-only',
					'icon' => 'close',
					'aria-label' => 'Close'
				));
				?>
				<div class="image-modal__img">
					<!-- image here -->
				</div>

				<div class="image-modal__img-caption font-body-sm theme__text--primary"></div>
			</div>
		</div>

	</div>

<?php endif; ?>

<?php get_footer(); ?>