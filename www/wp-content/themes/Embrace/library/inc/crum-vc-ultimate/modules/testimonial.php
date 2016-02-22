<?php
if (!class_exists('Crum_Testimonial')) {
    class Crum_Testimonial
    {
        function __construct()
        {
            add_shortcode('testimonial', array(&$this, 'crum_testimonial'));
            add_action('admin_init', array(&$this, 'add_testimonial'));
        }

        function add_testimonial()
        {
            if (function_exists('vc_map')) {

	            $group = __("Main Options", "crum");

                vc_map(
                    array(
                        "name" => __("Testimonial item", 'crum'),
                        "base" => "testimonial",
                        "icon" => "vc_timeline_item_icon",
                        "category" => __('Presentation', 'crum'),
                        "params" => array(
                            array(
                                "type" => "attach_image",
                                "class" => "",
                                "heading" => __("Client's photo", "crum"),
                                "param_name" => "image",
                                "value" => "",
                                "group"       => $group,
                                "description" => __("Upload the photo of client", "crum")
                            ),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => __("Client's name", "crum"),
                                "param_name" => "name",
                                "admin_label" => true,
                                "value" => "",
                                "group"       => $group,
                                "description" => __("Enter client's name", "crum"),
                            ),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => __("Profession", "crum"),
                                "param_name" => "profession",
                                "admin_label" => false,
                                "value" => "",
                                "group"       => $group,
                                "description" => __("Select client's profession", "crum"),
                            ),
                            array(
                                "type" => "textarea_html",
                                "class" => "",
                                "heading" => __("Testimonial text", "crum"),
                                "param_name" => "content",
                                "admin_label" => true,
                                "value" => "",
                                "group"       => $group,
                                "description" => __("Enter the text of testimonial.", "crum"),
                            ),

                            array(
                                "type" => "dropdown",
                                "class" => "",
                                "heading" => __("Image align", "crum"),
                                "param_name" => "pos",
                                "value" => array(
                                    "Left" => "left",
                                    "Right" => "right",
                                ),
                                "group"       => $group,
                                "description" => __("Select image position.", "crum")
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
                //end of testimonial item
            }
        }

        function crum_testimonial($atts, $content = null)
        {

            $image = $name = $profession = $pos = $module_animation = '';

            extract(
                shortcode_atts(
                    array(
                        'image' => '',
                        'name' => '',
                        'profession' => '',
                        'pos' => 'left',
	                    'module_animation' => '',
                    ), $atts
                )
            );

	        $animate = $animation_data = '';

	        if ( ! ($module_animation == '')){
		        $animate = ' cr-animate-gen';
		        $animation_data = 'data-animate-type = "'.$module_animation.'" ';
	        }

            $items_content = '<div class="testimonial-item align-' . $pos . ' ' . $animate . '" ' . $animation_data . '>';

            if ($image) {
                $img_url = crum_int_image( $image, '128', '128', true );
                $items_content .= '<img src="'.$img_url.'" alt="'.$name.'" class="" >';
            }

	        if ( isset($name) && !($name == '') ) {
		        $items_content .= '<h5 class="name">';
		        $items_content .= $name;
		        $items_content .= '</h5>';
	        }

	        if ( isset($profession) && !($profession == '') ) {
		        $items_content .= '<span class="profession">';
		        $items_content .= $profession;
		        $items_content .= '</span>';
	        }

	        $items_content .= '<div class="ovh"><div class="testimonial-content">';
	        $items_content .= $content;
	        $items_content .= '</div></div>';

            $items_content .= '</div>';//end testimonial-item

            return $items_content;

        }
        //end of crum_timeline_item
    }

    new Crum_Testimonial;

}