jQuery(function () {
	init_product_search();

	init_product_navigation();

	init_autosubmit_forms();
});

function init_autosubmit_forms() {
	jQuery('form.autosubmit').on('change', ':input', function(e) {
		jQuery(this).closest('form').submit();
	});
}

function init_product_navigation() {
	var $product_nav = jQuery('.product-search-row .product-dropdown');
	if ( $product_nav.length < 1 ) return;

	var $currentHoverTarget = false;

	var closeAllMenuItems = function() {
		$product_nav.find('.menu-open, .menu-hover')
			.removeClass('menu-hover')
			.removeClass('menu-open');
	};

	var menuItemHover = function( $menuItem ) {
		$currentHoverTarget = $menuItem;

		$menuItem.addClass('menu-hover');
	};

	var menuItemActivate = function( $menuItem ) {
		$menuItem.addClass('menu-open');
	};

	var menuItemBlur = function( $menuItem ) {
		// $currentHoverTarget = The element that is hovered over right now. If the item is being blurred, it will match $menuItem.
		// $menuItem = The element to be blurred.

		if ( !$currentHoverTarget || ($currentHoverTarget[0] === $menuItem[0]) ) {
			// The visitor has not hovered over a new item

			$currentHoverTarget = false;
			$menuItem.removeClass('menu-open');
			$menuItem.removeClass('menu-hover');

			// Blur parent items with the same logic
			$menuItem.parents('li').first().each(function() {
				menuItemBlur(jQuery(this));
			});

			return;
		}

		if ( $menuItem.find( $currentHoverTarget[0] ).length < 1 ) {
			// The visitor hovered over a new item, and the new item is not a child of the item in question

			$menuItem.removeClass('menu-open');
			$menuItem.removeClass('menu-hover');

			// Blur parent items with the same logic
			$menuItem.parents('li').first().each(function() {
				menuItemBlur(jQuery(this));
			});
		}
	};

	$product_nav.on( 'close-product-menu', closeAllMenuItems);

	$product_nav.on( 'click', 'a', function() {
		var $link = jQuery(this);
		var $menuItem = $link.closest('li');

		if ( $menuItem.hasClass('menu-open') || !$menuItem.hasClass('cat-has-children') ) {
			// Allow the click to navigate if the menu is already open, or the menu doesn't have any children.
			return true
		}else{
			menuItemActivate( $menuItem );
			return false;
		}
	});

	$product_nav.on( 'mouseover', 'a', function() {
		if ( typeof this.timeout != 'undefined' ) clearTimeout(this.timeout);

		var $link = jQuery(this);
		var $menuItem = $link.closest('li');

		menuItemHover( $menuItem );

		this.timeout = setTimeout(function() {
			menuItemActivate( $menuItem );
		}, 150);
	});

	$product_nav.on( 'mouseout', 'a', function(e) {
		if ( typeof this.timeout != 'undefined' ) clearTimeout(this.timeout);

		var $link = jQuery(this);
		var $menuItem = $link.closest('li');

		this.timeout = setTimeout(function() {
			menuItemBlur( $menuItem );
		}, 150);
	});

	$product_nav.addClass('menu-js').removeClass('menu-no-js');
}



function init_product_search() {
	var $product_button = jQuery('.product-search-button');
	if ( $product_button.length < 1 ) return;

	var $product_nav = jQuery('.product-search-row .product-dropdown');

	var $body = jQuery('body');
	var $site_header = jQuery('.site-header');
	var mobile_open = false;
	var rate_limit = false;

	var $overlay = jQuery('<div>', {class: 'product-search-overlay'}).css('display', 'none');

	var resizeOverlay = function() {
		var overlayTop = $site_header.offset().top + $site_header.outerHeight();
		var overlayHeight = $body.offset().top + $body.height() - overlayTop;

		$overlay
			.css( 'top', overlayTop )
			.css( 'height', overlayHeight );
	};

	var toggleMenuStart = function() {
		$body.addClass('prod-menu-fading');

		$overlay.css('display', mobile_open ? 'block' : 'none' );

		if ( typeof requestAnimationFrame === 'function' ) {
			requestAnimationFrame(function() {
				$body
					.toggleClass('prod-menu-open', mobile_open)
					.toggleClass('prod-menu-close', !mobile_open);
			});
		}else{
			$body
				.toggleClass('prod-menu-open', mobile_open)
				.toggleClass('prod-menu-close', !mobile_open);
		}
	};

	var toggleMenuFinish = function() {
		rate_limit = false;
		$body.removeClass('prod-menu-fading');
	};

	var closeMenu = function() {
		$product_nav.trigger('close-product-menu');
		if ( rate_limit !== false ) clearTimeout(rate_limit);
		mobile_open = false;
	};

	$product_button.click(function(e) {
		if ( rate_limit !== false ) {
			clearTimeout(rate_limit);
			toggleMenuFinish();
		}

		mobile_open = !mobile_open;
		$overlay.css('display', 'block');

		if ( !mobile_open ) closeMenu();
		toggleMenuStart();

		rate_limit = setTimeout(toggleMenuFinish, 300);

		return false;
	});

	$overlay.click(function(e) {
		closeMenu();
		toggleMenuStart();
		return false;
	});

	jQuery(window).on('resize', function() {
		if ( typeof this.timeout == 'undefined' ) this.timeout = false;
		if ( this.timeout ) clearTimeout( this.timeout );

		this.timeout = setTimeout(function() {
			resizeOverlay();
		}, 100);
	});

	$site_header.after( $overlay );

	resizeOverlay();
	toggleMenuStart();
	toggleMenuFinish();
}