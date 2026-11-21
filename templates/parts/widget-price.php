<?php
/**
 * Sidebar widget: Price range filter.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$wpfh_pl_currency = function_exists( 'get_woocommerce_currency_symbol' ) ? html_entity_decode( get_woocommerce_currency_symbol(), ENT_QUOTES, 'UTF-8' ) : '$';
$wpfh_pl_brackets = apply_filters(
	'wpfh_pl_price_brackets',
	array(
		array(
			'slug'  => 'free',
			/* translators: %s: Currency symbol */
			'label' => sprintf( __( 'Free (%s0)', 'forgehub-product-listings' ), $wpfh_pl_currency ),
			'min'   => 0,
			'max'   => 0,
		),
		array(
			'slug'  => 'under-20',
			/* translators: %s: Currency symbol */
			'label' => sprintf( __( 'Under %s20', 'forgehub-product-listings' ), $wpfh_pl_currency ),
			'min'   => 0,
			'max'   => 20,
		),
		array(
			'slug'  => '20-50',
			/* translators: 1: Currency symbol, 2: Currency symbol */
			'label' => sprintf( __( '%1$s20 - %2$s50', 'forgehub-product-listings' ), $wpfh_pl_currency, $wpfh_pl_currency ),
			'min'   => 20,
			'max'   => 50,
		),
		array(
			'slug'  => '50-plus',
			/* translators: %s: Currency symbol */
			'label' => sprintf( __( '%s50+', 'forgehub-product-listings' ), $wpfh_pl_currency ),
			'min'   => 50,
			'max'   => '',
		),
	),
	$wpfh_pl_currency
);
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
		<?php foreach ( $wpfh_pl_brackets as $wpfh_pl_b ) : ?>
			<button type="button" class="wpfh-pl-price-btn" data-price-range="<?php echo esc_attr( $wpfh_pl_b['slug'] ); ?>" data-min="<?php echo esc_attr( (string) ( $wpfh_pl_b['min'] ?? '' ) ); ?>" data-max="<?php echo esc_attr( (string) ( $wpfh_pl_b['max'] ?? '' ) ); ?>">
				<span><?php echo esc_html( $wpfh_pl_b['label'] ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
</div>
