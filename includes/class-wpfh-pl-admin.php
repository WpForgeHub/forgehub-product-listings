<?php
/**
 * Settings screen: template picker cards, layout controls, and modular sidebar widgets.
 *
 * @package forgehub-product-listings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPFH_PL_Admin {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	public static function menu() {
		add_options_page(
			__( 'Product Listings', 'forgehub-product-listings' ),
			__( 'Product Listings', 'forgehub-product-listings' ),
			'manage_options',
			'forgehub-product-listings',
			array( __CLASS__, 'render' )
		);
	}

	public static function register() {
		register_setting(
			'wpfh_pl_group',
			WPFH_PL_Templates::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( 'WPFH_PL_Templates', 'sanitize' ),
				'default'           => array(),
			)
		);

		register_setting(
			'wpfh_pl_group',
			WPFH_PL_Templates::SETTINGS_OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( 'WPFH_PL_Templates', 'sanitize_settings' ),
				'default'           => WPFH_PL_Templates::default_settings(),
			)
		);
	}

	public static function assets( $hook ) {
		if ( 'settings_page_forgehub-product-listings' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wpfh-pl-admin', WPFH_PL_URL . 'assets/css/admin.css', array(), (string) filemtime( WPFH_PL_PATH . 'assets/css/admin.css' ) );
		wp_enqueue_script( 'wpfh-pl-admin', WPFH_PL_URL . 'assets/js/admin.js', array(), (string) filemtime( WPFH_PL_PATH . 'assets/js/admin.js' ), true );
	}

	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$templates   = WPFH_PL_Templates::all();
		$assignments = WPFH_PL_Templates::assignments();
		$settings    = WPFH_PL_Templates::get_settings();

		$col_opts      = WPFH_PL_Templates::column_options();
		$pos_opts      = WPFH_PL_Templates::sidebar_position_options();
		$cw_opts       = WPFH_PL_Templates::container_width_options();
		$sw_opts       = WPFH_PL_Templates::sidebar_width_options();
		$avail_widgets = WPFH_PL_Templates::available_sidebar_widgets();
		$active_w      = isset( $settings['sidebar_widgets'] ) && is_array( $settings['sidebar_widgets'] ) ? $settings['sidebar_widgets'] : array();

		$card_layouts   = WPFH_PL_Templates::card_layout_options();
		$image_ratios   = WPFH_PL_Templates::image_ratio_options();
		$avail_elements = WPFH_PL_Templates::available_card_elements();
		$active_elems   = isset( $settings['card_elements'] ) && is_array( $settings['card_elements'] ) ? $settings['card_elements'] : array();
		?>
		<div class="wrap wpfh-pl-admin-wrap">
			<h1><?php esc_html_e( 'ForgeHub Product Listings', 'forgehub-product-listings' ); ?></h1>
			<p class="description">
				<?php esc_html_e( 'Configure WooCommerce catalog templates, sidebar positions, responsive grid columns, container width, product card design, and modular widgets.', 'forgehub-product-listings' ); ?>
			</p>

			<form method="post" action="options.php">
				<?php settings_fields( 'wpfh_pl_group' ); ?>
				<input type="hidden" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[_submitted]' ); ?>" value="1" />

				<!-- Section 1: Template Selection -->
				<div class="wpfh-pl-section">
					<h2 class="wpfh-pl-section-title"><?php esc_html_e( 'Template Assignments', 'forgehub-product-listings' ); ?></h2>
					<?php foreach ( WPFH_PL_Templates::contexts() as $ctx => $ctx_label ) : ?>
						<h3 class="wpfh-pl-ctx-title"><?php echo esc_html( $ctx_label ); ?></h3>
						<div class="wpfh-pl-cards" role="radiogroup">
							<?php
							foreach ( $templates as $slug => $label ) :
								$id      = 'wpfh-pl-' . $ctx . '-' . $slug;
								$preview = WPFH_PL_URL . 'assets/img/preview-' . $slug . '.svg';
								?>
								<label class="wpfh-pl-card" for="<?php echo esc_attr( $id ); ?>">
									<input type="radio" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( WPFH_PL_Templates::OPTION . '[' . $ctx . ']' ); ?>" value="<?php echo esc_attr( $slug ); ?>"<?php checked( $assignments[ $ctx ], $slug ); ?> />
									<img src="<?php echo esc_url( $preview ); ?>" alt="<?php echo esc_attr( $label ); ?>" width="240" height="150" />
									<span><?php echo esc_html( $label ); ?></span>
								</label>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Section 2: Layout & Appearance Settings -->
				<div class="wpfh-pl-section">
					<h2 class="wpfh-pl-section-title"><?php esc_html_e( 'Layout & Appearance Options', 'forgehub-product-listings' ); ?></h2>
					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-sidebar-pos"><?php esc_html_e( 'Sidebar Position', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-sidebar-pos" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[sidebar_position]' ); ?>">
										<?php foreach ( $pos_opts as $pval => $plabel ) : ?>
											<option value="<?php echo esc_attr( $pval ); ?>"<?php selected( $settings['sidebar_position'], $pval ); ?>>
												<?php echo esc_html( $plabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Choose whether the sidebar is placed on the left or right side of the product grid.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-grid-cols"><?php esc_html_e( 'Grid Columns', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-grid-cols" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[grid_columns]' ); ?>">
										<?php foreach ( $col_opts as $cval => $clabel ) : ?>
											<option value="<?php echo esc_attr( $cval ); ?>"<?php selected( $settings['grid_columns'], $cval ); ?>>
												<?php echo esc_html( $clabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Number of product columns on desktop displays. Responsively adapts on mobile and tablet.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-container-width"><?php esc_html_e( 'Container Max Width', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-container-width" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[container_width]' ); ?>">
										<?php foreach ( $cw_opts as $cwval => $cwlabel ) : ?>
											<option value="<?php echo esc_attr( $cwval ); ?>"<?php selected( $settings['container_width'], $cwval ); ?>>
												<?php echo esc_html( $cwlabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Controls the overall width of the listings container. Wide (1400px) gives comfortable space for sidebar + 3/4 columns.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-sidebar-width"><?php esc_html_e( 'Sidebar Width', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-sidebar-width" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[sidebar_width]' ); ?>">
										<?php foreach ( $sw_opts as $swval => $swlabel ) : ?>
											<option value="<?php echo esc_attr( $swval ); ?>"<?php selected( $settings['sidebar_width'], $swval ); ?>>
												<?php echo esc_html( $swlabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Width dedicated to the sidebar. 280px is recommended for compact readability.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Section 3: Product Card Design & Elements -->
				<div class="wpfh-pl-section">
					<h2 class="wpfh-pl-section-title"><?php esc_html_e( 'Product Card Design & Elements', 'forgehub-product-listings' ); ?></h2>
					<p class="description"><?php esc_html_e( 'Customize product card styling, proportions, image aspect ratio, and choose exactly which elements to show.', 'forgehub-product-listings' ); ?></p>

					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-card-layout"><?php esc_html_e( 'Card Layout Style', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-card-layout" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[card_layout]' ); ?>">
										<?php foreach ( $card_layouts as $clval => $cllabel ) : ?>
											<option value="<?php echo esc_attr( $clval ); ?>"<?php selected( $settings['card_layout'], $clval ); ?>>
												<?php echo esc_html( $cllabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Select vertical, sleek horizontal (image on left), or compact footprint.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-card-ratio"><?php esc_html_e( 'Thumbnail Aspect Ratio', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<select id="wpfh-pl-card-ratio" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[card_image_ratio]' ); ?>">
										<?php foreach ( $image_ratios as $irval => $irlabel ) : ?>
											<option value="<?php echo esc_attr( $irval ); ?>"<?php selected( $settings['card_image_ratio'], $irval ); ?>>
												<?php echo esc_html( $irlabel ); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="description"><?php esc_html_e( 'Use 21:9 or 16:9 for slim modern cards, or select Hidden to eliminate the image completely.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<?php esc_html_e( 'Elements to Display', 'forgehub-product-listings' ); ?>
								</th>
								<td>
									<fieldset class="wpfh-pl-element-checklist">
										<legend class="screen-reader-text"><?php esc_html_e( 'Card Elements', 'forgehub-product-listings' ); ?></legend>
										<?php foreach ( $avail_elements as $el_key => $el_label ) : ?>
											<label class="wpfh-pl-element-item">
												<input type="checkbox" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[card_elements][]' ); ?>" value="<?php echo esc_attr( $el_key ); ?>"<?php checked( in_array( $el_key, $active_elems, true ) ); ?> />
												<span><strong><?php echo esc_html( $el_label ); ?></strong></span>
											</label>
										<?php endforeach; ?>
									</fieldset>
									<p class="description"><?php esc_html_e( 'Select which details should appear on the product card. Uncheck elements to keep cards clean and compact.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-card-excerpt-len"><?php esc_html_e( 'Excerpt Word Count', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<input type="number" id="wpfh-pl-card-excerpt-len" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[card_excerpt_length]' ); ?>" value="<?php echo esc_attr( (string) $settings['card_excerpt_length'] ); ?>" min="0" max="50" step="1" class="small-text" />
									<p class="description"><?php esc_html_e( 'Maximum words for the product short description. Recommended: 10-14 words to prevent tall vertical cards.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-card-btn-text"><?php esc_html_e( 'Action Button Text', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<input type="text" id="wpfh-pl-card-btn-text" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[card_button_text]' ); ?>" value="<?php echo esc_attr( $settings['card_button_text'] ); ?>" class="regular-text" />
									<p class="description"><?php esc_html_e( 'Label displayed on the card call-to-action button (e.g. "View Details", "Explore", "Learn More").', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Section 4: Modular Sidebar Widgets -->
				<div class="wpfh-pl-section">
					<h2 class="wpfh-pl-section-title"><?php esc_html_e( 'Modular Sidebar Widgets', 'forgehub-product-listings' ); ?></h2>
					<p class="description"><?php esc_html_e( 'Select which widgets should appear in the template sidebar. Active widgets are displayed in order.', 'forgehub-product-listings' ); ?></p>
					<fieldset class="wpfh-pl-widget-checklist">
						<legend class="screen-reader-text"><?php esc_html_e( 'Sidebar Widgets', 'forgehub-product-listings' ); ?></legend>
						<?php foreach ( $avail_widgets as $w_key => $w_label ) : ?>
							<label class="wpfh-pl-widget-item">
								<input type="checkbox" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[sidebar_widgets][]' ); ?>" value="<?php echo esc_attr( $w_key ); ?>"<?php checked( in_array( $w_key, $active_w, true ) ); ?> />
								<span><strong><?php echo esc_html( $w_label ); ?></strong></span>
							</label>
						<?php endforeach; ?>
					</fieldset>

					<table class="form-table" role="presentation" style="margin-top: 1rem;">
						<tbody>
							<tr>
								<th scope="row">
									<label for="wpfh-pl-recent-count"><?php esc_html_e( 'Recent Products Count', 'forgehub-product-listings' ); ?></label>
								</th>
								<td>
									<input type="number" id="wpfh-pl-recent-count" name="<?php echo esc_attr( WPFH_PL_Templates::SETTINGS_OPTION . '[recent_count]' ); ?>" value="<?php echo esc_attr( (string) $settings['recent_count'] ); ?>" min="1" max="12" step="1" class="small-text" />
									<p class="description"><?php esc_html_e( 'Number of items shown in the "Recent Products" sidebar widget.', 'forgehub-product-listings' ); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
