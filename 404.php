<?php
$sidebarEnabled = apply_filters( "sidebar_enabled", true );

get_header();
?>

	<div class="inside site-content">
		<main id="main">
			<?php
			// load custom 404 template matching first part of the request URL (note: have_posts() is still true when is_404() is true)
			// *** based on post type's slug, NOT the post type itself, e.g. /blog/* uses 404-blog.php, not 404-post.php
			$slug = '';
			$url = parse_url( $_SERVER['REQUEST_URI'] );
			if ( isset( $url['path'] ) ) {
				$slug = sanitize_title_with_dashes( explode( "/", $url['path'] )[1] );
			}
			
			get_template_part( 'templates/loop/404', $slug );
			?>
		</main>

		<?php get_sidebar(); ?>

	</div>

<?php
get_footer();