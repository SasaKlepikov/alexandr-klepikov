<?php 
/**
 * Manage Screen View
 *
 * This view displays the output for the manage sliders
 * screen in the WordPress Administration Area. This 
 * screen allows the user to:
 *     
 *     - Get the shortcode for a specific slider
 *     - Choose to edit a specific page slider
 *     - Quickly delete a specific page slider
 *     - Quickly delete all page sliders   
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
?>
<form autocomplete="off" action="">
	<?php 
		/**
		 * Output New Page Slider Dialog Message
		 * 
		 * If there are no page sliders output a dialog message
		 * to prompt the user to create a new page slider.
		 * 
		 */
		if ( $this->no_page_sliders ) : ?>
			<div class="manage-sliders no-sliders">
				<label><?php _e( 'Create a new page slider:', 'crumina-page-slider' ); ?></label>
				<?php 
					submit_button(
						__( 'Create a New Page Slider', 'crumina-page-slider' ),
						'secondary',
						'create_new_slider',
						false,
						array( 'data-create-slider-url' => $this->create_url )
					);
				?>
			</div>
	<?php
		/**
		 * Output Custom Page Slider Table
		 * 
		 * If there are existing font controls output a table that
		 * displays all crumina page slider instances.
		 * 
		 */	
		else : ?>
			<div class="manage-sliders slider-dialog">
				<label class="manage-label"><?php _e( 'Manage your page sliders here or:', 'crumina-page-slider' ); ?></label>
				<label class="new-label"><?php _e( 'Create a new page slider:', 'crumina-page-slider' ); ?></label>
				<?php 
					submit_button(
						__( 'Create a New Page Slider', 'crumina-page-slider' ),
						'secondary',
						'create_new_slider',
						false,
						array( 'data-create-slider-url' => $this->create_url )
					);
				?>
			</div>
			<table id="page-sliders-table" class="widefat fixed" cellspacing="0">
				<thead>
					<tr>
						<th class="manage-column column-sliders"><?php _e( 'Page Slider Name', 'crumina-page-slider' ); ?></th>
						<th class="manage-column column-sliders"><?php _e( 'Slider Shortcode', 'crumina-page-slider' ) ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $row_count = 0; ?>
					<?php while ( $this->page_sliders->have_posts() ) : $this->page_sliders->the_post(); ?>
						<?php 
							$row_class = ( $row_count % 2 == 0 ) ? 'alternate' : '';
							$slider_id = get_post_meta( get_the_ID(), '_slider_id', true );
							$edit_link = esc_url(
								add_query_arg(
									array(
										'screen'  => 'edit',
										'action'  => 'edit',
										'slider' => $slider_id,
									),
									$this->admin_url
								)
							);
						?>
						<tr class="<?php echo $row_class; ?>">
							<td class="post-title page-title column-title">
								<div>
									<strong><a data-slider-reference="<?php echo $slider_id; ?>" class="slider-edit-link row-title" href="<?php echo $edit_link; ?>"><?php the_title(); ?></a></strong>
								</div>
								<div class="row-actions">
									<a data-slider-reference="<?php echo $slider_id; ?>" class="slider-edit-link" href="<?php echo $edit_link; ?>"><?php _e( 'Edit', $this->plugin_slug ); ?></a> | <a data-slider-reference="<?php echo $slider_id; ?>" class="slider-delete-link" href="#"><?php _e( 'Delete', $this->plugin_slug ); ?></a>
								</div>
							</td>
							<td class=""><input type="text" class="crumina-slider-shortcode" style="width:225px; text-align: center;" value='[crumina_page_slider id="<?php echo get_post_meta( get_the_ID(), '_cps_shortcode_id', true ); ?>"]' readonly></td>
							<td><span class="spinner" style=""></span></td>	
						</tr>
						<?php $row_count++; ?>
					<?php endwhile; ?>	
				</tbody>
			</table>
			<?php 
				/**
				 * Create Delete All Page Sliders Link
				 *
				 * Creates a button that will delete all crumina
				 * page sliders created by the user.
				 * 
				 */
			?>
			<a href="#" id="delete_all_sliders"><?php _e( 'Delete All Page Sliders', 'crumina-page-slider' ); ?></a>
	<?php endif; ?>
</form>