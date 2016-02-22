<?php
if (class_exists('WooCommerce')) {
	if ( ! class_exists( 'Crum_Products_Carousel' ) ) {

		class Crum_Products_Carousel {

			function __construct() {
				add_action( 'admin_init', array( $this, 'crum_products_carousel_init' ) );
				add_shortcode( 'crum_products_carousel', array( $this, 'crum_products_carousel_form' ) );

				//Transient deleting

				add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
			}

			function update_id_option( $transient_id ) {


				if ( get_option( 'crum_cached_products_carousel' ) ) {

					$tmp = get_option( 'crum_cached_products_carousel' );

					// The option already exists, so we just update it.
					$tmp = $tmp . ',crum_product_carousel_transient' . $transient_id;
					update_option( 'crum_cached_products_carousel', $tmp );

				} else {

					// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
					$new_value = 'crum_product_carousel_transient' . $transient_id;

					add_option( 'crum_cached_products_carousel', $new_value );
				}
			}

			function crum_delete_transient() {

				$tmp = get_option( 'crum_cached_products_carousel' );

				if ( $tmp !== false ) {

					// The option already exists, so we just update it.
					$temp = explode( ',', $tmp );

				} else {

					return;
				}

				foreach ( $temp as $transient ) {
					delete_transient( $transient );
				}

				delete_option( 'crum_cached_products_carousel' );
			}



			function crum_products_carousel_init() {
				if ( function_exists( 'vc_map' ) ) {

					$categories = get_terms( 'product_cat', array(
						'orderby'    => 'count',
						'hide_empty' => 0,
					) );

					$cat_arr = array();
					if ( is_array( $categories ) ) {
						foreach ( $categories as $cats ) {
							$cat_arr[ $cats->name ] = $cats->slug;
						}
					}

					vc_map(
						array(
							"name"                    => __( "Products Carousel", "crum" ),
							"base"                    => "crum_products_carousel",
							"icon"                    => "woocommerce_icon",
							"class"                   => "",
							"category"                => __( "Woocommerce", "crum" ),
							"description"             => __( "Display products in carousel slider", "crum" ),
							"controls"                => "full",
							"show_settings_on_create" => true,
							"params"                  => array(
								array(
									"type"        => "product_query",
									"class"       => "",
									"heading"     => __( "Products query", "crum" ),
									"param_name"  => "crum_products_carousel_query",
									"value"       => "",
									//"module" => "grid",
									"labels"      => array(
										"products_from" => __( "Display:", "crum" ),
										"per_page"      => __( "How Many:", "crum" ),
										"columns"       => __( "Columns:", "crum" ),
										"order_by"      => __( "Order By:", "crum" ),
										"order"         => __( "Display Order:", "crum" ),
										"category"      => __( "Category:", "crum" ),
									),
									"description" => __( "", "crum" ),
									"group"       => "Query Settings",
								),
								array(
									"type"        => "checkbox",
									"class"       => "",
									"heading"     => "Display title and categories under thumbnail",
									"value"       => array( "Yes, please" => "true" ),
									"param_name"  => "show_title",
									"description" => "",
									"group"       => "Query Settings",
								),
								array(
									"type"        => "checkbox",
									"class"       => "",
									"heading"     => "Display buttons under thumbnail",
									"value"       => array( "Yes, please" => "true" ),
									"param_name"  => "show_buttons",
									"description" => "",
									"group"       => "Query Settings",
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
							),
						)
					);
				}
			}

			function crum_products_carousel_form( $atts, $content = null ) {

				global $woocommerce;

				$crum_products_carousel_query = $show_title = $show_buttons = $slides_to_show = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = $product_animation = $module_animation = '';

				$class = $style = '';

				$element = 'carousel';

				extract( shortcode_atts( array(
					"crum_products_carousel_query" => "",
					"show_title"                   => "",
					"show_buttons"                 => "",
					"slides_to_show"               => "",
					"slides_to_scroll"             => "",
					"scroll_speed"                 => "",
					"advanced_opts"                => "",
					"autoplay_speed"               => "",
					"product_animation"            => "",
					"module_animation"             => "",
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

				$output = '';

				$uid = uniqid();

				if ( $element == "grid" ) {
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				} else {
					$paged = 1;
				}

				$image_size = apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );

				$post_count = '12';
				/* $output .= do_shortcode($content); */
				if ( $crum_products_carousel_query !== '' ) {
					$new_shortcode = rawurldecode( base64_decode( strip_tags( $crum_products_carousel_query ) ) );
				}
				$pattern       = get_shortcode_regex();
				$shortcode_str = $short_atts = '';
				preg_match_all( "/" . $pattern . "/", $new_shortcode, $matches );
				$shortcode_str = str_replace( '"', '', str_replace( " ", "&", trim( $matches[3][0] ) ) );
				$short_atts    = parse_str( $shortcode_str ); //explode("&",$shortcode_str);
				if ( isset( $matches[2][0] ) ): $display_type = $matches[2][0];
				else: $display_type = ''; endif;
				if ( ! isset( $columns ) ): $columns = '4'; endif;
				if ( isset( $per_page ) ): $post_count = $per_page; endif;
				if ( isset( $number ) ): $post_count = $number; endif;
				if ( ! isset( $order ) ): $order = 'asc'; endif;
				if ( ! isset( $orderby ) ): $orderby = 'date'; endif;
				if ( ! isset( $category ) ): $category = ''; endif;
				if ( ! isset( $ids ) ): $ids = ''; endif;
				if ( $ids ) {
					$ids = explode( ',', $ids );
					$ids = array_map( 'trim', $ids );
				}
				$col = $columns;
				if ( $columns == "2" ) {
					$columns = 6;
				} elseif ( $columns == "3" ) {
					$columns = 4;
				} elseif ( $columns == "4" ) {
					$columns = 3;
				}
				$meta_query = '';
				if ( $display_type == "recent_products" ) {
					$meta_query = WC()->query->get_meta_query();
				}
				if ( $display_type == "featured_products" ) {
					$meta_query = array(
						array(
							'key'     => '_visibility',
							'value'   => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						),
						array(
							'key'   => '_featured',
							'value' => 'yes'
						)
					);
				}
				if ( $display_type == "top_rated_products" ) {
					add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
					$meta_query = WC()->query->get_meta_query();
				}
				$args = array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => $post_count,
					'orderby'             => $orderby,
					'order'               => $order,
					'paged'               => $paged,
					'meta_query'          => $meta_query
				);
				if ( $display_type == "sale_products" ) {
					$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
					$meta_query          = array();
					$meta_query[]        = $woocommerce->query->visibility_meta_query();
					$meta_query[]        = $woocommerce->query->stock_status_meta_query();
					$args['meta_query']  = $meta_query;
					$args['post__in']    = $product_ids_on_sale;
				}
				if ( $display_type == "best_selling_products" ) {
					$args['meta_key']   = 'total_sales';
					$args['orderby']    = 'meta_value_num';
					$args['meta_query'] = array(
						array(
							'key'     => '_visibility',
							'value'   => array( 'catalog', 'visible' ),
							'compare' => 'IN'
						)
					);
				}
				if ( $display_type == "product_category" ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'terms'    => $category,
							'field'    => 'id',
							'operator' => 'IN'
						)
					);
				}
				if ( $display_type == "product_categories" ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'terms'    => $ids,
							'field'    => 'term_id',
							'operator' => 'IN'
						)
					);
				}

				if ( $product_animation == '' ) {
					$product_animation = 'no-animation';
				} else {
					$style .= 'opacity:1;';
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

						<?php

						if ( false === ( $query = get_transient( 'crum_product_carousel_transient' . $uid ) ) ) {
							$query = new WP_Query( $args );

							set_transient( 'crum_product_carousel_transient' . $uid, $query );

							$this->update_id_option( $uid );
						}

						//$query = new WP_Query( $args );

						if ( $query->have_posts() ):
							while ( $query->have_posts() ) : $query->the_post(); ?>

								<div <?php post_class(); ?>>

									<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

									<div class="entry-thumbnail">
										<a href="<?php echo the_permalink(); ?>" class="link">
											<?php
											do_action( 'woocommerce_before_shop_loop_item_title' );
											?>
										</a>

									</div>

									<?php if ( $show_title == 'true' ): ?>

										<div class="products-description">

											<h3><?php the_title(); ?></h3>

											<?php crum_woocommerce_single_subtitle(); ?>

										</div>

									<?php endif; ?>

									<?php if ( $show_buttons == 'true' ): ?>

										<div class="products-other">

											<?php
											do_action( 'woocommerce_after_shop_loop_item_title' );
											?>

											<div class="wrap-other">
												<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
											</div>
										</div>

									<?php endif; ?>

								</div>
							<?php endwhile;
						endif;?>


					</div>

					<?php if ( $display_type == "top_rated_products" ) {
						remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
					}
					wp_reset_postdata();?>

				</div>

				<script type="text/javascript">
					(function ($) {
						$(document).ready(function () {

							$('#<?php echo 'slides-'.$uid.''; ?>').slick({
								infinite      : <?php echo $infinite; ?>,
								slidesToShow  : <?php echo $slides_to_show; ?>,
								slidesToScroll: <?php echo $slides_to_scroll; ?>,
								arrows        : <?php echo $arrows;?>,
								dots          : <?php echo $dots; ?>,
								speed         : <?php echo $scroll_speed;?>,
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

				return $output;

			}

		}

	}

	if ( class_exists( 'Crum_Products_Carousel' ) ) {
		$Crum_Products_Carousel = new Crum_Products_Carousel;
	}
}