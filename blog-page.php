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
				// truncate the_content() to 55 words
				// Let's build custom wp_query here...

				// Define custom query parameters
				$custom_query_args = array(
					'cat' 			 => resolveBlogCat(), // only main blog page shouldn't have category, so this should always return a category ID
					'posts_per_page' => 6,
					'paged'			 => $paged,
					
				);

				// Get current page and append to custom query parameters array
				$custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				
				// Instantiate custom query
				$custom_query = new WP_Query( $custom_query_args );
				
				// Pagination fix
				$temp_query = $wp_query;
				$wp_query   = NULL;
				$wp_query   = $custom_query;
				
				// Output custom query loop
				if ( $custom_query->have_posts() ) :
					while ( $custom_query->have_posts() ) :
						$custom_query->the_post();

						$thumb 		= '';

						$width = 1080;
						$height = 675;
						$class_text = 'et_pb_post_main_image';
						$title_text = get_the_title();
						$alt_text    = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
						// $thumbnail  = get_thumbnail( $width, $height, $class_text, $alt_text, $title_text, false, 'Blogimage' );
						// $thumb      = $thumbnail["thumb"];

						the_content();

						// Loop output goes here
					endwhile;
				else: ?>
					<p><?php _e( 'Sorry, no posts have been added to this blog feed yet.' ); ?></p> 
				<?php endif;
				// Reset postdata
				wp_reset_postdata();
				
				// Custom query loop pagination
				// previous_posts_link( 'Older Posts' );
				// next_posts_link( 'Newer Posts', $custom_query->max_num_pages );
				
				// Reset main query object
				// $wp_query = NULL;
				// $wp_query = $temp_query;

				?>

			</div> <!-- .ast-row -->
		</main>

		<?php astra_pagination(); ?>

		<?php
			// Reset main query object
			$wp_query = NULL;
			$wp_query = $temp_query;
		?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
