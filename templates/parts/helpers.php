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
						'term_id'     => $t->term_id,
						'name'        => $t->name,
						'slug'        => $t->slug,
						'description' => $t->description,
						'count'       => 0,
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

if ( ! function_exists( 'wpfh_pl_allowed_svg_tags' ) ) {
	function wpfh_pl_allowed_svg_tags() {
		return array(
			'svg'      => array(
				'class'        => true,
				'aria-hidden'  => true,
				'aria-label'   => true,
				'role'         => true,
				'viewbox'      => true,
				'width'        => true,
				'height'       => true,
				'fill'         => true,
				'stroke'       => true,
				'stroke-width' => true,
				'xmlns'        => true,
			),
			'path'     => array(
				'd'            => true,
				'fill'         => true,
				'stroke'       => true,
				'stroke-width' => true,
			),
			'rect'     => array(
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'rx'     => true,
				'ry'     => true,
				'fill'   => true,
				'stroke' => true,
			),
			'circle'   => array(
				'cx'     => true,
				'cy'     => true,
				'r'      => true,
				'fill'   => true,
				'stroke' => true,
			),
			'line'     => array(
				'x1'     => true,
				'y1'     => true,
				'x2'     => true,
				'y2'     => true,
				'stroke' => true,
			),
			'polyline' => array(
				'points' => true,
				'fill'   => true,
				'stroke' => true,
			),
			'polygon'  => array(
				'points' => true,
				'fill'   => true,
				'stroke' => true,
			),
		);
	}
}
