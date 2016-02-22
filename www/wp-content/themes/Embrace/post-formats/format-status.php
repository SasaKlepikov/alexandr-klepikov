<?php
/**
 * The template for displaying the status post format
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		    <div class="entry-body">

            <header class="entry-header">
            	<?php reactor_post_header(); ?>
            </header><!-- .entry-header -->
    
            <div class="entry-content">
				<?php if ( !is_single()): ?>
            	<div class="row">
                    <div class="large-2 small-2 columns">
                        <?php echo get_avatar( get_the_author_meta('ID'), apply_filters('reactor_status_avatar', '70') ); ?>
                    </div>
                    <div class="large-10 small-10 large-offset-2 small-offset-2">
                        <?php the_content(); ?>
                    </div>
                </div>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>
            </div><!-- .entry-content -->
    
            <footer class="entry-footer">
            	<?php reactor_post_footer(); ?>
            </footer><!-- .entry-footer -->
            
        </div><!-- .entry-body -->
	</article><!-- #post -->
