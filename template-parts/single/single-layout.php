<?php
/**
 * Template for Single post
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

?>




<div class="entry-content clear" 
<?php
				echo astra_attr(
                    'article-entry-content-single-layout',
					array(
                        'class' => '',
                        )
                    );
                    ?>
	>
    
    <?php astra_entry_content_before(); ?>

    <div class="wp-block-group alignfull banner banner--noimage only-h1 <?php echo resolveBannerBG(); ?> has-background">
        <div class="wp-block-group__inner-container">
            <h1 class="has-text-align-center has-white-color has-text-color"><?php the_title(); ?></h1>
        </div>
    </div>

    <?php the_content(); ?>

    <?php
        astra_edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__( 'Edit %s', 'astra' ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>

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