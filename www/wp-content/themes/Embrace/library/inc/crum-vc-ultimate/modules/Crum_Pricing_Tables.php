<?php
if ( ! class_exists( 'Crum_Pricing_Tables' ) ) {
	class Crum_Pricing_Tables {
		function __construct() {
			add_shortcode( 'pricing_table', array( &$this, 'crum_pricing_tables_form' ) );
			add_shortcode( 'pricing_column', array( &$this, 'crum_pricing_table_column' ) );
			add_action( 'admin_init', array( &$this, 'crum_pricing_tables_init' ) );
		}

		function crum_pricing_tables_form( $atts, $content = null ) {
			$el_class = $module_animation = '';

			extract( shortcode_atts( array( "el_class" => '', "module_animation" => "" ), $atts ) );

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".pricing-column" data-animate-type = "'.$module_animation.'" ';
			}

			$columns    = explode( "[pricing_column", $content );
			$columnsNum = count( $columns );
			$columnsNum = $columnsNum - 1;

			switch ( $columnsNum ) {
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
			}

			return '<div class="pricing-table ' . $column_class . ' ' . $el_class . ' '.$animate.'" '.$animation_data.'>' . do_shortcode( $content ) . '</div>';
		}

		function crum_pricing_table_column($atts, $content = null) {
			$title = $highlight = $highlight_reason = $text = $link = $price = $currency_symbol = $interval = '';
			extract( shortcode_atts( array( "title"            => 'Column title',
											"highlight"        => 'false',
											"highlight_reason" => 'Most Popular',
											'text'             => 'Submit',
											'link'             => '#',
											"price"            => "99",
											"currency_symbol"  => '$',
											"interval"         => 'Per Month'
					), $atts
				)
			);

			$highlight_class        = null;
			$hightlight_reason_html = null;

			if ( $highlight == 'true' ) {
				$highlight_class        = 'highlight ';
				$hightlight_reason_html = '<span class="highlight-reason">' . $highlight_reason . '</span>';
			}

            $link = vc_build_link($link);
            if(isset($link['target'])){
                $target = 'target="'.$link['target'].'"';
            }

			return '<div class="pricing-column ' . $highlight_class . '">

  			<div class="pricing-title"><h3>' . $title . '</h3>' . $hightlight_reason_html . '</div>
            <div class="pricing-column-content">
				<span class="currency">' . $currency_symbol . '</span><span class="price">' . $price . '</span>
				<span class="interval">' . $interval . '</span><span class="product-description">' . do_shortcode( $content ) . '</span>
				<div class="cta-button"><a class="button" href="' . $link['url'] . '" '.$target.'>' . $text . '</a></div>
				</div></div>';
		}

		function crum_pricing_tables_init() {
			$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;
			if ( function_exists( 'vc_map' ) ) {
				/* pricing table */

				$group = __("Main Options", "crum");

				$tab_id_1 = time() . '-1-' . rand( 0, 100 );
				$tab_id_2 = time() . '-2-' . rand( 0, 100 );
				vc_map(
					array(
						"name"                    => __( "Pricing Table", "crum" ),
						"base"                    => "pricing_table",
						"show_settings_on_create" => false,
						"as_parent"               => array( 'only' => 'pricing_column' ),
						"icon"                    => "icon-wpb-pricing-table",
						"category"                => __( 'Presentation', 'crum' ),
						"description"             => __( 'Stylish pricing tables', 'crum' ),
						"params"                  => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Extra class name", "crum" ),
								"param_name"  => "el_class",
								"group"       => $group,
								"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "crum" )
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
						"custom_markup"           => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
					,
						'default_content'         => '
  [pricing_column title="' . __( 'Column', 'crum' ) . '" id="' . $tab_id_1 . '"]  [/pricing_column]
  [pricing_column title="' . __( 'Column', 'crum' ) . '" id="' . $tab_id_2 . '"]  [/pricing_column]
  ',
						"js_view"                 => 'VcColumnView'
					)
				);
				//pricing column
				vc_map(
					array(
						"name"            => __( "Pricing Column", "crum" ),
						"base"            => "pricing_column",
						"as_child"        => array( 'only' => 'pricing_table' ),
						"content_element" => true,
						"params"          => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Title", "crum" ),
								"param_name"  => "title",
								"admin_label" => true,
								"description" => __( "Please enter a title for your pricing column", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Price", "crum" ),
								"param_name"  => "price",
								"description" => __( "Enter the price for your column", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Currency Symbol", "crum" ),
								"param_name"  => "currency_symbol",
								"description" => __( "Enter the currency symbol that will display for your price", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Interval", "crum" ),
								"param_name"  => "interval",
								"description" => __( "Enter the interval for your pricing e.g. \"Per Month\" or \"Per Year\" ", "crum" )
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => "Highlight Column?",
								"value"       => array( "Yes, please" => "true" ),
								"param_name"  => "highlight",
								"description" => ""
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Highlight Reason", "crum" ),
								"param_name"  => "highlight_reason",
								"description" => __( "Enter the reason for the column being highlighted e.g. \"Most Popular\"", "crum" ),
								"dependency"  => Array( 'element' => "highlight", 'not_empty' => true )
							),
							array(
								"type"        => "textarea_html",
								"heading"     => __( "Pricing Table Content", "crum" ),
								"param_name"  => "content",
								"admin_label" => true,
								"description" => __( "Please use the Unordered List button <img src='" . get_template_directory_uri() . "/crumina/assets/img/icons/ul.png' alt='unordered list' /> on the editor to create the points of your pricing column. <br/> The demo also makes use of the button shortcode underneath the list for a call to action. ", "crum" )
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Button text", "crum" ),
								"param_name"  => "text",
								"description" => __( "Enter text for call to action button", "crum" )
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Button link ","crum"),
								"param_name" => "link",
								"value" => "",
								"description" => __("You can link or remove the existing link on the button from here.","crum"),
							),
						),
						'js_view'         => ( $vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35' )
					)
				);
			}
		}
	}

	new Crum_Pricing_Tables;
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Pricing_Table extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Pricing_Column extends WPBakeryShortCode {

		public function customAdminBlockParams() {
			return ' id="tab-' . $this->atts['id'] . '"';
		}
	}
}