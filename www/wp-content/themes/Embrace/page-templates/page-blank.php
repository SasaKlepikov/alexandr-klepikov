<?php
/**
 * Template Name: Blank page
 *
 * @package   Reactor
 * @subpackge Page-Templates
 * @link      http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 * @since     1.0.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if ( IE 7 )&!( IEMobile )]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if ( IE 8 )&!( IEMobile )]>
<html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<?php reactor_head(); ?>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php reactor_body_inside(); ?>

<div id="main-wrapper" class="hfeed site">

	<div id="primary" class="site-content">

		<?php reactor_content_before(); ?>

		<div id="content" role="main">


			<?php reactor_inner_content_before(); ?>


			<?php // get the page loop
			get_template_part( 'loops/loop', 'page' ); ?>


			<?php reactor_inner_content_after(); ?>


			<!-- #column -->

			<!-- #row -->
		</div>
		<!-- #content -->

		<?php reactor_content_after(); ?>

	</div>
	<!-- #primary -->

	<?php //get_footer(); ?>

</div>
<?php reactor_footer_after(); ?>



<?php reactor_foot();
wp_footer(); ?>
</body>
</html>