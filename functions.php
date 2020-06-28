<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//== Set Parent Theme
add_action( 'wp_enqueue_scripts', 'lpc_enqueue_styles' );
function lpc_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  // wp_enqueue_style( 'child-normalize',
  // 	get_stylesheet_directory_uri() . '/normalize.css',
  // 	array( 'parent-style' ),
  // 	wp_get_theme()->get('Version')
  // );
  wp_enqueue_style( 'child-style',
    get_stylesheet_directory_uri() . '/style.css',
    array( 'parent-style' ),
    wp_get_theme()->get('Version')
  );
  wp_enqueue_style( 'normalize-style',
    get_stylesheet_directory_uri() . '/normalize.css',
    array( 'child-style' ),
    wp_get_theme()->get('Version')
  );
}
//==

//== Run Scripts Only on Frontend
if ( !is_admin() ) {
	function load_custom_scripts() {
    // wp_deregister_script( 'jquery' );
    wp_register_script('carousel_library', get_stylesheet_directory_uri() . '/js/siema.min.js', array(), true);
    wp_register_script('carousel', get_stylesheet_directory_uri() . '/js/carousel.js', array('carousel_library'), true);
    // wp_register_script('carousel', get_stylesheet_directory_uri() . '/js/carousel.js', array(), true);
    wp_register_script('validate_lib', get_stylesheet_directory_uri() . '/js/validate.min.js', array(), true);
    wp_register_script('contact_form', get_stylesheet_directory_uri() . '/js/contact-form.js', array('validate_lib'), true);
    wp_register_script('general_scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), true);
    wp_enqueue_script('general_scripts');
	}
	add_action('wp_enqueue_scripts', 'load_custom_scripts', 99);

	function defer_parsing_of_js ( $url ) {
		if ( FALSE === strpos( $url, '.js' ) ) return $url;
		// if ( strpos( $url, 'jquery.js' ) ) return $url;
		// if ( strpos( $url, 'jquery' ) ) return $url;
		return "$url' defer ";
	}
	add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

	// Remove Query Strings From Static Resources 
	// function _remove_script_version( $src ){ 
	// 	$parts = explode( '?', $src );
	// 	return $parts[0];
	// }
	// add_filter( 'script_loader_src', '_remove_script_version', 15, 1 ); 
	// add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
}
//==

//== Include Shortcodes
require_once trailingslashit( get_stylesheet_directory() ) . 'shortcodes.php';
//==

//== Astra Parent Theme Overrides

// Remove premium options, add White Label
if ( is_admin() ) {
	require_once trailingslashit( get_stylesheet_directory() ) . 'inc/core/class-astra-admin-settings.php';
}

// Override astra_header(), add silo menu functionality
remove_action( 'astra_masthead_content', 'astra_primary_navigation_markup', 10 );
function astra_primary_navigation_markup() {

	$disable_primary_navigation = astra_get_option( 'disable-primary-nav' );
	$custom_header_section      = astra_get_option( 'header-main-rt-section' );

	if ( $disable_primary_navigation ) {

		$display_outside = astra_get_option( 'header-display-outside-menu' );

		if ( 'none' != $custom_header_section && ! $display_outside ) {

			echo '<div class="main-header-bar-navigation ast-header-custom-item ast-flex ast-justify-content-flex-end">';
			/**
			 * Fires before the Primary Header Menu navigation.
			 * Disable Primary Menu is checked
			 * Last Item in Menu is not 'none'.
			 * Take Last Item in Menu outside is unchecked.
			 *
			 * @since 1.4.0
			 */
			do_action( 'astra_main_header_custom_menu_item_before' );

			echo astra_masthead_get_menu_items(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			/**
			 * Fires after the Primary Header Menu navigation.
			 * Disable Primary Menu is checked
			 * Last Item in Menu is not 'none'.
			 * Take Last Item in Menu outside is unchecked.
			 *
			 * @since 1.4.0
			 */
			do_action( 'astra_main_header_custom_menu_item_after' );

			echo '</div>';

		}
	} else {

		$submenu_class = apply_filters( 'primary_submenu_border_class', ' submenu-with-border' );

		// Menu Animation.
		$menu_animation = astra_get_option( 'header-main-submenu-container-animation' );
		if ( ! empty( $menu_animation ) ) {
			$submenu_class .= ' astra-menu-animation-' . esc_attr( $menu_animation ) . ' ';
		}

		/**
		 * Filter the classes(array) for Primary Menu (<ul>).
		 *
		 * @since  1.5.0
		 * @var Array
		 */
		$primary_menu_classes = apply_filters( 'astra_primary_menu_classes', array( 'main-header-menu', 'ast-nav-menu', 'ast-flex', 'ast-justify-content-flex-end', $submenu_class ) );

		$items_wrap  = '<nav ';
		$items_wrap .= astra_attr(
			'site-navigation',
			array(
				'id'         => 'site-navigation',
				'class'      => 'ast-flex-grow-1 navigation-accessibility',
				'aria-label' => esc_attr__( 'Site Navigation', 'astra' ),
			)
		);
		$items_wrap .= '>';
		$items_wrap .= '<div class="main-navigation">';
		$items_wrap .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
		$items_wrap .= '</div>';
		$items_wrap .= '</nav>';

		// Primary Menu.
		$primary_menu_args = array(
			'menu'			  => resolvePrimaryMenu(),
			'theme_location'  => 'primary',
			'menu_id'         => 'primary-menu',
			'menu_class'      => esc_attr( implode( ' ', $primary_menu_classes ) ),
			'container'       => 'div',
			'container_class' => 'main-header-bar-navigation',
			'items_wrap'      => $items_wrap,
		);

		// To add default alignment for navigation which can be added through any third party plugin.
		// Do not add any CSS from theme except header alignment.
		echo '<div ' . astra_attr( 'ast-main-header-bar-alignment' ) . '>';
			wp_nav_menu( $primary_menu_args );
		echo '</div>';
	}

}

add_action( 'astra_masthead_content', 'astra_primary_navigation_markup', 10 );
//==

//== Remove Default Astra theme font (astra.woff)
// add_filter( 'astra_enable_default_fonts', '__return_false' );
//==

//== Functions
/**
 * Check if page is being loaded from mobile device, based on network headers
 * 
 * @return boolean
 */
function isMobile() {
	return preg_match("/\b(?:a(?:ndroid|vantgo)|b(?:lackberry|olt|o?ost)|cricket|docomo|hiptop|i(?:emobile|p[ao]d)|kitkat|m(?:ini|obi)|palm|(?:i|smart|windows )phone|symbian|up\.(?:browser|link)|tablet(?: browser| pc)|(?:hp-|rim |sony )tablet|w(?:ebos|indows ce|os))/i", $_SERVER["HTTP_USER_AGENT"]);
}

/**
 * Check if is blog page
 * 
 * @return boolean
 */
function isBlog() {
	return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

/**
 * Get top parent for the current page
 *
 * If the page is the highest level page, it will return it's own ID, or
 * if the page has parent(s) it will get the highest level page ID. 
 *
 * @return integer
 */
function get_top_parent_page_id() {
    global $post;
    $ancestors = $post->ancestors;

    // Check if the page is a child page (any level)
    if ($ancestors) {
        //  Get the ID of top-level page from the tree
        return end($ancestors);
    } else {
        // The page is the top level, so use its own ID
        return $post->ID;
    }
}

/**
 * Check if page is related to the passed parent page
 * 
 * @param integer
 * @return boolean
 */
function isRelated( $ancestorPageID ) {
	$pageID = get_the_ID();
	$ancestorsArr = get_post_ancestors( $pageID );
	if ($ancestorsArr ) {
		if ( in_array( $ancestorPageID, $ancestorsArr) ) {
			return true;
		}
	} else {
		if ( $ancestorPageID === $pageID ) {
			return true;
		}
	}
	return false;
 }

 /**
  * Resolve which silo menu to display
  *
  * @return string
  */
function resolvePrimaryMenu() {
	if ( isRelated(MUSIC_PARENT) ) {
		return MUSIC_MENU;
	} elseif ( isRelated(MARKETING_PARENT) ) {
		return MARKETING_MENU;
	} elseif ( isRelated(PODCAST_PARENT) ) {
		return PODCAST_MENU;
	} else {
		return 'Primary';
	}
}
//==

//== Remove Comments
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');
//==

//== Disable Feeds
// function itsme_disable_feed() {
// 	wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
// }
// add_action('do_feed', 'itsme_disable_feed', 1);
// add_action('do_feed_rdf', 'itsme_disable_feed', 1);
// add_action('do_feed_rss', 'itsme_disable_feed', 1);
// add_action('do_feed_rss2', 'itsme_disable_feed', 1);
// add_action('do_feed_atom', 'itsme_disable_feed', 1);
// add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
// add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);
//==

//== Fixes
function noindex_pagination_fix() {
	if(is_paged()) echo '<meta name="robots" content="noindex,follow"/>';
}
add_action('wp_head', 'noindex_pagination_fix');

function allow_svg( $mimes ){
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg' );

// Remove Emoji Icons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove Dashicons
function my_deregister_styles()    {
	if( !is_user_logged_in() ) 
		wp_deregister_style( 'dashicons'); 
}
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
//==

//== Constants
// Music
if ( !defined( "MUSIC_CATEGORY" ))  {
	define( "MUSIC_CATEGORY", 5 );
}
if ( !defined( "MUSIC_PARENT" ))  {
	define( "MUSIC_PARENT", 33 );
}
if ( !defined( "MUSIC_MENU" ))  {
	define( "MUSIC_MENU", "Music" );
}

// Marketing
if ( !defined( "MARKETING_CATEGORY" ))  {
	define( "MARKETING_CATEGORY", 6 );
}
if ( !defined( "MARKETING_PARENT" ))  {
	define( "MARKETING_PARENT", 25 );
}
if ( !defined( "MARKETING_MENU" ))  {
	define( "MARKETING_MENU", "Marketing" );
}

// Podcast
if ( !defined( "PODCAST_CATEGORY" ))  {
	define( "PODCAST_CATEGORY", 7 );
}
if ( !defined( "PODCAST_PARENT" ))  {
	define( "PODCAST_PARENT", 27 );
}
if ( !defined( "PODCAST_MENU" ))  {
	define( "PODCAST_MENU", "Podcast" );
}
//==