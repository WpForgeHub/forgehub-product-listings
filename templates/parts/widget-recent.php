<?php
/**
 * Sidebar widget: Recent products list.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_recent_limit = isset( $wpfh_pl_layout['recent_count'] ) ? (int) $wpfh_pl_layout['recent_count'] : 4;
$wpfh_pl_recent_query = function_exists( 'wc_get_products' ) ? wc_get_products(
	array(
		'status'  => 'publish',
		'limit'   => $wpfh_pl_recent_limit,
		'orderby' => 'date',
		'order'   => 'DESC',
	)
) : array();
?>
<div class="wpfh-pl-widget wpfh-pl-widget-recent">
	<h3 class="wpfh-pl-widget-title">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
		<?php esc_html_e( 'Recent Products', 'forgehub-product-listings' ); ?>
	</h3>
	<ul class="wpfh-pl-recent-list">
		<?php
		foreach ( $wpfh_pl_recent_query as $wpfh_pl_item ) :
			if ( ! $wpfh_pl_item instanceof WC_Product ) {
				continue;
			}
			$wpfh_pl_r_id    = $wpfh_pl_item->get_id();
			$wpfh_pl_r_title = $wpfh_pl_item->get_name();
			$wpfh_pl_r_url   = $wpfh_pl_item->get_permalink();
			$wpfh_pl_r_img   = $wpfh_pl_item->get_image_id();
			$wpfh_pl_r_price = $wpfh_pl_item->get_price_html();
			?>
			<li class="wpfh-pl-recent-item">
				<a href="<?php echo esc_url( $wpfh_pl_r_url ); ?>" class="wpfh-pl-recent-link">
					<?php if ( $wpfh_pl_r_img ) : ?>
						<?php echo wp_get_attachment_image( $wpfh_pl_r_img, array( 44, 44 ), false, array( 'class' => 'wpfh-pl-recent-thumb', 'alt' => esc_attr( $wpfh_pl_r_title ) ) ); ?>
					<?php else : ?>
						<div class="wpfh-pl-recent-thumb-ph">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
						</div>
					<?php endif; ?>
					<div class="wpfh-pl-recent-meta">
						<span class="wpfh-pl-recent-title"><?php echo esc_html( $wpfh_pl_r_title ); ?></span>
						<span class="wpfh-pl-recent-price"><?php echo $wpfh_pl_r_price ? wp_kses_post( $wpfh_pl_r_price ) : esc_html__( 'Free', 'forgehub-product-listings' ); ?></span>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
