<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

?>

<?php astra_entry_before(); ?>

<article 
	<?php
		echo astra_attr(
			'article-page',
			array(
				'id'    => 'post-' . get_the_id(),
				'class' => join( ' ', get_post_class() ),
			)
		);
		?>
>

	<?php astra_entry_top(); ?>

	<div class="entry-content clear" 
		<?php
				echo astra_attr(
					'article-entry-content-page',
					array(
						'class' => '',
					)
				);
				?>
	>


		<?php astra_entry_content_before(); ?>

		<?php if (!is_page_template('page-landing.php')): ?>

			<?php if ( has_post_thumbnail() ): ?>

				<div class="wp-block-group alignfull banner has-salamander-black-background-color has-background">
					<div class="wp-block-group__inner-container">
						<div class="wp-block-columns">
							<div class="wp-block-column is-vertically-aligned-center banner__content">
								<h1 class="has-white-color has-text-color"><?php the_title(); ?></h1>
							</div>
							<div class="wp-block-column is-vertically-aligned-center">
								<figure class="wp-block-image alignfull size-large"><?php the_post_thumbnail(); ?></figure>
							</div>
						</div>
					</div>
				</div>

			<?php else: ?>

				<div class="wp-block-group alignfull banner banner--noimage only-h1 <?php echo resolveBannerBG(); ?> has-background">
					<div class="wp-block-group__inner-container">
						<h1 class="has-text-align-center has-white-color has-text-color"><?php the_title(); ?></h1>
					</div>
				</div>

			<?php endif; ?>

		<?php endif; ?>
		
		<?php the_content(); ?>

		<?php astra_entry_content_after(); ?>

		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html( astra_default_strings( 'string-single-page-links-before', false ) ),
					'after'       => '</div>',
					'link_before' => '<span class="page-link">',
					'link_after'  => '</span>',
				)
			);
			?>

	</div><!-- .entry-content .clear -->

	<?php
		astra_edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'astra' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
		?>

	<?php astra_entry_bottom(); ?>

</article><!-- #post-## -->

<?php astra_entry_after(); ?>
