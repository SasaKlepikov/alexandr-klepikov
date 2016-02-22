<?php
/**
 * The template for displaying the image post format
 *
 * @package    Reactor
 * @subpackage Post-Formats
 * @since      1.0.0
 */
$auto_excerpt = reactor_option('auto_excerpt', false);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<div class="entry-body">

		<div class="entry-content">
			<div class="entry-thumbnail">
				<?php
				the_post_thumbnail( 'large' );
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				?>
				<div class="overlay"></div>
				<div class="links">
					<a href="<?php echo $large_image_url[0]; ?>" class="zoom" rel="bookmark" title="<?php the_title_attribute(); ?>"><i class="crumicon-resize-enlarge"></i></a>
				</div>
			</div>

		</div>
		<!-- .entry-content -->



			<header class="entry-header">
				<?php reactor_post_header(); ?>
			</header>

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