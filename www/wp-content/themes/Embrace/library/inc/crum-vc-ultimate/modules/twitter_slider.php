<?php
if ( ! class_exists( 'Crum_twitter_slider' ) ) {
	class Crum_twitter_slider {
		function  __construct() {
			add_shortcode( 'crum_twitter_slider', array( $this, 'crum_twitter_slider_form' ) );
			add_action( 'admin_init', array( $this, 'crum_twitter_slider_init' ) );

			//Cache deleting
			add_action( 'save_post', array( &$this, 'crum_delete_sldr_cache' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_sldr_cache' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_sldr_cache' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'tw_sldr_id' );

			return $uniue_id;
		}

		function crum_delete_sldr_cache() {
			delete_option( 'tw_sldr_tweets_array' );
		}

		function crum_twitter_slider_form( $atts, $content = null ) {
			require_once locate_template( '/library/lib/twitteroauth.php' );

			global $crum_theme_option;

			$tw_sldr_username = $tw_sldr_count = $tw_sldr_cache_time = $slideshow = $transient_id = $link_icon_color = $module_animation = '';
			$slides_to_show   = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = $module_style ='';

			$tw_sldr_consumer_key = $crum_theme_option['tw_consumer_key'];
			$tw_sldr_consumer_secret = $crum_theme_option['tw_consumer_secret'];
			$tw_sldr_access_token = $crum_theme_option['tw_access_token'];
			$tw_sldr_access_token_secret = $crum_theme_option['tw_access_token_secret'];

			extract(
				shortcode_atts(
					array(
						'tw_sldr_username'   => '',
						'tw_sldr_count'      => '10',
						'link_icon_color'    => '',
						'tw_sldr_cache_time' => '1',
                        'module_style' => '',
						'slideshow'          => '',
						'transient_id'       => '',
						'module_animation'   => '',
						'slides_to_show'     => '1',
						'slides_to_scroll'   => '1',
						'scroll_speed'       => '400',
						'advanced_opts'      => '',
						'autoplay_speed'     => '',
					), $atts
				)
			);

			//check settings and die if not set
			if ( empty( $tw_sldr_consumer_key ) || empty( $tw_sldr_consumer_secret ) || empty( $tw_sldr_access_token ) || empty( $tw_sldr_access_token_secret ) || empty( $tw_sldr_cache_time ) || empty( $tw_sldr_username ) ) {
				echo '<strong>Please fill all widget settings!</strong>';

				return;
			}

			$tw_sldr_last_cache_time = get_option( 'tw_sldr_last_cache_time' . $transient_id . '' );
			$diff                    = time() - $tw_sldr_last_cache_time;
			$crt                     = $tw_sldr_cache_time;

			if ( $diff >= $crt || empty( $tw_sldr_last_cache_time ) ) {

				$connection = $this->getTwitterConnection( $tw_sldr_consumer_key, $tw_sldr_consumer_secret, $tw_sldr_access_token, $tw_sldr_access_token_secret );
				$tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $tw_sldr_username . "&count=" . $tw_sldr_count . "" ) or die( 'Couldn\'t retrieve tweets! Wrong username?' );

				if ( ! empty( $tweets->errors ) ) {
					if ( $tweets->errors[0]->message == 'Invalid or expired token' ) {
						echo '<strong>' . $tweets->errors[0]->message . '!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!';
					} else {
						echo '<strong>' . $tweets->errors[0]->message . '</strong>';
					}

					return;
				}

				for ( $i = 0; $i <= count( $tweets ); $i ++ ) {
					if ( ! empty( $tweets[$i] ) ) {
						$tweets_array[$i]['user']       = $tweets[$i]->user;
						$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
						$tweets_array[$i]['text']       = $tweets[$i]->text;
						$tweets_array[$i]['status_id']  = $tweets[$i]->id_str;
					}
				}

				update_option( 'tw_sldr_tweets_array' . $transient_id, serialize( $tweets_array ) );
				update_option( 'tw_sldr_last_cache_time' . $transient_id . '', time() );
			}

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
            if ( in_array( "arrows", $advanced_opts ) ) {
				$arrows = 'true';
			}

			$output = '';

			$tw_sldr_tweets_array = maybe_unserialize( get_option( 'tw_sldr_tweets_array' . $transient_id . '' ) );

			if ( ! empty( $tw_sldr_tweets_array ) ) {

				if (isset($link_icon_color) && !($link_icon_color == '')){
					$styled_color = 'style="color: '.$link_icon_color.'"';
				}else{
					$styled_color = '';
				}

                $screen_name = $tw_sldr_tweets_array[0]['user']->name;


				$animate = $animation_data = '';

				if ( ! ($module_animation == '')){
					$animate = ' cr-animate-gen';
					$animation_data = 'data-animate-type = "'.$module_animation.'" ';
				}

				ob_start();?>

			<div id="slider-<?php echo $transient_id ?>" class="sliding-content-slider cursor-move latest_tweets_slider <?php echo $module_style; ?> <?php echo $animate;?>" <?php echo $animation_data;?>>

                <i class=" soc-icon soc-twitter"></i>
                <div class="username">
                <?php echo'<a href="https://twitter.com/'.$tw_sldr_username.'" class="name">' . $screen_name . ' </a>'; ?>

                <a href="https://twitter.com/<?php echo $tw_sldr_username; ?>"
                   class="twitter-follow-button"
                   data-show-count="false"
                   data-lang="en"><?php _e('Follow me', 'crum'); ?></a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");</script>
                </div>

				<div id="slides-<?php echo $transient_id ?>">
					<?php
					foreach ( $tw_sldr_tweets_array as $single_tweet ) { ?>
						<div class="twitter-item">
							<?php echo $this->convert_twitter_links( $single_tweet['text'], $targetBlank = true, $linkMaxLen = 250, $link_icon_color);?>
							<!--<div class="time">
							<?php echo $this->twitter_relative_time( $single_tweet['created_at'] );?>
							</div> -->
						</div>
					<?php }
					?>

				</div>
			</div>
				<script type="text/javascript">
					(function ($) {
						$(document).ready(function () {

							$('#<?php echo 'slides-'.$transient_id.''; ?>').slick({
								infinite      : <?php echo $infinite; ?>,
								slidesToShow  : <?php echo $slides_to_show; ?>,
								slidesToScroll: <?php echo $slides_to_scroll; ?>,
								arrows        : <?php echo $arrows; ?>,
								dots          : <?php echo $dots; ?>,
								speed         : <?php echo $scroll_speed; ?>,
								autoplay      : <?php echo $autoplay; ?>,
								autoplaySpeed : <?php echo $autoplay_speed.'000'; ?>,
								responsive    : [
									{
										breakpoint: 1280,
										settings  : {
											slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>
										}
									},
									{
										breakpoint: 1024,
										settings  : {
											slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>
										}
									},
									{
										breakpoint: 600,
										settings  : {
											slidesToShow: <?php echo ($slides_to_show > 1) ? $slides_to_show - 1 : $slides_to_show ; ?>
										}
									},
									{
										breakpoint: 480,
										settings  : {
											slidesToShow  : 1,
											slidesToScroll: 1
										}
									}
								]
							});
						});
						
					})(jQuery);
				</script>

<?php

			}


            $output .= ob_get_clean();

			return $output;
		}

		function getTwitterConnection( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
			$connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );

			return $connection;
		}

		function convert_twitter_links( $status, $targetBlank = true, $linkMaxLen = 250, $link_color = '' ) {

			// the target
			$target = $targetBlank ? " target=\"_blank\" " : "";
			if ( isset($link_color) && !($link_color == '') ) {
				$color_dec   = ultimate_hex2rgb( $link_color );
				$color_style = " style=\"color: $color_dec \" ";
			} else {
				$color_style = '';
			}
			// convert link to url
			$status = preg_replace(
				"/((http:\/\/|https:\/\/)[^ )
					]+)/e", "'<a href=\"$1\" title=\"$1\" $target $color_style>'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status
			);

			// convert @ to follow
			$status = preg_replace( "/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target $color_style>$1</a>", $status );

			// convert # to search
			$status = preg_replace( "/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target $color_style >$1</a>", $status );

			// return the status
			return $status;
		}

		function twitter_relative_time( $a ) {
			//get current timestampt
			$b = strtotime( "now" );
			//get timestamp when tweet created
			$c = strtotime( $a );
			//get difference
			$d = $b - $c;
			//calculate different time values
			$minute = 60;
			$hour   = $minute * 60;
			$day    = $hour * 24;
			$week   = $day * 7;

			if ( is_numeric( $d ) && $d > 0 ) {
				//if less then 3 seconds
				if ( $d < 3 ) {
					return "right now";
				}
				//if less then minute
				if ( $d < $minute ) {
					return floor( $d ) . " seconds ago";
				}
				//if less then 2 minutes
				if ( $d < $minute * 2 ) {
					return "about 1 minute ago";
				}
				//if less then hour
				if ( $d < $hour ) {
					return floor( $d / $minute ) . " minutes ago";
				}
				//if less then 2 hours
				if ( $d < $hour * 2 ) {
					return "about 1 hour ago";
				}
				//if less then day
				if ( $d < $day ) {
					return floor( $d / $hour ) . " hours ago";
				}
				//if more then day, but less then 2 days
				if ( $d > $day && $d < $day * 2 ) {
					return "yesterday";
				}
				//if less then year
				if ( $d < $day * 365 ) {
					return floor( $d / $day ) . " days ago";
				}

				//else return more than a year
				return "over a year ago";
			}
		}

		function crum_twitter_slider_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Twitter Slider", "crum" ),
						"base"        => "crum_twitter_slider",
						"icon"        => "crum_twitter_slider",
						"category"    => __( "Presentation", "crum" ),
						"description" => __( "Add slider with several tweets", "crum" ),
						"params"      => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Username", "crum" ),
								"param_name"  => "tw_sldr_username",
								"group"       => $group,
								"description" => __( "Enter Twitter username", "crum" ),
							),
							array(
								"type"        => "number",
								"heading"     => __( "Twits count", "crum" ),
								"param_name"  => "tw_sldr_count",
								"value"       => '10',
								"min"         => 0,
								"max"         => 500,
								"group"       => $group,
								"description" => __( "Select number of tweets to display", "crum" ),
							),
							array(
								"type"        => "number",
								"heading"     => __( "Cache time", "crum" ),
								"param_name"  => "tw_sldr_cache_time",
								"min"         => 0,
								"max"         => 100,
								"group"       => $group,
								"description" => __( "Select the cache lifetime in hours", "crum" ),
							),
                            array(
                                "type"        => "dropdown",
                                "class"       => "",
                                "heading"     => __( "Select Style", "crum" ),
                                "param_name"  => "module_style",
                                "value"       => array(
                                    __( "With icon", "crum" )       => "",
                                    __( "Without icon", "crum" )       => "no-icon",
                                ),
                                "description" => __( "Please select style of block", "crum" ),
                                "group"       => $group,
                            ),
							array(
								"type"        => "textfield",
								"param_name"  => "transient_id",
								"value"       => array( $this->generate_id() ),
								"group"       => $group,
								"description" => __('Make sure you Setup Twitter API OAuth settings under <a href="admin.php?page=theme_options&tab=3" target="_blank">Theme options</a>','crum'),
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

	new Crum_twitter_slider;
}