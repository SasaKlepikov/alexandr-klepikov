<?php 
/**
 * Updated Dialog Message 
 *
 * Message to display to the user if this
 * page slider has been updated.
 * 
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
?>
<?php if ( isset( $_GET['dialog'] ) ) : ?>
	<?php if ( 'updated' == $_GET['dialog'] ) : ?>
		<?php $updated_slider_name =  isset( $_GET['name'] ) ? $_GET['name'] : __( 'Page Slider', 'crumina-page-slider' ); ?>
		<div class="updated below-h2" id="update_message">
			<p>
				<?php printf( __( '%1$s has been updated.', 'crumina-page-slider' ), "<strong id='updated_slider_name'>{$updated_slider_name}</strong>" ); ?>
			</p>
		</div>
	<?php endif; ?>
<?php endif; ?>