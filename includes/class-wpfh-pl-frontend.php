<?php
/**
 * Front end: renders the assigned template via the [wpfh_product_listing] shortcode.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Frontend {

	public static function init() {
		add_shortcode( 'wpfh_product_listing', array( __CLASS__, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	public static function assets() {
		wp_enqueue_style( 'wpfh-pl-front', WPFH_PL_URL . 'assets/css/front.css', array(), (string) filemtime( WPFH_PL_PATH . 'assets/css/front.css' ) );
	}

	/**
	 * Detects the current page context.
	 *
	 * @return string
	 */
	public static function context() {
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			return 'category';
		}
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			return 'shop';
		}
		return 'plugins';
	}

	public static function shortcode( $atts ) {
		$atts        = shortcode_atts( array( 'template' => '' ), $atts, 'wpfh_product_listing' );
		$assignments = WPFH_PL_Templates::assignments();
		$all         = WPFH_PL_Templates::all();
		$slug        = sanitize_key( $atts['template'] );
		if ( ! isset( $all[ $slug ] ) ) {
			$slug = $assignments[ self::context() ];
		}
		$file = WPFH_PL_PATH . 'templates/' . $slug . '/template.php';
		if ( ! file_exists( $file ) || ! function_exists( 'wc_get_products' ) ) {
			return '';
		}
		$products = wc_get_products( array( 'status' => 'publish', 'limit' => 48 ) );
		ob_start();
		include $file;
		return ob_get_clean();
	}
}
