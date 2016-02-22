<?php
if ( class_exists( 'WooCommerce' ) ) {

	if ( ! class_exists( 'Crum_Single_Product' ) ) {

		class Crum_Single_Product {

			function __construct() {
				add_action( 'admin_init', array( $this, 'crum_single_product_init' ) );
				add_shortcode( 'crum_single_product', array( $this, 'crum_single_product_form' ) );
			}

			function crum_single_product_init() {
				if ( function_exists( 'vc_map' ) ) {
					vc_map(
						array(
							"name"                    => __( "Single Product", "crum" ),
							"base"                    => "crum_single_product",
							"icon"                    => "woocommerce_icon",
							"class"                   => "",
							"category"                => __( "Woocommerce", "crum" ),
							"description"             => __( "Display single product", "crum" ),
							"controls"                => "full",
							"show_settings_on_create" => true,
							"params"                  => array(
								array(
									"type"        => "product_search",
									"class"       => "",
									"heading"     => __( "Select Product", "woocomposer" ),
									"param_name"  => "crum_single_product_id",
									"admin_label" => true,
									"value"       => "",
									"description" => __( "", "woocomposer" ),
									"group"       => "Product Settings",
								),
								array(
									"type"        => "dropdown",
									"class"       => "",
									"heading"     => __( "Select Product Style", "woocomposer" ),
									"param_name"  => "crum_single_product_style",
									"admin_label" => true,
									"value"       => array(
										__( "Compact style (like shop grid view)", "crum" ) => "style01",
										__( "Full style (like shop list view)", "crum" )    => "style02",
									),
									"description" => __( "", "woocomposer" ),
									"group"       => "Product Settings",
								),
								array(
									"type"        => "checkbox",
									"class"       => "",
									"heading"     => "Display title and categories under thumbnail",
									"value"       => array( "Yes, please" => "true" ),
									"param_name"  => "crum_single_product_show_title",
									"description" => "",
									"group"       => "Product Settings",
								),
								array(
									"type"        => "checkbox",
									"class"       => "",
									"heading"     => "Display buttons under thumbnail",
									"value"       => array( "Yes, please" => "true" ),
									"param_name"  => "crum_single_product_show_buttons",
									"description" => "",
									"group"       => "Product Settings",
								),
								array(
									"type"        => "dropdown",
									"class"       => "",
									"heading"     => __( "Animation", "crum" ),
									"param_name"  => "module_animation",
									"value"       => array(
										__( "No Animation", "crum" )       => "",
										__( "FadeIn", "crum" )             => "transition.fadeIn",
										__( "FlipXIn", "crum" )            => "transition.flipXIn",
										__( "FlipYIn", "crum" )            => "transition.flipYIn",
										__( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
										__( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
										__( "SwoopIn", "crum" )            => "transition.swoopIn",
										__( "WhirlIn", "crum" )            => "transition.whirlIn",
										__( "ShrinkIn", "crum" )           => "transition.shrinkIn",
										__( "ExpandIn", "crum" )           => "transition.expandIn",
										__( "BounceIn", "crum" )           => "transition.bounceIn",
										__( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
										__( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
										__( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
										__( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
										__( "SlideUpIn", "crum" )          => "transition.slideUpIn",
										__( "SlideDownIn", "crum" )        => "transition.slideDownIn",
										__( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
										__( "SlideRightIn", "crum" )       => "transition.slideRightIn",
										__( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
										__( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
										__( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
										__( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
										__( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
										__( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
										__( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
										__( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
									),
									"description" => __( "", "crum" ),
									"group"       => "Animation Settings",
								),
							)
						)
					);
				}
			}

			function crum_single_product_form( $atts, $content = null ) {

				$crum_single_product_id = $crum_single_product_style = $crum_single_product_show_title = $crum_single_product_show_buttons = $module_animation = '';

				extract( shortcode_atts( array(
					"crum_single_product_id"           => "",
					"crum_single_product_style"        => "",
					"crum_single_product_show_title"   => "",
					"crum_single_product_show_buttons" => "",
					"module_animation"                => "",
				), $atts ) );

				$output = '';
				ob_start();?>

                <div class="woocommerce crum-single-product">

				<?php if ( $crum_single_product_style == 'style01' ) {?>

					<ul class="products grid">

				<?php } else {?>

					<ul class="products list">

				<?php }

				$args = array(
					'post_type' => 'any',
					'p' => $crum_single_product_id
				);

				$query = new WP_Query( $args );

						if ( $query->have_posts() ):

							$animate = $animation_data = '';

							if ( ! ($module_animation == '')){
								$animate = ' cr-animate-gen';
								$animation_data = 'data-animate-type = "'.$module_animation.'" ';
							}

							while ( $query->have_posts() ) : $query->the_post(); ?>

								<li <?php post_class($animate); ?> <?php echo $animation_data?>>

									<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

									<div class="entry-thumbnail">
										<a href="<?php echo the_permalink(); ?>" class="link">
											<?php
											do_action( 'woocommerce_before_shop_loop_item_title' );
											?>
										</a>

									</div>

									<?php if ( $crum_single_product_show_title == 'true' ): ?>

										<div class="products-description">

											<h3><?php the_title(); ?></h3>

											<?php crum_woocommerce_single_subtitle(); ?>

										</div>

									<?php endif; ?>

									<?php if ( $crum_single_product_show_buttons == 'true' ): ?>

										<div class="products-other">

											<?php
											do_action( 'woocommerce_after_shop_loop_item_title' );
											?>

											<div class="wrap-other">
												<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
											</div>
										</div>

									<?php endif; ?>

								</li>
							<?php endwhile;
						endif;?>


					</ul>

                </div>

					<?php $output .= ob_get_clean();



				return $output;

			}

		}

	}

	if ( class_exists( 'Crum_Single_Product' ) ) {
		$Crum_Single_Product = new Crum_Single_Product;
	}

}