<?php 
/**
 * Page Slider Persistent Options
 *
 * This view displays the fields for persistant
 * options for each slider:
 * 
 *     - Show Title
 *     - Show Icons
 *     - Show Categories
 *     - Show Link to Post      
 *     - Show Description
 *     - Description Limit
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

/**
 * Get Page Slider Static Options
 *
 * Sets up the static option variables to use
 * in this view.
 * 
 * @var mixed
 */
$show_title                   = get_post_meta( $this->page_slider_instance->ID, '_cps_show_title', true ); 
$show_icons                   = get_post_meta( $this->page_slider_instance->ID, '_cps_show_icon', true ); 
$show_categories              = get_post_meta( $this->page_slider_instance->ID, '_cps_show_category', true ); 
$show_link                    = get_post_meta( $this->page_slider_instance->ID, '_cps_show_link', true );
$show_description             = get_post_meta( $this->page_slider_instance->ID, '_cps_show_description', true );
$description_visibility_class = get_post_meta( $this->page_slider_instance->ID, '_cps_show_description', true ) ? '' : 'hidden';
$description_limit            = get_post_meta( $this->page_slider_instance->ID, '_cps_description_limit', true );
?>
<!-- Page Slider Options -->
<div class="slider-settings menu-settings crumina-static-options">
	<h3><?php _e( 'Page Slider Properties', 'crumina-page-slider' ); ?></h3>
	<div id="slider-properties-instructions">
		<p><?php _e( 'Edit the options below to change the appearence of this page slider.', 'crumina-page-slider' ); ?></p>
	</div>	
	<dl>
		<dt class="howto"><?php _e( 'Visibility Options', 'crumina-page-slider' ); ?></dt>
		<dd>
			<!-- Show Title -->
			<div class="crumina-option-field">
				<input type="checkbox" id="cps-show-title" name="cps-show-title" class="crumina-checkbox" <?php checked( $show_title ); ?>>
				<label class="crumina-label" for="cps-show-title"><?php _e( 'Show Title', 'crumina-page-slider' ) ?></label>
			</div>				
			<!-- Show Icons
			<div class="crumina-option-field">
				<input type="checkbox" id="cps-show-icons" name="cps-show-icons" class="crumina-checkbox" <?php checked( $show_icons ); ?>>
				<label class="crumina-label" for="cps-show-icons"><?php _e( 'Show Icons', 'crumina-page-slider' ) ?></label>
			</div>
			<!-- Show Categories -->
			<div class="crumina-option-field">
				<input type="checkbox" id="cps-show-categories" name="cps-show-categories" class="crumina-checkbox" <?php checked( $show_categories ); ?>>
				<label class="crumina-label" for="cps-show-categories"><?php _e( 'Show Meta', 'crumina-page-slider' ) ?></label>
			</div>
			<!-- Display Link to Page -->
			<div class="crumina-option-field">
				<input type="checkbox" id="cps-show-link" name="cps-show-link" class="crumina-checkbox" <?php checked( $show_link ); ?>>
				<label class="crumina-label" for="cps-show-link"><?php _e( 'Display Link to Page', 'crumina-page-slider' ) ?></label>
			</div>

			<!-- Show Descriptioon -->
			<div class="crumina-option-field">
				<input type="checkbox" id="cps-show-description" name="cps-show-description" class="crumina-checkbox" <?php checked( $show_description ); ?>>
				<label class="crumina-label" for="cps-show-description"><?php _e( 'Show Description', 'crumina-page-slider' ) ?></label>				
			</div>

		</dd>
		<div id="cps-description-limit-container" class="<?php echo $description_visibility_class; ?>">
			<dt class="howto"><label for=""><?php _e( 'Description Limit (Number of words)', 'crumina-page-slider' ); ?></label></dt>
			<dd>
				<input type="text" id="cps-description-limit" name="cps-description-limit" value="<?php echo $description_limit; ?>">
			</dd>
		</div>
	</dl>							
</div>	