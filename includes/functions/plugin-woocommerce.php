<?php

if ( !class_exists('WooCommerce') ) return;
add_theme_support( 'woocommerce' );

/*
Customizations for WooCommerce

	rs_reorganize_woocommerce_hooks()
		Moves/adds/deletes various woocommerce template hooks

	rs_rename_sort_dropdown_verbiage()
		Renames the values of the "Sort By" dropdown on the store page

	rs_remove_default_woocommerce_stylesheets()
		Removes the general stylesheet for woocommerce. This is replaced by woocommerce-custom.css in the theme.

	rs_woocommerce_body_class_for_pages()
		Adds the "woocommerce" class to woocommerce cart and checkout screens

	rs_woocommerce_display_tracking_code_header()
	rs_woocommerce_display_tracking_code_body()
		Displays tracking codes when checkout is completed for WooCommerce

	rs_woocommerce_template_hooks()
		Modifies template hooks for WooCommerce, removing uneeded ones, adding new ones, or moving them around.

	rs_woocommerce_before()
	rs_woocommerce_after()
		Adds markup before and after woocommerce, to give our theme's sidebar and other features.

	rs_woocommerce_custom_title()
		Custom WooCommerce title, to replace the default

	rs_woocommerce_disable_title_breadcrumbs()
		Disable default title & breadcrumbs, and replace hook with a custom title

	rs_woocommerce_filter_shortcodes()
		Enable shortcodes on specific WooCommerce filters

	rs_woocommerce_update_header_image_email()
		Update the header image used for WooCommerce emails
*/

function rs_reorganize_woocommerce_hooks() {
	// Disable WooCommerce "On Sale" div
	add_filter( 'woocommerce_sale_flash', '__return_false' );
	
	// Disable default placement of product page "Sort by" dropdown (see templates/parts/store-banner.php)
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	
	// Disable the line of text that read "Showing all xxx results"
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	
	// Move SKU below title on single products
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	
	// Move price after excerpt
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}
add_action( 'init', 'rs_reorganize_woocommerce_hooks' );

function rs_rename_sort_dropdown_verbiage( $options ) {
	if ( isset($options['menu_order']) ) $options['menu_order'] = 'Default';
	if ( isset($options['popularity']) ) $options['popularity'] = 'Most Popular';
	if ( isset($options['rating']) ) $options['rating'] = 'Highest Rating';
	if ( isset($options['date']) ) $options['date'] = 'Date Added';
	if ( isset($options['price']) ) $options['price'] = 'Price (lowest first)';
	if ( isset($options['price-desc']) ) $options['price-desc'] = 'Price (highest first)';
	return $options;
}
add_filter( 'woocommerce_catalog_orderby', 'rs_rename_sort_dropdown_verbiage', 15 );


function rs_remove_default_woocommerce_stylesheets( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss
	// unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
	// unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'rs_remove_default_woocommerce_stylesheets' );

function rs_woocommerce_body_class_for_pages( $classes ) {
	if ( is_page() ) {
		if ( get_the_ID() == get_option( 'woocommerce_cart_page_id' ) ) $classes[] = 'woocommerce';
		else if ( get_the_ID() == get_option( 'woocommerce_checkout_page_id' ) ) $classes[] = 'woocommerce';
	}

	return $classes;
}
add_filter( 'body_class', 'rs_woocommerce_body_class_for_pages' );


function rs_woocommerce_display_tracking_code_header() {
	// Conversion Codes - Header
	// This occurs when we are on the checkbox page with an order which has been paid for, and can only happen once per order.

	if ( class_exists('WC_Order') && get_the_ID() == get_option('woocommerce_checkout_page_id') ) {
		if ( $order_id = get_query_var('order-received') ) {
			$order = new WC_Order($order_id);

			// If the order is complete, pending, or closed...
			if ( $order && in_array($order->status, array( 'completed', 'processing', 'closed' )) ) {
				// Make sure the code hasn't been displayed for this order
				if ( !get_post_meta($order_id, 'conversion-code-displayed', true) ) {
					// Display the code
					echo get_field( 'tracking_head_checkout', 'options', false );

					// Display the code for the body section later, too.
					add_action( 'body_tracking_code', 'rs_woocommerce_display_tracking_code_body', 30 );

					// Remember that we displayed the code for this order.
					update_post_meta($order_id, 'conversion-code-displayed', true);
				}
			}
		}
	}

}
function rs_woocommerce_display_tracking_code_body() {
	echo get_field( 'tracking_body_checkout', 'options', false );
}
add_action( 'head_tracking_code', 'rs_woocommerce_display_tracking_code_header', 30 );


// Customize the WooCommerce template using hooks
function rs_woocommerce_template_hooks() {
	// Display markup before woocommerce
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	add_action('woocommerce_before_main_content', 'rs_woocommerce_before', 10 );

	// Display markup after woocommerce
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_after_main_content', 'rs_woocommerce_after', 10 );

	if ( is_singular('product') ) {
		// Disable sidebar on single product pages
		add_filter( 'sidebar_enabled', '__return_false' );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}else{
		// Move sidebar into custom hook on other pages
		add_action( 'rs_woocommerce_sidebar_area', 'woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}
}
function rs_woocommerce_before() {
	?>
	<div class="inside site-content">
	<main id="main">
	<?php
}
function rs_woocommerce_after() {
	?>
	</main>
	<?php do_action( 'rs_woocommerce_sidebar_area' ); ?>
	</div>
	<?php
}
add_action( 'wp', 'rs_woocommerce_template_hooks' );


// Custom WooCommerce title
function rs_woocommerce_custom_title() {
	if ( is_archive() ) return;
	if ( is_singular('product') ) return;
	
	?>
	<header class="loop-header">
		<?php
		if ( is_archive() ) {
			// deprecated
			echo '<h1 class="loop-title">', get_the_archive_title(),  '</h1>';
		}else{
			echo '<h1 class="loop-title">', get_the_title(), '</h1>';

			if ( $subtitle = get_field( 'subtitle', get_the_ID() ) ) {
				echo '<h2 class="loop-subtitle">', $subtitle, '</h2>';
			}
		}
		?>
	</header>
	<?php
}
add_action( 'woocommerce_before_main_content', 'rs_woocommerce_custom_title', 80 );


// Disable default title & breadcrumbs, hook breadcrumbs into custom title markup instead
function rs_woocommerce_disable_title_breadcrumbs() {
	add_filter( 'woocommerce_show_page_title', '__return_false', 40 );
	
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
}
add_action( 'init', 'rs_woocommerce_disable_title_breadcrumbs' );

function rs_get_breadcrumb() {
	$args = array(
		'delimiter' => ' <span class="sep">/</span> '
	);
	ob_start();
	
	woocommerce_breadcrumb( $args );
	
	return ob_get_clean();
}

// Enable shortcodes on specific WooCommerce filters
function rs_woocommerce_filter_shortcodes() {
	add_filter( 'woocommerce_email_footer_text', 'do_shortcode', 80 );
}
add_action( 'init', 'rs_woocommerce_filter_shortcodes' );


// Disable Order Notes on checkout screen
function rs_disable_order_notes( $fields ) {
	unset($fields['order']['order_comments']);
	return $fields;
}
//add_filter( 'woocommerce_checkout_fields' , 'rs_disable_order_notes' );