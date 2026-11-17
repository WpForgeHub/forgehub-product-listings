<?php
/**
 * Shared product card part for product listing templates.
 * Expects $product (WC_Product) or $item (array prepared from product).
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_card_product = isset( $wpfh_pl_prod ) ? $wpfh_pl_prod : ( isset( $product ) ? $product : ( isset( $item['product'] ) ? $item['product'] : null ) );

if ( ! $wpfh_pl_card_product instanceof WC_Product ) {
	return;
}

$wpfh_pl_prod_id    = $wpfh_pl_card_product->get_id();
$wpfh_pl_title      = $wpfh_pl_card_product->get_name();
$wpfh_pl_permalink  = $wpfh_pl_card_product->get_permalink();
$wpfh_pl_image_id   = $wpfh_pl_card_product->get_image_id();
$wpfh_pl_short_desc = wp_strip_all_tags( $wpfh_pl_card_product->get_short_description() ? $wpfh_pl_card_product->get_short_description() : $wpfh_pl_card_product->get_description() );
$wpfh_pl_short_desc = wp_trim_words( $wpfh_pl_short_desc, 24, '...' );
$wpfh_pl_price_html = $wpfh_pl_card_product->get_price_html();
$wpfh_pl_raw_price  = (float) $wpfh_pl_card_product->get_price();

// Determine edition: Free, Pro, or Variable with Free/Pro options
$wpfh_pl_slug    = $wpfh_pl_card_product->get_slug();
$wpfh_pl_is_pro  = ( substr( $wpfh_pl_slug, -4 ) === '-pro' );
$wpfh_pl_is_free = ( 0.0 === $wpfh_pl_raw_price || ! $wpfh_pl_card_product->get_price() );
$wpfh_pl_edition = $wpfh_pl_is_pro ? 'pro' : ( $wpfh_pl_is_free ? 'free' : 'all' );

// Get categories
$wpfh_pl_terms     = get_the_terms( $wpfh_pl_prod_id, 'product_cat' );
$wpfh_pl_cat_slugs = array();
$wpfh_pl_cat_names = array();
if ( ! empty( $wpfh_pl_terms ) && ! is_wp_error( $wpfh_pl_terms ) ) {
	foreach ( $wpfh_pl_terms as $wpfh_pl_term ) {
		if ( 'uncategorized' !== $wpfh_pl_term->slug ) {
			$wpfh_pl_cat_slugs[] = $wpfh_pl_term->slug;
			$wpfh_pl_cat_names[] = $wpfh_pl_term->name;
		}
	}
}
if ( empty( $wpfh_pl_cat_names ) ) {
	$wpfh_pl_cat_names[] = __( 'Micro Plugin', 'forgehub-product-listings' );
	$wpfh_pl_cat_slugs[] = 'micro-plugin';
}

$wpfh_pl_cats_attr = implode( ' ', $wpfh_pl_cat_slugs );
?>
<li class="wpfh-pl-card"
	data-id="<?php echo esc_attr( $wpfh_pl_prod_id ); ?>"
	data-title="<?php echo esc_attr( strtolower( $wpfh_pl_title ) ); ?>"
	data-edition="<?php echo esc_attr( $wpfh_pl_edition ); ?>"
	data-price="<?php echo esc_attr( (string) $wpfh_pl_raw_price ); ?>"
	data-cats="<?php echo esc_attr( $wpfh_pl_cats_attr ); ?>">
	<div class="wpfh-pl-card-inner">
		<a class="wpfh-pl-card-media" href="<?php echo esc_url( $wpfh_pl_permalink ); ?>" tabindex="-1" aria-hidden="true">
			<?php if ( $wpfh_pl_image_id ) : ?>
				<?php echo wp_get_attachment_image( $wpfh_pl_image_id, 'medium', false, array( 'class' => 'wpfh-pl-thumb', 'alt' => esc_attr( $wpfh_pl_title ), 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<div class="wpfh-pl-thumb-placeholder">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
				</div>
			<?php endif; ?>
			<span class="wpfh-pl-badge wpfh-pl-badge--<?php echo esc_attr( $wpfh_pl_edition ); ?>">
				<?php echo $wpfh_pl_is_pro ? esc_html__( 'Pro', 'forgehub-product-listings' ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?>
			</span>
		</a>
		<div class="wpfh-pl-card-body">
			<div class="wpfh-pl-card-tags">
				<?php foreach ( $wpfh_pl_cat_names as $wpfh_pl_cname ) : ?>
					<span class="wpfh-pl-tag"><?php echo esc_html( $wpfh_pl_cname ); ?></span>
				<?php endforeach; ?>
			</div>
			<h3 class="wpfh-pl-card-title">
				<a href="<?php echo esc_url( $wpfh_pl_permalink ); ?>">
					<?php echo esc_html( $wpfh_pl_title ); ?>
				</a>
			</h3>
			<p class="wpfh-pl-card-excerpt">
				<?php echo esc_html( $wpfh_pl_short_desc ); ?>
			</p>
			<div class="wpfh-pl-card-footer">
				<div class="wpfh-pl-price">
					<?php echo $wpfh_pl_price_html ? wp_kses_post( $wpfh_pl_price_html ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?>
				</div>
				<a class="wpfh-pl-btn" href="<?php echo esc_url( $wpfh_pl_permalink ); ?>">
					<?php esc_html_e( 'View Details', 'forgehub-product-listings' ); ?> &rarr;
				</a>
			</div>
		</div>
	</div>
</li>
