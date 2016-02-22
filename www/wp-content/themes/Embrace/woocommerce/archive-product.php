<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop');
$page_lay = false;
?>

	<div id="primary" class="site-content">

		<div id="content" role="main">

				<?php set_layout( 'woocommerce', true, $page_lay ); ?>

				<?php if ( have_posts() ) : ?>

					<div class="shop-top-panel">

						<div class="inner">
							<h3><?php woocommerce_page_title(); ?></h3>

							<?php woocommerce_result_count(); ?>

						</div>

					<?php
					/**
					 * woocommerce_before_shop_loop hook
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
					?>
					</div>

					<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories(
					array(
						'before' => woocommerce_product_loop_start( false ),
						'after'  => woocommerce_product_loop_end( false )
					)
				)
				) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>



		</div>
		<!-- #content -->
		<?php set_layout( 'woocommerce', false, $page_lay ); ?>
		<!-- #column -->
	</div><!-- #primary -->
	</div><!-- #primary -->
<?php get_footer('shop'); ?>