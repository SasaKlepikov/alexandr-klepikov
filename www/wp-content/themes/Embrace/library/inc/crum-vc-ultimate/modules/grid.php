<?php
if ( ! class_exists( 'Crum_Grid_Display' ) ) {
	class Crum_Grid_Display {
		function __construct() {
			add_shortcode( 'grid', array( &$this, 'crum_grid' ) );
			add_action( 'admin_init', array( &$this, 'crum_grid_init' ) );
		}

		function crum_grid( $atts, $content = null ) {
			$columns = $grid_lines = $module_animation = '';
			extract(
				shortcode_atts(
					array(
                        "grid_lines" => "false",
						"columns"           => '2',
						'module_animation' => '',
					), $atts
				)
			);

			$opening      = null;
			$closing      = null;
			$column_class = null;

			switch ( $columns ) {
				case '2' :
					$column_class = 'two-cols';
					break;
				case '3' :
					$column_class = 'three-cols';
					break;
				case '4' :
					$column_class = 'four-cols';
					break;
				case '5' :
					$column_class = 'five-cols';
					break;
				case '6' :
					$column_class = 'six-cols';
					break;
			}


            ( $grid_lines == "true" ) ? $grid_class = 'bordered': $grid_class = '';

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".grid > div" data-animate-type = "'.$module_animation.'" ';
			}
				$opening .= '<div class="grid-container '.$animate.'" '.$animation_data.'>';
				$opening .= '<div class="grid '.$grid_class.' ' . $column_class . '">';
				$closing .= '</div></div>';

			return $opening . do_shortcode( $content ) . $closing;
		}
		function crum_grid_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"                    => __( "Grid", "crum" ),
						"base"                    => "grid",
						"as_parent"               => array( 'only' => 'client, team_member, just_icon, qr_code, vc_single_image' ),
						"show_settings_on_create" => true,
						"icon"                    => "icon-grid",
						"category"                => __( 'Presentation', 'crum' ),
						"description"             => __( "Grid with clients, team members etc.", "crum" ),
						"params"                  => array(
							array(
								"type"        => "dropdown",
								"heading"     => __( 'Columns', 'crum' ),
								"param_name"  => "columns",
								"value"       => array(
									"Two"   => "2",
									"Three" => "3",
									"Four"  => "4",
									"Five"  => "5",
									"Six"   => "6"
								),
								"group"       => $group,
								"description" => __( 'Please select how many columns you would like..', 'crum' )
							),
                            array(
                                "type"        => "checkbox",
                                "class"       => "",
                                "heading"     => __('Show grid lines?','crum'),
                                "value"       => array( __('Yes, please','crum') => "true" ),
                                "param_name"  => "grid_lines",
                                "group"       => $group,
                                "description" => ""
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
                        "js_view" => 'VcColumnView'
					)
				);
			}
		}
	}

    new Crum_Grid_Display;

    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Grid extends WPBakeryShortCodesContainer {
        }
    }


}