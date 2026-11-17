<?php
/**
 * Sidebar widget: Category navigation tree.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_widget_cats  = isset( $wpfh_pl_categories ) ? $wpfh_pl_categories : array();
$wpfh_pl_widget_count = isset( $wpfh_pl_total_count ) ? (int) $wpfh_pl_total_count : 0;
?>
<div class="wpfh-pl-widget wpfh-pl-widget-categories">
	<h3 class="wpfh-pl-widget-title">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
		<?php esc_html_e( 'Categories', 'forgehub-product-listings' ); ?>
	</h3>
	<nav class="wpfh-pl-category-tree" aria-label="<?php esc_attr_e( 'Category list', 'forgehub-product-listings' ); ?>">
		<ul class="wpfh-pl-cat-list">
			<li class="wpfh-pl-cat-item">
				<button type="button" class="wpfh-pl-cat-btn is-active" data-cat="all">
					<span class="wpfh-pl-cat-name"><?php esc_html_e( 'All Products', 'forgehub-product-listings' ); ?></span>
					<span class="wpfh-pl-cat-badge"><?php echo (int) $wpfh_pl_widget_count; ?></span>
				</button>
			</li>
			<?php foreach ( $wpfh_pl_widget_cats as $wpfh_pl_w_cslug => $wpfh_pl_w_cinfo ) : ?>
				<li class="wpfh-pl-cat-item">
					<button type="button" class="wpfh-pl-cat-btn" data-cat="<?php echo esc_attr( $wpfh_pl_w_cslug ); ?>">
						<span class="wpfh-pl-cat-name"><?php echo esc_html( $wpfh_pl_w_cinfo['name'] ); ?></span>
						<span class="wpfh-pl-cat-badge"><?php echo (int) $wpfh_pl_w_cinfo['count']; ?></span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>
