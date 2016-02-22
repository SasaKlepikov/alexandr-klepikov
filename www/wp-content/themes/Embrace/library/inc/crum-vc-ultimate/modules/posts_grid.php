<?php
if ( ! class_exists( 'Crum_Posts_Grid' ) ) {

	class Crum_Posts_Grid {

		function __construct() {

			add_action( 'admin_init', array( &$this, 'crum_posts_grid_init' ) );
			add_shortcode( 'posts_grid', array( &$this, 'crum_posts_grid_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );

		}

		function generate_id() {
			$uniue_id = uniqid( 'crum_widget_id' );

			return $uniue_id;
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_posts_grid_content' ) ) {

				$tmp = get_option( 'crum_posts_grid_content' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_grid_posts_transient' . $transient_id;
				update_option( 'crum_posts_grid_content', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_grid_posts_transient' . $transient_id;

				add_option( 'crum_posts_grid_content', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_posts_grid_content' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_posts_grid_content' );
		}

		function crum_posts_grid_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Posts Grid", "crum" ),
						"base"        => "posts_grid",
						"icon"        => "posts_grid_icon",
						"category"    => __( "Content", "crum" ),
						"description" => __( "Add block with posts grid", "crum" ),
						"params"      => array(
							array(
								"type"        => "loop",
								"heading"     => __( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'post_type'  => array( 'hidden' => true, 'value' => 'post' ),
									'size'       => array( 'hidden' => false, 'value' => 12 ),
								),
								"group"       => $group,
								"description" => __( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Select template", "crum" ),
								"param_name"  => "posts_grid_style",
								"value"       => array(
									"Grid+Sorting" => "grid_sort",
									//"Grid+Inline box" => "grid_inline_box",
								),
								"group"       => $group,
								"description" => __( "Select template of grid for posts displaying", "crum" ),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Posts columns", "crum" ),
								"param_name"  => "posts_grid_columns",
								"value"       => array(
									'Two'   => '2',
									'Three' => '3',
									'Four'  => '4',
									'Five'  => '5',
									'Six'   => '6',
								),
								"group"       => $group,
								"description" => __( "Number of posts columns", "crum" )
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Item spacing", "crum" ),
								"param_name"  => "posts_grid_spacing",
								"value"       => array(
									'Enable'  => 'enable',
									'Disable' => 'disable',
								),
								"group"       => $group,
								"description" => __( "Display space gap between grid items", "crum" )
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => __( "Panel for items sorting  ", "crum" ),
								"param_name"  => "posts_grid_panel",
								"value"       => array(
									'Enabled' => 'enable',
								),
								"group"       => $group,
								"description" => __( "Display panel for posts isotope items sorting by category", "crum" ),
								"dependency"  => Array(
									"element" => "posts_grid_style",
									"value"   => array( "grid_sort" )
								),
							),
							array(
								"type"       => "checkbox",
								"class"      => "",
								"heading"    => __( "Title / description under item ", "crum" ),
								"param_name" => "posts_grid_description",
								"value"      => array(
									'Hide' => 'enable',
								),
								"group"       => $group,
								"dependency" => Array(
									"element" => "posts_grid_style",
									"value"   => array( "grid_sort" )
								),
							),
							array(
								"type"       => "checkbox",
								"class"      => "",
								"heading"    => __( "Show \"Read more\" button", "crum" ),
								"param_name" => "posts_grid_read_more",
								"value"      => array(
									'Enabled' => 'enable',
								),
								"group"       => $group,
								"dependency" => Array(
									"element" => "posts_grid_style",
									"value"   => array( "grid_inline_box" )
								),
							),
							array(
								"type"       => "dropdown",
								"param_name" => "transient_id",
								"group"       => $group,
								"value"      => array( $this->generate_id() ),
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

		function crum_posts_grid_form( $atts, $content = null ) {

			$loop = $posts_grid_style = $posts_grid_columns = $posts_grid_spacing = $posts_grid_panel = $posts_grid_description = $posts_grid_read_more = $transient_id = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						"loop"                   => "",
						"posts_grid_style"       => "",
						"posts_grid_columns"     => "",
						"posts_grid_spacing"     => "",
						"posts_grid_panel"       => "",
						"posts_grid_description" => "",
						"posts_grid_read_more"   => "",
						"transient_id"           => "",
						"module_animation"       => "",
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}

			$posts_grid_space    = ( $posts_grid_spacing == 'enable' ) ? '' : 'no-margin';
			$posts_grid_titles   = ( $posts_grid_description == 'enable' ) ? 'inline-titles' : '';
			$posts_grid_readmore = ( $posts_grid_read_more == 'enable' ) ? '' : 'no-read-more-button';

			$html = '';

			$parse_args = explode( '|', $loop );
			foreach ( $parse_args as $parse_arg ) {
				$parsing = explode( ':', $parse_arg );
				if ( ! ( $parsing[1] == '' ) ) {
					$parse_index[] = $parsing[0];
					$parse_value[] = $parsing[1];
				}
				$args = array_combine( $parse_index, $parse_value );
			}

			$args['posts_per_page'] = $args['size'];
			$args['size']           = null;

			if ( ( ! isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'post';
			}

			if ( isset($args['categories']) && !($args['categories'] == '') ) {
				$selected_cats = explode(',',$args['categories']);

				if (is_array($selected_cats)){
					$args['category__in'] = $selected_cats;
				}else{
					$args['cat'] = $args['categories'];
				}
			}
			if ( false === ( $the_query = get_transient( 'crum_grid_posts_transient' . $transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_grid_posts_transient' . $transient_id, $the_query );
				$this->update_id_option( $transient_id );
			}

			ob_start();

			if ( $posts_grid_panel ) {
				reactor_category_submenu( array( 'taxonomy' => 'category', 'quicksand' => true ) );
			}

			if ( $the_query->have_posts() ) :

				$animate = $animation_data = '';

				if ( ! ($module_animation == '')){
					$animate = ' cr-animate-gen';
					$animation_data = 'data-animate-item = ".type-post" data-animate-type = "'.$module_animation.'" ';
				}


				echo '<ul class="portfolio-sortable multi-column with-inline-desc small-block-grid-2  large-block-grid-' . $posts_grid_columns . ' ' . $posts_grid_space . ' '.$animate.'" '.$animation_data.' >';

				reactor_loop_before();

				while ( $the_query->have_posts() ) : $the_query->the_post();
					global $more;
					$more = 0;?>

					<?php // get the categories for data-type storting
					$port_cats   = '';
					$the_id      = get_the_ID();
					$the_terms   = get_the_terms( $the_id, 'category' );
					$cat_array   = array();
					$cat_array[] = 'isotope-item';
					$cat_array[] = $posts_grid_titles;

					if ( $the_terms && ! is_wp_error( $the_terms ) ) :

						foreach ( $the_terms as $the_term ) {
							if ( ! ( $the_term->parent == '' ) ) {
								$parent_terms = get_term( $the_term->parent, 'category' );
								if ( ! is_wp_error( $parent_terms ) ) {
									if ( is_array($selected_cats) && in_array($parent_terms->term_id,$selected_cats) ) {
										$cat_array[] = $parent_terms->slug;
									}
								}
							} else {
								if ( isset($selected_cats) && is_array($selected_cats) && in_array($the_term->term_id,$selected_cats) ) {
									$cat_array[] = $the_term->slug;
								}
							}
						}
					endif;
					?>

					<li id="portfolio-<?php the_ID(); ?>" <?php post_class( $cat_array ); ?>>
						<div class="entry-thumb no-radius no-margin">

							<?php
							$image_url = '';

							if (has_post_format('audio')){
								$featured_icon = '<i class="embrace-music2"></i>';
							}elseif (has_post_format('video')) {
								$featured_icon = '<i class="embrace-film_strip"></i>';
							}elseif (has_post_format('quote')) {
								$featured_icon = '<i class="crumicon-quote-left"></i>';
							}elseif (has_post_format('gallery')) {
								$featured_icon = '<i class="embrace-photos_alt2"></i>';
							}elseif (has_post_format('image')) {
								$featured_icon = '<i class="embrace-photo2"></i>';
							}else{
								$featured_icon = '<i class="embrace-forward2"></i>';
							}

							if ( has_post_thumbnail() ) {
								$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

								$thumb = theme_thumb( $image_url, 480, 420, true );

								echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

							} else {

								$image_url = '';

								$thumb = get_template_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

								echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

							} ?>

							<div class="overlay"></div>

							<div class="links">

								<a href="<?php the_permalink(); ?>" class="link"><?php echo $featured_icon;?></a>

							</div>

						</div>
						<div class="item-grid-title">
							<h5 class="entry-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h5>
							<?php the_terms( $the_id, 'category', '<div class="categories">', ',  ', '</div>' ); ?>
						</div>
					</li>

					<?php reactor_loop_after();

				endwhile; // end of the posts loop

				echo '</ul>';

			// if no posts are found
			else : reactor_loop_else();

			endif; // end have_posts() check

			wp_reset_postdata();

			$html .= ob_get_clean();

			return $html;

		}

	}

}

if ( class_exists( 'Crum_Posts_Grid' ) ) {
	$Crum_Posts_Grid = new Crum_Posts_Grid;
}