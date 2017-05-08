jQuery(function () {
	init_product_search();
});

function init_product_search() {
	var $product_button = jQuery('.product-search-button');
	if ( $product_button.length < 1 ) return;

	var $html = jQuery('html');
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

	$product_button.click(function(e) {
		if ( rate_limit !== false ) {
			clearTimeout(rate_limit);
			toggleMenuFinish();
		}

		mobile_open = !mobile_open;
		$overlay.css('display', 'block');

		toggleMenuStart();

		rate_limit = setTimeout(toggleMenuFinish, 300);

		return false;
	});

	$overlay.click(function(e) {
		clearTimeout(rate_limit);
		mobile_open = false;
		toggleMenuStart();
		toggleMenuFinish();
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