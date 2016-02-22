<?php
if ( ! class_exists( 'Crum_Team_Member' ) ) {
	class Crum_Team_Member {
		function __construct() {
			add_shortcode( 'team_member', array( &$this, 'crum_team_member_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_team_member_init' ) );
		}

        function team_hex2rgb( $hex, $opacity = 1 ) {
            $hex = str_replace( "#", "", $hex );

            if ( strlen( $hex ) == 3 ) {
                $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
                $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
                $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
            }
            else {
                $r = hexdec( substr( $hex, 0, 2 ) );
                $g = hexdec( substr( $hex, 2, 2 ) );
                $b = hexdec( substr( $hex, 4, 2 ) );
            }
            $rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';

            //return implode(",", $rgb); // returns the rgb values separated by commas
            return $rgba; // returns an array with the rgb values
        }

        function adjustBrightness($hex, $steps) {
            // Steps should be between -255 and 255. Negative = darker, positive = lighter
            $steps = max(-255, min(255, $steps));

            // Format the hex color string
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
            }

            // Get decimal values
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));

            // Adjust number of steps and keep it inside 0 to 255
            $r = max(0,min(255,$r + $steps));
            $g = max(0,min(255,$g + $steps));
            $b = max(0,min(255,$b + $steps));

            $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
            $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
            $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

            return '#'.$r_hex.$g_hex.$b_hex;
        }

		function crum_team_member_form( $atts, $content = null ) {
			$team_member_style = $description = $name = $job_position = $image_url = $link = $overlay_color = '';
			$fb_link = $gp_link = $tw_link = $in_link = $vi_link = $lf_link = $vk_link = $yt_link = $de_link = $li_link = $pi_link = $pt_link = $wp_link = $db_link = $fli_link = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						"team_member_style" => 'item-round',
						"description"  => '',
						'name'         => 'Name',
						'job_position' => '',
						'image_url'    => '',
						'link'         => '',
                        'overlay_color' => '',
						'fb_link'      => '',
						'gp_link'      => '',
						'tw_link'      => '',
						'in_link'      => '',
						'vi_link'      => '',
						'lf_link'      => '',
						'vk_link'      => '',
						'yt_link'      => '',
						'de_link'      => '',
						'li_link'      => '',
						'pi_link'      => '',
						'pt_link'      => '',
						'wp_link'      => '',
						'db_link'      => '',
						'fli_link'     => '',
						'module_animation' => '',
					), $atts
				)
			);

			$html = null;

			$description_template = '<p class="description">' . $description . '</p>';

			$contacts_template = '';
			$contacts_template .= '<ul class="worker-contacts">';
			$social_networks = array(
				"fb"  => "Facebook",
				"gp"  => "Google +",
				"tw"  => "Twitter",
				"in"  => "Instagram",
				"vi"  => "Vimeo",
				"lf"  => "Last FM",
				"vk"  => "Vkontakte",
				"yt"  => "YouTube",
				"de"  => "Devianart",
				"li"  => "LinkedIN",
				"pt"  => "Pinterest",
				"wp"  => "Wordpress",
				"db"  => "Dribbble",
				"fli" => "Flickr",
			);
			$social_icons    = array(
				"fb"  => "soc-facebook",
				"gp"  => "soc-google",
				"tw"  => "soc-twitter",
				"in"  => "soc-instagram",
				"vi"  => "soc-vimeo",
				"lf"  => "soc-lastfm",
				"vk"  => "soc-vkontakte",
				"yt"  => "soc-youtube",
				"de"  => "soc-deviantart",
				"li"  => "soc-linkedin",
				"pt"  => "soc-pinterest",
				"wp"  => "soc-wordpress",
				"db"  => "soc-dribbble",
				"fli" => "soc-flickr",
			);
			foreach ( $social_networks as $short => $original ) {

				$soc_link = ${$short . '_link'};
				$icon     = $social_icons[$short];
				if ( ! empty( $soc_link ) && $soc_link != 'none' ) {
					$contacts_template .= '<li><a href="' . $soc_link . '" class="si ' . $icon . '" target="_blank title="' . $original . '"></a></li>';
				}
			}

			$contacts_template .= '</ul>';

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$html .= '<div class="worker-item clearfix '.$team_member_style.' '.$animate.'" '.$animation_data.'>';

			if ($team_member_style == 'item-square'){

                if (isset($overlay_color) && !($overlay_color == '')){

                    $overlay_style = 'style="background:none repeat scroll 0 0 '.$this->team_hex2rgb($overlay_color,'0.7').'"';

                    $position_style = 'style="color:'.$this->adjustBrightness($overlay_color,-100).'"';

                    $contacts_style = 'style="background-color:'.$this->adjustBrightness($overlay_color,-100).'"';

                }else{
                    $overlay_style = '';

                    $position_style = '';

                    $contacts_style = '';
                }
                //;

				$html .= '<div class="photo entry-thumb">';

				if ( ! empty( $image_url ) ) {
					$image_url = crum_int_image( $image_url, '500', '500', true );

					$html .= '<img alt="' . $name . '" src="' . $image_url . '" title="' . $name . '" />';
				} else {
					$html .= '<img alt="' . $name . '" src="' . get_template_directory_uri() . 'library/images/team-member-default.jpg" title="' . $name . '" />';
				}

				$html .= '<div class="overlay" '.$overlay_style.'></div>';

				$html .= '<div class="worker-dopinfo">';

				$html .= '<div class="member-name-valign">';

				$html .= '<h3><a href="'.$link.'">'.$name.'</a></h3>';

				$html .= '<p class="position" ><a href="'.$link.'" '.$position_style.'>'.$job_position.'</a></p>';

				$html .= '</div>'; // member-name-valign

				$html .= '</div>'; // end worker-dopinfo

                $html .= '<div class="description-wrapper">';

                $html .= '<div class="description-valign">';

                $html .= $description_template;

                $html .= '<ul class="worker-contacts">';
                $social_networks = array(
                    "fb"  => "Facebook",
                    "gp"  => "Google +",
                    "tw"  => "Twitter",
                    "in"  => "Instagram",
                    "vi"  => "Vimeo",
                    "lf"  => "Last FM",
                    "vk"  => "Vkontakte",
                    "yt"  => "YouTube",
                    "de"  => "Devianart",
                    "li"  => "LinkedIN",
                    "pt"  => "Pinterest",
                    "wp"  => "Wordpress",
                    "db"  => "Dribbble",
                    "fli" => "Flickr",
                );
                $social_icons    = array(
                    "fb"  => "soc-facebook",
                    "gp"  => "soc-google",
                    "tw"  => "soc-twitter",
                    "in"  => "soc-instagram",
                    "vi"  => "soc-vimeo",
                    "lf"  => "soc-lastfm",
                    "vk"  => "soc-vkontakte",
                    "yt"  => "soc-youtube",
                    "de"  => "soc-deviantart",
                    "li"  => "soc-linkedin",
                    "pt"  => "soc-pinterest",
                    "wp"  => "soc-wordpress",
                    "db"  => "soc-dribbble",
                    "fli" => "soc-flickr",
                );
                foreach ( $social_networks as $short => $original ) {

                    $soc_link = ${$short . '_link'};
                    $icon     = $social_icons[$short];
                    if ( ! empty( $soc_link ) && $soc_link != 'none' ) {
                        $html .= '<li><a href="' . $soc_link . '" class="si ' . $icon . '" target="_blank title="' . $original . '"></a></li>';
                    }
                }

                $html .= '</ul>';

                $html .= '</div>'; // end description-valign

                $html .= '</div>'; // end description-wrapper

               $html .= '</div>'; //end photo entry-thumb

			}elseif($team_member_style == 'item-round'){

				$html .= '<div class="photo entry-thumb">';

                $html .= '<div class="links">';

					$html .= '<a href="'.$link.'"><i class="embrace-forward2"></i></a>';

				$html .= '</div>';

				$html .= '<div class="overlay"></div>';

				if ( ! empty( $image_url ) ) {
					$image_url = crum_int_image( $image_url, '500', '500', true );

					$html .= '<img alt="' . $name . '" src="' . $image_url . '" title="' . $name . '" />';
				} else {
					$html .= '<img alt="' . $name . '" src="' . get_template_directory_uri() . 'library/images/team-member-default.jpg" title="' . $name . '" />';
				}

				$html .= '</div>'; //end photo entry-thumb

				$html .= '<div class="worker-dopinfo">';

				$html .= '<h3>'.$name.'</h3>';

				$html .= '<p class="position">'.$job_position.'</p>';

				$html .= $description_template;

				$html .= '</div>'; // end worker-dopinfo

				$html .= $contacts_template;

			}else{

				$html .= '<div class="photo entry-thumb">';

				$html .= '<div class="overlay"></div>';

				if ( ! empty( $image_url ) ) {
					$image_url = crum_int_image( $image_url, '500', '500', true );

					$html .= '<img alt="' . $name . '" src="' . $image_url . '" title="' . $name . '" />';
				} else {
					$html .= '<img alt="' . $name . '" src="' . get_template_directory_uri() . 'library/images/team-member-default.jpg" title="' . $name . '" />';
				}

				$html .= '</div>'; //end photo entry-thumb

				$html .= '<div class="worker-dopinfo">';

				$html .= '<h3><a href="'.$link.'">'.$name.'</a></h3>';

				$html .= '<p class="position"><a href="'.$link.'">'.$job_position.'</a></p>';

				$html .= $contacts_template;

				$html .= $description_template;

				$html .= '</div>'; // end worker-dopinfo

			}

			$html .= '</div>'; //end worker-item

			return $html;
		}

		function crum_team_member_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Team Member", "crum" ),
						"base"        => "team_member",
						"icon"        => "icon-wpb-team-member",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( 'Info about your team', 'crum' ),
						"params"      => array(
							array(
								"type" => "dropdown",
								"heading" => __("Select style of block", "smile"),
								"param_name" => "team_member_style",
								"value" => array(
									__("Round photo","crum") => "item-round",
									__("Square photo","crum") => "item-square",
									__("Square photo on left","crum") => "item-square-left",
								),
								"group"       => $group,
								//"description" => __("Select style for countdown timer.", "smile"),
							),
                            array(
                                "type" => "colorpicker",
                                "class" => "",
                                "heading" => __("Overlay color", "crum"),
                                "param_name" => "overlay_color",
                                "value" => "",
                                "group"       => $group,
                                "description" => __("Give it a nice paint!", "crum"),
                                "dependency" => Array("element" => "team_member_style","value" => array("item-square")),
                            ),
							array(
								"type"        => "attach_image",
								"heading"     => __( "Image", "crum" ),
								"param_name"  => "image_url",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Select image from media library.", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Name", "crum" ),
								"param_name"  => "name",
								"admin_label" => true,
								"group"       => $group,
								"description" => __( "Please enter the name of your team member", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Job Position", "crum" ),
								"param_name"  => "job_position",
								"admin_label" => true,
								"group"       => $group,
								"description" => __( "Please enter the job position for your team member", "crum" )
							),
							array(
								"type"        => "textarea",
								"heading"     => __( "Description", "crum" ),
								"param_name"  => "description",
								"group"       => $group,
								"description" => __( "The main text portion of your team member", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Custom link", "crum" ),
								"param_name"  => "link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Twitter", "crum" ),
								"param_name"  => "tw_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Facebook", "crum" ),
								"param_name"  => "fb_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Google +", "crum" ),
								"param_name"  => "gp_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Instagram", "crum" ),
								"param_name"  => "in_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Vimeo", "crum" ),
								"param_name"  => "vi_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Last FM", "crum" ),
								"param_name"  => "lf_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Vkontakte", "crum" ),
								"param_name"  => "vk_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "YouTube", "crum" ),
								"param_name"  => "yt_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Devianart", "crum" ),
								"param_name"  => "de_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "LinkedIN", "crum" ),
								"param_name"  => "li_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Picasa", "crum" ),
								"param_name"  => "pi_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Pinterest", "crum" ),
								"param_name"  => "pt_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Wordpress", "crum" ),
								"param_name"  => "wp_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Dropbox", "crum" ),
								"param_name"  => "db_link",
								"group"       => $group,
								"admin_label" => true
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Flickr", "crum" ),
								"param_name"  => "fli_link",
								"group"       => $group,
								"admin_label" => true
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
	}

	new Crum_Team_Member;
}