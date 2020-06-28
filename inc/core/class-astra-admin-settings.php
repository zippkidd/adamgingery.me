<?php
/**
 * Admin settings helper
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Admin_Settings' ) ) {

	$whiteLabel = "adamgingery.com";

	/**
	 * Astra Admin Settings
	 */
	class Astra_Admin_Settings {

		/**
		 * Menu page title
		 *
		 * @since 1.0
		 * @var array $menu_page_title
		 */
		static public $menu_page_title = 'Astra Theme';

		/**
		 * Page title
		 *
		 * @since 1.0
		 * @var array $page_title
		 */
		static public $page_title = 'Astra';

		/**
		 * Plugin slug
		 *
		 * @since 1.0
		 * @var array $plugin_slug
		 */
		static public $plugin_slug = 'astra';

		/**
		 * Default Menu position
		 *
		 * @since 1.0
		 * @var array $default_menu_position
		 */
		static public $default_menu_position = 'themes.php';

		/**
		 * Parent Page Slug
		 *
		 * @since 1.0
		 * @var array $parent_page_slug
		 */
		static public $parent_page_slug = 'general';

		/**
		 * Current Slug
		 *
		 * @since 1.0
		 * @var array $current_slug
		 */
		static public $current_slug = 'general';

		/**
		 * Constructor
		 */
		function __construct() {

			if ( ! is_admin() ) {
				return;
			}

			add_action( 'after_setup_theme', __CLASS__ . '::init_admin_settings', 99 );
		}

		/**
		 * Admin settings init
		 */
		public static function init_admin_settings() {
			self::$menu_page_title = apply_filters( 'astra_menu_page_title', __( $whiteLabel . ' Options', 'astra' ) );
			self::$page_title      = apply_filters( 'astra_page_title', __( $whiteLabel, 'astra' ) );
			self::$plugin_slug     = self::get_theme_page_slug();

			add_action( 'admin_enqueue_scripts', __CLASS__ . '::register_scripts' );

			if ( isset( $_REQUEST['page'] ) && strpos( $_REQUEST['page'], self::$plugin_slug ) !== false ) {

				add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );

				// Let extensions hook into saving.
				do_action( 'astra_admin_settings_scripts' );

				self::save_settings();
			}

			add_action( 'customize_controls_enqueue_scripts', __CLASS__ . '::customizer_scripts' );

			add_action( 'admin_menu', __CLASS__ . '::add_admin_menu', 99 );

			add_action( 'astra_menu_general_action', __CLASS__ . '::general_page' );

			add_action( 'astra_welcome_page_content', __CLASS__ . '::astra_welcome_page_content' );

			// AJAX.
			add_action( 'wp_ajax_astra-sites-plugin-activate', __CLASS__ . '::required_plugin_activate' );
			add_action( 'wp_ajax_astra-sites-plugin-deactivate', __CLASS__ . '::required_plugin_deactivate' );

			add_action( 'admin_notices', __CLASS__ . '::register_notices' );
			add_action( 'astra_notice_before_markup', __CLASS__ . '::notice_assets' );

			add_action( 'admin_notices', __CLASS__ . '::minimum_addon_version_notice' );

		}

		/**
		 * Theme options page Slug getter including White Label string.
		 *
		 * @since 2.1.0
		 * @return string Theme Options Page Slug.
		 */
		public static function get_theme_page_slug() {
			return apply_filters( 'astra_theme_page_slug', self::$plugin_slug );
		}

		/**
		 * Ask Theme Rating
		 *
		 * @since 1.4.0
		 */
		public static function register_notices() {

			if ( class_exists( 'Astra_Ext_White_Label_Markup' ) ) {
				if ( ! empty( Astra_Ext_White_Label_Markup::$branding['astra']['name'] ) ) {
					return;
				}
			}

			if ( false === get_option( 'astra-theme-old-setup' ) ) {
				set_transient( 'astra-theme-first-rating', true, MONTH_IN_SECONDS );
				update_option( 'astra-theme-old-setup', true );
			} elseif ( false === get_transient( 'astra-theme-first-rating' ) && current_user_can( 'install_plugins' ) ) {
				$image_path = ASTRA_THEME_URI . 'inc/assets/images/astra-logo.svg';
				Astra_Notices::add_notice(
					array(
						'id'                         => 'astra-theme-rating',
						'type'                       => '',
						'message'                    => sprintf(
							'<div class="notice-image">
								<img src="%1$s" class="custom-logo" alt="Astra" itemprop="logo"></div> 
								<div class="notice-content">
									<div class="notice-heading">
										%2$s
									</div>
									%3$s<br />
									<div class="astra-review-notice-container">
										<a href="%4$s" class="astra-notice-close astra-review-notice button-primary" target="_blank">
										%5$s
										</a>
									<span class="dashicons dashicons-calendar"></span>
										<a href="#" data-repeat-notice-after="%6$s" class="astra-notice-close astra-review-notice">
										%7$s
										</a>
									<span class="dashicons dashicons-smiley"></span>
										<a href="#" class="astra-notice-close astra-review-notice">
										%8$s
										</a>
									</div>
								</div>',
							$image_path,
							__( 'Hello! Seems like you have used Astra theme to build this website — Thanks a ton!', 'astra' ),
							__( 'Could you please do us a BIG favor and give it a 5-star rating on WordPress? This would boost our motivation and help other users make a comfortable decision while choosing the Astra theme.', 'astra' ),
							'https://wordpress.org/support/theme/astra/reviews/?filter=5#new-post',
							__( 'Ok, you deserve it', 'astra' ),
							MONTH_IN_SECONDS,
							__( 'Nope, maybe later', 'astra' ),
							__( 'I already did', 'astra' )
						),
						'repeat-notice-after'        => MONTH_IN_SECONDS,
						'priority'                   => 10,
						'display-with-other-notices' => false,
						'show_if'                    => class_exists( 'Astra_Ext_White_Label_Markup' ) ? Astra_Ext_White_Label_Markup::show_branding() : true,
					)
				);
			}

			// Force Astra welcome notice on theme activation.
			if ( current_user_can( 'install_plugins' ) && ! defined( 'ASTRA_SITES_NAME' ) && '1' == get_option( 'fresh_site' ) ) {

				wp_enqueue_script( 'astra-admin-settings' );
				$image_path           = ASTRA_THEME_URI . 'inc/assets/images/astra-logo.svg';
				$ast_sites_notice_btn = Astra_Admin_Settings::astra_sites_notice_button();

				if ( file_exists( WP_PLUGIN_DIR . '/astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-pro-sites/astra-pro-sites.php' ) ) {
					$ast_sites_notice_btn['button_text'] = __( 'Get Started', 'astra' );
					$ast_sites_notice_btn['class']      .= ' button button-primary button-hero';
				} elseif ( ! file_exists( WP_PLUGIN_DIR . '/astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-pro-sites/astra-pro-sites.php' ) ) {
					$ast_sites_notice_btn['button_text'] = __( 'Get Started', 'astra' );
					$ast_sites_notice_btn['class']      .= ' button button-primary button-hero';
					// Astra Premium Sites - Active.
				} elseif ( is_plugin_active( 'astra-pro-sites/astra-pro-sites.php' ) ) {
					$ast_sites_notice_btn['class'] = ' button button-primary button-hero astra-notice-close';
				} else {
					$ast_sites_notice_btn['class'] = ' button button-primary button-hero astra-notice-close';
				}

				$astra_sites_notice_args = array(
					'id'                         => 'astra-sites-on-active',
					'type'                       => 'info',
					'message'                    => sprintf(
						'<div class="notice-image">
							<img src="%1$s" class="custom-logo" alt="Astra" itemprop="logo"></div> 
							<div class="notice-content">
								<h2 class="notice-heading">
									%2$s
								</h2>
								<p>%3$s</p>
								<div class="astra-review-notice-container">
									<a class="%4$s" %5$s %6$s %7$s %8$s %9$s %10$s> %11$s </a>
								</div>
							</div>',
						$image_path,
						__( 'Thank you for installing Astra!', 'astra' ),
						__( 'Did you know Astra comes with dozens of ready-to-use <a href="https://wpastra.com/ready-websites/?utm_source=install-notice">starter site templates</a>? Install the Astra Starter Sites plugin to get started.', 'astra' ),
						esc_attr( $ast_sites_notice_btn['class'] ),
						'href="' . astra_get_prop( $ast_sites_notice_btn, 'link', '' ) . '"',
						'data-slug="' . astra_get_prop( $ast_sites_notice_btn, 'data_slug', '' ) . '"',
						'data-init="' . astra_get_prop( $ast_sites_notice_btn, 'data_init', '' ) . '"',
						'data-settings-link-text="' . astra_get_prop( $ast_sites_notice_btn, 'data_settings_link_text', '' ) . '"',
						'data-settings-link="' . astra_get_prop( $ast_sites_notice_btn, 'data_settings_link', '' ) . '"',
						'data-activating-text="' . astra_get_prop( $ast_sites_notice_btn, 'activating_text', '' ) . '"',
						esc_html( $ast_sites_notice_btn['button_text'] )
					),
					'priority'                   => 5,
					'display-with-other-notices' => false,
					'show_if'                    => class_exists( 'Astra_Ext_White_Label_Markup' ) ? Astra_Ext_White_Label_Markup::show_branding() : true,
				);

				Astra_Notices::add_notice(
					$astra_sites_notice_args
				);
			}
		}

		/**
		 * Display notice for minimun version for Astra addon.
		 *
		 * @since 2.0.0
		 */
		public static function minimum_addon_version_notice() {

			if ( ! defined( 'ASTRA_EXT_VER' ) ) {
				return;
			}

			$astra_theme_name = astra_get_theme_name();
			$astra_addon_name = astra_get_addon_name();

			$notice_args = array(
				'id'             => 'ast-minimum-addon-version-notice',
				'type'           => '',
				'message'        => sprintf(
					/* translators: %1$1s: Theme Name, %2$2s: Minimum Required version of the addon */
					__( 'Glad to see you have updated the %1$1s! Please update the %2$2s to version %3$3s or higher.', 'astra' ),
					$astra_theme_name,
					$astra_addon_name,
					ASTRA_EXT_MIN_VER
				),
				'priority'       => 1,
				'type'           => 'warning',
				'show_if'        => version_compare( ASTRA_EXT_VER, ASTRA_EXT_MIN_VER ) < 0,
				'is_dismissible' => false,
			);

			Astra_Notices::add_notice( $notice_args );
		}

		/**
		 * Enqueue Astra Notices CSS.
		 *
		 * @since 2.0.0
		 *
		 * @return void
		 */
		public static function notice_assets() {
			if ( is_rtl() ) {
				wp_enqueue_style( 'astra-notices-rtl', ASTRA_THEME_URI . 'inc/assets/css/astra-notices-rtl.css', array(), ASTRA_THEME_VERSION );
			} else {
				wp_enqueue_style( 'astra-notices', ASTRA_THEME_URI . 'inc/assets/css/astra-notices.css', array(), ASTRA_THEME_VERSION );
			}
		}

		/**
		 * Render button for Astra Site notices
		 *
		 * @since 1.6.5
		 * @return array $ast_sites_notice_btn Rendered button
		 */
		public static function astra_sites_notice_button() {
			$ast_sites_notice_btn = array();
			// Astra Sites - Installed but Inactive.
			// Astra Premium Sites - Inactive.
			if ( file_exists( WP_PLUGIN_DIR . '/astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-pro-sites/astra-pro-sites.php' ) ) {

				$ast_sites_notice_btn['class']                   = 'astra-activate-recommended-plugin';
				$ast_sites_notice_btn['button_text']             = __( 'Activate Importer Plugin', 'astra' );
				$ast_sites_notice_btn['data_slug']               = 'astra-sites';
				$ast_sites_notice_btn['data_init']               = '/astra-sites/astra-sites.php';
				$ast_sites_notice_btn['data_settings_link']      = admin_url( 'themes.php?page=astra-sites' );
				$ast_sites_notice_btn['data_settings_link_text'] = __( 'See Library »', 'astra' );
				$ast_sites_notice_btn['activating_text']         = __( 'Activating Importer Plugin ', 'astra' ) . '&hellip;';

				// Astra Sites - Not Installed.
				// Astra Premium Sites - Inactive.
			} elseif ( ! file_exists( WP_PLUGIN_DIR . '/astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-pro-sites/astra-pro-sites.php' ) ) {

				$ast_sites_notice_btn['class']                   = 'astra-install-recommended-plugin';
				$ast_sites_notice_btn['button_text']             = __( 'Install Importer Plugin', 'astra' );
				$ast_sites_notice_btn['data_slug']               = 'astra-sites';
				$ast_sites_notice_btn['data_init']               = '/astra-sites/astra-sites.php';
				$ast_sites_notice_btn['data_settings_link']      = admin_url( 'themes.php?page=astra-sites' );
				$ast_sites_notice_btn['data_settings_link_text'] = __( 'See Library »', 'astra' );
				$ast_sites_notice_btn['detail_link_class']       = 'plugin-detail thickbox open-plugin-details-modal astra-starter-sites-detail-link';
				$ast_sites_notice_btn['detail_link']             = admin_url( 'plugin-install.php?tab=plugin-information&plugin=astra-sites&TB_iframe=true&width=772&height=400' );
				$ast_sites_notice_btn['detail_link_text']        = __( 'Details »', 'astra' );

				// Astra Premium Sites - Active.
			} elseif ( is_plugin_active( 'astra-pro-sites/astra-pro-sites.php' ) ) {
				$ast_sites_notice_btn['class']       = 'active';
				$ast_sites_notice_btn['button_text'] = __( 'See Library »', 'astra' );
				$ast_sites_notice_btn['link']        = admin_url( 'themes.php?page=astra-sites' );
			} else {
				$ast_sites_notice_btn['class']       = 'active';
				$ast_sites_notice_btn['button_text'] = __( 'See Library »', 'astra' );
				$ast_sites_notice_btn['link']        = admin_url( 'themes.php?page=astra-sites' );
			}
			return $ast_sites_notice_btn;
		}

		/**
		 * Save All admin settings here
		 */
		public static function save_settings() {

			// Only admins can save settings.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Let extensions hook into saving.
			do_action( 'astra_admin_settings_save' );
		}

		/**
		 * Load the scripts and styles in the customizer controls.
		 *
		 * @since 1.2.1
		 */
		public static function customizer_scripts() {
			$color_palettes = json_encode( astra_color_palette() );
			wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $color_palettes . ';' );
		}

		/**
		 * Register admin scripts.
		 *
		 * @param String $hook Screen name where the hook is fired.
		 * @return void
		 */
		public static function register_scripts( $hook ) {
			$js_prefix  = '.min.js';
			$css_prefix = '.min.css';
			$dir        = 'minified';
			if ( SCRIPT_DEBUG ) {
				$js_prefix  = '.js';
				$css_prefix = '.css';
				$dir        = 'unminified';
			}

			if ( is_rtl() ) {
				$css_prefix = '-rtl.min.css';
				if ( SCRIPT_DEBUG ) {
					$css_prefix = '-rtl.css';
				}
			}

			/**
			 * Filters the Admin JavaScript handles added
			 *
			 * @since v1.4.10
			 *
			 * @param array array of the javascript handles.
			 */
			$js_handle = apply_filters( 'astra_admin_script_handles', array( 'jquery', 'wp-color-picker' ) );

			// Add customize-base handle only for the Customizer Preview Screen.
			if ( true === is_customize_preview() ) {
				$js_handle[] = 'customize-base';
			}

			wp_register_script( 'astra-color-alpha', ASTRA_THEME_URI . 'assets/js/' . $dir . '/wp-color-picker-alpha' . $js_prefix, $js_handle, ASTRA_THEME_VERSION, true );

			if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
				$post_types = get_post_types( array( 'public' => true ) );
				$screen     = get_current_screen();
				$post_type  = $screen->id;

				if ( in_array( $post_type, (array) $post_types ) ) {
					echo '<style class="astra-meta-box-style">
						.block-editor-page #side-sortables #astra_settings_meta_box select { min-width: 84%; padding: 3px 24px 3px 8px; height: 20px; min-height: 20px; }
						.block-editor-page #normal-sortables #astra_settings_meta_box select { min-width: 200px; }
						.block-editor-page .edit-post-meta-boxes-area #poststuff #astra_settings_meta_box h2.hndle { border-bottom: 0; }
						.block-editor-page #astra_settings_meta_box .components-base-control__field, .block-editor-page #astra_settings_meta_box .block-editor-page .transparent-header-wrapper, .block-editor-page #astra_settings_meta_box .adv-header-wrapper, .block-editor-page #astra_settings_meta_box .stick-header-wrapper, .block-editor-page #astra_settings_meta_box .disable-section-meta div { margin-bottom: 8px; }
						.block-editor-page #astra_settings_meta_box .disable-section-meta div label { vertical-align: inherit; }
						.block-editor-page #astra_settings_meta_box .post-attributes-label-wrapper { margin-bottom: 4px; }
						#side-sortables #astra_settings_meta_box select { min-width: 100%; }
						#normal-sortables #astra_settings_meta_box select { min-width: 200px; }
					</style>';
				}
			}
			/* Add CSS for the Submenu for BSF plugins added in Appearance Menu */

			if ( ! is_customize_preview() ) {
				echo '<style class="astra-menu-appearance-style">
					#menu-appearance a[href^="edit.php?post_type=astra-"]:before,
					#menu-appearance a[href^="themes.php?page=astra-"]:before,
					#menu-appearance a[href^="edit.php?post_type=astra_"]:before,
					#menu-appearance a[href^="edit-tags.php?taxonomy=bsf_custom_fonts"]:before,
					#menu-appearance a[href^="themes.php?page=custom-typekit-fonts"]:before,
					#menu-appearance a[href^="edit.php?post_type=bsf-sidebar"]:before {
					    content: "\21B3";
					    margin-right: 0.5em;
					    opacity: 0.5;
					}
				</style>';

				wp_register_script( 'astra-admin-settings', ASTRA_THEME_URI . 'inc/assets/js/astra-admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), ASTRA_THEME_VERSION );

				$localize = array(
					'ajaxUrl'                            => admin_url( 'admin-ajax.php' ),
					'btnActivating'                      => __( 'Activating Importer Plugin ', 'astra' ) . '&hellip;',
					'astraSitesLink'                     => admin_url( 'themes.php?page=astra-sites' ),
					'astraSitesLinkTitle'                => __( 'See Library »', 'astra' ),
					'recommendedPluiginActivatingText'   => __( 'Activating', 'astra' ) . '&hellip;',
					'recommendedPluiginDeactivatingText' => __( 'Deactivating', 'astra' ) . '&hellip;',
					'recommendedPluiginActivateText'     => __( 'Activate', 'astra' ),
					'recommendedPluiginDeactivateText'   => __( 'Deactivate', 'astra' ),
					'recommendedPluiginSettingsText'     => __( 'Settings', 'astra' ),
				);

				wp_localize_script( 'astra-admin-settings', 'astra', apply_filters( 'astra_theme_js_localize', $localize ) );
			}
		}

		/**
		 * Enqueues the needed CSS/JS for the builder's admin settings page.
		 *
		 * @since 1.0
		 */
		public static function styles_scripts() {

			// Styles.
			if ( is_rtl() ) {
				wp_enqueue_style( 'astra-admin-settings-rtl', ASTRA_THEME_URI . 'inc/assets/css/astra-admin-menu-settings-rtl.css', array(), ASTRA_THEME_VERSION );
			} else {
				wp_enqueue_style( 'astra-admin-settings', ASTRA_THEME_URI . 'inc/assets/css/astra-admin-menu-settings.css', array(), ASTRA_THEME_VERSION );
			}

			wp_register_script( 'astra-admin-settings', ASTRA_THEME_URI . 'inc/assets/js/astra-admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), ASTRA_THEME_VERSION );

			$localize = array(
				'ajaxUrl'                            => admin_url( 'admin-ajax.php' ),
				'btnActivating'                      => __( 'Activating Importer Plugin ', 'astra' ) . '&hellip;',
				'astraSitesLink'                     => admin_url( 'themes.php?page=astra-sites' ),
				'astraSitesLinkTitle'                => __( 'See Library »', 'astra' ),
				'recommendedPluiginActivatingText'   => __( 'Activating', 'astra' ) . '&hellip;',
				'recommendedPluiginDeactivatingText' => __( 'Deactivating', 'astra' ) . '&hellip;',
				'recommendedPluiginActivateText'     => __( 'Activate', 'astra' ),
				'recommendedPluiginDeactivateText'   => __( 'Deactivate', 'astra' ),
				'recommendedPluiginSettingsText'     => __( 'Settings', 'astra' ),

			);
			wp_localize_script( 'astra-admin-settings', 'astra', apply_filters( 'astra_theme_js_localize', $localize ) );

			// Script.
			wp_enqueue_script( 'astra-admin-settings' );

			if ( ! file_exists( WP_PLUGIN_DIR . '/astra-sites/astra-sites.php' ) && is_plugin_inactive( 'astra-pro-sites/astra-pro-sites.php' ) ) {
				// For starter site plugin popup detail "Details »" on Astra Options page.
				wp_enqueue_script( 'plugin-install' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_style( 'thickbox' );
			}
		}


		/**
		 * Get and return page URL
		 *
		 * @param string $menu_slug Menu name.
		 * @since 1.0
		 * @return  string page url
		 */
		public static function get_page_url( $menu_slug ) {

			$parent_page = self::$default_menu_position;

			if ( strpos( $parent_page, '?' ) !== false ) {
				$query_var = '&page=' . self::$plugin_slug;
			} else {
				$query_var = '?page=' . self::$plugin_slug;
			}

			$parent_page_url = admin_url( $parent_page . $query_var );

			$url = $parent_page_url . '&action=' . $menu_slug;

			return esc_url( $url );
		}

		/**
		 * Add main menu
		 *
		 * @since 1.0
		 */
		public static function add_admin_menu() {

			$parent_page    = self::$default_menu_position;
			$page_title     = self::$menu_page_title;
			$capability     = 'manage_options';
			$page_menu_slug = self::$plugin_slug;
			$page_menu_func = __CLASS__ . '::menu_callback';

			if ( apply_filters( 'astra_dashboard_admin_menu', true ) ) {
				add_theme_page( $page_title, $page_title, $capability, $page_menu_slug, $page_menu_func );
			} else {
				do_action( 'asta_register_admin_menu', $parent_page, $page_title, $capability, $page_menu_slug, $page_menu_func );
			}
		}

		/**
		 * Menu callback
		 *
		 * @since 1.0
		 */
		public static function menu_callback() {

			$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;

			$active_tab   = str_replace( '_', '-', $current_slug );
			$current_slug = str_replace( '-', '_', $current_slug );

			$ast_icon           = apply_filters( 'astra_page_top_icon', true );
			$ast_visit_site_url = apply_filters( 'astra_site_url', 'https://wpastra.com' );
			$ast_wrapper_class  = apply_filters( 'astra_welcome_wrapper_class', array( $current_slug ) );

			?>
			<div class="ast-menu-page-wrapper wrap ast-clear <?php echo esc_attr( implode( ' ', $ast_wrapper_class ) ); ?>">
					<div class="ast-theme-page-header">
						<div class="ast-container ast-flex">
							<div class="ast-theme-title">
								<a href="<?php echo esc_url( $ast_visit_site_url ); ?>" target="_blank" rel="noopener" >
								<?php if ( $ast_icon ): ?>
									<img src="<?php echo esc_url( ASTRA_THEME_URI . 'inc/assets/images/astra.svg' ); ?>" class="ast-theme-icon" alt="<?php echo esc_attr( self::$page_title ); ?> " >
								<?php else: ?>
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo.jpg' ?>" class="ast-theme-icon" alt="<?php echo $whiteLabel; ?> Theme Logo" >
								<?php endif; ?>
								<?php do_action( 'astra_welcome_page_header_title' ); ?>
								</a>
							</div>

							<?php do_action( 'astra_header_right_section' ); ?>

						</div>
					</div>

				<?php do_action( 'astra_menu_' . esc_attr( $current_slug ) . '_action' ); ?>
			</div>
			<?php
		}

		/**
		 * Include general page
		 *
		 * @since 1.0
		 */
		public static function general_page() {
			require_once ASTRA_THEME_DIR . 'inc/core/view-general.php';
		}

		/**
		 * Include Welcome page right starter sites content
		 *
		 * @since 1.2.4
		 */
		public static function astra_welcome_page_starter_sites_section() {

			if ( astra_is_white_labelled() ) {
				return;
			}
			?>

			<?php
		}

		/**
		 * Include Welcome page right side knowledge base content
		 *
		 * @since 1.2.4
		 */
		public static function astra_welcome_page_knowledge_base_scetion() {

			if ( astra_is_white_labelled() ) {
				return;
			}

			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-book"></span>
					<span><?php esc_html_e( 'Knowledge Base', 'astra' ); ?></span>
				</h2>
				<div class="inside">
					<p>
						<?php esc_html_e( 'Not sure how something works? Take a peek at the knowledge base and learn.', 'astra' ); ?>
					</p>
					<?php
					$astra_knowledge_base_doc_link      = apply_filters( 'astra_knowledge_base_documentation_link', astra_get_pro_url( 'https://wpastra.com/docs/', 'astra-dashboard', 'visit-documentation', 'welcome-page' ) );
					$astra_knowledge_base_doc_link_text = apply_filters( 'astra_knowledge_base_documentation_link_text', __( 'Visit Knowledge Base »', 'astra' ) );

					printf(
						/* translators: %1$s: Astra Knowledge doc link. */
						'%1$s',
						! empty( $astra_knowledge_base_doc_link ) ? '<a href=' . esc_url( $astra_knowledge_base_doc_link ) . ' target="_blank" rel="noopener">' . esc_html( $astra_knowledge_base_doc_link_text ) . '</a>' :
						esc_html( $astra_knowledge_base_doc_link_text )
					);
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Include Welcome page right side Astra community content
		 *
		 * @since 1.2.4
		 */
		public static function astra_welcome_page_community_scetion() {

			if ( astra_is_white_labelled() ) {
				return;
			}

			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-groups"></span>
					<span>
						<?php
						printf(
							/* translators: %1$s: Astra Theme name. */
							esc_html__( '%1$s Community', 'astra' ),
							self::$page_title
						);
						?>
				</h2>
				<div class="inside">
					<p>
						<?php
						printf(
							/* translators: %1$s: Astra Theme name. */
							esc_html__( 'Join the community of super helpful %1$s users. Say hello, ask questions, give feedback and help each other!', 'astra' ),
							self::$page_title
						);
						?>
					</p>
					<?php
					$astra_community_group_link      = apply_filters( 'astra_community_group_link', 'https://www.facebook.com/groups/wpastra' );
					$astra_community_group_link_text = apply_filters( 'astra_community_group_link_text', __( 'Join Our Facebook Group »', 'astra' ) );

					printf(
						/* translators: %1$s: Astra Knowledge doc link. */
						'%1$s',
						! empty( $astra_community_group_link ) ? '<a href=' . esc_url( $astra_community_group_link ) . ' target="_blank" rel="noopener">' . esc_html( $astra_community_group_link_text ) . '</a>' :
						esc_html( $astra_community_group_link_text )
					);
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Include Welcome page right side Five Star Support
		 *
		 * @since 1.2.4
		 */
		public static function astra_welcome_page_five_star_scetion() {

			if ( astra_is_white_labelled() ) {
				return;
			}

			?>

			<div class="postbox">
				<h2 class="hndle ast-normal-cusror">
					<span class="dashicons dashicons-sos"></span>
					<span><?php esc_html_e( 'Five Star Support', 'astra' ); ?></span>
				</h2>
				<div class="inside">
					<p>
						<?php
						printf(
							/* translators: %1$s: Astra Theme name. */
							esc_html__( 'Got a question? Get in touch with %1$s developers. We\'re happy to help!', 'astra' ),
							self::$page_title
						);
						?>
					</p>
					<?php
						$astra_support_link      = apply_filters( 'astra_support_link', astra_get_pro_url( 'https://wpastra.com/contact/', 'astra-dashboard', 'submit-a-ticket', 'welcome-page' ) );
						$astra_support_link_text = apply_filters( 'astra_support_link_text', __( 'Submit a Ticket »', 'astra' ) );

						printf(
							/* translators: %1$s: Astra Knowledge doc link. */
							'%1$s',
							! empty( $astra_support_link ) ? '<a href=' . esc_url( $astra_support_link ) . ' target="_blank" rel="noopener">' . esc_html( $astra_support_link_text ) . '</a>' :
							esc_html( $astra_support_link_text )
						);
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Include Welcome page content
		 *
		 * @since 1.2.4
		 */
		public static function astra_welcome_page_content() {

			$astra_addon_tagline = apply_filters( 'astra_addon_list_tagline', __( 'More Options Available with Astra Pro!', 'astra' ) );

			// Quick settings.
			$quick_settings = apply_filters(
				'astra_quick_settings',
				array(
					'logo-favicon' => array(
						'title'     => __( 'Upload Logo', 'astra' ),
						'dashicon'  => 'dashicons-format-image',
						'quick_url' => admin_url( 'customize.php?autofocus[control]=custom_logo' ),
					),
					'colors'       => array(
						'title'     => __( 'Set Colors', 'astra' ),
						'dashicon'  => 'dashicons-admin-customizer',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-colors-background' ),
					),
					'typography'   => array(
						'title'     => __( 'Customize Fonts', 'astra' ),
						'dashicon'  => 'dashicons-editor-textcolor',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-typography' ),
					),
					'layout'       => array(
						'title'     => __( 'Layout Options', 'astra' ),
						'dashicon'  => 'dashicons-layout',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-container-layout' ),
					),
					'header'       => array(
						'title'     => __( 'Header Options', 'astra' ),
						'dashicon'  => 'dashicons-align-center',
						'quick_url' => admin_url( 'customize.php?autofocus[panel]=panel-header-group' ),
					),
					'blog-layout'  => array(
						'title'     => __( 'Blog Layouts', 'astra' ),
						'dashicon'  => 'dashicons-welcome-write-blog',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-blog-group' ),
					),
					'footer'       => array(
						'title'     => __( 'Footer Settings', 'astra' ),
						'dashicon'  => 'dashicons-admin-generic',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-footer-group' ),
					),
					'sidebars'     => array(
						'title'     => __( 'Sidebar Options', 'astra' ),
						'dashicon'  => 'dashicons-align-left',
						'quick_url' => admin_url( 'customize.php?autofocus[section]=section-sidebars' ),
					),
				)
			);

			?>
			<div class="postbox">
				<h2 class="hndle ast-normal-cusror"><span><?php esc_html_e( 'Links to Customizer Settings:', 'astra' ); ?></span></h2>
					<div class="ast-quick-setting-section">
						<?php
						if ( ! empty( $quick_settings ) ) :
							?>
							<div class="ast-quick-links">
								<ul class="ast-flex">
									<?php
									foreach ( (array) $quick_settings as $key => $link ) {
										echo '<li class=""><span class="dashicons ' . esc_attr( $link['dashicon'] ) . '"></span><a class="ast-quick-setting-title" href="' . esc_url( $link['quick_url'] ) . '" target="_blank" rel="noopener">' . esc_html( $link['title'] ) . '</a></li>';
									}
									?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
			</div>

			<!-- Notice for Older version of Astra Addon -->
			<?php self::min_addon_version_message(); ?>

			<?php
		}

		/**
		 * Include Welcome page content
		 *
		 * @since 1.2.4
		 */

		/**
		 * Build plugin's page URL on WordPress.org
		 * https://wordpress.org/plugins/{plugin-slug}
		 *
		 * @since 1.6.9
		 * @param String $slug plugin slug.
		 * @return String Plugin URL on WordPress.org
		 */
		private static function build_worg_plugin_link( $slug ) {
			return esc_url( trailingslashit( 'https://wordpress.org/plugins/' . $slug ) );
		}

		/**
		 * Required Plugin Activate
		 *
		 * @since 1.2.4
		 */
		public static function required_plugin_activate() {

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'astra' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

			$activate = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $activate->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Plugin Successfully Activated', 'astra' ),
				)
			);

		}

		/**
		 * Required Plugin Activate
		 *
		 * @since 1.2.4
		 */
		public static function required_plugin_deactivate() {

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'astra' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

			$deactivate = deactivate_plugins( $plugin_init, '', false );

			if ( is_wp_error( $deactivate ) ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $deactivate->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Plugin Successfully Deactivated', 'astra' ),
				)
			);

		}

		/**
		 * Check compatible theme version.
		 *
		 * @since 1.2.4
		 */
		public static function min_addon_version_message() {

			$astra_global_options = get_option( 'astra-settings' );

			if ( isset( $astra_global_options['astra-addon-auto-version'] ) && defined( 'ASTRA_EXT_VER' ) ) {

				if ( version_compare( $astra_global_options['astra-addon-auto-version'], '1.2.1' ) < 0 ) {

					// If addon is not updated & White Label for Addon is added then show the white labelewd pro name.
					$astra_addon_name        = astra_get_addon_name();
					$update_astra_addon_link = astra_get_pro_url( 'https://wpastra.com/?p=25258', 'astra-dashboard', 'update-to-astra-pro', 'welcome-page' );
					if ( class_exists( 'Astra_Ext_White_Label_Markup' ) ) {
						$plugin_data = Astra_Ext_White_Label_Markup::$branding;
						if ( ! empty( $plugin_data['astra-pro']['name'] ) ) {
							$update_astra_addon_link = '';
						}
					}

					$class   = 'ast-notice ast-notice-error';
					$message = sprintf(
						/* translators: %1$1s: Addon Name, %2$2s: Minimum Required version of the Astra Addon */
						__( 'Update to the latest version of %1$2s to make changes in settings below.', 'astra' ),
						( ! empty( $update_astra_addon_link ) ) ? '<a href=' . esc_url( $update_astra_addon_link ) . ' target="_blank" rel="noopener">' . $astra_addon_name . '</a>' : $astra_addon_name
					);

					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
				}
			}
		}

		/**
		 * Astra Header Right Section Links
		 *
		 * @since 1.2.4
		 */
		public static function top_header_right_section() {

			$top_links = apply_filters(
				'astra_header_top_links',
				array(
					'astra-theme-info' => array(
						'title' => __( '⚡ Lightning Fast & Fully Customizable WordPress theme!', 'astra' ),
					),
				)
			);

			if ( ! empty( $top_links ) ) {
				?>
				<div class="ast-top-links">
					<ul>
						<?php
						foreach ( (array) $top_links as $key => $info ) {
							/* translators: %1$s: Top Link URL wrapper, %2$s: Top Link URL, %3$s: Top Link URL target attribute */
							printf(
								'<li><%1$s %2$s %3$s > %4$s </%1$s>',
								isset( $info['url'] ) ? 'a' : 'span',
								isset( $info['url'] ) ? 'href="' . esc_url( $info['url'] ) . '"' : '',
								isset( $info['url'] ) ? 'target="_blank" rel="noopener"' : '',
								esc_html( $info['title'] )
							);
						}
						?>
						</ul>
					</div>
				<?php
			}
		}
	}

	new Astra_Admin_Settings();
}
