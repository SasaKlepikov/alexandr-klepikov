<?php
if (! class_exists('Crum_Single_Post')){
	class Crum_Single_Post{

		function __construct(){
			add_action('admin_init',array($this, 'crum_single_post_init'));
			add_shortcode('crum_single_post',array($this, 'crum_single_post_form'));
		}

		function crum_single_post_init(){
			if (function_exists('vc_map')){
				vc_map(
					array(
						"name"                    => __( "Single post", "crum" ),
						"base"                    => "crum_single_post",
						"icon"                    => "",
						"class"                   => "",
						"category"                => __( "Content", "crum" ),
						"description"             => __( "Display single post", "crum" ),
						"controls"                => "full",
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type"        => "post_search",
								"class"       => "",
								"heading"     => __( "Select Post", "woocomposer" ),
								"param_name"  => "crum_single_post_id",
								"admin_label" => true,
								"value"       => "",
								"description" => __( "", "woocomposer" ),
								"group"       => "Post Settings",
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Select Post Style", "woocomposer" ),
								"param_name"  => "crum_single_post_style",
								"admin_label" => true,
								"value"       => array(
									__( "Compact style", "crum" ) => "style01",
									__( "Featured style", "crum" )    => "style02",
								),
								"description" => __( "", "woocomposer" ),
								"group"       => "Post Settings",
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => "Display date and excerpt",
								"value"       => array( "Yes, please" => "true" ),
								"param_name"  => "crum_single_post_show_excerpt",
								"description" => "",
								"group"       => "Post Settings",
								"dependency" => Array("element" => "crum_single_post_style","value" => array("style01")),
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => "Display \"Read more\" button",
								"value"       => array( "Yes, please" => "true" ),
								"param_name"  => "crum_single_post_show_button",
								"description" => "",
								"group"       => "Post Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => "Thumbnail size",
								"param_name" => "thumb_size",
								"value" => array(
									__("Standard","crum") => "standard",
									__("Custom","crum") => "custom",
								),
								"group" => "Thumbnail Settings",
								"description" => __('Select custom thumbnail height. Leave empty for default','crum')
							),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => "Thumbnail width",
                                "param_name" => "thumb_width",
                                "group" => "Thumbnail Settings",
                                "description" => __('Select custom thumbnail width. Leave empty for default','crum'),
                                "dependency" => Array("element" => "thumb_size","value" => array("custom")),
                            ),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => "Thumbnail height",
								"param_name" => "thumb_height",
								"group" => "Thumbnail Settings",
								"description" => __('Select custom thumbnail height. Leave empty for default','crum'),
								"dependency" => Array("element" => "thumb_size","value" => array("custom")),
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

		function crum_single_post_form($atts, $content = null){

			$crum_single_post_id = $crum_single_post_style = $crum_single_post_show_excerpt = $crum_single_post_show_button = $thumb_size = $thumb_height = $thumb_width = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						"crum_single_post_id" => "",
						"crum_single_post_style" => "",
						"crum_single_post_show_excerpt" => "",
						"crum_single_post_show_button" => "",
						"thumb_size" => "standard",
						"thumb_height" => "",
						"thumb_width" => "",
						"module_animation" => "",
					),$atts
				)
			);

			$output = '';



			$args = array(
				'post_type' => 'any',
				'p' => $crum_single_post_id
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {

				$animate = $animation_data = '';

				if ( ! ($module_animation == '')){
					$animate = ' cr-animate-gen';
					$animation_data = 'data-animate-type = "'.$module_animation.'" ';
				}


                $no_read_more = '';

                if ( !($crum_single_post_show_button == 'true') ) {
                    $no_read_more = ' no-read-more';
                }

				if ( has_post_format( 'audio', $crum_single_post_id ) ) {
					$featured_icon = '<i class="embrace-music2"></i>';
				} elseif ( has_post_format( 'video', $crum_single_post_id ) ) {
					$featured_icon = '<i class="embrace-film_strip"></i>';
				} elseif ( has_post_format( 'quote', $crum_single_post_id ) ) {
					$featured_icon = '<i class="crumicon-quote-left"></i>';
				} elseif ( has_post_format( 'gallery', $crum_single_post_id ) ) {
					$featured_icon = '<i class="embrace-photos_alt2"></i>';
				} elseif ( has_post_format( 'image', $crum_single_post_id ) ) {
					$featured_icon = '<i class="embrace-photo2"></i>';
				} else {
					$featured_icon = '<i class="embrace-forward2"></i>';
				}

				while ( $query->have_posts() ) : $query->the_post();

					$output .= '<div class="single-post">';

					if(has_post_thumbnail()){
						$url          = wp_get_attachment_image_src( get_post_thumbnail_id( $crum_single_post_id ), 'full' );
						$url          = $url[0];
						$thumbnail_width  = '600';
						$thumbnail_height = '300';

						if($thumb_size == 'custom'){
							if (isset($thumb_width) && !($thumb_width == '')){
								$thumbnail_width = $thumb_width;
							}
							if (isset($thumb_height) && !($thumb_height == '')){
								$thumbnail_height = $thumb_height;
							}
						}

						$thumb_crop   = true;

					} else {
						$url          = get_template_directory_uri() . '/library/img/no-image/large.png';
						$thumbnail_width  = '600';
						$thumbnail_height = '300';

						if($thumb_size == 'custom'){
							if (isset($thumb_width) && !($thumb_width == '')){
								$thumbnail_width = $thumb_width;
							}
							if (isset($thumb_height) && !($thumb_height == '')){
								$thumbnail_height = $thumb_height;
							}
						}
					}

					if ( $crum_single_post_style == 'style02' ) {


						$output .= '<div class="featured-post">';
						$output .= '<img src ="' . theme_thumb( $url, $thumbnail_width, $thumbnail_height, $thumb_crop ) . '" alt="' . get_the_title() . '">';
						$output .= '<div class="overlay"></div>';
                        $output .= '<span class="text-desc">';
                        $output .= '<h3 class="item-title"><a href="'. get_the_permalink().'" class="link" rel="bookmark" title="'.get_the_title().'">';
                        $output .= get_the_title();
                        $output .= '</a></h3>';
                        ob_start();

                        reactor_post_meta( $args = array(
                                'show_author'   => true,
                                'show_date'     => true,
                                'show_cat'      => true,
                                'show_tag'      => false,
                                'show_icons'    => false,
                                'show_comments' => false,
                            )
                        );

                        $output .= ob_get_clean();
						$output .= '<div class="entry-content ' . $no_read_more . '">';
                        $output .= '<p>'.get_the_excerpt().'</p>';
						$output .= '</div>';//entry-content
						$output .= '</div>';//feature post
					} else {
						$output .= '<div class="single-thumbnail">';
						$output .= '<img src ="' . theme_thumb( $url, $thumbnail_width, $thumbnail_height, $thumb_crop ) . '" alt="' . get_the_title() . '">';
                        $output .= '<div class="overlay"></div>';
                        $output .= '<div class="links"><a href="'. get_the_permalink().'" class="link" rel="bookmark" title="'.get_the_title().'">'.$featured_icon.'</a></div>';
						$output .= '</div>';//entry-thumbnail
						$output .= '<h3 class="post-title">';
                        $output .=  '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
                        $output .= get_the_title();
                        $output .= '</a>';
                        $output .= '</h3>';//post-title

						if ( $crum_single_post_show_excerpt == 'true' ) {
							ob_start();

							reactor_post_meta( $args = array(
									'show_author'   => true,
									'show_date'     => true,
									'show_cat'      => true,
									'show_tag'      => false,
									'show_icons'    => false,
									'show_comments' => false,
								)
							);

							$output .= ob_get_clean();



							$output .= '<div class="entry-content ' . $no_read_more . '">';
							$output .= '<p>'.get_the_excerpt().'</p>';
							$output .= '</div>';//entry-content
						}
					}


					$output .= '</div>'; //single-post

				endwhile;

			}

			return $output;

		}

	}
}

if (class_exists('Crum_Single_Post')){
	$Crum_Single_Post = new Crum_Single_Post;
}