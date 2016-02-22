<?php
/**
 * The default template for displaying pages
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

			<?php set_layout( 'pages', true, $page_lay ); ?>

			<?php reactor_inner_content_before(); ?>

			<?php // get the page loop
			get_template_part( 'loops/loop', 'page' ); ?>

			<?php reactor_inner_content_after(); ?>

			<?php set_layout( 'pages', false, $page_lay ); ?>

		</div>
		<!-- #content -->

		<?php reactor_content_after(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>