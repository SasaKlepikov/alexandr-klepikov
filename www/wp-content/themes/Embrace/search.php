<?php
/**
 * The template for displaying search results
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

            <?php set_layout('search'); ?>

            <?php reactor_inner_content_before(); ?>

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php printf( __('Search Results for: %s', 'crum'), '<span>' . get_search_query() . '</span>'); ?></h1>
                </header>

                <?php get_search_form(); ?>

            <?php endif; // end have_posts() check ?>
            <div id="main-loop">
                <?php get_template_part('loops/loop', 'index'); ?>
            </div>
            <?php reactor_inner_content_after(); ?>

            <?php set_layout('search', false); ?>
        </div></div><!-- #content -->

    <?php reactor_content_after(); ?>

</div><!-- #primary -->

<?php get_footer(); ?>