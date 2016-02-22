<?php 
/**
 * Page Slider Dynamic Template Options
 *
 * This view is used to ouput all of the available
 * fields for each template. It is also used to
 * display the current page sliders selected 
 * template options. 
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
?>
<!-- Page Slider Options -->
<div class="slider-settings menu-settings crumina-dynamic-template-options">
	<h3><?php _e( 'Page Slider Template Options', 'crumina-page-slider' ); ?></h3>
	<div id="slider-properties-instructions">
		<p><?php _e( 'Edit the options below to change the appearence of this page slider.', 'crumina-page-slider' ); ?></p>
	</div>
	<?php
	global $post;
	$slider_id   = get_post_meta( $post->ID, '_slider_id', true );
	?>
	<?php CPS_Templates::output_admin_page_options($slider_id); ?>
</div>	