<?php
/**
 * Template registry, page-context assignments, and layout settings.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Templates {

	const OPTION          = 'wpfh_pl_assignments';
	const SETTINGS_OPTION = 'wpfh_pl_settings';

	/**
	 * Available templates: slug => label.
	 *
	 * @return array
	 */
	public static function all() {
		return array(
			'sidebar-grid'        => __( 'Sidebar + Grid', 'forgehub-product-listings' ),
			'topbar-grid'         => __( 'Top Bar + Grid', 'forgehub-product-listings' ),
			'category-cards-list' => __( 'Category Cards + List', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Page contexts a template can be assigned to.
	 *
	 * @return array
	 */
	public static function contexts() {
		return array(
			'plugins'  => __( 'Catalog / Shortcode pages', 'forgehub-product-listings' ),
			'shop'     => __( 'Shop page', 'forgehub-product-listings' ),
			'category' => __( 'Product category pages', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Available sidebar widgets.
	 *
	 * @return array
	 */
	public static function available_sidebar_widgets() {
		return array(
			'search'     => __( 'Product Search', 'forgehub-product-listings' ),
			'categories' => __( 'Category Tree & Counts', 'forgehub-product-listings' ),
			'recent'     => __( 'Recent Products', 'forgehub-product-listings' ),
			'price'      => __( 'Price Filter', 'forgehub-product-listings' ),
			'featured'   => __( 'Featured & On Sale', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Grid column options.
	 *
	 * @return array
	 */
	public static function column_options() {
		return array(
			'2'    => __( '2 Columns', 'forgehub-product-listings' ),
			'3'    => __( '3 Columns (Recommended)', 'forgehub-product-listings' ),
			'4'    => __( '4 Columns', 'forgehub-product-listings' ),
			'5'    => __( '5 Columns', 'forgehub-product-listings' ),
			'auto' => __( 'Auto-fit (Responsive)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Sidebar position options.
	 *
	 * @return array
	 */
	public static function sidebar_position_options() {
		return array(
			'left'  => __( 'Left (Default)', 'forgehub-product-listings' ),
			'right' => __( 'Right', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Container max-width options.
	 *
	 * @return array
	 */
	public static function container_width_options() {
		return array(
			'1200px' => __( 'Standard (1200px)', 'forgehub-product-listings' ),
			'1400px' => __( 'Wide (1400px - Recommended)', 'forgehub-product-listings' ),
			'1600px' => __( 'Extra Wide (1600px)', 'forgehub-product-listings' ),
			'full'   => __( 'Full Width (100%)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Sidebar width options.
	 *
	 * @return array
	 */
	public static function sidebar_width_options() {
		return array(
			'240px' => __( 'Narrow (240px)', 'forgehub-product-listings' ),
			'280px' => __( 'Standard (280px - Default)', 'forgehub-product-listings' ),
			'320px' => __( 'Wide (320px)', 'forgehub-product-listings' ),
			'360px' => __( 'Extra Wide (360px)', 'forgehub-product-listings' ),
			'25%'   => __( 'Proportional (25%)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Card layout style options.
	 *
	 * @return array
	 */
	public static function card_layout_options() {
		return array(
			'vertical'   => __( 'Vertical Card (Standard)', 'forgehub-product-listings' ),
			'horizontal' => __( 'Horizontal Card (Image on Left, Sleek & Low Height)', 'forgehub-product-listings' ),
			'compact'    => __( 'Compact Card (Condensed Footprint)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Thumbnail aspect ratio options.
	 *
	 * @return array
	 */
	public static function image_ratio_options() {
		return array(
			'16:9'   => __( '16:9 (Standard Banner)', 'forgehub-product-listings' ),
			'21:9'   => __( '21:9 (Ultra-wide / Slim - Shortest Height)', 'forgehub-product-listings' ),
			'4:3'    => __( '4:3 (Traditional)', 'forgehub-product-listings' ),
			'1:1'    => __( '1:1 (Square)', 'forgehub-product-listings' ),
			'hidden' => __( 'Hidden (No Image)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Available card elements for granular visibility control.
	 *
	 * @return array
	 */
	public static function available_card_elements() {
		return array(
			'image'      => __( 'Product Image / Thumbnail', 'forgehub-product-listings' ),
			'badge'      => __( 'Free / Pro Edition Badge', 'forgehub-product-listings' ),
			'categories' => __( 'Category Tags', 'forgehub-product-listings' ),
			'title'      => __( 'Product Title', 'forgehub-product-listings' ),
			'excerpt'    => __( 'Short Description / Excerpt', 'forgehub-product-listings' ),
			'price'      => __( 'Price / Free Indicator', 'forgehub-product-listings' ),
			'button'     => __( 'Action Button (View Details)', 'forgehub-product-listings' ),
		);
	}

	/**
	 * Default settings array.
	 *
	 * @return array
	 */
	public static function default_settings() {
		return array(
			'grid_columns'        => '3',
			'sidebar_position'    => 'left',
			'container_width'     => '1400px',
			'sidebar_width'       => '280px',
			'sidebar_widgets'     => array( 'search', 'categories', 'recent', 'price' ),
			'recent_count'        => 4,
			'card_layout'         => 'vertical',
			'card_image_ratio'    => '16:9',
			'card_excerpt_length' => 12,
			'card_button_text'    => __( 'View Details', 'forgehub-product-listings' ),
			'card_elements'       => array( 'image', 'badge', 'categories', 'title', 'excerpt', 'price', 'button' ),
		);
	}

	/**
	 * Saved settings merged with defaults.
	 *
	 * @return array
	 */
	public static function get_settings() {
		$saved    = get_option( self::SETTINGS_OPTION, array() );
		$saved    = is_array( $saved ) ? $saved : array();
		$defaults = self::default_settings();

		$output = array();
		foreach ( $defaults as $key => $default_val ) {
			if ( 'sidebar_widgets' === $key || 'card_elements' === $key ) {
				$output[ $key ] = ( isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ) ? $saved[ $key ] : $default_val;
			} elseif ( isset( $saved[ $key ] ) ) {
				$output[ $key ] = $saved[ $key ];
			} else {
				$output[ $key ] = $default_val;
			}
		}

		return $output;
	}

	/**
	 * Saved assignments with defaults applied.
	 *
	 * @return array
	 */
	public static function assignments() {
		$saved = get_option( self::OPTION, array() );
		$saved = is_array( $saved ) ? $saved : array();
		$all   = self::all();
		$out   = array();
		foreach ( array_keys( self::contexts() ) as $ctx ) {
			$out[ $ctx ] = ( isset( $saved[ $ctx ] ) && isset( $all[ $saved[ $ctx ] ] ) ) ? $saved[ $ctx ] : 'sidebar-grid';
		}
		return $out;
	}

	/**
	 * Sanitizes the posted assignments.
	 *
	 * @param mixed $input Raw input.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$input = is_array( $input ) ? $input : array();
		$all   = self::all();
		$out   = array();
		foreach ( array_keys( self::contexts() ) as $ctx ) {
			$val         = isset( $input[ $ctx ] ) ? sanitize_key( $input[ $ctx ] ) : '';
			$out[ $ctx ] = isset( $all[ $val ] ) ? $val : 'sidebar-grid';
		}
		return $out;
	}

	/**
	 * Sanitizes layout settings.
	 *
	 * @param mixed $input Raw input.
	 * @return array
	 */
	public static function sanitize_settings( $input ) {
		$input    = is_array( $input ) ? $input : array();
		$defaults = self::default_settings();
		$out      = array();

		// Grid columns
		$cols_allowed = array_keys( self::column_options() );
		$raw_cols     = isset( $input['grid_columns'] ) ? sanitize_key( (string) $input['grid_columns'] ) : $defaults['grid_columns'];
		$out['grid_columns'] = in_array( $raw_cols, $cols_allowed, true ) ? $raw_cols : $defaults['grid_columns'];

		// Sidebar position
		$pos_allowed = array_keys( self::sidebar_position_options() );
		$raw_pos     = isset( $input['sidebar_position'] ) ? sanitize_key( (string) $input['sidebar_position'] ) : $defaults['sidebar_position'];
		$out['sidebar_position'] = in_array( $raw_pos, $pos_allowed, true ) ? $raw_pos : $defaults['sidebar_position'];

		// Container width
		$cw_allowed = array_keys( self::container_width_options() );
		$raw_cw     = isset( $input['container_width'] ) ? sanitize_text_field( (string) $input['container_width'] ) : $defaults['container_width'];
		$out['container_width'] = in_array( $raw_cw, $cw_allowed, true ) ? $raw_cw : $defaults['container_width'];

		// Sidebar width
		$sw_allowed = array_keys( self::sidebar_width_options() );
		$raw_sw     = isset( $input['sidebar_width'] ) ? sanitize_text_field( (string) $input['sidebar_width'] ) : $defaults['sidebar_width'];
		$out['sidebar_width'] = in_array( $raw_sw, $sw_allowed, true ) ? $raw_sw : $defaults['sidebar_width'];

		// Sidebar widgets — allow saving an empty array when the form was explicitly submitted.
		$valid_widgets = array_keys( self::available_sidebar_widgets() );
		$out_widgets   = array();
		if ( isset( $input['sidebar_widgets'] ) && is_array( $input['sidebar_widgets'] ) ) {
			foreach ( $input['sidebar_widgets'] as $w ) {
				$clean_w = sanitize_key( $w );
				if ( in_array( $clean_w, $valid_widgets, true ) && ! in_array( $clean_w, $out_widgets, true ) ) {
					$out_widgets[] = $clean_w;
				}
			}
		}
		$form_submitted         = ! empty( $input['_submitted'] );
		$out['sidebar_widgets'] = ( ! empty( $out_widgets ) || $form_submitted ) ? $out_widgets : $defaults['sidebar_widgets'];

		// Recent count
		$raw_rc = isset( $input['recent_count'] ) ? absint( $input['recent_count'] ) : $defaults['recent_count'];
		$out['recent_count'] = ( $raw_rc >= 1 && $raw_rc <= 12 ) ? $raw_rc : $defaults['recent_count'];

		// Card layout style
		$layout_allowed     = array_keys( self::card_layout_options() );
		$raw_card_layout    = isset( $input['card_layout'] ) ? sanitize_key( (string) $input['card_layout'] ) : $defaults['card_layout'];
		$out['card_layout'] = in_array( $raw_card_layout, $layout_allowed, true ) ? $raw_card_layout : $defaults['card_layout'];

		// Thumbnail image ratio
		$ratio_allowed         = array_keys( self::image_ratio_options() );
		$raw_ratio             = isset( $input['card_image_ratio'] ) ? sanitize_text_field( (string) $input['card_image_ratio'] ) : $defaults['card_image_ratio'];
		$out['card_image_ratio'] = in_array( $raw_ratio, $ratio_allowed, true ) ? $raw_ratio : $defaults['card_image_ratio'];

		// Excerpt length (0 to 50 words)
		$raw_el = isset( $input['card_excerpt_length'] ) ? absint( $input['card_excerpt_length'] ) : $defaults['card_excerpt_length'];
		$out['card_excerpt_length'] = ( $raw_el >= 0 && $raw_el <= 50 ) ? $raw_el : $defaults['card_excerpt_length'];

		// Action button text
		$raw_btn = isset( $input['card_button_text'] ) ? sanitize_text_field( (string) $input['card_button_text'] ) : $defaults['card_button_text'];
		$out['card_button_text'] = ! empty( $raw_btn ) ? substr( $raw_btn, 0, 50 ) : $defaults['card_button_text'];

		// Card elements checklist — allow saving an empty array when explicitly submitted.
		$valid_elements = array_keys( self::available_card_elements() );
		$out_elements   = array();
		if ( isset( $input['card_elements'] ) && is_array( $input['card_elements'] ) ) {
			foreach ( $input['card_elements'] as $el ) {
				$clean_el = sanitize_key( $el );
				if ( in_array( $clean_el, $valid_elements, true ) && ! in_array( $clean_el, $out_elements, true ) ) {
					$out_elements[] = $clean_el;
				}
			}
		}
		$out['card_elements'] = ( ! empty( $out_elements ) || $form_submitted ) ? $out_elements : $defaults['card_elements'];

		return $out;
	}

	/**
	 * Merges shortcode attributes over saved settings.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return array
	 */
	public static function get_layout_config( $atts = array() ) {
		$settings = self::get_settings();

		if ( ! empty( $atts['columns'] ) ) {
			$col = sanitize_key( (string) $atts['columns'] );
			if ( array_key_exists( $col, self::column_options() ) ) {
				$settings['grid_columns'] = $col;
			}
		}

		if ( ! empty( $atts['sidebar_position'] ) ) {
			$pos = sanitize_key( (string) $atts['sidebar_position'] );
			if ( array_key_exists( $pos, self::sidebar_position_options() ) ) {
				$settings['sidebar_position'] = $pos;
			}
		}

		if ( ! empty( $atts['container_width'] ) ) {
			$cw = sanitize_text_field( (string) $atts['container_width'] );
			if ( array_key_exists( $cw, self::container_width_options() ) ) {
				$settings['container_width'] = $cw;
			}
		}

		if ( ! empty( $atts['sidebar_width'] ) ) {
			$sw = sanitize_text_field( (string) $atts['sidebar_width'] );
			if ( array_key_exists( $sw, self::sidebar_width_options() ) ) {
				$settings['sidebar_width'] = $sw;
			}
		}

		if ( ! empty( $atts['widgets'] ) ) {
			$w_list  = array_map( 'trim', explode( ',', $atts['widgets'] ) );
			$valid   = array_keys( self::available_sidebar_widgets() );
			$cleaned = array();
			foreach ( $w_list as $w ) {
				$cw = sanitize_key( $w );
				if ( in_array( $cw, $valid, true ) ) {
					$cleaned[] = $cw;
				}
			}
			if ( ! empty( $cleaned ) ) {
				$settings['sidebar_widgets'] = $cleaned;
			}
		}

		if ( ! empty( $atts['recent_count'] ) ) {
			$rc = absint( $atts['recent_count'] );
			if ( $rc >= 1 && $rc <= 12 ) {
				$settings['recent_count'] = $rc;
			}
		}

		// Shortcode card overrides
		if ( ! empty( $atts['card_layout'] ) ) {
			$cl = sanitize_key( (string) $atts['card_layout'] );
			if ( array_key_exists( $cl, self::card_layout_options() ) ) {
				$settings['card_layout'] = $cl;
			}
		}

		$ratio_param = ! empty( $atts['card_image_ratio'] ) ? $atts['card_image_ratio'] : ( ! empty( $atts['image_ratio'] ) ? $atts['image_ratio'] : '' );
		if ( ! empty( $ratio_param ) ) {
			$ir = sanitize_text_field( (string) $ratio_param );
			if ( array_key_exists( $ir, self::image_ratio_options() ) ) {
				$settings['card_image_ratio'] = $ir;
			}
		}

		$exc_param = isset( $atts['card_excerpt_length'] ) ? $atts['card_excerpt_length'] : ( isset( $atts['excerpt_length'] ) ? $atts['excerpt_length'] : null );
		if ( null !== $exc_param && '' !== $exc_param ) {
			$settings['card_excerpt_length'] = min( 50, max( 0, absint( $exc_param ) ) );
		}

		$btn_param = ! empty( $atts['card_button_text'] ) ? $atts['card_button_text'] : ( ! empty( $atts['button_text'] ) ? $atts['button_text'] : '' );
		if ( ! empty( $btn_param ) ) {
			$settings['card_button_text'] = sanitize_text_field( substr( (string) $btn_param, 0, 50 ) );
		}

		$elements_param = ! empty( $atts['card_elements'] ) ? $atts['card_elements'] : ( ! empty( $atts['elements'] ) ? $atts['elements'] : '' );
		if ( ! empty( $elements_param ) ) {
			$el_list     = array_map( 'trim', explode( ',', $elements_param ) );
			$valid_els   = array_keys( self::available_card_elements() );
			$cleaned_els = array();
			foreach ( $el_list as $el ) {
				$cel = sanitize_key( $el );
				if ( in_array( $cel, $valid_els, true ) ) {
					$cleaned_els[] = $cel;
				}
			}
			if ( ! empty( $cleaned_els ) ) {
				$settings['card_elements'] = $cleaned_els;
			}
		}

		return $settings;
	}
}
