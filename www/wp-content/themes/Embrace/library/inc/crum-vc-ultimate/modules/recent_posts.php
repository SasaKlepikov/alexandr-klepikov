<?php
if ( ! class_exists( 'Crum_recent_posts' ) ) {
	class Crum_recent_posts {
		function __construct() {
			add_shortcode( 'recent_posts', array( &$this, 'crum_recent_posts_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_recent_posts_init' ) );

			//Transient deleting

			add_action( 'save_post', array(&$this, 'crum_delete_transient') );
			add_action( 'deleted_post', array(&$this, 'crum_delete_transient') );
			add_action( 'switch_theme', array(&$this, 'crum_delete_transient') );
		}

		function generate_id() {
			$uniue_id = uniqid( 'crum_widget_id' );

			return $uniue_id;
		}

		function update_id_option($transient_id){


			if ( get_option( 'crum_cached_content' ) ) {

				$tmp = get_option( 'crum_cached_content' );

				// The option already exists, so we just update it.
				$tmp = $tmp. ',crum_recent_post_transient'.$transient_id;
				update_option( 'crum_cached_content', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_post_transient'.$transient_id;

				add_option( 'crum_cached_content', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient(){

			$tmp = get_option('crum_cached_content');

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode(',',$tmp);

			} else {

				return;
			}

			foreach($temp as $transient){
				delete_transient($transient);
			}

			delete_option('crum_cached_content');
		}

		function crum_recent_posts_form( $atts, $content = null ) {

			$displaying_type = $feat_sticky = $first_featured = $show_dopinfo = $loop = $transient_id = $cache_time = $html = $module_animation ='';

			extract(
				shortcode_atts(
					array(
						"displaying_type" => '1_column',
						"feat_sticky"     => 'featured',
						"first_featured"  => '',
						'show_dopinfo'    => 'false',
						"loop"            => '',
						'transient_id'    => '',
						'module_animation'=> '',
					), $atts
				)
			);

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".animation-item" data-animate-type = "'.$module_animation.'" ';
			}

			$html = '<div class="bock-recent-posts '.$animate.'" '.$animation_data.'>';

			if ( empty( $loop ) ) {
				return;
			}
			$this->getLoop( $loop );

			//if ( $displaying_type == '1_column' ) {
			$args = $this->loop_args;

			if ( !(isset($args['post_type'])) || $args['post_type'] == '' ) {
				$args['post_type'] = 'post';
			}
			if ( $feat_sticky == 'featured' ) {
				$args['ignore_sticky_posts'] = '1';
			}

			if ( false === ( $latest_news_query = get_transient( 'crum_recent_post_transient'.$transient_id ) ) ) {
				$latest_news_query = new WP_Query( $args );

				set_transient( 'crum_recent_post_transient'.$transient_id, $latest_news_query );

				$this->update_id_option($transient_id);
			}

			$i = '1';

            if ($displaying_type == '2_column'){
                $displaying_type = '2_column row';
            }

			$html .= '<div class="type-'.$displaying_type.'">';

			while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post();

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

				if ($i == '1' && $first_featured){

					if ($displaying_type == '1_column'){

						$html .= '<div class="entry-body animation-item">';

						if ( has_post_thumbnail() ) {
							$url          = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
							$url          = $url[0];
							$thumb_width  = '600';
							$thumb_height = '400';
							$thumb_crop   = true;

							$html .= '<div class="entry-thumbnail">';
							$html .= '<img src ="' . theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ) . '" alt="' . get_the_title() . '">';
							$html .= '<div class="overlay"></div>';
							$html .= '<div class="links">';
							$html .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
							$html .= '</div>';
							$html .= '</div>';
						}else{
							$html .= '<div class="entry-thumbnail">';
							$html .= '<img src ="'.get_template_directory_uri() . '/library/img/no-image/large.png'.'" alt="' . get_the_title() . '">';
							$html .= '<div class="overlay"></div>';
							$html .= '<div class="links">';
							$html .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
							$html .= '</div>';
							$html .= '</div>';
						}

						$html .= '<header class="entry-header">';
						$html .= '<h3 class="entry-title">';
						$html .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
						$html .= '</h3>';

						if ( $show_dopinfo == '1' ) {

							ob_start();
							reactor_post_meta( $args = array(
								'show_date' => true,
								'show_author' => false,
							) );

							$html .= ob_get_clean();

						}

						$html .= '</header><!-- .entry-header -->';

						$html .= '<div class="entry-summary">';
						$html .= '<p>';
						$html .= get_the_excerpt();
						$html .= '</p>';
						$html .= '</div><!-- .entry-summary -->';

						$html .= '</div>';//entry-body

						$i++;

					}else{

						$html .= '<div class="large-6 columns animation-item">';

						$html .= '<div class="entry-body featured-item">';

						if ( has_post_thumbnail() ) {
							$url          = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
							$url          = $url[0];
							$thumb_width  = '600';
							$thumb_height = '380';
							$thumb_crop   = true;

							$html .= '<div class="entry-thumbnail">';
							$html .= '<img src ="' . theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ) . '" alt="' . get_the_title() . '">';
							$html .= '<div class="overlay"></div>';
							$html .= '<div class="links">';
							$html .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
							$html .= '</div>';
							$html .= '</div>';
						}else{
							$html .= '<div class="entry-thumbnail">';
							$html .= '<img src ="'.get_template_directory_uri() . '/library/img/no-image/large.png'.'" alt="' . get_the_title() . '">';
							$html .= '<div class="overlay"></div>';
							$html .= '<div class="links">';
							$html .= '<a href="' . get_permalink() . '" class="link" rel="bookmark" title="' . get_the_title() . '">'.$featured_icon.'</a>';
							$html .= '</div>';
							$html .= '</div>';
						}

						$html .= '<header class="entry-header">';
						$html .= '<h3 class="entry-title">';
						$html .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a>';
						$html .= '</h3>';

						if ( $show_dopinfo == '1' ) {
							ob_start();
							reactor_post_meta( $args = array( 'show_date' => true ) );
							$html .= ob_get_clean();
						}

						$html .= '</header><!-- .entry-header -->';

						$html .= '<div class="entry-summary no-read-more">';
						$html .= '<p>';
						$html .= get_the_excerpt();
						$html .= '</p>';
						$html .= '</div><!-- .entry-summary -->';

						$html .= '</div>';//entry-body

						$html .= '</div><div class="large-6 columns">';

						$i++;


					}

				}else{


					if ($displaying_type != '1_column' ){

                        if (! $first_featured) {
                            $columns_class = 'large-6 columns';
                        } else {
                            $columns_class = '';
                        }

						$html .= '<div class="animation-item '.$columns_class.'">';
						$html .= '<div class="entry-body">';
						$html .= '<div class="single-thumbnail">';

						if ( has_post_thumbnail() ) {
							$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
						}
						else {
							$image_url = get_template_directory_uri() . '/library/img/no-image/large.png';
						}

						$thumb = theme_thumb( $image_url, 127, 127, true );
						$html .= '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

                        $html .= '<div class="overlay"></div>';
                        $html .= '<div class="links"><a href="'. get_the_permalink().'" class="link" rel="bookmark" title="'.get_the_title().'">'.$featured_icon.'</a></div>';

						$html .= '</div><!-- .entry-thumb -->';

						$html .= '<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h4>';

						if ( $show_dopinfo == '1' ) {
							ob_start();
							reactor_post_meta( $args = array(
                                'show_date' => true,
                                'show_author' => true,
                                'show_cat' => false,
                                'show_tag' => false
							) );
							$html .= ob_get_clean();

						}

						$html .= '<div class="entry-content">';
						$trimexcerpt  = get_the_content();
						$shortexcerpt = wp_trim_words( $trimexcerpt, $num_words = 15, $more = '… ' );
						$html .= '<p>' . $shortexcerpt . '</p>';


						$html .= '</div><!-- .entry-content -->';
						$html .= '</div><!-- .entry-body -->';
                        $html .= '</div><!-- .animation item -->';


					}else{

						$html .= '<div class="entry-body animation-item">';
						$html .= '<div class="single-thumbnail">';

						if ( has_post_thumbnail() ) {
							$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
						}
						else {
							$image_url = get_template_directory_uri() . '/library/img/no-image/large.png';
						}

						$thumb = theme_thumb( $image_url, 250, 250, true );
						$html .= '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

                        $html .= '<div class="overlay"></div>';
                        $html .= '<div class="links"><a href="'. get_the_permalink().'" class="link" rel="bookmark" title="'.get_the_title().'">'.$featured_icon.'</a></div>';

						$html .= '</div><!-- .entry-thumb -->';//

						$html .= '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';

						if ( $show_dopinfo == '1' ) {
						ob_start();
						reactor_post_meta( $args = array(
							'show_date' => true,
							'show_author' => true
						) );
						$html .= ob_get_clean();

						}

						$html .= '<div class="entry-content">';

                        $shortexcerpt = wp_trim_words( get_the_content(), $num_words = 60, $more = '' );

						$html .= '<p>' . $shortexcerpt . '</p>';

                        $html .= '<span class="read-more-button"><a class="button" href="'. get_permalink() .'">'. __( 'Read more &raquo;', 'crum' ).'</a></span>';

						$html .= '</div><!-- .entry-content -->';

						$html .= '</div><!-- .entry-body -->';
					}

					$i++;

				}

			endwhile;
            if ($displaying_type != '1_column' ){
                $html .= '</div>';//close 6-columns
            }

			$html .= '</div>';//row

			$html .= '</div>';//bock-recent-news

			wp_reset_postdata();

			return $html;
		}

		function crum_recent_posts_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Recent Posts", "crum" ),
						"base"        => "recent_posts",
						"icon"        => "recent_posts",
						"category"    => __( "Content", "crum" ),
						"description" => __( "Add block with several recent posts", "crum" ),
						"params"      => array(
							array(
								"type"        => "dropdown",
								"heading"     => __( "Select style of displaying", "crum" ),
								"param_name"  => "displaying_type",
								"admin_label" => true,
								"value"       => array(
									'1 Column'  => '1_column',
									'2 Columns' => '2_column',
								),
								"group"       => $group,
								"description" => __( "Select, how many columns you want to display", "crum" )
							),
							array(
								"type"        => "dropdown",
								"heading"     => __( "Which post display first?", "crum" ),
								"param_name"  => "feat_sticky",
								"value"       => array(
									"Latest post" => "featured",
									"Sticky post"   => "sticky",
								),
								"group"       => $group,
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => "Display big featured image on first post?",
								"value"       => array( "Yes, please" => "true" ),
								"param_name"  => "first_featured",
								"group"       => $group,
								"description" => ""
							),
							array(
								"type"        => "checkbox",
								"heading"     => __( "Show additional post info", "crum" ),
								"param_name"  => "show_dopinfo",
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
								"type"        => "dropdown",
								"param_name"  => "transient_id",
								"group"       => $group,
								"value"       => array($this->generate_id())
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
}
if ( class_exists( 'Crum_recent_posts' ) ) {
	$Crum_recent_posts = new Crum_recent_posts;
}