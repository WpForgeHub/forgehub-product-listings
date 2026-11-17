<?php
/**
 * Plugin Name:       ForgeHub Product Listings
 * Plugin URI:        https://wpforgehub.com/plugins/forgehub-product-listings/
 * Description:       Choose a ready-made layout for your plugin catalog, shop and category pages, and assign a template per page.
 * Version:           1.0.0
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

define( 'WPFH_PL_VERSION', '1.0.0' );
define( 'WPFH_PL_FILE', __FILE__ );
define( 'WPFH_PL_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPFH_PL_URL', plugin_dir_url( __FILE__ ) );

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
