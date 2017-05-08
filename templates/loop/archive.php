<article <?php post_class('loop-archive'); ?>>

	<header class="loop-header">
		<?php the_title( '<h2 class="loop-title"><a href="' . get_permalink() . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="loop-meta">
			<?php if (is_author()): ?>
				Posted on <span class="loop-date"><?php the_time(get_option('date_format')); ?></span>
			<?php else: ?>
				Posted by <span class="loop-author"><?php the_author_posts_link(); ?></span> on <span class="loop-date"><?php the_time(get_option('date_format')); ?></span>
			<?php endif; ?>
		</div>
	</header>

	<div class="loop-body">

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="loop-thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
			</div>
		<?php } ?>

		<div class="loop-summary">
			<?php the_excerpt(); ?>
		</div>

	</div>

</article>
