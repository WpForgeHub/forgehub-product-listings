<?php
/**
 * Sidebar widget: Featured & on-sale products.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_feat_query = function_exists( 'wc_get_products' ) ? wc_get_products(
	array(
		'status'   => 'publish',
		'limit'    => 3,
		'featured' => true,
	)
) : array();

// If no featured products explicitly set, fallback to on-sale
if ( empty( $wpfh_pl_feat_query ) && function_exists( 'wc_get_products' ) ) {
	$wpfh_pl_feat_query = wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 3,
			'on_sale' => true,
		)
	);
}

if ( empty( $wpfh_pl_feat_query ) ) {
	return;
}
?>
<div class="wpfh-pl-widget wpfh-pl-widget-featured">
	<h3 class="wpfh-pl-widget-title">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
		<?php esc_html_e( 'Featured Products', 'forgehub-product-listings' ); ?>
	</h3>
	<ul class="wpfh-pl-recent-list">
		<?php
		foreach ( $wpfh_pl_feat_query as $wpfh_pl_f_item ) :
			if ( ! $wpfh_pl_f_item instanceof WC_Product ) {
				continue;
			}
			$wpfh_pl_f_id    = $wpfh_pl_f_item->get_id();
			$wpfh_pl_f_title = $wpfh_pl_f_item->get_name();
			$wpfh_pl_f_url   = $wpfh_pl_f_item->get_permalink();
			$wpfh_pl_f_img   = $wpfh_pl_f_item->get_image_id();
			$wpfh_pl_f_price = $wpfh_pl_f_item->get_price_html();
			?>
			<li class="wpfh-pl-recent-item">
				<a href="<?php echo esc_url( $wpfh_pl_f_url ); ?>" class="wpfh-pl-recent-link">
					<?php if ( $wpfh_pl_f_img ) : ?>
						<?php echo wp_get_attachment_image( $wpfh_pl_f_img, array( 44, 44 ), false, array( 'class' => 'wpfh-pl-recent-thumb', 'alt' => esc_attr( $wpfh_pl_f_title ) ) ); ?>
					<?php else : ?>
						<div class="wpfh-pl-recent-thumb-ph">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>
					<?php endif; ?>
					<div class="wpfh-pl-recent-meta">
						<span class="wpfh-pl-recent-title"><?php echo esc_html( $wpfh_pl_f_title ); ?></span>
						<span class="wpfh-pl-recent-price"><?php echo $wpfh_pl_f_price ? wp_kses_post( $wpfh_pl_f_price ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?></span>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
