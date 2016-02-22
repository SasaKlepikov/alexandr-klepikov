<?php
if ( ! class_exists( 'Crum_Recent_Posts_Slider' ) ) {
	class Crum_Recent_Posts_Slider {

		function __construct() {
			add_action( 'admin_init', array( &$this, 'crum_recent_posts_slider_init' ) );
			add_shortcode( 'recent_posts_slider', array( &$this, 'crum_recent_posts_slider_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'recent_posts_id' );

			return $uniue_id;
		}

		function update_id_option( $transient_id ) {

			if ( get_option( 'crum_cached_content' ) ) {

				$tmp = get_option( 'crum_cached_content' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_recent_post_transient' . $transient_id;
				update_option( 'crum_cached_content', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_post_transient' . $transient_id;

				add_option( 'crum_cached_content', $new_value );

			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_content' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_content' );
		}

		function crum_recent_posts_slider_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Recent Posts Slider", "crum" ),
						"base"        => "recent_posts_slider",
						"icon"        => "recent_posts_slider_icon",
						"category"    => __( "Content", "crum" ),
						"description" => __( "Add block with several recent posts", "crum" ),
						"params"      => array(
							array(
								"type"       => "dropdown",
								"heading"    => __( "Which post display first?", "crum" ),
								"param_name" => "recent_posts_slider_featured",
								"value"      => array(
									"Latest post" => "featured",
									"Sticky post" => "sticky",
								),
								"group"       => $group,
							),
                            array(
                                "type"       => "dropdown",
                                "heading"    => __( "Select template", "crum" ),
                                "param_name" => "template",
                                "value"      => array(
                                    "Vertical" => "vartical",
                                    "Horizontal" => "horizontal",
                                ),
                                "group"       => $group,
                            ),
							array(
								"type"        => "checkbox",
								"heading"     => __( "Show additional post info", "crum" ),
								"param_name"  => "recent_posts_slider_dopinfo",
								"value"       => array( "Yes, please" => true ),
								"group"       => $group,
								"description" => __( "Meta information about post. For example: date of post creation and author name", "crum" ),
							),
							array(
								"type"        => "loop",
								"heading"     => __( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'post_type' => array( 'hidden' => true, 'value' => 'post' ),
									'size'      => array( 'hidden' => false, 'value' => 4 ),
									'order_by'  => array( 'value' => 'date' ),
								),
								"group"       => $group,
								"description" => __( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
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
								"type"       => "dropdown",
								"param_name" => "transient_id",
								"group"       => $group,
								"value"      => array( $this->generate_id() )
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

		// end crum_recent_posts_slider_init

		function crum_recent_posts_slider_form( $atts, $content = null ) {

			$recent_posts_slider_featured = $recent_posts_slider_dopinfo = $loop = $transient_id = $module_animation = '';

			$slides_to_show = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = $template = '';

				extract(
				shortcode_atts(
					array(
						"recent_posts_slider_featured"          => "",
						"recent_posts_slider_dopinfo"           => "",
                        "template"                              => "",
						"loop"                                  => "",
						"transient_id"                          => "",
						"slides_to_show"         => "",
						"slides_to_scroll"             => "",
						"scroll_speed"     => "",
						"advanced_opts"     => "",
						"autoplay_speed"     => "",
						"module_animation" => "",
					), $atts
				)
			);

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

			if ( empty( $loop ) ) {
				return;
			}
			$this->getLoop( $loop );

			//if ( $displaying_type == '1_column' ) {
			$args = $this->loop_args;

			if ( ! ( isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'post';
			}
			if ( $recent_posts_slider_featured == 'featured' ) {
				$args['ignore_sticky_posts'] = '1';
			}

			if ( false === ( $latest_news_query = get_transient( 'crum_recent_post_transient' . $transient_id ) ) ) {
				$latest_news_query = new WP_Query( $args );

				set_transient( 'crum_recent_post_transient' . $transient_id, $latest_news_query );

				$this->update_id_option( $transient_id );
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}


			$output = '';

			$output .= '<div class="row '.$animate.' template-'.$template.'" '.$animation_data.' >';

			$output .= '<div id="slider-'.$transient_id.'" class="sliding-content-slider cursor-move recent-posts-slider">';
			$output .= '<div id="slides-' . $transient_id . '">';
			while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post();

                if ($template == 'horizontal'){

                    if ( has_post_format( 'audio') ) {
                        $featured_icon = '<i class="embrace-music2"></i>';
                    } elseif ( has_post_format( 'video') ) {
                        $featured_icon = '<i class="embrace-film_strip"></i>';
                    } elseif ( has_post_format( 'quote') ) {
                        $featured_icon = '<i class="crumicon-quote-left"></i>';
                    } elseif ( has_post_format( 'gallery') ) {
                        $featured_icon = '<i class="embrace-photos_alt2"></i>';
                    } elseif ( has_post_format( 'image') ) {
                        $featured_icon = '<i class="embrace-photo2"></i>';
                    } else {
                        $featured_icon = '<i class="embrace-forward2"></i>';
                    }

                    $output .= '<div class="entry-body bock-recent-posts">';
                    $output .= '<div class="single-thumbnail">';

                    if ( has_post_thumbnail() ) {
                        $image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
                    }
                    else {
                        $image_url = get_template_directory_uri() . '/library/img/no-image/large.png';
                    }

                    $thumb = theme_thumb( $image_url, 250, 250, true );
                    $output .= '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

                    $output .= '<div class="overlay"></div>';
                    $output .= '<div class="links"><a href="'. get_the_permalink().'" class="link" rel="bookmark" title="'.get_the_title().'">'.$featured_icon.'</a></div>';

                    $output .= '</div><!-- .entry-thumb -->';//

                    $output .= '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';

                    if ( $show_dopinfo == '1' ) {
                        ob_start();
                        reactor_post_meta( $args = array(
                            'show_date' => true,
                            'show_author' => true
                        ) );
                        $output .= ob_get_clean();

                    }

                    $output .= '<div class="entry-content">';

                    $shortexcerpt = wp_trim_words( get_the_content(), $num_words = 60, $more = '' );

                    $output .= '<p>' . $shortexcerpt . '</p>';

                    $output .= '<span class="read-more-button"><a class="button" href="'. get_permalink() .'">'. __( 'Read more &raquo;', 'crum' ).'</a></span>';

                    $output .= '</div><!-- .entry-content -->';

                    $output .= '</div><!-- .entry-body -->';



                } else {

				$output .= '<div id="post-' . get_the_ID() . '"  class="post type-post">';

				$output .= '<div class="entry-body">';

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
					$url          = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					$url          = $url[0];
					$thumb_width  = '500';
					$thumb_height = '500';
					$thumb_crop   = true;

					$output .= '<div class="entry-thumbnail">';
					$output .= '<img src ="' . theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ) . '" alt="' . get_the_title() . '">';
					$output .= '<div class="overlay"></div>';
					$output .= '<div class="links">';
					$output .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
					$output .= '</div>';
					$output .= '</div>';
				} else {
					$output .= '<div class="entry-thumbnail">';
					$output .= '<img src ="'.get_template_directory_uri() . '/library/img/no-image/large.png'.'" alt="' . get_the_title() . '">';
					$output .= '<div class="overlay"></div>';
					$output .= '<div class="links">';
					$output .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
					$output .= '</div>';
					$output .= '</div>';
				}

				$output .= '</div>'; // entry-body

					$output .= '<header class="recent-post-header">';
					$output .= '<h5 class="entry-title">';
					$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
					$output .= '</h5>';


				if ( $recent_posts_slider_dopinfo == '1' ) {
					ob_start();
					reactor_post_meta( $args = array(
							'show_author'   => false,
							'show_date'     => true,
							'show_cat'      => false,
							'show_tag'      => false,
							'show_icons'    => false,
							'show_comments' => false,
						)
					);

					$output .= ob_get_clean();
				}
                $output .= '</header>';

				$output .= '</div>';

                }

			endwhile;

			wp_reset_postdata();

			$output .= '</div>'; //recent-slider
			$output .= '</div>'; //sliding-content-slider
			$output .= '</div>'; //row
			?>

			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {

						$('#<?php echo 'slides-'.$transient_id.''; ?>').slick({
								infinite      : <?php echo $infinite; ?>,
								slidesToShow  : <?php echo $slides_to_show; ?>,
								slidesToScroll: <?php echo $slides_to_scroll; ?>,
								arrows        : <?php echo $arrows;?>,
								speed         : <?php echo $scroll_speed;?>,
								dots          : <?php echo $dots; ?>,
								autoplay      : <?php echo $autoplay; ?>,
								autoplaySpeed : <?php echo $autoplay_speed.'000'; ?>,
								responsive    : [
                                    {
                                        breakpoint: 600,
                                        settings  : {
                                            slidesToShow  : 2,
                                            slidesToScroll: 2
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

			<?php return $output;

		}
		// end crum_recent_posts_slider_form
	}
	// end Crum_Recent_Posts_Slider
}
// endif

if ( class_exists( 'Crum_Recent_Posts_Slider' ) ) {
	$Crum_Recent_Posts_Slider = new Crum_Recent_Posts_Slider;
}