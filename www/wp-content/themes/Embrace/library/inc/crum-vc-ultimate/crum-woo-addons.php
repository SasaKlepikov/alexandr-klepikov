<?php
if ( class_exists( 'WooCommerce' ) ) {

	if ( ! class_exists( 'Crum_Woo_Comoser' ) ) {

		class Crum_Woo_Comoser {

			function __construct() {
				add_action( 'admin_init', array( $this, 'generate_shortcode_params' ) );
			}

			function generate_shortcode_params() {
				/* Generate param type "product_query" */
				if ( function_exists( 'add_shortcode_param' ) ) {
					add_shortcode_param( 'product_query', array(
							$this,
							'woo_query_builder'
						), get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/mapping.js' );
				}

				/* Generate param type "product_search" */
				if ( function_exists( 'add_shortcode_param' ) ) {
					add_shortcode_param( 'product_search', array( $this, 'woo_product_search' ) );
				}

				/* Generate param type "product_categories" */
				if ( function_exists( 'add_shortcode_param' ) ) {
					add_shortcode_param( 'product_categories', array( $this, 'woo_product_categories' ) );
				}
			}

			function woo_query_builder( $settings, $value ) {
				$output  = $asc = $desc = $post_count = $shortcode_str = $cat_id = '';
				$labels  = isset( $settings['labels'] ) ? $settings['labels'] : '';
				$pattern = get_shortcode_regex();
				if ( $value !== "" ) {
					$shortcode = rawurldecode( base64_decode( strip_tags( $value ) ) );
					preg_match_all( "/" . $pattern . "/", $shortcode, $matches );
					$shortcode_str = str_replace( '"', '', str_replace( " ", "&", trim( $matches[3][0] ) ) );
				}

				$short_atts = parse_str( $shortcode_str ); //explode("&",$shortcode_str);
				if ( isset( $matches[2][0] ) ): $display_type = $matches[2][0];
				else: $display_type = ''; endif;
				if ( ! isset( $columns ) ): $columns = '4'; endif;
				if ( ! isset( $per_page ) ): $post_count = '12';
				else: $post_count = $per_page; endif;
				if ( ! isset( $number ) ): $per_page = '12';
				else: $post_count = $number; endif;
				if ( ! isset( $order ) ): $order = 'asc'; endif;
				if ( ! isset( $orderby ) ): $orderby = 'date'; endif;
				if ( isset( $ids ) && ! ( $ids == '' ) ): $categories = explode( ',', $ids ); endif;

				if ( isset( $categories ) && ! ( $categories == '' ) ) {
					foreach ( $categories as $category_id ) {
						$catObj = get_term_by( 'ID', $category_id, 'product_cat' );
						if ( is_object( $catObj ) ) {
							$cat_id[] = $catObj->term_id;
						}
					}
				}

				if (isset ($category) && !($category) == ''){
					$cat_id[] = $category;
				}



				$param_name  = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
				$type        = isset( $settings['type'] ) ? $settings['type'] : '';
				$class       = isset( $settings['class'] ) ? $settings['class'] : '';
				$module      = isset( $settings['module'] ) ? $settings['module'] : '';
				$displays    = array(
					"Recent products"       => "recent_products",
					"Featured Products"     => "featured_products",
					"Top Rated Products"    => "top_rated_products",
					"Product Category"      => "product_category",
					"Product Categories"    => "product_categories",
					"Products on Sale"      => "sale_products",
					"Best Selling Products" => "best_selling_products",
				);
				$orderby_arr = array(
					"Date"       => "date",
					"Title"      => "title",
					"Product ID" => "ID",
					"Name"       => "name",
					"Price"      => "price",
					"Sales"      => "sales",
					"Random"     => "rand",
				);
				$output .= '<div class="display_type"><label for="display_type"><strong>' . $labels['products_from'] . '</strong></label>';
				$output .= '<select id="display_type">';
				foreach ( $displays as $title => $display ) {
					if ( $display == $display_type ) {
						$output .= '<option value="' . $display . '" selected="selected">' . $title . '</option>';
					} else {
						$output .= '<option value="' . $display . '">' . $title . '</option>';
					}
				}
				$output .= '</select></div>';
				$output .= '<div class="per_page"><label for="per_page"><strong>' . $labels['per_page'] . '</strong></label>';
				$output .= '<input type="number" min="2" max="1000" id="per_page" value="' . $post_count . '"></div>';
				if ( $module == "grid" ) {
					$output .= '<div class="columns"><label for="columns"><strong>' . $labels['columns'] . '</strong></label>';
					$output .= '<input type="number" min="2" max="4" id="columns" value="' . $columns . '"></div>';
				}
				$output .= '<div class="orderby"><label for="orderby"><strong>' . $labels['order_by'] . '</strong></label>';
				$output .= '<select id="orderby">';
				foreach ( $orderby_arr as $key => $val ) {
					if ( $orderby == $val ) {
						$output .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
					} else {
						$output .= '<option value="' . $val . '">' . $key . '</option>';
					}
				}
				$output .= '</select></div>';
				$output .= '<div class="order"><label for="order"><strong>' . $labels['order'] . '</strong></label>';
				$output .= '<select id="order">';
				if ( $order == "asc" ) {
					$asc = 'selected="selected"';
				} else {
					$desc = 'selected="selected"';
				}
				$output .= '<option value="asc" ' . $asc . '>Ascending</option>';
				$output .= '<option value="desc" ' . $desc . '>Descending</option>';
				$output .= '</select></div>';
				$output .= '<div class="cat"><label for="cat"><strong>' . $labels['category'] . '</strong></label>';
				//$output .= wp_dropdown_categories( array('taxonomy'=>'product_cat','selected'=>$cat_id,'echo' => false,)).

				$output .= '<select id="cat" name="cat" class="postform">';

				$args = array(
					'orderby'    => 'title',
					'order'      => 'ASC',
					'hide_empty' => 0,
				);

				$product_categories = get_terms( 'product_cat', $args );

				if ( ! is_wp_error( $product_categories ) ) {
					foreach ( $product_categories as $product_category ) {
						if ( is_array( $cat_id ) && in_array( $product_category->term_id, $cat_id ) ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}

						$output .= '<option value="' . $product_category->term_id . '" ' . $selected . ' >' . $product_category->name . '</option>';

					}
				}

				$output .= '</select>';


				$output .= '</div>';
				$output .= '<!-- ' . $value . ' -->';
				$output .= "<input type='hidden' name='" . $param_name . "' value='" . $value . "' class='wpb_vc_param_value " . $param_name . " " . $type . " " . $class . "' id='shortcode'>";

				return $output;
			} /* end woo_query_builder */

			function woo_product_search( $settings, $value ) {
				$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
				$type       = isset( $settings['type'] ) ? $settings['type'] : '';
				$class      = isset( $settings['class'] ) ? $settings['class'] : '';

				$products_array = new WP_Query( array(
					'post_type'      => 'product',
					'posts_per_page' => - 1,
					'post_status'    => 'publish'
				) );
				$output         = '';
				$output .= '<select id="products" name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '">';
				while ( $products_array->have_posts() ) : $products_array->the_post();
					if ( $value == get_the_ID() ) {
						$selected = "selected='selected'";
					} else {
						$selected = '';
					}
					$output .= '<option ' . $selected . ' value="' . get_the_ID() . '">' . get_the_title() . '</option>';
				endwhile;
				$output .= '</select>';


				return $output;
			} /* end woo_product_search */

			function woo_product_categories( $settings, $value ) {
				$param_name         = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
				$type               = isset( $settings['type'] ) ? $settings['type'] : '';
				$class              = isset( $settings['class'] ) ? $settings['class'] : '';
				$product_categories = get_terms( 'product_cat', '' );
				$output             = $selected = $ids = '';
				if ( $value !== '' ) {
					$ids = explode( ',', $value );
					$ids = array_map( 'trim', $ids );
				} else {
					$ids = array();
				}

				$output .= '<select id="sel2_cat" multiple="multiple" style="min-width:200px;">';
				foreach ( $product_categories as $cat ) {
					if ( in_array( $cat->term_id, $ids ) ) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					$output .= '<option ' . $selected . ' value="' . $cat->term_id . '">' . $cat->name . '</option>';
				}

				$output .= '</select>';

				$output .= "<input type='hidden' name='" . $param_name . "' value='" . $value . "' class='wpb_vc_param_value " . $param_name . " " . $type . " " . $class . "' id='sel_cat'>";
				$output .= '<script type="text/javascript">
							jQuery("#sel2_cat").on("change",function(){
								jQuery("#sel_cat").val(jQuery(this).val());
							});
						</script>';

				return $output;

			} /* end woo_product_categories*/

		}

	}

	if ( class_exists( 'Crum_Woo_Comoser' ) ) {
		$Crum_Woo_Comoser = new Crum_Woo_Comoser;
	}

}