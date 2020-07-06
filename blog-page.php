<?php
/**
 * Template Name: Blog Page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php //astra_content_loop(); ?>

		<!-- Let's build custom loop here... -->
		<main id="main" class="site-main">
			<div class="ast-row">
				<?php
				// Let's build custom wp_query here...
				$args = array(
					'cat' => $cat, //let's decide cat based on isRelated()
				);
				// The Query
				$the_query = new WP_Query( $args );
				
				// The Loop
				if ( $the_query->have_posts() ) {
					echo '<ul>';
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<li>' . get_the_title() . '</li>';
					}
					echo '</ul>';
				} else {
					// no posts found
				}
				/* Restore original Post Data */
				wp_reset_postdata();
				?>
			</div>
		</main>

		<?php astra_pagination(); ?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
