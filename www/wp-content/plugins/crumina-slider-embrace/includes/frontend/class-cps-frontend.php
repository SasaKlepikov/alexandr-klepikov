<?php
/**
 * Class: CPS_Frontend
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
if ( ! class_exists( 'CPS_Frontend' ) ) :
	class CPS_Frontend {
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
			$this->register_shortcode();		
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
			// Load admin style sheet and JavaScript.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
		 * Enqueue Frontend Styles
		 *
		 * Used to enqueue any css stylesheets on the
		 * frontend side of the website.
		 *
		 * DEVELOPERS: Edit frontend.css in order to add
		 * global styles for every crumina page slider.
		 * File located in:
		 *     - assets\css\frontend\frontend.css
		 *
		 * If you want to enqueue additional stylesheets
		 * to be loaded on the frontend, you can do so in
		 * this function. 
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function enqueue_styles() {

			// Load global Crumina Page Slider stylesheet
			wp_deregister_style( $this->plugin_slug .'-frontend' );
			wp_register_style( 
				$this->plugin_slug .'-frontend', 
				Crumina_Page_Slider::get_css_url() . '/frontend/frontend.css', 
				array(), 
				Crumina_Page_Slider::VERSION
			);
			wp_enqueue_style( $this->plugin_slug .'-frontend' );

			wp_enqueue_style('wp-mediaelement');

			/**
			 * Load Conditional Inline Styles 
			 * 
			 * Load styles for Crumina Page Slider Instances.
			 * Makes the options available for each page
			 * slider based on the template it is using.
			 *
			 * Note: Uses transients for performance. To 
			 * refresh the transients just save the page
			 * slider in the admin section and the transient
			 * will automatically refresh.
			 *  
			 */
			if ( false === ( $custom_css = get_transient( 'crumina-page-slider-styles' ) ) ) {
				$custom_css = '';

				$page_sliders = CPS_Posttype::get_all_page_sliders();

				if ( $page_sliders && $page_sliders->have_posts() ) {
					while ( $page_sliders->have_posts() ) {
						$page_sliders->the_post();

						// Get all templates
						$templates     = CPS_Templates::get_templates();

						// Get page slider template options
						$template_slug = get_post_meta( get_the_ID(), '_cps_template_name', true );
						$options       = get_post_meta( get_the_ID(), '_cps_template_options', true );
						$slider_id     = get_post_meta( get_the_ID(), '_slider_id', true );

						if ( CPS_Templates::template_exists( $template_slug ) ) {
							/**
							 * Get Options 
							 * 
							 * Get default options and attempt to parse 
							 * them with the options set for this slider.
							 * Falls back to defaults if $options is not
							 * an array.
							 * 
							 */
							$default_options = CPS_Templates::get_template_default_options( $template_slug );

							if ( is_array( $options ) ) {
								$options = wp_parse_args( $options, $default_options );
							} else {
								$options = $default_options;
							}

							/**
							 * DEVELOPER NOTE: Add Inline Styles Here
							 * 
							 * Now you can output conditional css based on 
							 * the template slugs defined in the get_templates() 
							 * function in:
							 * 
							 *     - includes\frontend\class-cps-templates.php
							 *
							 * One Touch Template used as example, you would need
							 * to add an if statement like the one below with the 
							 * template slug in order to add template specific 
							 * styles:
							 * 
							 */
							if ( 'atlantis' == $template_slug ) {
								/**
								 * Now you can get each option by accessing the
								 * $options[] array and append the styles to the
								 * custom css.
								 *
								 * e.g. $options['checkbox_example']
								 * 
								 * use the example below.
								 */
								$custom_css .= '#' . $slider_id . '.crumina-slider-wrap .active .click-section {';
								$custom_css .= 'background:' . $options['featured_color'] . ';';
								$custom_css .= '}';
								$custom_css .= '#' . $slider_id . ' .crumina_slider.atlantis .item-category {';
								$custom_css .= 'background:' . $options['featured_color'] . ';';
								$custom_css .= '}';
								$custom_css .= '#' . $slider_id . ' .crumina_slider.atlantis .cr-sl-item:hover .bg {';
								$custom_css .= 'background-color:' . $options['slide_hover_color'] . ';';
								$custom_css .= 'opacity:' . $options['opacity'] / 100 . ';';
								$custom_css .= '}';

							}
                            if ( 'embrace' == $template_slug ) {
                                /**
                                 * Now you can get each option by accessing the
                                 * $options[] array and append the styles to the
                                 * custom css.
                                 *
                                 * e.g. $options['checkbox_example']
                                 *
                                 * use the example below.
                                 */
                                $custom_css .= '#' . $slider_id . ' .crumina_slider.embrace .text-desc, .crumina_slider.embrace .text-desc a {';
                                $custom_css .= 'color:' . $options['featured_color'] . ';';
                                $custom_css .= '}';
                                $custom_css .= '#' . $slider_id . ' .crumina_slider.embrace .more-button {';
                                $custom_css .= 'color:' . $options['featured_color'] . '; border-color:' . $options['featured_color'] . ';';
                                $custom_css .= '}';
                                $custom_css .= '#' . $slider_id . ' .crumina_slider.embrace  .active .cr-sl-item:hover .bg {';
                                $custom_css .= 'background-color:' . $options['slide_hover_color'] . ';';
                                $custom_css .= 'opacity:' . $options['opacity'] / 100 . ';';
                                $custom_css .= '}';

                            }
						}

					}
				}

				wp_reset_postdata();
										
						

			}
			set_transient( 'crumina-page-slider-styles', $custom_css );
			wp_add_inline_style( $this->plugin_slug .'-frontend', $custom_css );

		}

		/**
		 * Enqueue Frontend javaScript
		 *
		 * Used to enqueue any javascript files on the
		 * frontend side of the website.
		 *
		 * DEVELOPERS: Edit frontend.js in order to add
		 * custom js for each crumina page slider.
		 * File located in:
		 *     - assets\js\frontend\frontend.css
		 *
		 * If you want to enqueue additional js files
		 * to be loaded on the frontend, you can do so in
		 * this function. 
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function enqueue_scripts() {

			// Load frontend js
			wp_deregister_script( $this->plugin_slug . '-frontend' );
			wp_register_script( 
				$this->plugin_slug . '-frontend', 
				Crumina_Page_Slider::get_js_url() . '/frontend/frontend.js',  
				array( 'jquery' ), 
				Crumina_Page_Slider::VERSION 
			);
			wp_enqueue_script( $this->plugin_slug . '-frontend' );

			wp_enqueue_script('wp-mediaelement');

			// Load in js l10n for javascript translations
			wp_localize_script( $this->plugin_slug . '-frontend', 'cruminal10n', $this->getL10n() );

		}

		/**
		 * Get L10n Translation Object
		 *
		 * This array is enqueues as a javascript object on
		 * the frontend. This allows the plugin to remain
		 * fully translatable.
		 *
		 * DEVELOPERS: Add items to the array below to make them
		 * available in a js object on the frontend. To access each
		 * value in frontend just reference the cruminal10n object.
		 * So, to access the property in the example below just access:
		 *     - cruminal10n.name
		 * to get the value in .
		 * 
		 * @return array $l10n - Array of strings to be used as a js translation object
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function getL10n() {
			$l10n = array(
				'name' => __( 'Crumina Page Slider', 'crumina-page-slider' ),
			);
			return $l10n;
		}

		/**
		 * Register Shortcode
		 *
		 * Used to register the shortcode handles for 
		 * the crumina page slider shortcode.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_shortcode() {
			add_shortcode( 'crumina_page_slider', array( $this, 'render_shortcode' ) );
		}
		
		/**
		 * Render Shortcode
		 *
		 * Shortcode callback function that is used to output
		 * a particular crumina page slider instance.    
		 *
		 * Codex functions used:
		 * {@link http://codex.wordpress.org/Function_Reference/apply_filters} 	apply_filters()
		 * {@link http://codex.wordpress.org/Function_Reference/do_shortcode} 	do_shortcode()
		 * 
		 * @return string HTML output of a row with columns
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function render_shortcode( $atts, $content ) {
			
			// Extract shortcode arguments
			extract( shortcode_atts( array(
				'id' => '',
			), $atts ) );

			// Output to return
			$output = '';

			if ( $id ) {

				// Get the page slider with this id
				$page_slider = CPS_Posttype::get_page_slider_query_by_meta( '_cps_shortcode_id', $id );

				if ( $page_slider && $page_slider->have_posts() ) {
					while ( $page_slider->have_posts() ) {
						
						// Process page slider
						$page_slider->the_post();
						$current_post_id = get_the_ID();

						// Exit if transient exists
						if ( get_transient( "crumina-page-slider-{$current_post_id}" ) ) {
							$output = get_transient( "crumina-page-slider-{$current_post_id}" );
							continue;
						}

						// Get post, attachment and template data - Available to reference in template file
						$attachments     = get_post_meta( get_the_ID(), '_cps_attachments', true );
						$template_slug   = get_post_meta( get_the_ID(), '_cps_template_name', true );
						$options         = get_post_meta( get_the_ID(), '_cps_template_options', true );
						$slider_id       = get_post_meta( get_the_ID(), '_slider_id', true );

						// Get static properties - Available to reference in template file
						$show_title       = get_post_meta( get_the_ID(), '_cps_show_title', true );
						$show_icon        = get_post_meta( get_the_ID(), '_cps_show_icon', true );
						$show_category    = get_post_meta( get_the_ID(), '_cps_show_category', true );
						$show_link        = get_post_meta( get_the_ID(), '_cps_show_link', true );
						$show_description = get_post_meta( get_the_ID(), '_cps_show_description', true );
						$decription_limit = (int) get_post_meta( get_the_ID(), '_cps_description_limit', true );

						// Count variable - Available to reference in template file
						$count = 0;
						$i = 0;

						$img_dir_url = Crumina_Page_Slider::get_images_url();

						/**
						 * Check if the template exists
						 * 
						 * Only proceed if the template actually exists
						 * otherwise inform the user that the selected
						 * template is missing.
						 * 
						 */
						if ( CPS_Templates::template_exists( $template_slug ) ) {

							// Get all templates
							$templates = CPS_Templates::get_templates();

							/**
							 * Get Options 
							 * 
							 * Get default options and attempt to parse 
							 * them with the options set for this slider.
							 * Falls back to defaults if $options is not
							 * an array.
							 * 
							 */
							$default_options = CPS_Templates::get_template_default_options( $template_slug );

							if ( is_array( $options ) ) {
								$options = wp_parse_args( $options, $default_options );
							} else {
								$options = $default_options;
							}

							// Filter for developers to add options at run time
							$options = apply_filters( 'crumina-page-slider-instance-options', $options, $template_slug );

							/**
							 * Check If Template File Exists
							 *
							 * Attempts to locate the template file and load 
							 * the output. Returns a feedback message to the 
							 * user if the template could not be located.
							 * 
							 */
							if ( file_exists( $templates[ $template_slug ]['path'] ) ) {

								/**
								 * CPS Queries
								 *
								 * Stores each WP_Query instance in an array
								 * so that we can reuse it.
								 * 
								 */
								$cps_queries      = array();
								$attachment_count = count( $attachments );
								$total_posts      = 0;

								/**
								 * Process Attachments
								 */
								foreach ( $attachments as $attachment ) {

									// Either 'post_type' or 'taxonomy'
									$item_type        = $attachment['menu-item-type'];
									$item_id          = $attachment['menu-item-object-id'];
									$item_offset      = ! empty( $attachment['menu-item-crumina-post-offset'] ) 	? $attachment['menu-item-crumina-post-offset'] 		: apply_filters( 'crumina_default_post_offset', 0 );
									$item_order       = ! empty( $attachment['menu-item-crumina-post-order'] ) 		? $attachment['menu-item-crumina-post-order'] 		: apply_filters( 'crumina_default_post_order', 'DESC' );
									$item_no_of_posts = ! empty( $attachment['menu-item-crumina-number-of-posts'] ) ? $attachment['menu-item-crumina-number-of-posts'] 	: apply_filters( 'crumina_default_number_of_posts', 10 );

									/**
									 * Generate Query Args
									 *
									 * Build an array of args that we can use with
									 * WP_Query() in order to get the posts that
									 * we want.
									 * 
									 */

									$args = array(
										'post_status'    => 'publish',
									);

									if ( 'post_type' == $item_type ) {

										// Single post query
										if ( 'page' == $attachment['menu-item-object'] ) {
											$args['page_id'] = $item_id;
										} else {
											$args['post_type'] = $attachment['menu-item-object'];
											$args['p'] = $item_id;

										}

									}
									else {
										if ( 'taxonomy' == $item_type ) {

											switch ( $attachment['menu-item-object'] ) {
												case 'product_cat':
													$args['post_type'] = 'product';
													break;
												case 'product_tag':
													$args['post_type'] = 'product';
													break;
												case 'portfolio-category':
													$args['post_type'] = 'portfolio';
													break;
												case 'portfolio-tag':
													$args['post_type'] = 'portfolio';
													break;
												default:
													$args['post_type'] = 'post';
											}

											$args['posts_per_page']      = $item_no_of_posts;
											$args['order']               = $item_order;
											$args['offset']              = $item_offset;
											$args['ignore_sticky_posts'] = true;
											$args['tax_query']           = array(
												array(
													'taxonomy' => $attachment['menu-item-object'],
													'field'    => 'term_id',
													'terms'    => $item_id
												)
											);
										}
									}

									/**
									 * Generate a new WP_Query that will
									 * be available for each template and
									 * add it to the $cps_queries array.
									 * 
									 */
									$cps_queries[] = new WP_Query( $args );

									$attachment_count++;
								}

								/**
								 * Initialise Counter Variables
								 *
								 * Allows us to keep track of the total count
								 * and use them in template files even though 
								 * we are using multiple WP_Query() objects.
								 * 
								 */
								foreach ( $cps_queries as $cps_query ) {
									if ( $cps_query ) {
										while ( $cps_query->have_posts() ) {
											$cps_query->the_post();
											$total_posts++;
										}
									}
								}

								/**
								 * Load Template File as Output Buffer:
								 *
								 * DEVELOPER NOTE:
								 * To access the current post loop just reference the 
								 * $cps_query in the template file. Please note multiple
								 * queries are being run. 
								 *
								 * E.g.
								 * 
								 * while ( $cps_query->have_posts ) {
								 * 		$cps_query->the_post();
								 * }
								 * 
								 */
								foreach ( $cps_queries as $cps_query ) {
									if ( $cps_query ) {
										
										// Get content in output buffer and append to $output
										ob_start();
										include( $templates[ $template_slug ]['path'] );
										$output .= ob_get_contents();
										ob_end_clean();

										// Reset the post data
										wp_reset_postdata();
									}

								}
								
							} else {
								$output = __( 'Template file could not be located. Please select another template.', 'crumina-page-slider' );
							}

						} else {
							$output = __( 'Please select a template for this page slider.', 'crumina-page-slider' );
						}

						// Set transient
						set_transient( "crumina-page-slider-{$current_post_id}", $output );
					}
				} else {
					$output = __( 'No page sliders have been found with that id.', 'crumina-page-slider' );
				}

				// Reset Postdata
				wp_reset_postdata();
			}

			return $output;
		}
	}
endif;