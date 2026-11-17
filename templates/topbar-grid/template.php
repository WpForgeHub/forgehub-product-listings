<?php
/**
 * Template: topbar-grid.
 * Top horizontal filter bar with category pill chips, search, edition switch, sorting and grid/list view toggle.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __DIR__ ) . '/parts/helpers.php';

$wpfh_pl_prods       = isset( $products ) && is_array( $products ) ? $products : array();
$wpfh_pl_categories  = wpfh_pl_get_product_categories( $wpfh_pl_prods );
$wpfh_pl_total_count = count( $wpfh_pl_prods );
?>
<div class="wpfh-pl-wrapper wpfh-pl-topbar-grid" data-template="topbar-grid" data-default-view="grid">
	<?php
	$wpfh_pl_show_categories = true; // Show pill chips in the toolbar
	include dirname( __DIR__ ) . '/parts/toolbar.php';
	?>

	<div class="wpfh-pl-grid-container">
		<ul class="wpfh-pl-items wpfh-pl-view-grid">
			<?php foreach ( $wpfh_pl_prods as $wpfh_pl_prod ) : ?>
				<?php include dirname( __DIR__ ) . '/parts/card.php'; ?>
			<?php endforeach; ?>
		</ul>
		<div class="wpfh-pl-empty-state" style="display:none;">
			<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			<h4><?php esc_html_e( 'No matching plugins found', 'forgehub-product-listings' ); ?></h4>
			<p><?php esc_html_e( 'Try clearing your search terms or selecting another category.', 'forgehub-product-listings' ); ?></p>
		</div>
	</div>
</div>
