<?php
if (class_exists('WooCommerce')){

	if(! class_exists('Crum_Product_Categories_Grid')){

		class Crum_Product_Categories_Grid{

			function __construct(){
				add_action('admin_init', array($this, 'crum_product_categories_grid_init'));
				add_shortcode('crum_product_categories_grid', array($this, 'crum_product_categories_grid_form'));

				//Transient deleting

				add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
			}

			function update_id_option( $transient_id ) {


				if ( get_option( 'crum_cached_product_categories_grid' ) ) {

					$tmp = get_option( 'crum_cached_product_categories_grid' );

					// The option already exists, so we just update it.
					$tmp = $tmp . ',crum_product_categories_grid_transient' . $transient_id;
					update_option( 'crum_cached_product_categories_grid', $tmp );

				} else {

					// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
					$new_value = 'crum_product_categories_grid_transient' . $transient_id;

					add_option( 'crum_cached_product_categories_grid', $new_value );
				}
			}

			function crum_delete_transient() {

				$tmp = get_option( 'crum_cached_product_categories_grid' );

				if ( $tmp !== false ) {

					// The option already exists, so we just update it.
					$temp = explode( ',', $tmp );

				} else {

					return;
				}

				foreach ( $temp as $transient ) {
					delete_transient( $transient );
				}

				delete_option( 'crum_cached_product_categories_grid' );
			}

			function crum_product_categories_grid_init(){
				if(function_exists('vc_map')){
					$orderby_arr = array(
						"Date"       => "date",
						"Title"      => "title",
						"Product ID" => "ID",
						"Name"       => "name",
						"Price"      => "price",
						"Sales"      => "sales",
						"Random"     => "rand",
					);

					$group = __("Main Options", "crum");

					vc_map(
						array(
							"name"                    => __( "Product Categories Grid", "crum" ),
							"base"                    => "crum_product_categories_grid",
							"icon"                    => "woocommerce_icon",
							"class"                   => "",
							"category"                => __( "Woocommerce", "crum" ),
							"description"             => "Display product categories in grid view",
							"controls"                => "full",
							"wrapper_class"           => "clearfix",
							"show_settings_on_create" => true,
							"params" => array(
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
									"group"       => $group,
									"description" => __( "", "crum" ),
								),
								array(
									"type"        => "product_categories",
									"class"       => "",
									"heading"     => __( "Select Categories", "crum" ),
									"param_name"  => "ids",
									"value"       => "",
									"group"       => $group,
									"description" => __( "", "crum" ),
									"dependency"  => Array(
										"element" => "display_style",
										"value"   => array( "select_categs" )
									),
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
									"group"       => $group,
									"description" => __( "Set 0 to show all categories", "crum" ),
									"dependency"  => Array(
										"element" => "display_style",
										"value"   => array( "select_number" )
									),
								),
								array(
									"type"        => "dropdown",
									"class"       => "",
									"heading"     => __( "Orderby", "crum" ),
									"param_name"  => "orderby",
									"admin_label" => true,
									"value"       => $orderby_arr,
									"group"       => $group,
									"description" => __( "", "crum" ),
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
									"group"       => $group,
									"description" => __( "", "crum" ),
								),
								array(
									"type" => "dropdown",
									"class" => "",
									"heading" => __("Columns number", "crum"),
									"param_name" => "columns_number",
									"admin_label" => true,
									"value" => array(
										__("Two","crum") => "2",
										__("Three","crum") => "3",
										__("Four","crum") => "4",
										__("Five","crum") => "5",
										__("Six","crum") => "6",
									),
									"group"       => $group,
									"description" => __("", "crum"),
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
							),
						)
					);
				}
			}

			function crum_product_categories_grid_form($atts, $content = null){

				$display_style = $ids = $number = $orderby = $order = $columns_number = $module_animation = '';

				extract( shortcode_atts(array(
					"display_style" => "",
					"ids" => "",
					"number" => "",
					"orderby" => "",
					"order" => "",
					"columns_number" => "2",
					"module_animation" => "",
				), $atts));

				$ids = explode(',', $ids);

				if ($display_style == "select_number" && !($ids == '')){
					$ids = '';
				}

				$args = array(
					'orderby'    => $orderby,
					'order'      => $order,
					'include'    => $ids,
					'pad_counts' => true,
				);



				$output = '';

				$uid = uniqid();

				if ( false === ( $product_categories = get_transient( 'crum_product_categories_grid_transient' . $uid ) ) ) {
					$product_categories = get_terms( 'product_cat', $args );

					set_transient( 'crum_product_categories_grid_transient' . $uid, $product_categories );

					$this->update_id_option( $uid );
				}



				if ($product_categories && !is_wp_error($product_categories)){



					if ( $number && !($display_style == 'select_categs') ) {
						$product_categories = array_slice( $product_categories, 0, $number );
					}

					ob_start(); ?>

					<?php

					$animate = $animation_data = '';

					if ( ! ($module_animation == '')){
						$animate = ' cr-animate-gen';
						$animation_data = 'data-animate-item = ".woocommerce-category" data-animate-type = "'.$module_animation.'" ';
					}

					?>

				<ul class="small-block-grid-2  large-block-grid-<?php echo $columns_number;?><?php echo $animate;?>"<?php echo $animation_data;?>>
					<?php foreach ($product_categories as $product_category){?>

						<li class="woocommerce-category">

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

						</li>

					<?php }?>

				</ul>
					<?php wp_reset_postdata();?>

					<?php $output .= ob_get_clean();
				}

				return $output;

			}

		}

	}

	if (class_exists('Crum_Product_Categories_Grid')){
		$Crum_Product_Categories_Grid = new Crum_Product_Categories_Grid;
	}

}