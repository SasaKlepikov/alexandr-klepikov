<?php 
/**
 * Edit Page Slider Screen View
 *
 * This view displays the output for the edit screen
 * for each crumina page slider slider screen in the 
 * WordPress Administration Area.       
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

/**
 * Build Save Redirect Link URL
 * 
 * Generate the first part of the URL and store it
 * later in a data attribute. This URL will have the 
 * rest of the query variables appended to it via AJAX.
 *
 * @since 1.0
 * @version 1.0
 * 
 */
$save_redirect_link = esc_url( 
				add_query_arg( 
					array( 
						'page'   => $this->plugin_slug,
						'action' => 'edit',
						'slider' => $this->page_slider_selected_id,
						'dialog' => 'updated'
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
$delete_link = esc_url( 
				add_query_arg( 
					array( 
						'page'    => $this->plugin_slug,
						'dialog'  => 'deleted',
						'name'    => str_replace( ' ', '+', $this->page_slider_instance->post_title ),
					), 
					admin_url( 'admin.php' ) 
				) 
			);
?>
<div id="sliders-frame">
	<!-- Sidebar -->
	<div id="slider-all-pages-column" class="metabox-holder">
		<?php $this->do_accordion_sections(); ?>
	</div><!-- END #slider-all-pages-column -->

	<!-- Management -->
	<div id="slider-management-liquid">
		<div id="slider-management">
			<form autocomplete="off" id="update-slider" enctype="multipart/form-data" method="post" action="">
				<div class="slider-edit">

					<!-- Header -->
					<div id="slider-header">
						<div class="major-publishing-actions">
							<!-- Slider Name Input -->
							<label for="custom-slider-name" class="custom-slider-name-label howto open-label">
								<span><?php _e( 'Page Slider Name', 'crumina-page-slider' ); ?></span>
								<input autocomplete="off" type="text" value="<?php echo $this->page_slider_instance->post_title; ?>" title="<?php _e( 'Enter page slider name here', 'crumina-page-slider' ); ?>" class="custom-slider-name regular-text menu-item-textbox input-with-default-title" id="custom-slider-name" name="custom-slider-name">
							</label>
							<div class="publishing-action">
								<span class="spinner"></span>
								<?php 
									submit_button(
										__( 'Save Page Slider', 'crumina-page-slider' ),
										'primary',
										'submit',
										false,
										array(
											'id'                => 'save_slider_header',
											'data-slider-id'    => $this->page_slider_selected_id,
											'data-redirect-url' => $save_redirect_link,
										)
									);
								?>
							</div>
							<div class="clear"></div>
						</div><!-- END .major-publishing-actions -->
					</div><!-- END #slider-header -->
					
					<!-- Post Body -->
					<div id="post-body">
						<div id="post-body-content">
							<h3><?php _e( 'Page Slider Items', 'crumina-page-slider' ); ?></h3>
							<div class="drag-instructions post-body-plain" style="display:none;">
								<p>
									<?php _e( "Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.", 'crumina-page-slider' ); ?>
								</p>
							</div>
							<div id="slider-instructions" class="post-body-plain" style="display:none;">
								<p>
									<?php _e( "Add items to this page slider from the column on the left.", 'crumina-page-slider' ); ?>
								</p>
							</div>	

							<!-- Page Slider Items -->
							<ul class="slider nav-menus-php" id="slider-to-edit">
								<?php
									/**
									 * Load Page Slider Attachments
									 * 
									 * Loads all of the attachments assigned to 
									 * this page slider.
									 *
									 * @since 1.0
									 * @version 1.0
									 * 
									 */
									echo Crumina_Page_Slider_Admin::get_page_slider_attachment_markup( $this->page_slider_selected_id );
								?>
							</ul>

							<?php $this->get_slider_options(); ?>

						</div><!-- END #post-body-content -->
					</div><!-- END #post-body -->
					
					<!-- Footer -->
					<div id="slider-footer">
						<div class="major-publishing-actions">
							<span class="delete-action">
								<a data-redirect-url="<?php echo $delete_link; ?>" data-slider-id="<?php echo $this->page_slider_selected_id; ?>" id="delete-slider" href="#" class="submitdelete deletion menu-delete"><?php _e( 'Delete Page Slider', 'crumina-page-slider' ); ?></a>
							</span>
							<div class="publishing-action">
								<span class="spinner"></span>
								<?php 
									submit_button(
										__( 'Save Page Slider', 'crumina-page-slider' ),
										'primary',
										'submit',
										false,
										array(
											'id'                => 'save_slider_footer',
											'data-slider-id'    => $this->page_slider_selected_id,
											'data-redirect-url' => $save_redirect_link,
										)
									);
								?>
							</div>
							<div class="clear"></div>	
						</div><!-- END .major-publishing-actions -->
					</div><!-- END #slider-footer -->
				</div><!-- END .slider-edit -->
			</form><!-- END #update-slider -->
		</div><!-- END #slider-management -->
	</div><!-- END #slider-management-liquid -->
</div>