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

//== Astra Parent Theme Overrides
if ( is_admin() ) {
	require_once trailingslashit( get_stylesheet_directory() ) . 'inc/core/class-astra-admin-settings.php';
}
//==

//== Remove Default Astra theme font (astra.woff)
// add_filter( 'astra_enable_default_fonts', '__return_false' );
//==

//== Include Shortcodes
require_once trailingslashit( get_stylesheet_directory() ) . 'shortcodes.php';
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
function is_blog() {
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
 * Check if page is a parent/ancestor of current page
 * 
 * @param integer
 * @return boolean
 */

function has_ancestor( $ancestorPageID ) {
    $ancestorsArr = get_post_ancestors( get_the_ID() );
    if ( in_array( $ancestorPageID, $ancestorsArr) ) {
        return true;
    }
    return false;
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