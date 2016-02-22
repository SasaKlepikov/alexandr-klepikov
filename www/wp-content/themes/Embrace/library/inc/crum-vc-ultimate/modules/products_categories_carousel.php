<?php
if ( class_exists( 'WooCommerce' ) ) {
	if ( ! class_exists( 'Crum_Product_Categories_Carousel' ) ) {

		class Crum_Product_Categories_Carousel {

			function __construct() {
				add_action( 'admin_init', array( $this, 'crum_product_categories_carousel_init' ) );
				add_shortcode( 'crum_product_categories_carousel', array(
					$this,
					'crum_product_categories_carousel_form'
				) );

				//Transient deleting

				add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
			}

			function update_id_option( $transient_id ) {


				if ( get_option( 'crum_cached_categories_carousel' ) ) {

					$tmp = get_option( 'crum_cached_categories_carousel' );

					// The option already exists, so we just update it.
					$tmp = $tmp . ',crum_categories_carousel_transient' . $transient_id;
					update_option( 'crum_cached_categories_carousel', $tmp );

				} else {

					// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
					$new_value = 'crum_categories_carousel_transient' . $transient_id;

					add_option( 'crum_cached_categories_carousel', $new_value );
				}
			}

			function crum_delete_transient() {

				$tmp = get_option( 'crum_cached_categories_carousel' );

				if ( $tmp !== false ) {

					// The option already exists, so we just update it.
					$temp = explode( ',', $tmp );

				} else {

					return;
				}

				foreach ( $temp as $transient ) {
					delete_transient( $transient );
				}

				delete_option( 'crum_cached_categories_carousel' );
			}

			function crum_product_categories_carousel_init() {

					if ( function_exists( 'vc_map' ) ) {
						$orderby_arr = array(
							"Date"       => "date",
							"Title"      => "title",
							"Product ID" => "ID",
							"Name"       => "name",
							"Price"      => "price",
							"Sales"      => "sales",
							"Random"     => "rand",
						);
						vc_map(
							array(
								"name"                    => __( "Product Categories Carousel", "crum" ),
								"base"                    => "crum_product_categories_carousel",
								"icon"                    => "woocommerce_icon",
								"class"                   => "",
								"category"                => __( "Woocommerce", "crum" ),
								"description"             => "Display product categories in carousel view",
								"controls"                => "full",
								"wrapper_class"           => "clearfix",
								"show_settings_on_create" => true,
								"params"                  => array(
									array(
										"type"        => "dropdown",
										"class"       => "",
										"heading"     => __( "Display style", "crum" ),
										"param_name"  => "display_style",
										"admin_label" => true,
										"value"       => array(
											__( "Select number of categories", "crum" ) => "select_number",
											__( "Select names of categories", "crum" )  => "select_categs",
										),
										"description" => __( "", "crum" ),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "product_categories",
										"class"       => "",
										"heading"     => __( "Select Categories", "crum" ),
										"param_name"  => "ids",
										"value"       => "",
										"description" => __( "", "crum" ),
										"dependency"  => Array(
											"element" => "display_style",
											"value"   => array( "select_categs" )
										),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "number",
										"class"       => "",
										"heading"     => __( "Number of Categories", "crum" ),
										"param_name"  => "number",
										"value"       => "1",
										"min"         => 0,
										"max"         => 500,
										"suffix"      => "",
										"description" => __( "Set 0 to show all categories", "crum" ),
										"dependency"  => Array(
											"element" => "display_style",
											"value"   => array( "select_number" )
										),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "checkbox",
										"class"       => "",
										"heading"     => __( "Options", "crum" ),
										"param_name"  => "options",
										"admin_label" => true,
										"value"       => array(
											__( "Hide empty categories<br>", "crum" )    => "hide_empty",
										),
										"description" => __( "", "crum" ),
										"dependency"  => Array(
											"element" => "display_style",
											"value"   => array( "select_number" )
										),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "dropdown",
										"class"       => "",
										"heading"     => __( "Orderby", "crum" ),
										"param_name"  => "orderby",
										"admin_label" => true,
										"value"       => $orderby_arr,
										"description" => __( "", "crum" ),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "dropdown",
										"class"       => "",
										"heading"     => __( "Order", "crum" ),
										"param_name"  => "order",
										"admin_label" => true,
										"value"       => array(
											"Asending"  => "asc",
											"Desending" => "desc",
										),
										"description" => __( "", "crum" ),
										"group"       => "Initial Settings",
									),
									array(
										"type"        => "number",
										"class"       => "",
										"heading"     => __( "Number of Slides to Show", "crum" ),
										"param_name"  => "slides_to_show",
										"value"       => "1",
										"min"         => 1,
										"max"         => 10,
										"suffix"      => "",
										"description" => __( "The number of slides to show on page", "crum" ),
										"group"       => "Carousel Settings",
									),
									array(
										"type"        => "number",
										"class"       => "",
										"heading"     => __( "Number of Slides to Scroll", "crum" ),
										"param_name"  => "slides_to_scroll",
										"value"       => "1",
										"min"         => 1,
										"max"         => 10,
										"suffix"      => "",
										"description" => __( "The number of slides to move on transition", "crum" ),
										"group"       => "Carousel Settings",
									),
                                    array(
                                        "type"        => "number",
                                        "class"       => "",
                                        "heading"     => __( "Slide Scrolling Speed", "crum" ),
                                        "param_name"  => "scroll_speed",
                                        "value"       => "400",
                                        "min"         => 100,
                                        "max"         => 10000,
                                        "suffix"      => "ms",
                                        "description" => __( "Slide transition duration", "crum" ),
                                        "group"       => "Carousel Settings",
                                    ),
                                    array(
                                        "type"        => "checkbox",
                                        "class"       => "",
                                        "heading"     => __( "Advanced settings", "crum" ),
                                        "param_name"  => "advanced_opts",
                                        "value"       => array(
                                            "Enable infinite scroll<br>" => "infinite",
                                            "Enable navigation dots<br>" => "dots",
                                            "Enable navigation arrows<br>" => "arrows",
                                            "Enable auto play"           => "autoplay",
                                        ),
                                        "description" => __( "", "crum" ),
                                        "group"       => "Carousel Settings",
                                    ),
                                    array(
                                        "type"        => "number",
                                        "class"       => "",
                                        "heading"     => __( "Autoplay Speed", "crum" ),
                                        "param_name"  => "autoplay_speed",
                                        "value"       => "3",
                                        "min"         => 1,
                                        "max"         => 10,
                                        "suffix"      => "sec",
                                        "description" => __( "The amount of time between each auto transition", "crum" ),
                                        "group"       => "Carousel Settings",
                                        "dependency"  => Array(
                                            "element" => "advanced_opts",
                                            "value"   => array( "autoplay" )
                                        ),
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

			function crum_product_categories_carousel_form( $atts, $content = null ) {

				$options = $display_style = $ids = $number = $orderby = $order = $slides_to_show = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = $product_animation = $module_animation = '';

				extract( shortcode_atts( array(
					"options"           => "",
					"display_style"     => "",
					"ids"               => "",
					"number"            => "",
					"orderby"           => "",
					"order"             => "",
					"slides_to_show"    => "",
					"slides_to_scroll"  => "",
					"scroll_speed"      => "",
					"advanced_opts"     => "",
					"autoplay_speed"    => "",
					"product_animation" => "",
					"module_animation"  => "",
				), $atts ) );

				$infinite      = $autoplay = $dots = $arrows = 'false';
				$advanced_opts = explode( ",", $advanced_opts );

				if ( in_array( "infinite", $advanced_opts ) ) {
					$infinite = 'true';
				}
				if ( in_array( "autoplay", $advanced_opts ) ) {
					$autoplay = 'true';
				}
				if ( in_array( "dots", $advanced_opts ) ) {
					$dots = 'true';
				}
				if (in_array("arrows", $advanced_opts)){
					$arrows = 'true';
				}

				$options_array = explode(',', $options);

				$hide_empty = $display_child = 'false';

				if ( (in_array("hide_empty", $options_array))){
					$hide_empty = '1';
				}

				$ids = explode(',', $ids);

				if ($display_style == "select_number" && !($ids == '')){
					$ids = '';
				}

				$args = array(
					'orderby'    => $orderby,
					'order'      => $order,
					'hide_empty' => $hide_empty,
					'include'    => $ids,
					'pad_counts' => true,
				);

				$output = '';

				$uid = uniqid();

				if ( false === ( $product_categories = get_transient( 'crum_categories_carousel_transient' . $uid ) ) ) {
					$product_categories = get_terms( 'product_cat', $args );

					set_transient( 'crum_categories_carousel_transient' . $uid, $product_categories );

					$this->update_id_option( $uid );
				}

				if ($product_categories && !is_wp_error($product_categories)){

					if ( $number && !($display_style == 'select_categs') ) {
						$product_categories = array_slice( $product_categories, 0, $number );
					}

					if ( $hide_empty ) {
						foreach ( $product_categories as $key => $category ) {
							if ( $category->count == 0 ) {
								unset( $product_categories[ $key ] );
							}
						}
					}

							ob_start(); ?>

					<?php

					$animate = $animation_data = '';

					if ( ! ($module_animation == '')){
						$animate = ' cr-animate-gen';
						$animation_data = 'data-animate-type = "'.$module_animation.'" ';
					}

					?>

				<div id="slider-<?php echo $uid ?>" class="sliding-content-slider cursor-move <?php echo $animate;?>" <?php echo $animation_data;?>>
				<div id="slides-<?php echo $uid ?>">

					<?php foreach ($product_categories as $product_category){?>

					<div class="woocommerce-category">

						<?php do_action( 'woocommerce_before_subcategory', $product_category ); ?>

						<a href="<?php echo get_term_link( $product_category->slug, 'product_cat' );?>">

							<div class="category-image">

								<?php
								do_action( 'woocommerce_before_subcategory_title', $product_category );
								?>

							</div>

							<h3>
								<?php
								echo $product_category->name;
								?>
							</h3>

							<?php
							do_action( 'woocommerce_after_subcategory_title', $product_category );
							?>

						</a>

						<?php do_action( 'woocommerce_after_subcategory', $product_category ); ?>

					</div>

					<?php }//end foreach?>

				</div>

					<?php wp_reset_postdata();?>

				</div>

					<script type="text/javascript">
						(function ($) {
							$(document).ready(function () {

								$('#<?php echo 'slides-'.$uid.''; ?>').slick({
									infinite      : <?php echo $infinite; ?>,
									slidesToShow  : <?php echo $slides_to_show; ?>,
									slidesToScroll: <?php echo $slides_to_scroll; ?>,
									arrows        : <?php echo $arrows?>,
									dots          : <?php echo $dots; ?>,
									speed         : <?php echo $scroll_speed; ?>,
									autoplay      : <?php echo $autoplay; ?>,
									autoplaySpeed : <?php echo $autoplay_speed.'000'; ?>,
									responsive    : [
										{
											breakpoint: 1280,
											settings  : {
												slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>,

											}
										},
										{
											breakpoint: 1024,
											settings  : {
												slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>,

											}
										},
										{
											breakpoint: 600,
											settings  : {
												slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>,
												arrows      : false
											}
										},
										{
											breakpoint: 480,
											settings  : {
												slidesToShow  : 1,
												slidesToScroll: 1,
												arrows        : false
											}
										}
									]
								});
							});
						})(jQuery);
					</script>

					<?php $output .= ob_get_clean();

				}

				return $output;

			}

		}

	}

	if ( class_exists( 'Crum_Product_Categories_Carousel' ) ) {
		$Crum_Product_Categories_Carousel = new Crum_Product_Categories_Carousel;
	}


}