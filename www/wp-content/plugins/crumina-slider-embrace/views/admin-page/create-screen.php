<?php 
/**
 * Create Screen View
 *
 * This view displays the output for the create slider
 * screen in the WordPress Administration Area.       
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

/**
 * Build Edit Redirect Link URL
 * 
 * Generate the first part of the URL and store it
 * later in a data attribute. This URL will have the 
 * rest of the query variables appended to it via AJAX.
 *
 * @since 1.0
 * @version 1.0
 * 
 */
$edit_redirect_link = esc_url( 
				add_query_arg( 
					array( 
						'page'    => $this->plugin_slug,
						'action'  => 'edit'
					), 
					admin_url( 'admin.php' ) 
				) 
			);

/**
 * Build Delete Link URL
 * 
 * Generate a unique edit URL for each custom
 * sidebar.
 *
 * @since 1.0
 * @version 1.0
 * 
 */
$delete_link = $this->admin_url;
?>

<div id="sliders-frame">
	<!-- Sidebar -->
	<div id="slider-all-pages-column" class="metabox-holder metabox-holder-disabled">
		<?php wp_nonce_field( 'add-menu_item', 'menu-settings-column-nonce' ); ?>
		<?php wp_nonce_field( 'crumina_add_slider_item', 'crumina_slider_settings_column_nonce' ); ?>
		<?php $this->do_accordion_sections(); ?>
	</div><!-- END #slider-all-pages-column -->

	<!-- Management -->
	<div id="slider-management-liquid">
		<div id="slider-management">
			<form autocomplete="off" id="update-slider" enctype="multipart/form-data" method="post" action="">
				<div class="slider-edit">
					<div id="slider-header">
						<div class="major-publishing-actions">
							<!-- Slider Name Input -->
							<label for="custom-slider-name" class="custom-slider-name-label howto open-label">
								<span><?php _e( 'Page Slider Name', 'crumina-page-slider' ); ?></span>
								<input type="text" value="" title="<?php _e( 'Enter page slider name here', 'crumina-page-slider' ); ?>" class="custom-slider-name regular-text menu-item-textbox input-with-default-title" id="custom-slider-name" name="custom-slider-name">
							</label>
							<div class="publishing-action">
								<span class="spinner"></span>
								<?php 
									/**
									 * Create Submit Button
									 * 
									 * Using the edit link defined at the top
									 * of this file.
									 */
									submit_button( 
										__( 'Create Page Slider', 'crumina-page-slider' ), 
										'primary', 
										'submit', 
										false, 
										array( 
											'id'                => 'create_slider_header',
											'data-redirect-url' => $edit_redirect_link
										) 
									); 
								?>
							</div>

							<div class="clear"></div>
						</div><!-- END .major-publishing-actions -->
					</div><!-- END #slider-header -->
					
					<div id="post-body">
						<div id="post-body-content">
							<p class="post-body-plain"><?php _e( 'Give your page slider a name above, then click Create Page Slider.', 'crumina-page-slider' ); ?></p>
						</div><!-- END #post-body-content -->
					</div><!-- END #post-body -->
					
					<div id="slider-footer">
						<div class="major-publishing-actions">
							<span class="delete-action">
								<?php 
									/**
									 * Create Delete Button
									 * 
									 * Using the delete link defined at the top
									 * of this file.
									 */
									submit_button( 
										__( 'Delete Page Slider', 'crumina-page-slider' ), 
										'delete create-screen', 
										'submit', 
										false, 
										array( 
											'id'                => 'delete-slider',
											'data-redirect-url' => $delete_link,
											'data-slider-id'    => 0,
										) 
									); 
								?>
							</span>
							<div class="publishing-action">
								<span class="spinner"></span>
								<?php 
									/**
									 * Create Submit Button
									 * 
									 * Using the edit link defined at the top
									 * of this file.
									 */
									submit_button( 
										__( 'Create Page Slider', 'crumina-page-slider' ), 
										'primary', 
										'submit', 
										false, 
										array( 
											'id'                => 'create_slider_footer',
											'data-redirect-url' => $edit_redirect_link
										) 
									); 
								?>
							</div>
							<div class="clear"></div>
						</div>
					</div>					

				</div><!-- END .slider-edit -->
			</form><!-- END #update-slider -->
		</div><!-- END #slider-management -->
	</div><!-- END #slider-management-liquid -->
</div>