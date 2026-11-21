<?php
/**
 * Shared filter toolbar part for product listing templates.
 * Expects $wpfh_pl_categories (array: slug => ['name' => ..., 'count' => ...]), $wpfh_pl_show_categories (bool).
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpfh_pl_show_categories = isset( $wpfh_pl_show_categories ) ? (bool) $wpfh_pl_show_categories : ( isset( $show_categories ) ? (bool) $show_categories : true );
$wpfh_pl_categories      = isset( $wpfh_pl_categories ) ? $wpfh_pl_categories : ( isset( $categories ) ? $categories : array() );
$wpfh_pl_toolbar_uid     = function_exists( 'wp_unique_id' ) ? wp_unique_id( 'wpfh-pl-' ) : 'wpfh-pl-' . wp_rand( 1000, 9999 );
?>
<div class="wpfh-pl-toolbar" role="region" aria-label="<?php esc_attr_e( 'Product listing controls', 'forgehub-product-listings' ); ?>">
	<div class="wpfh-pl-toolbar-row wpfh-pl-toolbar-primary">
		<!-- Live Search -->
		<div class="wpfh-pl-search-wrap">
			<label for="<?php echo esc_attr( $wpfh_pl_toolbar_uid . '-search' ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search products', 'forgehub-product-listings' ); ?></label>
			<svg class="wpfh-pl-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			<input type="search" id="<?php echo esc_attr( $wpfh_pl_toolbar_uid . '-search' ); ?>" class="wpfh-pl-search-input" placeholder="<?php esc_attr_e( 'Search products by keyword...', 'forgehub-product-listings' ); ?>" autocomplete="off" />
			<button type="button" class="wpfh-pl-search-clear" aria-label="<?php esc_attr_e( 'Clear search', 'forgehub-product-listings' ); ?>" style="display:none;">&times;</button>
		</div>

		<!-- Edition Filter (All / Free / Paid) -->
		<div class="wpfh-pl-edition-filter" role="radiogroup" aria-label="<?php esc_attr_e( 'Filter by tier', 'forgehub-product-listings' ); ?>">
			<button type="button" class="wpfh-pl-edition-btn is-active" data-edition="all"><?php esc_html_e( 'All', 'forgehub-product-listings' ); ?></button>
			<button type="button" class="wpfh-pl-edition-btn" data-edition="free"><?php esc_html_e( 'Free', 'forgehub-product-listings' ); ?></button>
			<button type="button" class="wpfh-pl-edition-btn" data-edition="pro"><?php esc_html_e( 'Paid / Pro', 'forgehub-product-listings' ); ?></button>
		</div>

		<!-- Sort and View Controls -->
		<div class="wpfh-pl-actions">
			<div class="wpfh-pl-sort-wrap">
				<label for="<?php echo esc_attr( $wpfh_pl_toolbar_uid . '-sort' ); ?>" class="screen-reader-text"><?php esc_html_e( 'Sort products by', 'forgehub-product-listings' ); ?></label>
				<select id="<?php echo esc_attr( $wpfh_pl_toolbar_uid . '-sort' ); ?>" class="wpfh-pl-sort-select">
					<option value="title-asc"><?php esc_html_e( 'Alphabetical (A-Z)', 'forgehub-product-listings' ); ?></option>
					<option value="title-desc"><?php esc_html_e( 'Alphabetical (Z-A)', 'forgehub-product-listings' ); ?></option>
					<option value="price-asc"><?php esc_html_e( 'Price: Low to High', 'forgehub-product-listings' ); ?></option>
					<option value="price-desc"><?php esc_html_e( 'Price: High to Low', 'forgehub-product-listings' ); ?></option>
				</select>
			</div>

			<div class="wpfh-pl-view-toggle" role="group" aria-label="<?php esc_attr_e( 'View layout switch', 'forgehub-product-listings' ); ?>">
				<button type="button" class="wpfh-pl-view-btn is-active" data-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'forgehub-product-listings' ); ?>" title="<?php esc_attr_e( 'Grid view', 'forgehub-product-listings' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
				</button>
				<button type="button" class="wpfh-pl-view-btn" data-view="list" aria-label="<?php esc_attr_e( 'List view', 'forgehub-product-listings' ); ?>" title="<?php esc_attr_e( 'List view', 'forgehub-product-listings' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
				</button>
			</div>
		</div>
	</div>

	<?php if ( $wpfh_pl_show_categories && ! empty( $wpfh_pl_categories ) ) : ?>
	<div class="wpfh-pl-toolbar-row wpfh-pl-category-chips" role="group" aria-label="<?php esc_attr_e( 'Filter by category', 'forgehub-product-listings' ); ?>">
		<button type="button" class="wpfh-pl-chip is-active" data-cat="all">
			<?php esc_html_e( 'All Categories', 'forgehub-product-listings' ); ?>
		</button>
		<?php foreach ( $wpfh_pl_categories as $wpfh_pl_cslug => $wpfh_pl_cinfo ) : ?>
			<button type="button" class="wpfh-pl-chip" data-cat="<?php echo esc_attr( $wpfh_pl_cslug ); ?>">
				<?php echo esc_html( $wpfh_pl_cinfo['name'] ); ?>
				<?php if ( isset( $wpfh_pl_cinfo['count'] ) ) : ?>
					<span class="wpfh-pl-chip-count">(<?php echo (int) $wpfh_pl_cinfo['count']; ?>)</span>
				<?php endif; ?>
			</button>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="wpfh-pl-status-bar" aria-live="polite">
		<span class="wpfh-pl-count-label"></span>
		<button type="button" class="wpfh-pl-reset-filters" style="display:none;"><?php esc_html_e( 'Reset filters', 'forgehub-product-listings' ); ?></button>
	</div>
</div>
