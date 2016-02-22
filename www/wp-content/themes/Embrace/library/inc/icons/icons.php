<?php

	/*	
	*	---------------------------------------------------------------------
	*	Compatibility mode
	*	Set to TRUE to enable compatibility mode - [v_icon]
	*	--------------------------------------------------------------------- 
	*/

	define( 'VI_SAFE_MODE', apply_filters( 'vi_safe_mode', FALSE ) );
	
	
	/* Setup perfix */
	function crum_i_compatibility_mode() {
		$prefix = ( VI_SAFE_MODE == true ) ? 'v_' : '';
		return $prefix;
	}

	

	/*	
	*	---------------------------------------------------------------------
	*	Setup plugin
	*	--------------------------------------------------------------------- 
	*/
		
	function crum_i_plugin_init() {

		wp_register_style( 'mnky-icon-generator', get_template_directory_uri() . '/library/inc/icons/css/generator.css', false, '', 'all' );
		wp_register_script( 'mnky-icon-generator', get_template_directory_uri() . '/library/inc/icons/js/generator.js', array( 'jquery' ), '', false );

		if ( !is_admin() ) {


		} elseif ( is_admin() ) {

				wp_enqueue_style( 'thickbox' );
				wp_enqueue_style( 'farbtastic' );
				wp_enqueue_style( 'mnky-icon-generator' );	


				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'farbtastic' );		
				wp_enqueue_script( 'mnky-icon-generator' );

		}
	}
	
	add_action( 'init', 'crum_i_plugin_init' );
	
	

	/*	
	*	---------------------------------------------------------------------
	*	Plugin URL
	*	--------------------------------------------------------------------- 
	*/
	
	function crum_i_plugin_url() {
		return locate_template('/inc/icons/icons.php');
    }

	/*
	*	---------------------------------------------------------------------
	*	Icon generator box
	*	---------------------------------------------------------------------
	*/

	function crum_i_generator() { ?>
		<div id="mnky-generator-overlay" class="mnky-overlay-bg" style="display:none"></div>
		<div id="mnky-generator-wrap" style="display:none">
			<div id="mnky-generator">
				<a href="#" id="mnky-generator-close"><span class="mnky-close-icon"></span></a>
				<div id="mnky-generator-shell">

					<div class="mnky-generator-icon-select">
						<input name="mnky-generator-insert" type="submit" class="button button-primary button-large" id="mnky-generator-insert" value="Insert Icon">
						<?php

        if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

            $font_manager = Crum_Icon_Manager::get_font_manager();
            $dependency = vc_generate_dependencies_attributes($settings);
            $output = '<div class="my_param_block">'
                . '<input name="' . $settings['param_name'] . '"
					  class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . '
					  ' . $settings['type'] . '_field" type="hidden"
					  value="' . $value . '" ' . $dependency . '/>'
                . '</div>';
            $output .= $font_manager;

        } else {
            $output = '<h1><br><br><br><br><br>Please Install and Activate Visual Composer Plugin</h1>';
        }

						echo $output;

						?>

					</div>


				</div>
			</div>
		</div>
		
	<?php
	}

	add_action( 'admin_footer', 'crum_i_generator' );

?>