<?php
/**
 * The template for displaying posts by tag
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">
    
    	<?php reactor_content_before(); ?>
    
        <div id="content" role="main">

            <div class="row">

                <?php set_layout('archive', true); ?>
                
                <?php reactor_inner_content_before(); ?>
                <div id="main-loop">
                    <?php // get the loop
                    get_template_part('loops/loop', 'index'); ?>
                </div>
                <?php reactor_inner_content_after(); ?>

                    <?php set_layout('archive', false); ?>

            </div><!-- .row -->

        </div><!-- #content -->
        
        <?php reactor_content_after(); ?>
        
	</div><!-- #primary -->

<?php get_footer(); ?>