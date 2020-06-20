<?php
/**
 * The header for Astra Child Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 */

if (!defined('ABSPATH')) {
  exit(); // Exit if accessed directly.
} ?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>

<?php astra_body_top(); ?>
<?php wp_body_open(); ?>
<div 
	<?php echo astra_attr('site', ['id' => 'page', 'class' => 'hfeed site']); ?>
>
	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html(
   astra_default_strings('string-header-skip-link', false)
 ); ?></a>

    <span class="test before astra_header_before"></span>
	<?php astra_header_before(); ?>
	<span class="test after astra_header_before before astra_header"></span>
	
	<!-- Custom Header+Menu Start -->

	<!-- Originally: -->
	<?php
//astra_header(); //this is the header#masthead part
?>
	<!-- Originally End -->


<?php
	/*
	wp_nav_menu( array $args = array(
		'menu'              => "", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
		'menu_class'        => "", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
		'menu_id'           => "", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
		'container'         => "", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
		'container_class'   => "", // (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
		'container_id'      => "", // (string) The ID that is applied to the container.
		'fallback_cb'       => "", // (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
		'before'            => "", // (string) Text before the link markup.
		'after'             => "", // (string) Text after the link markup.
		'link_before'       => "", // (string) Text before the link text.
		'link_after'        => "", // (string) Text after the link text.
		'echo'              => "", // (bool) Whether to echo the menu or return it. Default true.
		'depth'             => "", // (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
		'walker'            => "", // (object) Instance of a custom walker class.
		'theme_location'    => "", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
		'items_wrap'        => "", // (string) How the list items should be wrapped. Default is a ul with an id and class. Uses printf() format with numbered placeholders.
		'item_spacing'      => "", // (string) Whether to preserve whitespace within the menu's HTML. Accepts 'preserve' or 'discard'. Default 'preserve'.
	) );
	*/
	// wp_nav_menu( array $args = array(
	// 	'menu'              => "Primary Menu", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
	// 	'menu_class'        => "menu_class_test1 menu_class_test2", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
	// 	'menu_id'           => "", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
	// 	'container'         => "", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
	// 	'container_class'   => "", // (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
	// 	'container_id'      => "", // (string) The ID that is applied to the container.
	// 	'fallback_cb'       => "", // (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
	// 	'before'            => "", // (string) Text before the link markup.
	// 	'after'             => "", // (string) Text after the link markup.
	// 	'link_before'       => "", // (string) Text before the link text.
	// 	'link_after'        => "", // (string) Text after the link text.
	// 	'echo'              => "", // (bool) Whether to echo the menu or return it. Default true.
	// 	'depth'             => "", // (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
	// 	'walker'            => "", // (object) Instance of a custom walker class.
	// 	'theme_location'    => "", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
	// ) );

	$primary_menu_classes = apply_filters( 'astra_primary_menu_classes', array( 'main-header-menu', 'ast-nav-menu', 'ast-flex', 'ast-justify-content-flex-end', $submenu_class ) );
?>


	<!-- Custom Header+Menu End -->
    <span class="test after astra_header before astra_header_after"></span>
	<?php astra_header_after(); ?>
    <span class="test after astra_header_after before astra_content_before"></span>
	<?php astra_content_before(); ?>
    <span class="test after astra_content_before"></span>

	<div id="content" class="site-content">

		<div class="ast-container">

		<?php astra_content_top(); ?>
