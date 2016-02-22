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
    
     // if layout has two sidebars and second sidear is active
    if ( is_active_sidebar('sidebar-2')) : ?>
    
    <?php reactor_sidebar_before(); ?>
    
        <aside id="right-sidebar" class="sidebar <?php reactor_columns('3'); ?>" role="complementary">
            <?php dynamic_sidebar('sidebar-2'); ?>
        </aside><!-- #sidebar-2 -->
        
    <?php // else show an alert
    else : ?>

        <aside id="right-sidebar" class="sidebar <?php reactor_columns('3'); ?>" role="complementary">
            <div class="alert-box secondary"><p>Add some widgets to this area!</p></div>
        </aside><!-- #sidebar-2 -->
        
    <?php reactor_sidebar_after(); ?>
        
    <?php endif;?>