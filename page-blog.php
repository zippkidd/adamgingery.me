<?php
/**
 * Template Name: Blog Page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header( 'blog' ); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php
			$title = get_the_title();
			if ( is_home() ) {
				$title = 'Blog';
			}
		?>

		<main id="main" class="site-main">
			<div class="entry-content clear">
				<div class="wp-block-group alignfull banner banner--noimage <?php echo resolveBannerBG(); ?> has-background">
					<div class="wp-block-group__inner-container">
						<h1 class="has-text-align-center has-white-color has-text-color"><?php echo $title; ?></h1>
					</div>
				</div>
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

						// $thumb 		= '';

						// $width = 1080;
						// $height = 675;
						// $class_text = 'et_pb_post_main_image';
						// $title_text = get_the_title();
						// $alt_text    = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
						// $thumbnail  = get_thumbnail( $width, $height, $class_text, $alt_text, $title_text, false, 'Blogimage' );
						// $thumb      = $thumbnail["thumb"];

						?>

						<article
							<?php post_class( array('ast-col-sm-12', 'ast-article-post') ) ?>
							itemtype="https://schema.org/CreativeWork"
							itemscope="itemscope"
							id="post-<?php the_ID(); ?>"
						>
							<div class="ast-post-format- ast-no-thumb blog-layout-1">
								<div class="post-content ast-col-md-12">
									
									<!-- is this necessary without thumbnail? --><div class="ast-blog-featured-section post-thumb ast-col-md-12"></div>
									
									<header class="entry-header">

										<h2 class="entry-title" itemprop="headline">
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h2>

										<!-- <div class="entry-meta"><span class="cat-links"><a href="http://adamging.local/category/podcast/" rel="category tag">Podcast</a>, <a href="http://adamging.local/category/podcast/podcast-episode/" rel="category tag">Podcast Episode</a></span> / By <span class="posted-by vcard author" itemtype="https://schema.org/Person" itemscope="itemscope" itemprop="author"> <a title="View all posts by admin" href="http://adamging.local/author/admin/" rel="author" class="url fn n" itemprop="url"> <span class="author-name" itemprop="name">admin</span> </a> </span></div> -->
									</header><!-- .entry-header -->

									<div class="entry-content clear" itemprop="text">
										<p><?php echo wp_trim_words( get_the_content(), 55, ' ...' ); ?></p>
										<p class="read-more">
											<a class="" href="<?php the_permalink(); ?>">
												<span class="screen-reader-text"><?php the_title(); ?></span> Read More »
											</a>
										</p>
									</div><!-- .entry-content .clear -->
								</div><!-- .post-content -->
							</div> <!-- .ast-post-format .blog-layout-1 -->
						</article>

						<?php
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
			</div><!-- .entry-content.clear -->
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
