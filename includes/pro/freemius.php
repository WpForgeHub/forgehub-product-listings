<?php
/**
 * Freemius bootstrap placeholder (id / public_key to be filled after product creation).
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpfh_pl_fs' ) ) {
	/**
	 * Returns the Freemius instance, or null until the SDK is bundled.
	 *
	 * @return object|null
	 */
	function wpfh_pl_fs() {
		global $wpfh_pl_fs;
		if ( isset( $wpfh_pl_fs ) ) {
			return $wpfh_pl_fs;
		}
		$sdk = WPFH_PL_PATH . 'freemius/start.php';
		if ( ! file_exists( $sdk ) ) {
			return null;
		}
		require_once $sdk;
		$wpfh_pl_fs = fs_dynamic_init(
			array(
				'id'             => 'FS_PRODUCT_ID_PLACEHOLDER',
				'slug'           => 'forgehub-product-listings',
				'type'           => 'plugin',
				'public_key'     => 'pk_PLACEHOLDER',
				'is_premium'     => false,
				'has_addons'     => false,
				'has_paid_plans' => true,
				'menu'           => array( 'slug' => 'forgehub-product-listings', 'support' => false ),
			)
		);
		return $wpfh_pl_fs;
	}
}
