<?php
/**
 * Pro: per-category template assignment.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Pro_Category_Templates {

	const META = 'wpfh_pl_template';

	public static function init() {
		if ( function_exists( 'wpfh_pl_fs' ) && ! wpfh_pl_fs()->can_use_premium_code() ) {
			return;
		}
		add_action( 'product_cat_edit_form_fields', array( __CLASS__, 'field' ) );
		add_action( 'edited_product_cat', array( __CLASS__, 'save' ) );
		add_filter( 'wpfh_pl_template_slug', array( __CLASS__, 'filter' ) );
	}

	public static function field( $term ) {
		$current = get_term_meta( $term->term_id, self::META, true );
		wp_nonce_field( 'wpfh_pl_cat_tpl', 'wpfh_pl_cat_nonce' );
		echo '<tr class="form-field"><th scope="row"><label for="wpfh_pl_template">' . esc_html__( 'Listing template', 'forgehub-product-listings' ) . '</label></th><td><select name="wpfh_pl_template" id="wpfh_pl_template"><option value="">' . esc_html__( 'Default', 'forgehub-product-listings' ) . '</option>';
		foreach ( WPFH_PL_Templates::all() as $slug => $label ) {
			echo '<option value="' . esc_attr( $slug ) . '"' . selected( $current, $slug, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select></td></tr>';
	}

	public static function save( $term_id ) {
		if ( ! isset( $_POST['wpfh_pl_cat_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpfh_pl_cat_nonce'] ) ), 'wpfh_pl_cat_tpl' ) || ! current_user_can( 'manage_categories' ) ) {
			return;
		}
		$val = isset( $_POST['wpfh_pl_template'] ) ? sanitize_key( wp_unslash( $_POST['wpfh_pl_template'] ) ) : '';
		if ( '' !== $val && isset( WPFH_PL_Templates::all()[ $val ] ) ) {
			update_term_meta( $term_id, self::META, $val );
		} else {
			delete_term_meta( $term_id, self::META );
		}
	}

	public static function filter( $slug ) {
		if ( function_exists( 'is_product_category' ) && is_product_category() ) {
			$tpl = get_term_meta( get_queried_object_id(), self::META, true );
			if ( $tpl && isset( WPFH_PL_Templates::all()[ $tpl ] ) ) {
				return $tpl;
			}
		}
		return $slug;
	}
}
