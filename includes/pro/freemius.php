<?php
/**
 * Freemius SDK integration for Pro edition.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Main Freemius bootstrap resides in forgehub-product-listings.php.
// Pro-specific Freemius hooks and filters can be attached here.
if ( function_exists( 'wpfh_pl_fs' ) ) {
	wpfh_pl_fs();
}
