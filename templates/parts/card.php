<?php
/**
 * Shared product card part for product listing templates.
 * Expects $product (WC_Product) or $item (array prepared from product).
 * Supports customizable layout, image ratios, and granular element visibility.
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
$wpfh_pl_price_html = $wpfh_pl_card_product->get_price_html();

if ( $wpfh_pl_card_product->is_type( 'variable' ) ) {
	$wpfh_pl_min_price = (float) $wpfh_pl_card_product->get_variation_price( 'min', true );
	$wpfh_pl_max_price = (float) $wpfh_pl_card_product->get_variation_price( 'max', true );
} else {
	$wpfh_pl_min_price = (float) $wpfh_pl_card_product->get_price();
	$wpfh_pl_max_price = $wpfh_pl_min_price;
}

/**
 * Filter the min/max price bounds used for card data attributes and price-range filtering.
 *
 * @param array      $bounds  Associative array with 'min' and 'max' floats.
 * @param WC_Product $product The WooCommerce product object.
 */
$wpfh_pl_price_bounds = apply_filters(
	'wpfh_pl_card_price_bounds',
	array(
		'min' => $wpfh_pl_min_price,
		'max' => $wpfh_pl_max_price,
	),
	$wpfh_pl_card_product
);
if ( is_array( $wpfh_pl_price_bounds ) ) {
	if ( isset( $wpfh_pl_price_bounds['min'] ) && is_numeric( $wpfh_pl_price_bounds['min'] ) ) {
		$wpfh_pl_min_price = (float) $wpfh_pl_price_bounds['min'];
	}
	if ( isset( $wpfh_pl_price_bounds['max'] ) && is_numeric( $wpfh_pl_price_bounds['max'] ) ) {
		$wpfh_pl_max_price = (float) $wpfh_pl_price_bounds['max'];
	}
}

/**
 * Filter the formatted price HTML displayed on the product listing card.
 *
 * @param string     $price_html Formatted price HTML.
 * @param WC_Product $product    The WooCommerce product object.
 * @param float      $min_price  Effective minimum price.
 * @param float      $max_price  Effective maximum price.
 */
$wpfh_pl_price_html = apply_filters( 'wpfh_pl_card_price_html', $wpfh_pl_price_html, $wpfh_pl_card_product, $wpfh_pl_min_price, $wpfh_pl_max_price );
$wpfh_pl_raw_price  = $wpfh_pl_max_price > 0.0 ? $wpfh_pl_max_price : $wpfh_pl_min_price;

// Retrieve layout & card design configuration
$wpfh_pl_layout      = isset( $wpfh_pl_layout ) && is_array( $wpfh_pl_layout ) ? $wpfh_pl_layout : WPFH_PL_Templates::get_settings();
$wpfh_pl_card_layout = isset( $wpfh_pl_layout['card_layout'] ) ? $wpfh_pl_layout['card_layout'] : 'vertical';
$wpfh_pl_img_ratio   = isset( $wpfh_pl_layout['card_image_ratio'] ) ? $wpfh_pl_layout['card_image_ratio'] : '16:9';
$wpfh_pl_elements    = isset( $wpfh_pl_layout['card_elements'] ) && is_array( $wpfh_pl_layout['card_elements'] ) ? $wpfh_pl_layout['card_elements'] : array( 'image', 'badge', 'categories', 'title', 'excerpt', 'price', 'button' );
$wpfh_pl_exc_len     = isset( $wpfh_pl_layout['card_excerpt_length'] ) ? absint( $wpfh_pl_layout['card_excerpt_length'] ) : 12;
$wpfh_pl_btn_text    = ! empty( $wpfh_pl_layout['card_button_text'] ) ? $wpfh_pl_layout['card_button_text'] : __( 'View Details', 'forgehub-product-listings' );

$wpfh_pl_show_img    = in_array( 'image', $wpfh_pl_elements, true ) && ( 'hidden' !== $wpfh_pl_img_ratio );
$wpfh_pl_show_badge  = in_array( 'badge', $wpfh_pl_elements, true );
$wpfh_pl_show_cats   = in_array( 'categories', $wpfh_pl_elements, true );
$wpfh_pl_show_title  = in_array( 'title', $wpfh_pl_elements, true );
$wpfh_pl_show_exc    = in_array( 'excerpt', $wpfh_pl_elements, true ) && ( $wpfh_pl_exc_len > 0 );
$wpfh_pl_show_price  = in_array( 'price', $wpfh_pl_elements, true );
$wpfh_pl_show_btn    = in_array( 'button', $wpfh_pl_elements, true );

$wpfh_pl_short_desc = wp_strip_all_tags( $wpfh_pl_card_product->get_short_description() ? $wpfh_pl_card_product->get_short_description() : $wpfh_pl_card_product->get_description() );
if ( $wpfh_pl_show_exc && $wpfh_pl_exc_len > 0 ) {
	$wpfh_pl_short_desc = wp_trim_words( $wpfh_pl_short_desc, $wpfh_pl_exc_len, '...' );
}

// Determine edition: Free, Pro, or Variable with Free/Paid options.
$wpfh_pl_slug     = $wpfh_pl_card_product->get_slug();
$wpfh_pl_is_pro   = ( substr( $wpfh_pl_slug, -4 ) === '-pro' );
$wpfh_pl_has_free = ( 0.0 === $wpfh_pl_min_price );
$wpfh_pl_has_paid = ( $wpfh_pl_max_price > 0.0 );

if ( $wpfh_pl_is_pro ) {
	$wpfh_pl_edition     = 'pro';
	$wpfh_pl_badge_label = __( 'Pro', 'forgehub-product-listings' );
} elseif ( $wpfh_pl_has_free && $wpfh_pl_has_paid ) {
	$wpfh_pl_edition     = 'all';
	$wpfh_pl_badge_label = __( 'Free / Pro', 'forgehub-product-listings' );
} elseif ( $wpfh_pl_has_free ) {
	$wpfh_pl_edition     = 'free';
	$wpfh_pl_badge_label = __( 'Free', 'forgehub-product-listings' );
} elseif ( $wpfh_pl_card_product->is_on_sale() ) {
	$wpfh_pl_edition     = 'pro';
	$wpfh_pl_badge_label = __( 'Sale', 'forgehub-product-listings' );
} else {
	$wpfh_pl_edition     = 'pro';
	$wpfh_pl_badge_label = '';
}
$wpfh_pl_badge_label = apply_filters( 'wpfh_pl_card_badge_label', $wpfh_pl_badge_label, $wpfh_pl_card_product, $wpfh_pl_edition );

// Get categories (never inject store-specific fallback tags on uncategorized products).
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

$wpfh_pl_cats_attr = implode( ' ', $wpfh_pl_cat_slugs );

$wpfh_pl_card_classes = array(
	'wpfh-pl-card',
	'wpfh-pl-card--' . sanitize_html_class( $wpfh_pl_card_layout ),
	'wpfh-pl-ratio--' . sanitize_html_class( str_replace( ':', '-', $wpfh_pl_img_ratio ) ),
);
if ( ! $wpfh_pl_show_img ) {
	$wpfh_pl_card_classes[] = 'wpfh-pl-card--no-thumb';
}
?>
<li class="<?php echo esc_attr( implode( ' ', $wpfh_pl_card_classes ) ); ?>"
	data-id="<?php echo esc_attr( $wpfh_pl_prod_id ); ?>"
	data-title="<?php echo esc_attr( strtolower( $wpfh_pl_title ) ); ?>"
	data-edition="<?php echo esc_attr( $wpfh_pl_edition ); ?>"
	data-price="<?php echo esc_attr( (string) $wpfh_pl_raw_price ); ?>"
	data-min-price="<?php echo esc_attr( (string) $wpfh_pl_min_price ); ?>"
	data-max-price="<?php echo esc_attr( (string) $wpfh_pl_max_price ); ?>"
	data-cats="<?php echo esc_attr( $wpfh_pl_cats_attr ); ?>">
	<div class="wpfh-pl-card-inner">
		<?php if ( $wpfh_pl_show_img ) : ?>
			<a class="wpfh-pl-card-media" href="<?php echo esc_url( $wpfh_pl_permalink ); ?>" tabindex="-1" aria-hidden="true">
				<?php if ( $wpfh_pl_image_id ) : ?>
					<?php echo wp_get_attachment_image( $wpfh_pl_image_id, 'medium', false, array( 'class' => 'wpfh-pl-thumb', 'alt' => esc_attr( $wpfh_pl_title ), 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<div class="wpfh-pl-thumb-placeholder">
						<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
					</div>
				<?php endif; ?>
				<?php if ( $wpfh_pl_show_badge && '' !== $wpfh_pl_badge_label ) : ?>
					<span class="wpfh-pl-badge wpfh-pl-badge--<?php echo esc_attr( $wpfh_pl_edition ); ?>">
						<?php echo esc_html( $wpfh_pl_badge_label ); ?>
					</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>
		<div class="wpfh-pl-card-body">
			<?php if ( ! $wpfh_pl_show_img && $wpfh_pl_show_badge && '' !== $wpfh_pl_badge_label ) : ?>
				<div class="wpfh-pl-badge-inline">
					<span class="wpfh-pl-badge wpfh-pl-badge--<?php echo esc_attr( $wpfh_pl_edition ); ?>">
						<?php echo esc_html( $wpfh_pl_badge_label ); ?>
					</span>
				</div>
			<?php endif; ?>
			<?php if ( $wpfh_pl_show_cats && ! empty( $wpfh_pl_cat_names ) ) : ?>
				<div class="wpfh-pl-card-tags">
					<?php foreach ( $wpfh_pl_cat_names as $wpfh_pl_cname ) : ?>
						<span class="wpfh-pl-tag"><?php echo esc_html( $wpfh_pl_cname ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( $wpfh_pl_show_title ) : ?>
				<h3 class="wpfh-pl-card-title">
					<a href="<?php echo esc_url( $wpfh_pl_permalink ); ?>">
						<?php echo esc_html( $wpfh_pl_title ); ?>
					</a>
				</h3>
			<?php endif; ?>
			<?php if ( $wpfh_pl_show_exc && ! empty( $wpfh_pl_short_desc ) ) : ?>
				<p class="wpfh-pl-card-excerpt">
					<?php echo esc_html( $wpfh_pl_short_desc ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $wpfh_pl_show_price || $wpfh_pl_show_btn ) : ?>
				<div class="wpfh-pl-card-footer">
					<?php if ( $wpfh_pl_show_price ) : ?>
						<div class="wpfh-pl-price">
							<?php echo $wpfh_pl_price_html ? wp_kses_post( $wpfh_pl_price_html ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $wpfh_pl_show_btn ) : ?>
						<a class="wpfh-pl-btn" href="<?php echo esc_url( $wpfh_pl_permalink ); ?>">
							<?php echo esc_html( $wpfh_pl_btn_text ); ?> &rarr;
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</li>
