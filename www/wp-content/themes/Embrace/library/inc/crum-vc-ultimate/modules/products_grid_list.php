<?php
if (class_exists('WooCommerce')){
	if (! class_exists('Crum_Products_Grid_List')){

		class Crum_Products_Grid_List{

			function __construct(){

				add_action('admin_init', array($this, 'crum_products_grid_list_init'));
				add_shortcode('crum_products_grid_list', array($this, 'crum_products_grid_list_form'));

				//Transient deleting

				add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
				add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );

			}

			function update_id_option( $transient_id ) {


				if ( get_option( 'crum_cached_products_grid' ) ) {

					$tmp = get_option( 'crum_cached_products_grid' );

					// The option already exists, so we just update it.
					$tmp = $tmp . ',crum_product_grid_transient' . $transient_id;
					update_option( 'crum_cached_products_grid', $tmp );

				} else {

					// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
					$new_value = 'crum_product_grid_transient' . $transient_id;

					add_option( 'crum_cached_products_grid', $new_value );
				}
			}

			function crum_delete_transient() {

				$tmp = get_option( 'crum_cached_products_grid' );

				if ( $tmp !== false ) {

					// The option already exists, so we just update it.
					$temp = explode( ',', $tmp );

				} else {

					return;
				}

				foreach ( $temp as $transient ) {
					delete_transient( $transient );
				}

				delete_option( 'crum_cached_products_grid' );
			}

			function crum_products_grid_list_init(){
				if (function_exists('vc_map')){

					$group = __("Main Options", "crum");

					vc_map(
						array(
							"name"                    => __( "Products Grid/List", "crum" ),
							"base"                    => "crum_products_grid_list",
							"icon"                    => "woocommerce_icon",
							"class"                   => "",
							"category"                => __( "Woocommerce", "crum" ),
							"description"             => __( "Display products in Grid or List view", "crum" ),
							"controls"                => "full",
							"show_settings_on_create" => true,
							"params"                  => array(
								array(
									"type"        => "product_query",
									"class"       => "",
									"heading"     => __( "Products query", "crum" ),
									"param_name"  => "crum_products_grid_query",
									"value"       => "",
									"labels"      => array(
										"products_from" => __( "Display:", "crum" ),
										"per_page"      => __( "How Many:", "crum" ),
										"columns"       => __( "Columns:", "crum" ),
										"order_by"      => __( "Order By:", "crum" ),
										"order"         => __( "Display Order:", "crum" ),
										"category"      => __( "Category:", "crum" ),
									),
									"group"       => $group,
									"description" => __( "", "crum" ),
								),
								array(
									"type" => "dropdown",
									"class" => "",
									"heading" => __("Display Style", "crum"),
									"param_name" => "display_style",
									"admin_label" => true,
									"value" => array(
										__("Grid","crum") => "grid",
										__("List","crum") => "list",
									),
									"group"       => $group,
									"description" => __("", "crum"),
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
									"dependency"  => Array(
										"element" => "display_style",
										"value"   => array( "grid" )
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

			function crum_products_grid_list_form($atts, $content = null){

				global $woocommerce;

				$crum_products_grid_query = $display_style = $columns_number = $module_animation = '';

				extract(shortcode_atts(array(
					"crum_products_grid_query" => "",
					"display_style" => "grid",
					"columns_number" => "2",
					"module_animation" => "",
				),$atts));

				$uid = uniqid();

				if ( $crum_products_grid_query !== '' ) {
					$new_shortcode = rawurldecode( base64_decode( strip_tags( $crum_products_grid_query ) ) );
				}
				$pattern       = get_shortcode_regex();
				$shortcode_str = $short_atts = '';
				preg_match_all( "/" . $pattern . "/", $new_shortcode, $matches );
				$shortcode_str = str_replace( '"', '', str_replace( " ", "&", trim( $matches[3][0] ) ) );
				$short_atts    = parse_str( $shortcode_str ); //explode("&",$shortcode_str);

				if ( isset( $matches[2][0] ) ): $display_type = $matches[2][0];
				else: $display_type = ''; endif;
				if ( ! isset( $per_page ) ): $per_page = '-1'; endif;
				if (isset ($number)) : $per_page = $number; endif;
				if ( ! isset( $order ) ): $order = 'asc'; endif;
				if ( ! isset( $orderby ) ): $orderby = 'date'; endif;
				if ( ! isset( $category ) ): $category = ''; endif;
				if ( ! isset( $ids ) ): $ids = ''; endif;
				if ( $ids ) {
					$ids = explode( ',', $ids );
					$ids = array_map( 'trim', $ids );
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
					'posts_per_page'      => $per_page,
					'orderby'             => $orderby,
					'order'               => $order,
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

				if ($display_style == 'list'){
					$columns_number = '1';
				}

				$output = '';

				ob_start(); ?>

				<?php

				$animate = $animation_data = '';

				if ( ! ($module_animation == '')){
					$animate = ' cr-animate-gen';
					$animation_data = 'data-animate-item = ".type-product" data-animate-type = "'.$module_animation.'" ';
				}

				?>

                <div class="woocommerce">

					<ul class="products small-block-grid-2  large-block-grid-<?php echo $columns_number.' '.$display_style.' '.$animate;?>"<?php echo $animation_data;?>>

						<?php

						if ( false === ( $query = get_transient( 'crum_product_grid_transient' . $uid ) ) ) {
							$query = new WP_Query( $args );

							set_transient( 'crum_product_grid_transient' . $uid, $query );

							$this->update_id_option( $uid );
						}

						//$query = new WP_Query( $args );

						if ( $query->have_posts() ):
							while ( $query->have_posts() ) : $query->the_post(); ?>

								<li <?php post_class(  ); ?>>

									<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

									<div class="entry-thumbnail">
										<a href="<?php echo the_permalink(); ?>" class="link" >
											<?php
											/**
											 * woocommerce_before_shop_loop_item_title hook
											 *
											 * @hooked woocommerce_show_product_loop_sale_flash - 10
											 * @hooked woocommerce_template_loop_product_thumbnail - 10
											 */
											do_action( 'woocommerce_before_shop_loop_item_title' );
											?>
										</a>

									</div>

									<div class="products-description">

										<h3><?php the_title(); ?></h3>

										<?php crum_woocommerce_single_subtitle(); ?>

									</div>

									<div class="products-other">

										<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );
										?>

										<div class="wrap-other">
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
										</div>
									</div>

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

	if (class_exists('Crum_Products_Grid_List')){
		$Crum_Products_Grid_List = new Crum_Products_Grid_List;
	}
}