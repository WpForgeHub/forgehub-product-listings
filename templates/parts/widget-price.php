<?php
/**
 * Sidebar widget: Price range filter.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wpfh-pl-widget wpfh-pl-widget-price">
	<h3 class="wpfh-pl-widget-title">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
		<?php esc_html_e( 'Price Filter', 'forgehub-product-listings' ); ?>
	</h3>
	<div class="wpfh-pl-price-filter-list" role="radiogroup" aria-label="<?php esc_attr_e( 'Price ranges', 'forgehub-product-listings' ); ?>">
		<button type="button" class="wpfh-pl-price-btn is-active" data-price-range="all">
			<span><?php esc_html_e( 'All Prices', 'forgehub-product-listings' ); ?></span>
		</button>
		<button type="button" class="wpfh-pl-price-btn" data-price-range="free">
			<span><?php esc_html_e( 'Free ($0)', 'forgehub-product-listings' ); ?></span>
		</button>
		<button type="button" class="wpfh-pl-price-btn" data-price-range="under-20">
			<span><?php esc_html_e( 'Under $20', 'forgehub-product-listings' ); ?></span>
		</button>
		<button type="button" class="wpfh-pl-price-btn" data-price-range="20-50">
			<span><?php esc_html_e( '$20 - $50', 'forgehub-product-listings' ); ?></span>
		</button>
		<button type="button" class="wpfh-pl-price-btn" data-price-range="50-plus">
			<span><?php esc_html_e( '$50+', 'forgehub-product-listings' ); ?></span>
		</button>
	</div>
</div>
