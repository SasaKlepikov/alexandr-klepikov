<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' );
$page_lay = false;
?>

<div id="primary" class="site-content">

	<div id="content" role="main">

<?php set_layout( 'woocommerce', true, $page_lay ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

		<?php set_layout( 'woocommerce', false, $page_lay ); ?>

		<!-- #column -->
	</div>
	<!-- #content -->

</div><!-- #primary -->
	</div><!-- #primary -->
<?php get_footer('shop'); ?>