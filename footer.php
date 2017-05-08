</div>

<footer class="site-footer">
	<div class="inside">
		
		<div class="grid footer-grid">
				
			<?php
			$locations = array(
				'footer_first',
				'footer_second',
				'footer_third',
			);
			
			$menu_ids_by_location = get_nav_menu_locations();
			
			foreach( $locations as $location ) {
				if ( has_nav_menu( $location ) ) {
					$menu_id = $menu_ids_by_location[ $location ];
					$object = wp_get_nav_menu_object( $menu_id );
					$name = $object->name;
					$args = array(
						'theme_location' => $location,
						'container'      => '',
						'container_id'   => '',
						'menu_class'     => '',
						'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
					);
					
					?>
					<div class="cell">
						<h2><?php echo $name; ?></h2>
						<nav><?php wp_nav_menu( $args ); ?></nav>
					</div>
					<?php
				}
			}
			?>
			
			<div class="cell signup">
				
				<p>Sign up today for emails with exclusive offers,
				   sales &amp; tips in the industry.</p>
				
				<!-- Begin MailChimp Signup Form -->
				<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
				<style type="text/css">
					#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
					/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
					   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
				</style>
				<div id="mc_embed_signup">
					<form action="//radleygh.us3.list-manage.com/subscribe/post?u=6630e6e0dd9d2b2f105fc753c&amp;id=1b371c55b4" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div id="mc_embed_signup_scroll">
							
							<div class="mc-field-group">
								<label for="mce-EMAIL" class="screen-reader-text">Email Address </label>
								<input type="email" value="" name="EMAIL" class="required email" placeholder="Email Address" id="mce-EMAIL">
								<input type="submit" value="SIGN UP" name="subscribe" id="mc-embedded-subscribe" class="button">
							</div>
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_6630e6e0dd9d2b2f105fc753c_1b371c55b4" tabindex="-1" value=""></div>
						</div>
					</form>
				</div>
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
				<!--End mc_embed_signup-->
				
			</div>
			
			<div class="cell connect-with-us">
				<h2>Connect With Us:</h2>
				<?php
				// SOCIAL MEDIA
				// developer: edit the $socialsites array below and/or the Social Media ACF field group to prevent the client adding sites that haven't been styled
				// this code also appears in includes/widgets/socialMediaButtons.php
				$socialsites = array(
					"facebook" => 'Facebook',
					"twitter"  => 'Twitter',
					"youtube"  => 'Youtube',
					"linkedin" => 'LinkedIn',
				);
				$socialoutput = '';
				$svg = file_get_contents( get_template_directory() . '/includes/images/social_icons.svg' );
				foreach( $socialsites as $site => $sitename ) {
					// Remove paths that are not for the given site
					$icon_svg = preg_replace( '/^<path class="((?!'. $site .').)*$/m', '', $svg );
					
					if ( $url = get_field( $site . '_url', 'options' ) ) {
						$socialoutput .= '<li class="social-' . $site . '"><a href="' . $url . '" target="_blank" rel="external"><span class="screen-reader-text">' . $sitename . '</span>' . $icon_svg . '</a></li>';
					}
				}
				if ( $socialoutput ) {
					echo '<ul class="nav-menu nav-social social-links">', $socialoutput, '</ul>';
				}
				?>
			</div>
		</div>
		
	</div>
</footer>

</div>


<?php
// Mobile Nav Menu
if ( has_nav_menu( 'mobile_primary' ) || has_nav_menu( 'mobile_secondary' ) ) {

	?>

	<div id="mobile-nav">

		<div class="inside">
			<div class="mobile-menu">
				<?php
				// Mobile - Primary Menu
				if ( has_nav_menu( 'mobile_primary' ) ) {
					$args = array(
						'theme_location' => 'mobile_primary',
						'menu'           => 'Mobile - Primary',
						'container'      => '',
						'container_id'   => '',
						'menu_class'     => '',
						'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
					);

					echo '<nav class="nav-menu nav-mobile nav-primary">';
					wp_nav_menu( $args );
					echo '</nav>';
				}

				// Mobile - Secondary Menu
				if ( has_nav_menu( 'mobile_secondary' ) ) {
					$args = array(
						'theme_location' => 'mobile_secondary',
						'menu'           => 'Mobile - Secondary',
						'container'      => '',
						'container_id'   => '',
						'menu_class'     => '',
						'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
					);

					echo '<nav class="nav-menu nav-mobile nav-secondary">';
					wp_nav_menu( $args );
					echo '</nav>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

?>

<?php wp_footer(); ?>

</body>
</html>