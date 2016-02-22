<?php 
/**
 * Manage Control Form
 * 
 * A form to allow the user to quickly select another
 * form to edit. 
 * 
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
?>
<div class="manage-sliders">
	<form autocomplete="off" id="" action="" method="get" enctype="multipart/form-data">
		<?php if ( $this->is_edit_screen() ) : ?>
			<input type="hidden" name="page" value="<?php echo $this->plugin_slug; ?>">
			<input name="action" type="hidden" value="edit">
			<label class="selected-slider" for="slider"><?php _e( 'Select a page slider to edit:', 'crumina-page-slider' ); ?></label>
			<select autocomplete="off" name="slider" id="slider">
				<?php foreach ( $this->custom_page_sliders as $custom_page_slider_id => $custom_page_slider_name ) : ?>
					<option value="<?php echo $custom_page_slider_id; ?>" <?php if ( $custom_page_slider_id == $this->page_slider_selected_id ) : ?>selected<?php endif; ?>><?php echo $custom_page_slider_name; ?></option>
				<?php endforeach; ?>
				<?php submit_button( __( 'Select', 'crumina-page-slider' ), 'secondary', '', false ); ?>
			</select>
			<span class="add-new-slider-action">
				or <a href="<?php echo $this->create_url; ?>"><?php _e( 'create a new page slider', 'crumina-page-slider' ); ?></a>	
			</span>
		<?php elseif ( $this->is_create_screen() ) : ?>
			<label><?php _e( 'Create a new Page Slider.', 'crumina-page-slider' ); ?></label>
		<?php endif ?>
	</form>	
</div><!-- END .manage-controls -->