<?php
/**
 * Template: sidebar-grid.
 * Left sidebar with category navigation tree & counts, right product grid/list with live search, edition filter and sorting.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __DIR__ ) . '/parts/helpers.php';

$categories  = wpfh_pl_get_product_categories( $products );
$total_count = count( $products );
?>
<div class="wpfh-pl-wrapper wpfh-pl-sidebar-grid" data-template="sidebar-grid" data-default-view="grid">
	<div class="wpfh-pl-layout">
		<!-- Left Sidebar: Category tree & counts -->
		<aside class="wpfh-pl-sidebar" aria-label="<?php esc_attr_e( 'Categories', 'forgehub-product-listings' ); ?>">
			<div class="wpfh-pl-sidebar-inner">
				<div class="wpfh-pl-sidebar-header">
					<h3 class="wpfh-pl-sidebar-title">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
						<?php esc_html_e( 'Categories', 'forgehub-product-listings' ); ?>
					</h3>
				</div>
				<nav class="wpfh-pl-category-tree" aria-label="<?php esc_attr_e( 'Category list', 'forgehub-product-listings' ); ?>">
					<ul class="wpfh-pl-cat-list">
						<li class="wpfh-pl-cat-item">
							<button type="button" class="wpfh-pl-cat-btn is-active" data-cat="all">
								<span class="wpfh-pl-cat-name"><?php esc_html_e( 'All Products', 'forgehub-product-listings' ); ?></span>
								<span class="wpfh-pl-cat-badge"><?php echo (int) $total_count; ?></span>
							</button>
						</li>
						<?php foreach ( $categories as $cslug => $cinfo ) : ?>
							<li class="wpfh-pl-cat-item">
								<button type="button" class="wpfh-pl-cat-btn" data-cat="<?php echo esc_attr( $cslug ); ?>">
									<span class="wpfh-pl-cat-name"><?php echo esc_html( $cinfo['name'] ); ?></span>
									<span class="wpfh-pl-cat-badge"><?php echo (int) $cinfo['count']; ?></span>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>
		</aside>

		<!-- Main Content Area -->
		<main class="wpfh-pl-main">
			<?php
			$show_categories = false; // Categories are already in the sidebar
			include dirname( __DIR__ ) . '/parts/toolbar.php';
			?>

			<div class="wpfh-pl-grid-container">
				<ul class="wpfh-pl-items wpfh-pl-view-grid">
					<?php foreach ( $products as $product ) : ?>
						<?php include dirname( __DIR__ ) . '/parts/card.php'; ?>
					<?php endforeach; ?>
				</ul>
				<div class="wpfh-pl-empty-state" style="display:none;">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
					<h4><?php esc_html_e( 'No matching plugins found', 'forgehub-product-listings' ); ?></h4>
					<p><?php esc_html_e( 'Try clearing your search terms or selecting another category.', 'forgehub-product-listings' ); ?></p>
				</div>
			</div>
		</main>
	</div>
</div>
