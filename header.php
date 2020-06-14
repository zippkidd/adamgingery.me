<?php
/**
 * The header for Astra Child Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>

<?php astra_body_top(); ?>
<?php wp_body_open(); ?>
<div 
	<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?></a>

    <span class="test before astra_header_before"></span>
	<?php astra_header_before(); ?>
    <span class="test after astra_header_before before astra_header"></span>
	<?php astra_header(); //this is the header#masthead part ?>
    <span class="test after astra_header before astra_header_after"></span>
	<?php astra_header_after(); ?>
    <span class="test after astra_header_after before astra_content_before"></span>
	<?php astra_content_before(); ?>
    <span class="test after astra_content_before"></span>

	<div id="content" class="site-content">

		<div class="ast-container">

		<?php astra_content_top(); ?>
