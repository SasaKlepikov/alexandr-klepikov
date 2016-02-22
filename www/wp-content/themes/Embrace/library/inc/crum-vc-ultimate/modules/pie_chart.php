<?php
if (!class_exists('Crumina_Pie_Chart')){

	class Crumina_Pie_Chart{

		function __construct(){
			add_action('admin_init',array(&$this, 'crum_pie_chart_init'));
			add_shortcode('crum_pie_chart',array(&$this, 'crum_pie_chart_form'));
		}

		function generate_id() {
			$uniue_id = uniqid( '_pie_chart_id_' );

			return $uniue_id;
		}

		function crum_pie_chart_init(){

			if (function_exists('vc_map')){

				vc_map(
					array(
						"name"                    => __( "Pie Chart", "crum" ),
						"base"                    => "crum_pie_chart",
						"class"                   => "",
						"icon"                    => "icon-wpb-vc_pie",
						"category"                => __( "Presentation", "crum" ),
						"description"             => __("Animated pie chart","crum"),
						"params"                  => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Title", "crum" ),
								"param_name"  => "pie_chart_title",
								"description" => __( "The Title text", "crum" ),
							),
							array(
								"type"        => "number",
								'heading' => __( 'Pie size', 'crum' ),
								'param_name' => 'pie_chart_size',
								'description' => __( 'Set size of the circe in pixels.', 'crum' ),
								"value"       => "100",
								"min"         => 0,
								"max"         => 1000,
							),
							array(
								"type"        => "number",
								'heading' => __( 'Pie value', 'crum' ),
								'param_name' => 'pie_chart_value',
								'description' => __( 'Input graph value here. Choose range between 0 and 100.', 'crum' ),
								"value"       => "50",
								"min"         => 0,
								"max"         => 100,
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select label style", "crum"),
								"param_name" => "pie_chart_label_style",
								"value" => array(
									"Counter with units" => "counter",
									"Icon" => "icon",
								),
							),
							array(
								"type"        => "number",
								'heading' => __( 'Pie label value', 'crum' ),
								'param_name' => 'pie_chart_label_value',
								'description' => __( 'Input integer value for label. If empty "Pie value" will be used.', 'crum' ),
								"value"       => "",
								"min"         => -1000000,
								"max"         => 1000000,
								"dependency"  => Array( "element" => "pie_chart_label_style", "value" => array( 'counter' ) ),
							),
							array(
								'type' => 'textfield',
								'heading' => __( 'Units', 'crum' ),
								'param_name' => 'pie_chart_units',
								'description' => __( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'crum' ),
								"dependency"  => Array( "element" => "pie_chart_label_style", "value" => array( 'counter' ) ),
							),
							array(
								"type"        => "icon_manager",
								"class"       => "",
								"heading"     => __( "Select Icon", "crum" ),
								"param_name"  => "pie_chart_icon",
								"admin_label" => true,
								"value"       => "",
								"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Crum_Icon_Manager' target='_blank'>add new here</a>.", "crum" ),
								"dependency"  => Array( "element" => "pie_chart_label_style", "value" => array( 'icon' ) ),
							),
							array(
								"type" => "dropdown",
								"heading" => __("Chart color style", "crum"),
								"param_name" => "pie_chart_color_style",
								"value" => array(
									"Color" => "color",
									"Gradient" => "gradient",
								),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Line color", "crum"),
								"param_name" => "pie_chart_line_color",
								"description" => __("Give it a nice paint!", "crum"),
								"dependency" => Array("element" => "pie_chart_color_style","value" => array("color")),
								"value" => "#000",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Gradient color 1", "crum"),
								"param_name" => "pie_chart_gradient_color_1",
								"description" => __("Give it a nice paint!", "crum"),
								"value" => "#f00",
								"dependency" => Array("element" => "pie_chart_color_style","value" => array("gradient")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Gradient color 2", "crum"),
								"param_name" => "pie_chart_gradient_color_2",
								"description" => __("Give it a nice paint!", "crum"),
								"value" => "#FF9900",
								"dependency" => Array("element" => "pie_chart_color_style","value" => array("gradient")),
							),
							array(
								"type"        => "dropdown",
								"param_name"  => "pie_chart_id",
								"value"       => array($this->generate_id())
							),
						),
					)
				);

			}

		}

		function crum_pie_chart_form( $atts, $content = null ){

			wp_enqueue_script( 'jquery.countdown', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/circle-progress.js' );

			$pie_chart_title = $pie_chart_size = $pie_chart_value = $pie_chart_label_style = $pie_chart_label_value = $pie_chart_units = $pie_chart_icon = $pie_chart_color_style = $pie_chart_line_color = $pie_chart_gradient_color_1 = $pie_chart_gradient_color_2 = $pie_chart_id = '';

			extract(
				shortcode_atts(
					array(
						'pie_chart_title' => '',
						'pie_chart_size' => '',
						'pie_chart_value' => '',
						'pie_chart_label_style' => 'counter',
						'pie_chart_label_value' => '',
						'pie_chart_units' => '',
						'pie_chart_icon' => '',
						'pie_chart_color_style' => 'color',
						'pie_chart_line_color' => '',
						'pie_chart_gradient_color_1' => '',
						'pie_chart_gradient_color_2' => '',
						'pie_chart_id' => '',
					),$atts
				)
			);

			if ($pie_chart_label_value == ''){
				$pie_chart_label_value = $pie_chart_value;
			}

			if ($pie_chart_size == ''){
				$pie_chart_size = 100;
			}

			$output = '';

			$output .= '<div id="pie-chart'.$pie_chart_id.'" class="pie-chart">';

			if ( $pie_chart_label_style == 'counter' ) {
				$output .= '<span class="pie-chart-value-general pie-chart-value' . $pie_chart_id . '">';
				$output .= '</span>';//pie-chart-value
			} else {
				$output .= '<i class="'.$pie_chart_icon.'"></i>';
			}

			$output .= '</div>';//pie-chart

			$output .= '<span class="vc-pie-chart-title">';
			$output .= $pie_chart_title;
			$output .= '</span>';//vc-pie-chart-title

			ob_start();?>






			<script>


				jQuery(function () {

					if (typeof jQuery.fn.waypoint !== 'undefined') {

						var current_cart = jQuery("#pie-chart<?php echo $pie_chart_id; ?>");

						current_cart.waypoint(function () {

							current_cart.circleProgress({
								value: 0.<?php echo $pie_chart_value;?>,
								size: <?php echo $pie_chart_size; ?>,
								startAngle: -Math.PI / 4 * 2,
								fill: {
									<?php if ($pie_chart_color_style == 'color'){?>
									color: "<?php echo $pie_chart_line_color; ?>",
									<?php }else{ ?>
									gradient: ["<?php echo $pie_chart_gradient_color_1; ?>", "<?php echo $pie_chart_gradient_color_2; ?>"]
									<?php }?>
								},
								emptyFill: 'rgb(255,255,255)'
							}).on('circle-animation-progress', function (event, progress) {

								current_cart.find('.pie-chart-value<?php echo $pie_chart_id;?>').html(parseInt(<?php echo $pie_chart_label_value;?> * progress) + '<span><?php echo $pie_chart_units;?></span>'
								)
							}).on('circle-animation-end', function (event) {

								current_cart.waypoint('destroy');

							})

						},{
							offset:'85%'
						})

					}
					//TODO: move js code from inline to reactor php

				});


			</script>

			<?php $output .= ob_get_clean();

			return $output;

		}

	}

}

if (class_exists('Crumina_Pie_Chart')){

	$Crumina_Pie_Chart = new Crumina_Pie_Chart;

}