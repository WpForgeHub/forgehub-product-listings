<?php
/**
 * Shared helper to extract categories from products.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpfh_pl_get_product_categories' ) ) {
	function wpfh_pl_get_product_categories( $products ) {
		$categories = array();
		foreach ( $products as $p ) {
			if ( ! $p instanceof WC_Product ) {
				continue;
			}
			$terms = get_the_terms( $p->get_id(), 'product_cat' );
			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				continue;
			}
			foreach ( $terms as $t ) {
				if ( 'uncategorized' === $t->slug ) {
					continue;
				}
				if ( ! isset( $categories[ $t->slug ] ) ) {
					$categories[ $t->slug ] = array(
						'term_id' => $t->term_id,
						'name'    => $t->name,
						'slug'    => $t->slug,
						'count'   => 0,
					);
				}
				$categories[ $t->slug ]['count']++;
			}
		}
		uasort( $categories, function( $a, $b ) {
			return strcmp( $a['name'], $b['name'] );
		} );
		return $categories;
	}
}
