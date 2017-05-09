<?php
$area = 'sidebar';

if ( is_home() || is_post_type_archive('post')|| is_tax('category') || is_tax('post_tag') || get_post_type() == 'post' ) $area = 'blog';
elseif ( is_front_page() ) $area = 'front-page';
elseif ( is_search() ) $area = 'search';
elseif ( class_exists('WooCommerce') ) {
	if ( is_woocommerce() || is_shop() || is_post_type_archive( 'product' ) ) $area = 'store';
	
	if ( is_tax() ) {
		if ( is_tax( 'rswc_brand' ) ) $area = 'store';
		else if ( is_tax( 'tt_product_group' ) ) $area = 'store';
		else if ( is_tax( 'product_cat' ) ) $area = 'store';
		else if ( is_tax( 'product_tag' ) ) $area = 'store';
	}

	// Checkout and cart page
	if ( get_the_ID() == get_option('woocommerce_cart_page_id')  || get_the_ID() == get_option('woocommerce_checkout_page_id') )
		$area = 'checkout';

}
// If a specific sidebar is empty, fall back to the default
if ( $area !== 'sidebar' && !is_active_sidebar($area) ) $area = 'sidebar';

// ----------------------------------------------------------------

if ( is_active_sidebar( $area ) ) {
	$classes = array( 'sidebar' );
	if ( $area == 'sidebar' ) $classes[] = 'sidebar-default';
	else $classes[] = 'sidebar-' . $area;
	?>
	<aside id="sidebar" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<?php dynamic_sidebar( $area ); ?>
	</aside>
	<?php
}
