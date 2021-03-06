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

<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

<?php
add_filter( 'body_class', function ($classes) {
	unset( $classes[array_search('ast-single-post', $classes)] );
    return $classes;
} );
?>

<body <?php astra_schema_body(); ?> <?php body_class('blog'); ?>>

<?php astra_body_top(); ?>
<?php wp_body_open(); ?>
<div 
	<?php echo astra_attr('site', ['id' => 'page', 'class' => 'hfeed site']); ?>
>
	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html(
   astra_default_strings('string-header-skip-link', false)
 ); ?></a>

	<?php astra_header_before(); ?>
	
	<?php astra_header(); ?>

	<?php astra_header_after(); ?>
	
	<?php astra_content_before(); ?>

	<div id="content" class="site-content">

		<div class="ast-container">

		<?php astra_content_top(); ?>
