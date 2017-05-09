<?php

// Include Files
include_once 'includes/functions/general.php'; // general functions, customizations
include_once 'includes/functions/dashboard.php'; // logged-in customizations; includes login screen, dashboard, editor, etc
include_once 'includes/functions/dashboard-settings.php'; // adds fields to Settings pages, incl new image sizes and email addresses
include_once 'includes/functions/rss.php'; // improves RSS feeds, adds featured images and image size, cleanup defaults
include_once 'includes/functions/forestry-horticulture.php'; // Adds a new taxonomy used to tag products as either Horticulture or Forestry
include_once 'includes/functions/plugin-acf.php'; // ACF extensions
include_once 'includes/functions/plugin-yoast.php'; // Yoast extensions
include_once 'includes/functions/plugin-woocommerce.php'; // WooCommerce extensions

// Theme Configuration
function theme_scripts() {
	$theme = wp_get_theme();
	$theme_version = $theme->get( 'Version' );

	wp_enqueue_style( 'woocommerce-theme', get_template_directory_uri() . '/woocommerce-custom.css', array(), $theme_version );
	wp_enqueue_style( get_stylesheet(), get_stylesheet_uri(), array(), $theme_version );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/includes/assets/main.js' , array('jquery'), $theme_version );
	
	// Titles: 'Patua One', 'Segoe UI', Helvetica, Arial, sans-serif;
	// Subtitles, Buttons: 'Jockey One', 'Segoe UI', Helvetica, Arial, sans-serif;
	// Content: 'Segoe UI', Helvetica, Arial, sans-serif;
	wp_enqueue_style( 'theme-google-fonts', '//fonts.googleapis.com/css?family=Jockey+One|Patua+One' );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

function theme_setup() {

	// 1. Theme Features
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	
	// 2. Menus
	$menus = array(
		'footer_first'   => 'Footer - First',
		'footer_second' => 'Footer - Second',
		'footer_third' => 'Footer - Third',
	);
	register_nav_menus($menus);
	
	// 3. Sidebars
	$sidebars = array(
		'sidebar'    => array(
			'Sidebar',
			'Default sidebar.',
		),
		'store'      => array(
			'Store',
			'WooCommerce store sidebar.',
		),
		'store-banner'      => array(
			'Store banner',
			'A banner along the top of the store.',
		),
		'checkout'   => array(
			'Checkout',
			'WooCommerce checkout page sidebar.',
		),
	);

	foreach ( $sidebars as $key => $bar ) {
		register_sidebar( array(
			'id'          => $key,
			'name'        => $bar[0],
			'description' => $bar[1],

			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
	}
	
	// 4. Shortcodes
	add_shortcode( 'year', function () { return date('Y'); } );
}
add_action( 'after_setup_theme', 'theme_setup' );


function tt_register_widgets() {
	include_once 'includes/widgets/class-tt-product-group-widget.php';
	register_widget( 'TT_Widget_Product_Group' );
}
add_action( 'widgets_init', 'tt_register_widgets' );