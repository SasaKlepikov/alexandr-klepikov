<?php
/**
 * The template for displaying single portfolio posts
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">

		<?php reactor_content_before(); ?>

		<div id="content" role="main">

				<?php set_layout('portfolio'); ?>

				<?php reactor_inner_content_before(); ?>

				<?php // start the loop
				while ( have_posts() ) : the_post(); ?>

					<?php reactor_post_before(); ?>

					<?php get_template_part('post-formats/portfolio', 'single'); ?>

					<?php reactor_post_after(); ?>

				<?php endwhile; // end of the loop ?>

				<?php reactor_inner_content_after(); ?>

				<?php set_layout('portfolio', false); ?>

			</div><!-- #content -->

		<?php reactor_content_after(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>
