<?php
/**
 * The template for displaying the video post format
 *
 * @package    Reactor
 * @subpackage Post-Formats
 * @since      1.0.0
 */
?>

<?php
global $post;
$post_meta = get_post_meta( $post->ID, '_format_video_embed', true );
$auto_excerpt = reactor_option('auto_excerpt', false);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-body">

		<?php if ($post_meta && !empty($post_meta)):?>

		<div class="flex-video widescreen vimeo">
		<?php
		echo apply_filters('the_content', $post_meta);
		?>
		</div>

		<?php endif;?>

		<header class="entry-header">
			<?php reactor_post_header(); ?>
		</header>


		<?php if ( (!is_single() && $auto_excerpt) || is_search() ){ ?>
			<div class="entry-summary">
				<?php echo get_the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php } else{ ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		<?php } ?>
		<!-- .entry-content -->


		<footer class="entry-footer">

			<?php reactor_post_footer(); ?>

		</footer>
		<!-- .entry-footer -->

	</div>
	<!-- .entry-body -->
</article><!-- #post -->
