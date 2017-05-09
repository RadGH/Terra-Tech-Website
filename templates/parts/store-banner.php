<?php
global $wp_query;
?>
<aside id="store-banner">
	<div class="banner-product-count">
		<div class="count"><?php echo $wp_query->found_posts; ?></div>
		<div class="label"><?php echo $wp_query->found_posts === 1 ? 'Product' : 'Products'; ?> Found</div>
	</div>
	
	<?php
	if ( is_active_sidebar( 'store-banner' ) ) {
		?>
		<div class="store-banner-widget-area">
			<?php dynamic_sidebar( 'store-banner' ); ?>
		</div>
		<?php
	}
	?>
	
	<?php if ( function_exists('woocommerce_catalog_ordering') ) { ?>
	<div class="banner-sort">
		<span class="sort-label">Sort By:</span>
		<?php woocommerce_catalog_ordering(); ?>
	</div>
	<?php } ?>
</aside>