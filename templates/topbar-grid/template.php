<?php
/**
 * Template: topbar-grid. Expects $products (WC_Product[]).
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wpfh-pl-listing wpfh-pl-topbar-grid">
	<ul class="wpfh-pl-items">
	<?php foreach ( $products as $product ) : ?>
		<li><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></li>
	<?php endforeach; ?>
	</ul>
</div>
