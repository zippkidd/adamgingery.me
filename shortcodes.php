<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function contact_form_func() {
	wp_enqueue_script('validate_lib');
	wp_enqueue_script('contact_form');
$html = <<<HTML
<form class="contactForm" action="https://formsubmit.co/CHANGEME" method="POST" novalidate>
	<label for="name">
		Name
		<span class="name error">Name is required.</span>
		<input type="text" name="name" id="name" required />
	</label>
	<label for="email">
		Email address
		<span class="email error">Email is invalid.</span>
		<input type="email" name="email" id="email" required />
	</label>
	<label for="_subject">
		Subject
		<span class="_subject error">Subject is required.</span>
		<input type="text" name="_subject" id="subject" required />
	</label>
	<label for="message">
		Message
		<span class="message error">Message is required.</span>
		<textarea name="message" id="message" rows="3"></textarea>
	</label>
	<input type="text" name="_honey">
	<input type="hidden" name="_captcha" value="false">
	<input type="hidden" name="action" value="contactform_action" />
	<input type="submit" value="Submit" id="contactSubmit" />
</form>
<div class="responseMsg"></div>
HTML;
	return $html;
}
add_shortcode( 'contact_form', 'contact_form_func' );

function carousel_func() {
	wp_enqueue_script('carousel_library');
	wp_enqueue_script('carousel');
$html = <<<HTML
<div class="carouselWrapper">
	<div class="prev"></div>
	<div class="carousel">
		<div>
			<figure class="txt-center">
				<!-- Slide Content Here -->
			</figure>
		</div>
		<div>
			<figure class="txt-center">
				<!-- Slide Content Here -->
			</figure>
		</div>
		<div>
			<figure class="txt-center">
				<!-- Slide Content Here -->
			</figure>
		</div>
	</div>
	<div class="next"></div>
</div>
HTML;

	return $html;
}
add_shortcode( 'carousel', 'carousel_func' );

function chevron_jump_func( $atts ) {
	$a = shortcode_atts( array(
		'to' => 'no-anchor-selected'
	), $atts);
	$html = '
		<div class="chevronJump flex-center">
			<a href="#' . $a['to'] . '"></a>
		</div>';
	return $html;
}
add_shortcode( 'chevron_jump', 'chevron_jump_func' );

function chevron_landing_func( $atts ) {
	$a = shortcode_atts( array(
		'id' => 'no-anchor-selected'
	), $atts);
	$html = '
		<div class="chevronLanding invisible">
			<a id="' . $a['id'] . '"></a>
		</div>';
	return $html;
}
add_shortcode( 'chevron_landing', 'chevron_landing_func' );

function trust_bar_func() {
$html = <<<HTML
<div class="trust-bar">
	<img src="/wp-content/uploads/2020/07/benq-logo-new-bigger.png" alt="benq logo">
	<img src="/wp-content/uploads/2020/07/enu-logo.svg" alt="enu-nutrition logo">
	<img src="/wp-content/uploads/2020/07/logo-broadview-networks-vector.svg" alt="broadview networks logo">
	<img src="/wp-content/uploads/2020/07/logo-cross-country-healthcare.png" alt="cross country healthcare logo">
</div>
HTML;
return $html;
}
add_shortcode( 'trust_bar', 'trust_bar_func' );