<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="site-container">
	<header class="site-header">
		
		<div class="inside wide">
			
			<div class="grid grid-header">
			
				<div class="cell header-left">
					<?php
					// Logo
					if ( $logo_id = get_field( 'logo', 'options', false ) ) {
						if ( $img_tag = wp_get_attachment_image( $logo_id, 'full' ) ) {
							printf( '<a href="%s" title="%s" class="logo">%s</a>', esc_attr( home_url() ), esc_attr( get_bloginfo( 'title' ) ), $img_tag );
						}
					}
					?>
				</div>
				
				<?php
				$cart_item_count = WC()->cart->get_cart_contents_count();
				
				if ( $cart_item_count < 1 ) $cart_text = 'My Cart';
				else if ( $cart_item_count == 1 ) $cart_text = '1 Item';
				else if ( $cart_item_count > 1 ) $cart_text = $cart_item_count . ' Items';
				?>
				<div class="cell header-right">
					
					<div class="subnav-row">
						<nav class="nav-menu nav-user">
							<ul class="nav-list">
								
								<li class="menu-item news"><a href="<?php echo get_post_type_archive_link( 'post' ); ?>">News</a></li>
								
								<?php if ( is_user_logged_in() ) { ?>
									<li class="menu-item account"><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>">My Account</a></li>
								<?php }else{ ?>
									<li class="menu-item login"><a href="<?php echo wp_login_url(get_permalink()); ?>">Log In</a></li>
								<?php } ?>
								
								<li class="menu-item cart"><a href="<?php echo wc_get_cart_url(); ?>"><?php echo $cart_text; ?></a></li>
								
								<li class="menu-item search"><a href="<?php echo add_query_arg(array('s' => ''), site_url()); ?>">Search</a></li>
								
							</ul>
						</nav>
					</div>
					
					<div class="grid product-search-row">
						
						<div class="cell product-menu">
							<a href="#" class="product-search-button" onclick="return false;"><span>Products</span></a>
							
							<ul class="product-dropdown menu-no-js">
								<li class="cat-item cat-item-view-all">
									<a href="<?php echo get_post_type_archive_link('product'); ?>">All Products</a>
								</li>
								<?php
								wp_list_categories(array(
									'title_li' => '',
									'taxonomy' => 'product_cat',
									'hide_empty' => false,
								));
								?>
							</ul>
						</div>
						
						<div class="cell product-search">
							
							<form action="<?php echo get_post_type_archive_link('product'); ?>">
								<input type="text" name="s" id="product-search" placeholder="What are you looking for?">
								<button type="submit"><span class="screen-reader-text">Submit search</span></button>
								<input type="hidden" name="post_type" value="product">
							</form>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
		
		</div>
		
		<?php
		$promo = get_field( 'promotional_strip', 'options' );
		
		if ( $promo ) {
			?>
			<div class="notification-banner"><?php echo $promo; ?></div>
			<?php
		}
		?>
		
	</header>


	<div id="content"<?php if ( apply_filters( "sidebar_enabled", true ) ) {echo ' class=" has-sidebar"';} ?>>
		
		<div class="inside wide">
			<?php
			if ( !is_front_page() ) {
				$breadcrumb_html = rs_get_breadcrumb();
				
				if ( $breadcrumb_html ) {
					?>
					<div class="breadcrumb-row">
						<?php echo $breadcrumb_html; ?>
					</div>
					<?php
				}
			}
			?>
		</div>
		
		<?php
		if ( is_archive() && ( is_shop() || is_post_type_archive('product') || is_woocommerce() ) ) {
			get_template_part( 'templates/parts/store-banner' );
		}