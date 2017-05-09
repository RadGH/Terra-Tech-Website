<?php

/* Template Name: Front Page */

// Note: by default, the WYSIWYG editor is hidden on pages that use this template; see hide_editor() in includes/functions/dashboard.php

add_filter( "sidebar_enabled", "__return_false" ); // disable sidebar

get_header();
?>

	<div class="site-content">
		<main id="main">
			
			<?php
			$title = get_field( "hero_title" );
			$subtitle = get_field( "hero_subtitle" );
			$bg = get_field( "hero_bg" );
			if ( $bg ) {
				$bg = ' style="background-image: url(' . $bg['url'] . ')"';
			}
			?>
			<section class="hero"<?php echo $bg; ?>>
				<div class="inside">
					<h2><?php echo $title; ?></h2>
					<p><?php echo $subtitle; ?></p>
				</div>
			</section>
			
			
			<?php
			$title = get_field( "intro_title" );
			$subtitle = get_field( "intro_subtitle" );
			?>
			<section class="intro">
				<div class="inside">
					<h2><?php echo $title; ?></h2>
					<?php echo $subtitle; ?>
				</div>
			</section>
			
			<section class="store-categories">
				<div class="inside wide">
					<?php
					$suffixes = array(
						"left",
						"right",
					);
					foreach( $suffixes as $suffix ) :
						$title = get_field( "shop_title_" . $suffix );
						$icon = get_field( "shop_icon_" . $suffix );
						$url = get_field( "shop_url_" . $suffix );
						?>
						<div class="store-cat <?php echo $suffix; ?>">
							<a href="<?php echo esc_attr($url); ?>"><span class="screen-reader-text">Go to <?php echo $title; ?></span></a>
							<div class="store-cat-inner">
								<?php if ( $icon ): ?>
									<img src="<?php echo $icon['url']; ?>" alt="<?php echo $title; ?>" />
								<?php endif; ?>
								<div class="cat-title"><?php echo $title; ?></div>
							</div>
						</div>
						<?php
					
					endforeach;
					?>
				</div>
			</section>
			
			<section class="featured products">
				<div class="inside">
					<?php
					$title = get_field('featured_products_title', get_the_ID());
					if ( !$title ) $title = 'Featured Products';
					
					// Prefer featured products, fall back to any products if none found (just the container markup is returned, so check character count)
					$products_shortcode = do_shortcode('[featured_products per_page="4" columns="4" orderby="rand" order="rand"]');
					if ( strlen($products_shortcode) < 100 ) $products_shortcode = do_shortcode('[products per_page="4" columns="4" orderby="rand" order="rand"]');
					?>
					<h2><?php echo $title; ?></h2>
					<?php echo $products_shortcode; ?>
				</div>
			</section>
			
			<?php
			$ads = array(
				'primary' => get_field( 'ad_primary', get_the_ID(), false ),
				'left' => get_field( 'ad_left', get_the_ID(), false ),
				'right' => get_field( 'ad_right', get_the_ID(), false ),
			);
			
			if ( $ads ) foreach( $ads as $k => $v ) {
				$back = !empty($v[0]) ? array_shift($v[0]) : false;
				$front = !empty($v[0]) ? array_shift($v[0]) : false;
				$url = !empty($v[0]) ? array_shift($v[0]) : false;
				
				$ads[$k] = array(
					'back' => !empty($back) ? wp_get_attachment_image_src($back, 'full') : false,
					'front' => !empty($front) ? wp_get_attachment_image_src($front, 'full') : false,
					'url' => !empty($url) ? $url : false,
				);
				
				if ( empty($ads[$k]['back']) && empty($ads[$k]['front']) && empty($ads[$k]['url']) ) unset($ads[$k]);
			}
			
			
			if ( $ads )  {
				?>
				<section class="promos">
					<div class="inside">
						<?php
						foreach( $ads as $k => $v ) {
							$back = $v['back'][0];
							$front = $v['front'][0];
							$url = $v['url'];
							?>
							<div class="promo promo-<?php echo $k; ?>">
								<div class="background-wrap"><div class="background" style="background-image: url(<?php echo $back; ?>);"></div></div>
								<a href="<?php echo $url; ?>"><img src="<?php echo $front; ?>" alt=""></a>
							</div>
							<?php
						}
						?>
					</div>
				</section>
				<?php
			}
			?>
		
		</main>
	</div>

<?php
get_footer();