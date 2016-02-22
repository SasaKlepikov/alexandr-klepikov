<?php
/**
 * Footer Content
 * hook in the content for footer.php
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */



/**
 * Footer widgets
 * in footer.php
 * 
 * @since 1.0.0
 */
function reactor_do_footer_widgets() { ?>
	<div class="row">
		<div class="<?php reactor_columns( 12 ); ?>">
			<div class="inner-footer">
				<?php get_sidebar('footer'); ?>       
				</div><!-- .inner-footer -->
			</div><!-- .columns -->
	</div><!-- .row -->
<?php 
}
add_action('reactor_footer_inside', 'reactor_do_footer_widgets', 1);

/**
 * Footer links and site info
 * in footer.php
 * 
 * @since 1.0.0
 */
function reactor_do_footer_content() { ?>
	<div class="site-info">
		<div class="row">
            <?php if ( function_exists('reactor_footer_links') && reactor_footer_links()){ ?>

            <div class="<?php reactor_columns( 6 ); ?>">

                <?php }else{ ?>

                <div class="<?php reactor_columns( 12 ); ?>">

                    <?php } ?>
                    <div id="colophon">
                        <p>
                            <?php if ( reactor_option('footer-text') ) : echo do_shortcode(reactor_option('footer-text')); else : ?>
                                <span class="copyright">&copy;<?php echo date_i18n('Y'); ?> <?php bloginfo('name'); ?> | </span>

                                <span class="site-source"><?php _e('Powered by ', 'crum'); ?><a href="<?php echo esc_url('http://wordpress.org/'); ?>" title="<?php esc_attr_e('Personal Publishing Platform', 'crum'); ?>">WordPress</a> &amp; <a href="<?php echo esc_url('http://crumina.net/') ?>" title="<?php esc_attr_e('Atlantis WordPress Theme', 'crum'); ?>">Atlantis</a></span>
                            <?php endif; ?>
                        </p>
                    </div><!-- #colophon -->

                </div><!-- .columns -->

                <?php if ( function_exists('reactor_footer_links') && reactor_footer_links() ) : ?>

                    <div class="<?php reactor_columns( 6 ); ?>">
                        <nav class="footer-links" role="navigation">
                            <?php echo reactor_footer_links(); ?>
                        </nav><!-- #footer-links -->
                    </div><!--.columns -->

                <?php endif; ?>
            
		</div><!-- .row -->
	</div><!-- #site-info -->
<?php 
}
add_action('reactor_footer_inside', 'reactor_do_footer_content', 2);


/**
 * Footer links and site info
 * in footer.php
 *
 * @since 1.0.0
 */
function reactor_do_backtotop() {
	if ( reactor_option( 'backtotop', false ) == '1' ) {
		echo '<a href="#" id="linkTop" class="backtotop hidden"><i class="crumicon-arrow-up2"></i></a>

		<script>
    	jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() === 0) {
            jQuery("#linkTop").addClass("hidden")
        } else {
            jQuery("#linkTop").removeClass("hidden")
        }
    	});

    	jQuery("#linkTop").click(function (e) {
        	jQuery("body,html").animate({
            	scrollTop:0
        	}, 800);
        	e.preventDefault();
    	})
    	</script>';

	}
}
add_action('reactor_footer_inside', 'reactor_do_backtotop', 3);


function crum_side_secondary_menu(){
    if (reactor_option('header_side_menu', '')) {
        ?>

        <nav id="cd-lateral-nav" class="smooth-animation">

            <div class="sidebar-logo logo">
                <?php reactor_do_logo(); ?>
            </div>

            <?php reactor_sidebar_menu(); ?>

            <?php echo reactor_topbar_social(); ?>

	        <?php get_sidebar('secondary');?>

        </nav>
    <?php }
}

add_action('reactor_foot', 'crum_side_secondary_menu', 10);

/**
 * Footer links and site info
 * in footer.php
 *
 * @since 1.0.0
 */
function reactor_tracking_code() {
    echo reactor_option('tracking-code','');

    if ((reactor_option('js-code') != '') && (reactor_option('js-code') != 'jQuery(document).ready(function(){\n\n});')){
        echo '<script>'.reactor_option('js-code').'</script>';
    }
}
add_action('reactor_foot', 'reactor_tracking_code', 1);





/**
 * Pages without top menu
 * in header.php
 *
 * @since 1.0.0
 */

function reactor_remove_footer() {
	if (is_page_template('page-templates/coming-soon.php') || is_page_template('page-templates/page-blank.php')):


		remove_action('reactor_footer_inside', 'reactor_do_footer_widgets', 1);
		remove_action('reactor_footer_inside', 'reactor_do_footer_content', 2);

	endif;
}

add_action( 'get_footer', 'reactor_remove_footer');

