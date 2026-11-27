<?php
/**
 * Plugin Name:       ForgeHub Product Listings
 * Plugin URI:        https://wpforgehub.com/plugins/forgehub-product-listings/
 * Description:       Choose a ready-made layout for your plugin catalog, shop and category pages, and assign a template per page.
 * Version:           1.0.5
 * Author:            WPForgeHub
 * Author URI:        https://wpforgehub.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       forgehub-product-listings
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPFH_PL_VERSION', '1.0.5' );
define( 'WPFH_PL_FILE', __FILE__ );
define( 'WPFH_PL_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPFH_PL_URL', plugin_dir_url( __FILE__ ) );

/**
 * Freemius SDK helper wrapper
 */
if ( ! function_exists( 'wpfh_pl_fs' ) ) {
	function wpfh_pl_fs() {
		global $wpfh_pl_fs;

		if ( ! isset( $wpfh_pl_fs ) ) {
			$fs_path = WPFH_PL_PATH . 'freemius/start.php';
			if ( file_exists( $fs_path ) ) {
				require_once $fs_path;
				$wpfh_pl_fs = fs_dynamic_init( array(
					'id'             => '45298',
					'slug'           => 'forgehub-product-listings',
					'type'           => 'plugin',
					'public_key'     => 'pk_69a50c0ad07134126cbc83fd6a56f',
					'is_premium'     => false,
					'has_addons'     => false,
					'has_paid_plans' => true,
					'menu'           => array(
						'slug'       => 'forgehub-product-listings',
						'first-path' => 'options-general.php?page=forgehub-product-listings',
						'parent'     => array(
							'slug' => 'options-general.php',
						),
					),
				) );
				// Freemius forbids uninstall.php in premium builds; use its after_uninstall hook there.
				$wpfh_pl_fs->add_action( 'after_uninstall', 'wpfh_pl_uninstall_cleanup' );
			} else {
				// Clean fallback for standard WordPress distribution
				$wpfh_pl_fs = new class {
					public function can_use_premium_code() {
						// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
						return (bool) apply_filters( 'fs_can_use_premium_code__forgehub-product-listings', false );
					}
					public function is__premium_only() { return false; }
					public function is_plan( $plan ) {
						// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
						return (bool) apply_filters( 'fs_is_plan__forgehub-product-listings', false, $plan );
					}
					public function get_upgrade_url() {
						return 'https://wpforgehub.com/product/product-listings/#pricing';
					}
				};
			}
		}

		return $wpfh_pl_fs;
	}

	// Init Freemius.
	wpfh_pl_fs();
}

/**
 * Removes plugin options and termmeta (Freemius premium build; free build uses uninstall.php).
 */
function wpfh_pl_uninstall_cleanup() {
	delete_option( 'wpfh_pl_settings' );
	delete_option( 'wpfh_pl_assignments' );

	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- uninstall cleanup.
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '%wpfh_pl_%'" );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- uninstall cleanup.
	$wpdb->query( "DELETE FROM {$wpdb->termmeta} WHERE meta_key LIKE 'wpfh_pl_%'" );
}

require_once WPFH_PL_PATH . 'includes/class-wpfh-pl-templates.php';
require_once WPFH_PL_PATH . 'includes/class-wpfh-pl-admin.php';
require_once WPFH_PL_PATH . 'includes/class-wpfh-pl-frontend.php';

// Pro code lives only in includes/pro (stripped from the Free build).
if ( file_exists( WPFH_PL_PATH . 'includes/pro/loader.php' ) ) {
	require_once WPFH_PL_PATH . 'includes/pro/loader.php';
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpfh_pl_action_links' );

/**
 * Adds the Settings link on the Plugins screen.
 *
 * @param array $links Existing links.
 * @return array
 */
function wpfh_pl_action_links( $links ) {
	$url = admin_url( 'options-general.php?page=forgehub-product-listings' );
	array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'forgehub-product-listings' ) . '</a>' );
	return $links;
}

WPFH_PL_Admin::init();
WPFH_PL_Frontend::init();

add_action( 'admin_notices', function() {
	if ( ! class_exists( 'WooCommerce' ) && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="notice notice-warning is-dismissible"><p><strong>' . esc_html__( 'ForgeHub Product Listings:', 'forgehub-product-listings' ) . '</strong> ' . esc_html__( 'WooCommerce is required to display product listings. Please install and activate WooCommerce.', 'forgehub-product-listings' ) . '</p></div>';
	}
} );
