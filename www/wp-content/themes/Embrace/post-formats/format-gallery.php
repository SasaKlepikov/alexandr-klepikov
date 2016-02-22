<?php
/**
 * The template for displaying the gallery post format
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
			<?php

			if (! get_post_gallery() ) {
				echo '<h1>Please, insert gallery into post!</h1>';
			}
			else {
				$gallery = get_post_gallery( get_the_ID(), false );

				echo '<div id="post-' . get_the_ID() . '-slider" class="gallery-post-slider cursor-move"><div class="slides-' . get_the_ID() . '">';

				/* Loop through all the image and output them one by one */
				foreach ( $gallery['src'] AS $src ) {

					$thumb_image = theme_thumb( $src, 63, 63, true );

					$full_image = str_replace( '-150x150', '', $src );

					$thumb_width  = reactor_option( false, false, '_cr_post_thumb_width' ) ? reactor_option( false, false, '_cr_post_thumb_width' ) : reactor_option( 'post_thumbnails_width', '300' );;
					$thumb_height = reactor_option( false, false, '_cr_post_thumb_height' ) ? reactor_option( false, false, '_cr_post_thumb_height' ) : reactor_option( 'post_thumbnails_height', '900' );
					$thumb_crop   = reactor_option( 'thumb_image_crop', 1 );

					$post_thumbnail = theme_thumb( $full_image, $thumb_width, $thumb_height, $thumb_crop );

					?>
			<div class="slide">
			<div class="entry-thumbnail">
			<img src="<?php echo  $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
			<div class="overlay"></div>
			<div class="links">
				<a href="<?php echo $post_thumbnail; ?>" class="zoom" rel="bookmark" title="<?php the_title_attribute(); ?>"><i class="crumicon-resize-enlarge"></i></a>
			</div>
			</div>
			</div>
				<?php
				}

				echo '</div></div>';

				?>

				<script type="text/javascript">
					(function ($) {
						$(document).ready(function () {

							$('.slides-<?php echo get_the_ID()?>').slick({
								infinite      : true,
								slidesToShow  : 1,
								slidesToScroll: 1,
								arrows        : true,
								dots          : true,
								autoplay      : true,
								autoplaySpeed : 4000,
								responsive    : [
									{
										breakpoint: 600,
										settings  : {
											slidesToShow: 1,
											arrows      : false
										}
									}
								]
							});
						});
					})(jQuery);

				</script>

			<?php
			} ?>
		</div>
		<!-- .entry-content -->

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

		<!-- .entry-header -->

		<footer class="entry-footer">
			<?php reactor_post_footer(); ?>
		</footer>
		<!-- .entry-footer -->
	</div>
	<!-- .entry-body -->
</article><!-- #post -->