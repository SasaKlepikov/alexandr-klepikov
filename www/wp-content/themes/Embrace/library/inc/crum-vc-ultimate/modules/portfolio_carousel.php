<?php
if ( ! class_exists( 'Crum_Recent_Portfolios' ) ) {
	class Crum_Recent_Portfolios {
		function __construct() {
			add_shortcode( 'recent_portfolios', array( $this, 'crum_recent_portfolios_form' ) );
			add_action( 'admin_init', array( $this, 'crum_recent_portfolios_init' ) );

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'crum_recent_folio' );

			return $uniue_id;
		}

		function update_id_option($transient_id){


			if ( get_option( 'crum_cached_folio' ) ) {

				$tmp = get_option( 'crum_cached_folio' );

				// The option already exists, so we just update it.
				$tmp = $tmp. ',crum_recent_folio_transient'.$transient_id;
				update_option( 'crum_cached_folio', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_folio_transient'.$transient_id;

				add_option( 'crum_cached_folio', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );

		}

		function crum_delete_transient(){

			$tmp = get_option('crum_cached_folio');

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode(',',$tmp);

			} else {

				return;
			}

			foreach($temp as $transient){
				delete_transient($transient);
			}

			delete_option('crum_cached_folio');
		}

		function crum_recent_portfolios_form( $atts, $content = null ) {

			$loop = $crop_thumb_disable = $carousel_easing = $transient_id = $module_animation = '';

			$slides_to_show = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = '';

			extract(
				shortcode_atts(
					array(
						"loop"                  => '',
						'crop_thumb_disable' => '',
						"carousel_easing"       => 'linear',
						"transient_id" => '',
						'module_animation' => '',
						'slides_to_show' => '',
						"scroll_speed" => '',
						'slides_to_scroll' => '',
						'advanced_opts' => '',
						'autoplay_speed' => '',
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}
			$unique_id = uniqid( 'vc_addon' );

			$uniqid = 'recent-' . uniqid();


			$html = '';

			$parse_args = explode('|',$loop);
			foreach ($parse_args as $parse_arg){
				$parsing = explode(':',$parse_arg);
				if ( !($parsing[1] == '') ) {
					$parse_index[] = $parsing[0];
					$parse_value[] = $parsing[1];
				}
				$args = array_combine($parse_index,$parse_value);
			}

			if (isset($args['tax_query']) && !($args['tax_query'] == '')){
				$tax_ids = explode(',',$args['tax_query']);

				$args['tax_query'] = array(
					array('taxonomy' => 'portfolio-category',
					      'field'    => 'id',
					      'terms' => $tax_ids,)
				);

			}

			$args['posts_per_page'] = $args['size'];
			$args['size'] = null;

			if ( (!isset($args['post_type'])) || $args['post_type'] == '' ) {
				$args['post_type'] = 'portfolio';
			}

			if ( false === ( $the_query = get_transient( 'crum_recent_folio_transient'.$transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_recent_folio_transient'.$transient_id, $the_query );
				$this->update_id_option($transient_id);
			}

			$infinite = $autorotation = $dots = $arrows = 'false';
			$advanced_opts = explode( ",", $advanced_opts );

			if ( in_array( "infinite", $advanced_opts ) ) {
				$infinite = 'true';
			}
			if ( in_array( "autoplay", $advanced_opts ) ) {
				$autorotation = 'true';
			}
			if ( in_array( "dots", $advanced_opts ) ) {
				$dots = 'true';
			}
			if (in_array("arrows",$advanced_opts)){
				$arrows = 'true';
			}

			ob_start();

				$animate = $animation_data = '';

				if ( ! ($module_animation == '')){
					$animate = ' cr-animate-gen';
					$animation_data = 'data-animate-type = "'.$module_animation.'" ';
				}

				$opening = null;
				$closing = null;

			$rtl = 'false';
			if(is_rtl())
				$rtl = 'true';

				$opening .= '<div class="carousel-wrap '.$animate.'" '.$animation_data.'> <div class="carousel slider-loading" data-rtl="'.$rtl.'" data-easing="ease-in-out" data-slides-show="'.$slides_to_show.'" data-slides-scroll="'.$slides_to_scroll.'" data-autoplay-speed="'.$autoplay_speed.'000" data-autorotate="' . $autorotation . '" data-infinite="'.$infinite.'" data-dots="'.$dots.'" data-arrows="'.$arrows.'" data-scroll-speed="' . $scroll_speed . '" data-full-width="false">';
				$closing .= '</div></div>';

				echo $opening;

				while ( $the_query->have_posts() ) : $the_query->the_post();

					include(locate_template('post-formats/portfolio-carousel.php'));
					//get_template_part( 'post-formats/portfolio', 'carousel' );

				endwhile;

				echo $closing;


			wp_reset_postdata();

			$html .= ob_get_clean();

			return $html;

		}

		function crum_recent_portfolios_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Recent Portfolios Carousel", "crum" ),
						"base"        => "recent_portfolios",
						"icon"        => "recent_portfolio",
						"category"    => __( "Content", "crum" ),
						"description" => __( "Add module with portfolios carousel", "crum" ),
						"params"      => array(
							array(
								"type"        => "loop",
								"heading"     => __( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'post_type'  => array( 'hidden' => true, 'value' => 'portfolio' ),
									'size'       => array( 'hidden' => false, 'value' => 12 ),
									'order_by'   => array( 'value' => 'date' ),
									'categories' => array( 'hidden' => true, 'value' => '' ),
									'tags'       => array( 'hidden' => true, 'value' => '' ),
									'tax_query'  => array( 'hidden' => false, 'value' => '' ),
									'by_id'      => array( 'hidden' => true, 'value' => '' ),
									'authors'    => array( 'hidden' => false, 'value' => '' )
								),
								"group"       => $group,
								"description" => __( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
							),
							array(
								"type"        => "dropdown",
								"param_name"  => "transient_id",
								"group"       => $group,
								"value"       => array($this->generate_id()),
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => __( "Disable thumbnail crop", "crum" ),
								"param_name"  => "crop_thumb_disable",
								"value"       => array(
									"Show full size thumbnails"           => "true",
								),
								"description" => __( "", "crum" ),
								"group"       => $group,
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
	}

	new Crum_Recent_Portfolios;
}