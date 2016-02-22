<?php 
/**
 * Deleted Dialog Message 
 *
 * Message to display to the user if this
 * page slider has been deleted.
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
	<?php if ( $_GET['dialog'] == 'deleted' ) : ?>
		<?php $deleted_slider_name = isset( $_GET['name'] ) ? $_GET['name'] : __( 'Page Slider', 'crumina-page-slider' ); ?>
		<div class="updated below-h2" id="delete_message">
			<p><?php printf( __( '%1$s has been deleted.', 'crumina-page-slider' ), "<strong>{$deleted_slider_name}</strong>" ) ?></p>
		</div>
	<?php endif; ?>
<?php endif; ?>