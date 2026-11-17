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

if ( ! isset( $product ) && isset( $item['product'] ) ) {
	$product = $item['product'];
}

if ( ! $product instanceof WC_Product ) {
	return;
}

$prod_id    = $product->get_id();
$title      = $product->get_name();
$permalink  = $product->get_permalink();
$image_id   = $product->get_image_id();
$short_desc = wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() );
$short_desc = wp_trim_words( $short_desc, 24, '...' );
$price_html = $product->get_price_html();
$raw_price  = (float) $product->get_price();

// Determine edition: Free, Pro, or Variable with Free/Pro options
$slug     = $product->get_slug();
$is_pro   = ( substr( $slug, -4 ) === '-pro' );
$is_free  = ( 0.0 === $raw_price || ! $product->get_price() );
$edition  = $is_pro ? 'pro' : ( $is_free ? 'free' : 'all' );

// Get categories
$terms    = get_the_terms( $prod_id, 'product_cat' );
$cat_slugs = array();
$cat_names = array();
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		if ( 'uncategorized' !== $term->slug ) {
			$cat_slugs[] = $term->slug;
			$cat_names[] = $term->name;
		}
	}
}
if ( empty( $cat_names ) ) {
	$cat_names[] = __( 'Micro Plugin', 'forgehub-product-listings' );
	$cat_slugs[] = 'micro-plugin';
}

$cats_attr = esc_attr( implode( ' ', $cat_slugs ) );
?>
<li class="wpfh-pl-card"
	data-id="<?php echo esc_attr( $prod_id ); ?>"
	data-title="<?php echo esc_attr( strtolower( $title ) ); ?>"
	data-edition="<?php echo esc_attr( $edition ); ?>"
	data-price="<?php echo esc_attr( $raw_price ); ?>"
	data-cats="<?php echo $cats_attr; ?>">
	<div class="wpfh-pl-card-inner">
		<a class="wpfh-pl-card-media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'medium', false, array( 'class' => 'wpfh-pl-thumb', 'alt' => esc_attr( $title ), 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<div class="wpfh-pl-thumb-placeholder">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
				</div>
			<?php endif; ?>
			<span class="wpfh-pl-badge wpfh-pl-badge--<?php echo esc_attr( $edition ); ?>">
				<?php echo $is_pro ? esc_html__( 'Pro', 'forgehub-product-listings' ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?>
			</span>
		</a>
		<div class="wpfh-pl-card-body">
			<div class="wpfh-pl-card-tags">
				<?php foreach ( $cat_names as $cname ) : ?>
					<span class="wpfh-pl-tag"><?php echo esc_html( $cname ); ?></span>
				<?php endforeach; ?>
			</div>
			<h3 class="wpfh-pl-card-title">
				<a href="<?php echo esc_url( $permalink ); ?>">
					<?php echo esc_html( $title ); ?>
				</a>
			</h3>
			<p class="wpfh-pl-card-excerpt">
				<?php echo esc_html( $short_desc ); ?>
			</p>
			<div class="wpfh-pl-card-footer">
				<div class="wpfh-pl-price">
					<?php echo $price_html ? wp_kses_post( $price_html ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?>
				</div>
				<a class="wpfh-pl-btn" href="<?php echo esc_url( $permalink ); ?>">
					<?php esc_html_e( 'View Details', 'forgehub-product-listings' ); ?> &rarr;
				</a>
			</div>
		</div>
	</div>
</li>
