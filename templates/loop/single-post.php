<article <?php post_class( 'loop-single' ); ?>>

	<header class="loop-header">
		<?php
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
		}

		the_title( '<h1 class="loop-title">', '</h1>' );
		if ( $subtitle = get_field( 'subtitle', get_the_ID() ) ) {
			printf( '<h2 class="loop-subtitle">%s</h2>', $subtitle );
		}
		?>

		<div class="loop-share social-links">
			Share this page: <?php echo implode( generate_sharing_links( 'all', array( 'after_text' => '</span>' . file_get_contents( get_template_directory() . '/includes/images/social_icons.svg' ) ) ) ); ?>
		</div>

		<div class="loop-meta">
			<p>Posted by <span class="loop-author"><?php the_author_posts_link(); ?></span> on <span class="loop-date"><?php the_time( get_option( 'date_format' ) ); ?></span></p>
			<?php if(get_the_category()) { ?><p>Categories: <?php the_category( ', ' ); ?></p><?php } ?>
			<?php echo get_the_tag_list('<p>Tags: ',', ','</p>'); ?>
		</div>
	</header>

	<div class="loop-body">

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="loop-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php } ?>

		<div class="loop-content">
			<?php the_content(); ?>
		</div>

	</div>

	<?php
	// RELATED POSTS: fetch random posts from the same categories
	$catList = array();
	foreach ( get_the_category() as $cat ) {
		$catList[] = $cat->cat_ID;
	}
	$posts = get_posts( array(
		'numberposts'   => 4,
		'no_found_rows' => true,
		'post_type'     => 'post',
		'category'      => implode( $catList, ',' ),
		'orderby'       => 'rand',
		'post__not_in'  => array( $post->ID ),
	) );
	if ( $posts ):
		?>
		<div class="loop-related">
			<h2>Related Stories</h2>
			<div class="related-posts">
				<?php
				foreach ( $posts as $post ) :
					setup_postdata( $post );
					echo '<a href="' . get_the_permalink() . '" class="related-post"><div class="related-post-thumb">';
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'thumbnail-cropped' );
					}elseif ( $logo_id = get_field( 'logo', 'options', false ) ){
						echo wp_get_attachment_image( $logo_id, 'thumbnail', false, array('class'=>'no-featured-image' ));
					}
					echo '</div><span class="related-post-title">' . get_the_title() . '</span>';
					echo '</a>';
				endforeach;
				?>
			</div>
		</div>
	<? endif; ?>

</article>