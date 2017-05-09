<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Register Custom Taxonomy
function theme_register_product_groups_taxonomy() {
	$labels = array(
		'name'                       => 'Product Group',
		'singular_name'              => 'Product Group',
		'menu_name'                  => 'Product Groups',
		'all_items'                  => 'All Product Groups',
		'parent_item'                => 'Parent Product Group',
		'parent_item_colon'          => 'Parent Product Group:',
		'new_item_name'              => 'New Product Group Name',
		'add_new_item'               => 'Add New Product Group',
		'edit_item'                  => 'Edit Product Group',
		'update_item'                => 'Update Product Group',
		'view_item'                  => 'View Product Group',
		'separate_items_with_commas' => 'Separate product Groups with commas',
		'add_or_remove_items'        => 'Add or remove product Groups',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Product Groups',
		'search_items'               => 'Search Product Group',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No product Groups',
		'items_list'                 => 'Product Groups list',
		'items_list_navigation'      => 'Product Groups list navigation',
	);
	
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'query_var'                  => 'product_group',
		'rewrite'                    => array(
				'slug' => 'group'
		)
	);
	
	register_taxonomy( 'tt_product_group', array( 'product' ), $args );
}
add_action( 'init', 'theme_register_product_groups_taxonomy', 3 );


function theme_disable_adding_terms_to_product_groups( $term, $taxonomy ) {
	if ( $taxonomy === 'tt_product_group' ) return new WP_Error( 'term_addition_blocked', __( 'You cannot add terms to this taxonomy' ) );
	
	return $term;
}
add_action( 'pre_insert_term', 'theme_disable_adding_terms_to_product_groups', 5, 2 );


function theme_warn_no_product_group() {
	if ( !function_exists( 'get_current_screen' ) ) return;
	
	$screen = get_current_screen();
	if ( $screen->id != 'product' ) return;
	
	global $post;
	
	$product_groups = get_the_terms( $post->ID, 'tt_product_group' );
	
	if ( $post->post_status == 'publish' && empty($product_groups) ) {
		?>
		<div class="notice notice-info">
			<p><strong>Warning:</strong> No product group has been selected.</p>
			<p>You should select one of the available product groups to ensure the product appears in the respective sections of the website.</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'theme_warn_no_product_group' );