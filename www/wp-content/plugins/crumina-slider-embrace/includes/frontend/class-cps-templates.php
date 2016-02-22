<?php
/**
 * Class: CPS_Templates
 *
 * This file initialises the admin functionality for this plugin.
 * It initalises a posttype that acts as a data structure for
 * the crumina page sliders. It also has useful static helper 
 * functions each custom page slider. 
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Templates' ) ) :
	class CPS_Templates {
		/**
		 * Instance of this class.
		 * 
		 * @var      object
		 * @since    1.0
		 *
		 */
		protected static $instance = null;

		/**
		 * Slug of the plugin screen.
		 * 
		 * @var      string
		 * @since    1.0
		 *
		 */
		protected $plugin_screen_hook_suffix = 'crumina-page-slider';

		/**
		 * Constructor Function
		 * 
		 * Initialize the class and register all
		 * actions and filters.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		function __construct() {
			$this->plugin_slug = 'crumina-page-slider';
			$this->register_actions();		
			$this->register_filters();			
		}

		/**
		 * Return an instance of this class.
		 * 
		 * @return    object    A single instance of this class.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Register Custom Actions
		 *
		 * Add any custom actions in this function.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_actions() {
		}
		
		/**
		 * Register Custom Filters
		 *
		 * Add any custom filters in this function.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_filters() {
		}

		/**
		 * Get Templates
		 *
		 * Returns a list of templates along with their
		 * fields and default values.
		 *
		 * Custom Filters:
		 *     - crumina_page_slider_templates
		 *
		 * 
		 * @return [type] [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_templates() {

			// Get template directory view directory path
			$template_dir = Crumina_Page_Slider::get_template_directory_path();

			$templates = array(

				/**
				 * Template: Atlantis
				 *
				 * To create a new template just create a 
				 * new array entry and follow the format
				 * below.
				 * */

				'atlantis' => array(
					'name'             => 'Atlantis style',
					'path'             => $template_dir . '/atlantis.php',
					'default_template' => true,
					'options' => array(
						'slide_grid' => array(
							'label'       => __('Select Grid for items', 'crumina-page-slider'),
							'description' => __('Layout for slider display', 'crumina-page-slider'),
							'type'        => 'select',
							'choices' => array(
								'1big-6small' => __('1 Big 6 Small', 'crumina-page-slider'),
								'8small'      => __('8 Small Blocks', 'crumina-page-slider'),
								'4-large'     => __('4 Rectangle Blocks', 'crumina-page-slider'),
								'1big-4small' => __('1 Big 4 Small', 'crumina-page-slider'),
								'4small-1big' => __('4 Small 1 Big', 'crumina-page-slider'),
								'2big'        => __('2 Big Blocks', 'crumina-page-slider'),
							),
							'default'     => '1big-6small'
						),
						'auto_mode' => array(
							'label'       => __( 'Automatic Scroll', 'crumina-page-slider' ),
							'description' => __( 'Please check this box to enable auto scroll mode.', 'crumina-page-slider' ),
							'type'        => 'checkbox',
							'default'     => false
						),
						'scroll_timer' => array(
							'label'       => __('Delay between cycles in seconds', 'crumina-page-slider'),
							'description' => __('Type only number here', 'crumina-page-slider'),
							'type'        => 'text',
							'default'     => '5',
						),
						'featured_color' => array(
							'label'       => __( 'Category and Scrollbar Color', 'crumina-page-slider' ),
							'description' => __( 'Select slider featured color', 'crumina-page-slider' ),
							'type'        => 'color',
							'default'     => '#ff3800',
						),
						'slide_hover_color' => array( 
							'label'       => __( 'Hover Background Color', 'crumina-page-slider' ),
							'description' => __( 'This option determines the hover box background color for items', 'crumina-page-slider' ),
							'type'        => 'color',
							'default'     => '#000',
						),
						'opacity' => array(
							'label'       => __( 'Opacity', 'crumina-page-slider' ),
							'description' => __( 'This option determines hover box opacity.', 'crumina-page-slider' ),
							'type'        => 'slider',
							'min'         => '0',
							'max'         => '100',
							'step'        => '1',
							'default'     => '90',
						),						
					),
				),
                'embrace' => array(
                    'name'             => 'Embrace style',
                    'path'             => $template_dir . '/embrace.php',
                    'default_template' => true,
                    'options' => array(
                        'slide_grid' => array(
                            'label'       => __('Select Grid for items', 'crumina-page-slider'),
                            'description' => __('Layout for slider display', 'crumina-page-slider'),
                            'type'        => 'select',
                            'choices' => array(
                                '8small'      => __('8 Small Blocks', 'crumina-page-slider'),
                                '1big-4small' => __('1 Big 4 Small', 'crumina-page-slider'),
                                '4small-1big' => __('4 Small 1 Big', 'crumina-page-slider'),
                                '2big'        => __('2 Big Blocks', 'crumina-page-slider'),
                                '1large'      => __('1 Extra large', 'crumina-page-slider'),
                            ),
                            'default'     => '1big-4small'
                        ),
                        'auto_mode' => array(
                            'label'       => __( 'Automatic Scroll', 'crumina-page-slider' ),
                            'description' => __( 'Please check this box to enable auto scroll mode.', 'crumina-page-slider' ),
                            'type'        => 'checkbox',
                            'default'     => false
                        ),
                        'start_first' => array(
	                        'label'       => __( 'Start from first slide', 'crumina-page-slider' ),
	                        'description' => __( 'Check this box to start slider from the first slide.', 'crumina-page-slider' ),
	                        'type'        => 'checkbox',
	                        'default'     => false
                        ),
                        'scroll_timer' => array(
                            'label'       => __('Delay between cycles in seconds', 'crumina-page-slider'),
                            'description' => __('Type only number here', 'crumina-page-slider'),
                            'type'        => 'text',
                            'default'     => '5',
                        ),
                        'featured_color' => array(
                            'label'       => __( 'Text Color', 'crumina-page-slider' ),
                            'description' => __( 'Customize slider text color', 'crumina-page-slider' ),
                            'type'        => 'color',
                            'default'     => '#fff',
                        ),
                        'slide_hover_color' => array(
                            'label'       => __( 'Hover Background Color', 'crumina-page-slider' ),
                            'description' => __( 'This option determines the hover box background color for items', 'crumina-page-slider' ),
                            'type'        => 'color',
                            'default'     => '#000',
                        ),
                        'opacity' => array(
                            'label'       => __( 'Opacity', 'crumina-page-slider' ),
                            'description' => __( 'This option determines hover box opacity.', 'crumina-page-slider' ),
                            'type'        => 'slider',
                            'min'         => '0',
                            'max'         => '100',
                            'step'        => '1',
                            'default'     => '80',
                        ),
                    ),
                ),
			);

			return apply_filters( 'crumina_page_slider_templates', $templates );
		}

		/**
		 * Get Default Template Slug
		 *
		 * Gets the default template slug. This function returns
		 * the slug as soon as it finds it.
		 * 
		 * @return string $slug - Template slug
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_default_template_slug() {
			$slug = false;

			foreach ( self::get_templates()  as $slug => $template ) {
				if ( ! empty( $template['default_template'] ) ) {
					return $slug;
				}
			}

			return $slug;
		}

		/**
		 * Check if Template Exists
		 *
		 * Boolean function that returns true or false
		 * depending on whether the template exists.
		 * 
		 * @return string $slug - Template slug
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function template_exists( $template_slug ) {
			$templates = self::get_templates();
			return isset( $templates[ $template_slug ] );
		}

		/**
		 * Output Template Fields
		 *
		 * Output's Template Fields for the admin settings
		 * page.
		 * 
		 * @param  [type] $template_slug [description]
		 * @return [type]                [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function output_template_fields( $template_slug, $visible, $slider_options = array() ) {

			$output = '';

			$container_class = $visible ? 'visible' : 'hidden';

			// Output template fields
			if ( self::template_exists( $template_slug ) ) {

				$output .= "<dl data-options-for-template='{$template_slug}' class='{$container_class} crumina-template-options-group'>";
			
				// Get all tempaltes and options merged with defaults
				$templates = self::get_templates();
				$options   = wp_parse_args( $slider_options, self::get_template_default_options( $template_slug ) );

				// Output fields
				foreach ( $templates[ $template_slug ]['options'] as $option_name => $properties ) {

					// Append dt elements
					$output .= "<dt class='howto'>{$properties['label']}</dt><dd>";
				
					$value = $options[ $option_name ];

					/**
					 * Output Admin Field Markup
					 *
					 * Checks field type and outputs the appropriate 
					 * control for the admin area.
					 */
					switch ( $properties['type'] ) {
						case 'checkbox':
							$value = 'true' == $value ? true : false;
							$output .= "<input type='checkbox' name='{$option_name}' class='crumina-option crumina-checkbox' " . checked( $value, true, false ) .">";
							break;
						
						case 'number':
							$min           = $properties['min'];
							$max           = $properties['max'];
							$step          = $properties['step'];
							$initial_value = $value ? $value : $min;
							$default_value = $properties['default'];
							$output .= "<input type='text' name='{$option_name}' class='crumina-option crumina-number-spinner' value='{$value}'>";
							break;

						case 'text':
							$output .= "<input type='text' name='{$option_name}' class='crumina-option crumina-text-input' value='{$value}'>";
							break;

						case 'textbox':
							$output .= "<textarea name='{$option_name}' class='crumina-option crumina-textarea'>{$value}</textarea>";
							break;

						case 'color':
							$placeholder = __( 'Hex Value', 'crumina-page-slider' );
							$default_color  = $properties['default'];
							$output .= "<input autocomplete='off' type='text' name='{$option_name}' data-default-color='{$default_color}' value='{$value}' class='crumina-option crumina-color-input' maxlength='7' placeholder='{$placeholder}'>";
							break;

						case 'slider':
							$min           = $properties['min'];
							$max           = $properties['max'];
							$step          = $properties['step'];
							$initial_value = $value ? $value : $min;
							$default_value = $properties['default'];

							$output .= "<div name='{$option_name}' data-min-range='{$min}' data-max-range='{$max}' data-step='{$step}' data-initial-value='{$initial_value}' data-default-value='{$default_value}' class='crumina-option crumina-ui-slider'></div>";
							$output .= "<div class='crumina-ui-slider-display'>{$initial_value}</div>";
							$output .= "<div class='clear'></div>";
							$output .= "<a href='#' class='crumina-ui-slider-reset'>" . __( 'Reset', 'crumina-page-slider' ) . "</a>";
							break;

						case 'select':
							$output .= "<select name='{$option_name}'  class='crumina-option crumina-select'>";

							foreach ( $properties['choices'] as $key => $label ) {
								if ($value == $key) {
									$output .= "<option selected value='{$key}'>{$label}</option>";
								} else {
									$output .= "<option value='{$key}'>{$label}</option>";
								}

							}
							
							$output .= '</select>';
							break;
						
						default:
							break;
					}

					$output .= '<p class="howto">' . $properties['description'] . '</p>';		
				}

				$output .= '</dd></dl>';
			}

			return $output;
		}


		/**
		 * [output_admin_page_options description]
		 * @return [type] [description]
		 */
		public static function output_admin_page_options( $page_slider_id = '' ) {
			
			// Get page slider and template variables
			$all_templates       = self::get_templates();
			$page_slider         = CPS_Posttype::get_page_slider( $page_slider_id );
			$page_slider_options = array();
			$has_template        = false;
			$selected_template   = self::get_default_template_slug();

			/**
			 * Attempt to get options that have been
			 * set to the page slider if it exists.
			 * 
			 */
			if ( $page_slider ) {

				$template_slug = get_post_meta( $page_slider->ID, '_cps_template_name', true );
				
				// Check if page slider has a template and if that template exists
				if ( $template_slug && self::template_exists( $template_slug ) ) {
					$selected_template = $template_slug;
					$has_template      = true;
				}

				// Get template options if they exist
				if ( $has_template ) {
					$slider_options      = get_post_meta( get_the_ID(), '_cps_template_options', true );
					$page_slider_options = $slider_options ? (array) $slider_options : array();
				}

				// Reset post data
				wp_reset_postdata();
			}
			?>
			<!-- Template Selection -->
			<dl>
				<dt class="howto"><?php _e( 'Template', 'crumina-page-slider' ); ?></dt>
				<dd>
					<select name="crumina-page-slider-template" id="crumina-page-slider-template">
						<?php foreach ( $all_templates as $template => $properties ) : ?>
							<option value="<?php echo $template ?>" <?php selected( $template, $selected_template ); ?>><?php echo $properties['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="howto"><?php _e( 'Please select a template to use', 'crumina-page-slider' ); ?></p>
				</dd>				
			</dl>

			<!-- Options For Every Template -->
			<?php

			foreach ( $all_templates as $template_name => $properties ) {
				if ( $template_name == $selected_template ) {
					echo self::output_template_fields( $template_name, true, $page_slider_options );
				} else {
					echo self::output_template_fields( $template_name, false, array() );
				}
			}

		}

		/**
		 * Get Default Options For A Template
		 *
		 * Takes the template slug as a parameter and returns
		 * a list of default options for that template
		 * 
		 * @param  string $template_slug [description]
		 * @return array $options
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_template_default_options( $template_slug = '' ) {
			$options = array();

			$templates = self::get_templates();

			if ( self::template_exists( $template_slug ) ) {
				foreach ( $templates[ $template_slug ]['options'] as $option_name => $properties ) {
					$options[ $option_name ] = $properties['default'];
				}
			}

			return $options;
		}

	}
endif;