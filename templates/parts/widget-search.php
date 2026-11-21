<?php
/**
 * Sidebar widget: Live search bar.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_search_id = 'wpfh-pl-sidebar-search-' . wp_rand( 1000, 9999 );
?>
<div class="wpfh-pl-widget wpfh-pl-widget-search">
	<h3 class="wpfh-pl-widget-title">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
		<?php esc_html_e( 'Search Products', 'forgehub-product-listings' ); ?>
	</h3>
	<div class="wpfh-pl-search-wrap">
		<label for="<?php echo esc_attr( $wpfh_pl_search_id ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search products', 'forgehub-product-listings' ); ?></label>
		<svg class="wpfh-pl-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
		<input type="search" id="<?php echo esc_attr( $wpfh_pl_search_id ); ?>" class="wpfh-pl-search-input" placeholder="<?php esc_attr_e( 'Search products...', 'forgehub-product-listings' ); ?>" autocomplete="off" />
		<button type="button" class="wpfh-pl-search-clear" aria-label="<?php esc_attr_e( 'Clear search', 'forgehub-product-listings' ); ?>" style="display:none;">&times;</button>
	</div>
</div>
