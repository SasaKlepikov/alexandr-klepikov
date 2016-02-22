<?php
/*
* Add-on Name: CountDown for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('Ultimate_CountDown'))
{
	class Ultimate_CountDown
	{
		function __construct()
		{
			add_action('admin_init',array($this,'countdown_init'));
			add_shortcode('ult_countdown',array($this,'countdown_shortcode'));
			add_action('admin_enqueue_scripts',array($this,'admin_scripts'));
		}
		function admin_scripts() {
			wp_enqueue_script( 'jquery.datetimep', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/admin/js/bootstrap-datetimepicker.min.js', '1.0', array( 'jQuery' ), true );
			wp_enqueue_style( 'colorpicker.style', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/admin/css/bootstrap-datetimepicker.min.css' );
		}
		function countdown_init()
		{
			if(function_exists('vc_map'))
			{
				vc_map(
					array(
						"name" => __("Countdown", 'crum'),
						"base" => "ult_countdown",
						"class" => "vc_countdown",
						"icon" => "vc_countdown",
						"category" => __("Ultimate VC Addons","crum"),
						"description" => __("Countdown Timer.","crum"),
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Countdown Timer Style", "crum"),
								"param_name" => "count_style",
								"value" => array(
									__("Style 1","crum") => "crum_cd_1",
									__("Style 2","crum") => "crum_cd_2",
									__("Style 3","crum") => "crum_cd_3",
									__("Style 4","crum") => "crum_cd_4",
									__("Style 5","crum") => "crum_cd_5",
									__("Style 6","crum") => "crum_cd_6",
									__("Style 7","crum") => "crum_cd_7",
									__("Style 8","crum") => "crum_cd_8",
								),
								"group" => "General Settings",
								//"description" => __("Select style for countdown timer.", "crum"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Countdown Timer Text placement", "crum"),
								"param_name" => "count_text_placement",
								"value" => array(
									__("Text below digits","crum") => "ult-cd-s1",
									__("Text over digits","crum") => "ult-cd-s2",
								),
								"group" => "General Settings",
								//"description" => __("Select style for countdown timer.", "crum"),
							),
							array(
								"type" => "datetimepicker",
								"class" => "",
								"heading" => __("Target Time For Countdown", "crum"),
								"param_name" => "datetime",
								"value" => "",
								"description" => __("Date and time format (yyyy/mm/dd hh:mm:ss).", "crum"),
								"group" => "General Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Countdown Timer Depends on", "crum"),
								"param_name" => "ult_tz",
								"value" => array(
									__("WordPress Defined Timezone","crum") => "ult-wptz",
									__("User's System Timezone","crum") => "ult-usrtz",
								),
								//"description" => __("Select style for countdown timer.", "crum"),
								"group" => "General Settings",
							),
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Select Time Units To Display In Countdown Timer", "crum"),
								"param_name" => "countdown_opts",
								"value" => array(
									__("Years","crum") => "syear",
									__("Months","crum") => "smonth",
									__("Weeks","crum") => "sweek",
									__("Days","crum") => "sday",
									__("Hours","crum") => "shr",
									__("Minutes","crum") => "smin",
									__("Seconds","crum") => "ssec",
								),
								//"description" => __("Select options for the video.", "crum"),
								"group" => "General Settings",
							),
							/*

							*/
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "crum"),
								"param_name" => "el_class",
								"value" => "",
								"description" => __("Extra Class for the Wrapper.", "crum"),
								"group" => "General Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Day (Singular)", "crum"),
								"param_name" => "string_days",
								"value" => "Day",
								//"description" => __("Enter your string for day.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Days (Plural)", "crum"),
								"param_name" => "string_days2",
								"value" => "Days",
								//"description" => __("Enter your string for days.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Week (Singular)", "crum"),
								"param_name" => "string_weeks",
								"value" => "Week",
								//"description" => __("Enter your string for Week.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Weeks (Plural)", "crum"),
								"param_name" => "string_weeks2",
								"value" => "Weeks",
								//"description" => __("Enter your string for Weeks.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Month (Singular)", "crum"),
								"param_name" => "string_months",
								"value" => "Month",
								//"description" => __("Enter your string for Month.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Months (Plural)", "crum"),
								"param_name" => "string_months2",
								"value" => "Months",
								//"description" => __("Enter your string for Months.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Year (Singular)", "crum"),
								"param_name" => "string_years",
								"value" => "Year",
								//"description" => __("Enter your string for Year.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Years (Plural)", "crum"),
								"param_name" => "string_years2",
								"value" => "Years",
								//"description" => __("Enter your string for Years.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Hour (Singular)", "crum"),
								"param_name" => "string_hours",
								"value" => "Hour",
								//"description" => __("Enter your string for Hour.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Hours (Plural)", "crum"),
								"param_name" => "string_hours2",
								"value" => "Hours",
								//"description" => __("Enter your string for Hours.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Minute (Singular)", "crum"),
								"param_name" => "string_minutes",
								"value" => "Minute",
								//"description" => __("Enter your string for Minute.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Minutes (Plural)", "crum"),
								"param_name" => "string_minutes2",
								"value" => "Minutes",
								//"description" => __("Enter your string for Minutes.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Second (Singular)", "crum"),
								"param_name" => "string_seconds",
								"value" => "Second",
								//"description" => __("Enter your string for Second.", "crum"),
								"group" => "Strings Translation",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Seconds (Plural)", "crum"),
								"param_name" => "string_seconds2",
								"value" => "Seconds",
								//"description" => __("Enter your string for Seconds.", "crum"),
								"group" => "Strings Translation",
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
		// Shortcode handler function for  icon block
		function countdown_shortcode($atts)
		{
			wp_enqueue_script( 'jquery.timecircle', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/jquery.countdown_org.js' );
			wp_enqueue_script( 'jquery.countdown', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/count-timer.js' );
			wp_enqueue_style( 'crumVCmodules' );
			$count_style = $datetime = $ult_tz = $countdown_opts = $count_text_placement = '';
			$el_class = '';
			$string_days = $string_weeks = $string_months = $string_years = $string_hours = $string_minutes = $string_seconds = '';
			$string_days2 = $string_weeks2 = $string_months2 = $string_years2 = $string_hours2 = $string_minutes2 = $string_seconds2 = '';
			$module_animation = '';
			extract(shortcode_atts( array(
						'count_style'=>'crum_cd_1',
						'count_text_placement' => 'ult-cd-s1',
						'datetime'=>'',
						'ult_tz'=>'ult-wptz',
						'countdown_opts'=>'',
						'el_class'=>'',
						'string_days' => 'Day',
						'string_days2' => 'Days',
						'string_weeks' => 'Week',
						'string_weeks2' => 'Weeks',
						'string_months' => 'Month',
						'string_months2' => 'Months',
						'string_years' => 'Year',
						'string_years2' => 'Years',
						'string_hours' => 'Hour',
						'string_hours2' => 'Hours',
						'string_minutes' => 'Minute',
						'string_minutes2' => 'Minutes',
						'string_seconds' => 'Second',
						'string_seconds2' => 'Seconds',
						'module_animation' => '',
					),$atts));
			$count_frmt = $labels = '';
			$labels = $string_years2 .','.$string_months2.','.$string_weeks2.','.$string_days2.','.$string_hours2.','.$string_minutes2.','.$string_seconds2;
			$labels2 = $string_years .','.$string_months.','.$string_weeks.','.$string_days.','.$string_hours.','.$string_minutes.','.$string_seconds;
			$countdown_opt = explode(",",$countdown_opts);
			if(is_array($countdown_opt)){
				foreach($countdown_opt as $opt){
					if($opt == "syear") $count_frmt .= 'Y';
					if($opt == "smonth") $count_frmt .= 'O';
					if($opt == "sweek") $count_frmt .= 'W';
					if($opt == "sday") $count_frmt .= 'D';
					if($opt == "shr") $count_frmt .= 'H';
					if($opt == "smin") $count_frmt .= 'M';
					if($opt == "ssec") $count_frmt .= 'S';
				}
			}

			if($count_frmt=='') $count_frmt = 'DHMS';

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output = '<div class="ult_countdown '.$count_style.' '.$el_class.' '.$count_text_placement.' '.$animate.'" '.$animation_data.'>';
			if($datetime!=''){
				$output .='<div class="ult_countdown-div ult_countdown-dateAndTime '.$ult_tz.'" data-labels="'.$labels.'" data-labels2="'.$labels2.'"  data-terminal-date="'.$datetime.'" data-countformat="'.$count_frmt.'" data-time-zone="'.get_option('gmt_offset').'" data-time-now="'.str_replace('-', '/', current_time('mysql')).'" >'.$datetime.'</div>';
			}
			$output .='</div>';
			return $output;
		}
	}
	//instantiate the class
	$ult_countdown = new Ultimate_CountDown;
}