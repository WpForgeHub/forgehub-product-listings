<?php
/**
 * Front end: renders the assigned template via shortcodes and archive overrides.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Frontend {

	public static function init() {
		// Both shortcodes for maximum compatibility
		add_shortcode( 'wpfh_product_listing', array( __CLASS__, 'render_shortcode' ) );
		add_shortcode( 'forgehub_listing', array( __CLASS__, 'render_shortcode' ) );

		add_action( 'widgets_init', array( __CLASS__, 'register_sidebars' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'template_redirect', array( __CLASS__, 'archive_override' ) );
	}

	public static function register_sidebars() {
		register_sidebar(
			array(
				'name'          => __( 'ForgeHub Product Listings Sidebar', 'forgehub-product-listings' ),
				'id'            => 'wpfh-pl-sidebar',
				'description'   => __( 'Widgets placed here will appear in the Product Listings sidebar.', 'forgehub-product-listings' ),
				'before_widget' => '<div id="%1$s" class="wpfh-pl-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="wpfh-pl-widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	public static function assets() {
		$css_file = WPFH_PL_PATH . 'assets/css/front.css';
		$js_file  = WPFH_PL_PATH . 'assets/js/front.js';

		$css_ver = file_exists( $css_file ) ? (string) filemtime( $css_file ) : WPFH_PL_VERSION;
		$js_ver  = file_exists( $js_file ) ? (string) filemtime( $js_file ) : WPFH_PL_VERSION;

		wp_register_style( 'wpfh-pl-front', WPFH_PL_URL . 'assets/css/front.css', array(), $css_ver );
		wp_register_script( 'wpfh-pl-front', WPFH_PL_URL . 'assets/js/front.js', array(), $js_ver, true );

		// Enqueue automatically on relevant pages or when shortcode runs
		if ( self::should_enqueue() ) {
			wp_enqueue_style( 'wpfh-pl-front' );
			wp_enqueue_script( 'wpfh-pl-front' );
		}
	}

	public static function should_enqueue() {
		if ( is_admin() ) {
			return false;
		}
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			return true;
		}
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			return true;
		}
		if ( is_page( 'plugins' ) ) {
			return true;
		}
		return false;
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

	/**
	 * Renders shortcode output.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render_shortcode( $atts = array() ) {
		wp_enqueue_style( 'wpfh-pl-front' );
		wp_enqueue_script( 'wpfh-pl-front' );

		$atts = shortcode_atts(
			array(
				'template'         => '',
				'limit'            => 100,
				'category'         => '',
				'columns'             => '',
				'sidebar_position'    => '',
				'container_width'     => '',
				'sidebar_width'       => '',
				'widgets'             => '',
				'recent_count'        => '',
				'card_layout'         => '',
				'card_image_ratio'    => '',
				'image_ratio'         => '',
				'card_excerpt_length' => '',
				'excerpt_length'      => '',
				'card_button_text'    => '',
				'button_text'         => '',
				'card_elements'       => '',
				'elements'            => '',
			),
			$atts,
			'forgehub_listing'
		);

		$assignments = WPFH_PL_Templates::assignments();
		$all         = WPFH_PL_Templates::all();
		$slug        = sanitize_key( $atts['template'] );

		if ( ! isset( $all[ $slug ] ) ) {
			$ctx  = self::context();
			$slug = isset( $assignments[ $ctx ] ) ? $assignments[ $ctx ] : 'sidebar-grid';
		}

		$slug = apply_filters( 'wpfh_pl_template_slug', $slug, $atts );
		$file = WPFH_PL_PATH . 'templates/' . $slug . '/template.php';

		if ( ! file_exists( $file ) || ! function_exists( 'wc_get_products' ) ) {
			return '';
		}

		$query_args = array(
			'status'  => 'publish',
			'limit'   => (int) $atts['limit'],
			'orderby' => 'title',
			'order'   => 'ASC',
		);

		if ( ! empty( $atts['category'] ) ) {
			$query_args['category'] = array_map( 'trim', explode( ',', $atts['category'] ) );
		}

		$products       = wc_get_products( $query_args );
		$wpfh_pl_layout = WPFH_PL_Templates::get_layout_config( $atts );

		ob_start();
		include $file;
		return ob_get_clean();
	}

	/**
	 * WooCommerce Archive / Category Override if enabled by theme/template filter.
	 */
	public static function archive_override() {
		if ( is_admin() ) {
			return;
		}

		// Optional filter to enable full archive loop replacement
		if ( apply_filters( 'wpfh_pl_enable_archive_override', false ) ) {
			if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) ) {
				// Prevent standard WC product loop, render template via filter
				add_filter( 'template_include', array( __CLASS__, 'override_template_file' ), 99 );
			}
		}
	}

	public static function override_template_file( $template ) {
		return $template;
	}
}
