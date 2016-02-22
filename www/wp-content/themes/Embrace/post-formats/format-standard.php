<?php
/**
 * The template for displaying post content
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */

$auto_excerpt = reactor_option('auto_excerpt', false);

$sticky_class = is_sticky() ? 'sticky-post':'';


?>

<article id="post-<?php the_ID(); ?>" <?php post_class($sticky_class); ?>>

	<div class="entry-body">

		<header class="entry-header">
			<?php reactor_post_header(); ?>
		</header>
		<!-- .entry-header -->

		<?php if ( (!is_single() && $auto_excerpt) || is_search() ){ ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php } else{ ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		<?php } ?>

		<footer class="entry-footer">
			<?php reactor_post_footer(); ?>
		</footer>
		<!-- .entry-footer -->
	</div>
	<!-- .entry-body -->
</article><!-- #post -->