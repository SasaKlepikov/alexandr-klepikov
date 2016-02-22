<?php
/**
 * The sidebar template containing the main widget area
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>
	<?php 	wp_reset_postdata();

	 // if layout has one sidebar and the sidebar is active
    if ( is_active_sidebar('sidebar') ) : ?>
    
    <?php reactor_sidebar_before(); ?>

        <aside id="left-sidebar" class="sidebar <?php reactor_columns('3'); ?>" role="complementary">
            <?php dynamic_sidebar('sidebar'); ?>
        </aside><!-- #sidebar -->
        
    <?php // else show an alert
    else : ?>

        <aside id="left-sidebar" class="sidebar <?php reactor_columns('3'); ?>" role="complementary">
            <div class="alert-box secondary"><p>Add some widgets to this area!</p></div>
        </aside><!-- #sidebar -->
        
    <?php reactor_sidebar_after(); ?>    
    
    <?php endif;?>