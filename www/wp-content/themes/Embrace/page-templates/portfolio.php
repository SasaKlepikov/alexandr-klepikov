<?php
/**
 * Template Name: Portfolio
 *
 * @package   Reactor
 * @subpackge Page-Templates
 * @since     1.0.0
 */
?>

<?php // get the options
$page_lay = reactor_option('', '', '_page_layout_select');
?>

<?php get_header(); ?>

    <div id="primary" class="site-content">

        <?php reactor_content_before(); ?>

        <div id="content" role="main">

            <?php set_layout('portfolio', true, $page_lay); ?>

            <?php reactor_inner_content_before(); ?>

            <?php // get the page loop
            get_template_part('loops/loop', 'page'); ?>

            <?php // get the portfolio loop
            get_template_part('loops/loop', 'portfolio'); ?>

            <?php reactor_inner_content_after(); ?>

            <?php set_layout('portfolio', false, $page_lay); ?>

            <!-- #column -->

        </div>
        <!-- #content -->

        <?php reactor_content_after(); ?>

    </div><!-- #primary -->
<?php get_footer(); ?>