<?php
/**
 * The template for displaying all single posts
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */

$page_lay = reactor_option( '', '', '_page_layout_select' );
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">

		<?php reactor_content_before(); ?>

		<div id="content" role="main">

			<?php set_layout( 'single', true, $page_lay ); ?>

			<?php reactor_inner_content_before(); ?>

			<?php // start the loop
			while ( have_posts() ) : the_post(); ?>

				<?php reactor_post_before(); ?>

				<?php // get post format and display code for that format
				if ( ! get_post_format() ) : get_template_part( 'post-formats/format', 'standard' );
				else : get_template_part( 'post-formats/format', get_post_format() ); endif; ?>

				<?php reactor_post_after(); ?>

			<?php endwhile; // end of the loop ?>

			<?php reactor_inner_content_after(); ?>

			<?php set_layout( 'single', false, $page_lay ); ?>

		</div>
		<!-- #content -->

		<?php reactor_content_after(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>