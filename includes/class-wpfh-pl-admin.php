<?php
/**
 * Settings screen: template picker cards and per-page assignment.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Admin {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	public static function menu() {
		add_options_page(
			__( 'Product Listings', 'forgehub-product-listings' ),
			__( 'Product Listings', 'forgehub-product-listings' ),
			'manage_options',
			'forgehub-product-listings',
			array( __CLASS__, 'render' )
		);
	}

	public static function register() {
		register_setting(
			'wpfh_pl_group',
			WPFH_PL_Templates::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( 'WPFH_PL_Templates', 'sanitize' ),
				'default'           => array(),
			)
		);
	}

	public static function assets( $hook ) {
		if ( 'settings_page_forgehub-product-listings' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wpfh-pl-admin', WPFH_PL_URL . 'assets/css/admin.css', array(), (string) filemtime( WPFH_PL_PATH . 'assets/css/admin.css' ) );
		wp_enqueue_script( 'wpfh-pl-admin', WPFH_PL_URL . 'assets/js/admin.js', array(), (string) filemtime( WPFH_PL_PATH . 'assets/js/admin.js' ), true );
	}

	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$templates   = WPFH_PL_Templates::all();
		$assignments = WPFH_PL_Templates::assignments();
		echo '<div class="wrap wpfh-pl"><h1>' . esc_html__( 'ForgeHub Product Listings', 'forgehub-product-listings' ) . '</h1>';
		echo '<form method="post" action="options.php">';
		settings_fields( 'wpfh_pl_group' );
		foreach ( WPFH_PL_Templates::contexts() as $ctx => $ctx_label ) {
			echo '<h2>' . esc_html( $ctx_label ) . '</h2><div class="wpfh-pl-cards" role="radiogroup">';
			foreach ( $templates as $slug => $label ) {
				$id      = 'wpfh-pl-' . $ctx . '-' . $slug;
				$preview = WPFH_PL_URL . 'assets/img/preview-' . $slug . '.svg';
				echo '<label class="wpfh-pl-card" for="' . esc_attr( $id ) . '">';
				echo '<input type="radio" id="' . esc_attr( $id ) . '" name="' . esc_attr( WPFH_PL_Templates::OPTION . '[' . $ctx . ']' ) . '" value="' . esc_attr( $slug ) . '"' . checked( $assignments[ $ctx ], $slug, false ) . ' />';
				echo '<img src="' . esc_url( $preview ) . '" alt="' . esc_attr( $label ) . '" width="240" height="150" />';
				echo '<span>' . esc_html( $label ) . '</span></label>';
			}
			echo '</div>';
		}
		submit_button();
		echo '</form></div>';
	}
}
