<?php
/**
 * Template: category-cards-list.
 * Visual category cards (icon, name, count, short description) on top, followed by interactive list/grid.
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

// Generic default category card metadata (filterable per store).
$wpfh_pl_default_cat_icon = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>';
$wpfh_pl_cat_meta         = apply_filters(
	'wpfh_pl_category_card_meta',
	array(
		'all' => array(
			'icon' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>',
			'desc' => __( 'Browse our complete product catalog.', 'forgehub-product-listings' ),
		),
	),
	$wpfh_pl_categories
);
$wpfh_pl_layout = isset( $wpfh_pl_layout ) && is_array( $wpfh_pl_layout ) ? $wpfh_pl_layout : WPFH_PL_Templates::default_settings();
$wpfh_pl_cw     = isset( $wpfh_pl_layout['container_width'] ) ? $wpfh_pl_layout['container_width'] : '1400px';
$wpfh_pl_wrapper_style = sprintf(
	'--wpfh-pl-container-width:%s;',
	( 'full' === $wpfh_pl_cw ? '100%' : esc_attr( $wpfh_pl_cw ) )
);
?>
<div class="wpfh-pl-wrapper wpfh-pl-category-cards-list" data-template="category-cards-list" data-default-view="list" style="<?php echo esc_attr( $wpfh_pl_wrapper_style ); ?>">
	<!-- Category Boxes Section -->
	<div class="wpfh-pl-cat-boxes-section">
		<div class="wpfh-pl-cat-boxes-grid">
			<div class="wpfh-pl-cat-box is-active" data-cat="all">
				<div class="wpfh-pl-cat-box-icon">
					<?php echo wp_kses( $wpfh_pl_cat_meta['all']['icon'], wpfh_pl_allowed_svg_tags() ); ?>
				</div>
				<div class="wpfh-pl-cat-box-content">
					<div class="wpfh-pl-cat-box-top">
						<h4 class="wpfh-pl-cat-box-title"><?php esc_html_e( 'All Products', 'forgehub-product-listings' ); ?></h4>
						<span class="wpfh-pl-cat-box-count"><?php echo (int) $wpfh_pl_total_count; ?></span>
					</div>
					<p class="wpfh-pl-cat-box-desc"><?php echo esc_html( $wpfh_pl_cat_meta['all']['desc'] ); ?></p>
				</div>
			</div>
			<?php foreach ( $wpfh_pl_categories as $wpfh_pl_cslug => $wpfh_pl_cinfo ) :
				$wpfh_pl_term_desc = ! empty( $wpfh_pl_cinfo['description'] )
					? wp_trim_words( wp_strip_all_tags( $wpfh_pl_cinfo['description'] ), 14, '...' )
					: sprintf(
						/* translators: %s: category name. */
						__( 'Explore %s products.', 'forgehub-product-listings' ),
						$wpfh_pl_cinfo['name']
					);
				$wpfh_pl_meta = isset( $wpfh_pl_cat_meta[ $wpfh_pl_cslug ] ) ? $wpfh_pl_cat_meta[ $wpfh_pl_cslug ] : array(
					'icon' => $wpfh_pl_default_cat_icon,
					'desc' => $wpfh_pl_term_desc,
				);
			?>
				<div class="wpfh-pl-cat-box" data-cat="<?php echo esc_attr( $wpfh_pl_cslug ); ?>">
					<div class="wpfh-pl-cat-box-icon">
						<?php echo wp_kses( $wpfh_pl_meta['icon'], wpfh_pl_allowed_svg_tags() ); ?>
					</div>
					<div class="wpfh-pl-cat-box-content">
						<div class="wpfh-pl-cat-box-top">
							<h4 class="wpfh-pl-cat-box-title"><?php echo esc_html( $wpfh_pl_cinfo['name'] ); ?></h4>
							<span class="wpfh-pl-cat-box-count"><?php echo (int) $wpfh_pl_cinfo['count']; ?></span>
						</div>
						<p class="wpfh-pl-cat-box-desc"><?php echo esc_html( $wpfh_pl_meta['desc'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<?php
	$wpfh_pl_show_categories = false; // Category boxes handle category filtering
	include dirname( __DIR__ ) . '/parts/toolbar.php';
	?>

	<div class="wpfh-pl-grid-container">
		<ul class="wpfh-pl-items wpfh-pl-view-list">
			<?php foreach ( $wpfh_pl_prods as $wpfh_pl_prod ) : ?>
				<?php include dirname( __DIR__ ) . '/parts/card.php'; ?>
			<?php endforeach; ?>
		</ul>
		<div class="wpfh-pl-empty-state" style="display:none;">
			<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			<h4><?php esc_html_e( 'No matching products found', 'forgehub-product-listings' ); ?></h4>
			<p><?php esc_html_e( 'Try clearing your search terms or selecting another category.', 'forgehub-product-listings' ); ?></p>
		</div>
	</div>
</div>
