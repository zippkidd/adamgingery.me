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
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

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
