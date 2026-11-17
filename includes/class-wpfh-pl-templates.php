<?php
/**
 * Template registry and page-context assignments.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Templates {

	const OPTION = 'wpfh_pl_assignments';

	/**
	 * Available templates: slug => label.
	 *
	 * @return array
	 */
	public static function all() {
		return array(
			'sidebar-grid'        => __( 'Sidebar + Grid', 'forgehub-product-listings' ),
			'topbar-grid'         => __( 'Top Bar + Grid', 'forgehub-product-listings' ),
			'category-cards-list' => __( 'Category Cards + List', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Page contexts a template can be assigned to.
	 *
	 * @return array
	 */
	public static function contexts() {
		return array(
			'plugins'  => __( 'Plugins page (/plugins/)', 'forgehub-product-listings' ),
			'shop'     => __( 'Shop page', 'forgehub-product-listings' ),
			'category' => __( 'Product category pages', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Saved assignments with defaults applied.
	 *
	 * @return array
	 */
	public static function assignments() {
		$saved = get_option( self::OPTION, array() );
		$saved = is_array( $saved ) ? $saved : array();
		$all   = self::all();
		$out   = array();
		foreach ( array_keys( self::contexts() ) as $ctx ) {
			$out[ $ctx ] = ( isset( $saved[ $ctx ] ) && isset( $all[ $saved[ $ctx ] ] ) ) ? $saved[ $ctx ] : 'sidebar-grid';
		}
		return $out;
	}

	/**
	 * Sanitizes the posted assignments.
	 *
	 * @param mixed $input Raw input.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$input = is_array( $input ) ? $input : array();
		$all   = self::all();
		$out   = array();
		foreach ( array_keys( self::contexts() ) as $ctx ) {
			$val         = isset( $input[ $ctx ] ) ? sanitize_key( $input[ $ctx ] ) : '';
			$out[ $ctx ] = isset( $all[ $val ] ) ? $val : 'sidebar-grid';
		}
		return $out;
	}
}
