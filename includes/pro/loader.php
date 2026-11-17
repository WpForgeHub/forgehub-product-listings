<?php
/**
 * Pro features loader (this directory is excluded from the Free build).
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/freemius.php';
require_once __DIR__ . '/class-wpfh-pl-pro-category-templates.php';
WPFH_PL_Pro_Category_Templates::init();
