<?php
/**
 * Scripts
 * WordPress will add these scripts to the theme
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @see wp_register_script
 * @see wp_enqueue_script
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Reactor Scripts
 *
 * @since 1.0.0
 */
add_action('wp_enqueue_scripts', 'reactor_register_scripts', 1);
add_action('wp_enqueue_scripts', 'reactor_enqueue_scripts');
 
function reactor_register_scripts() {
	// register scripts

	wp_register_script('modernizr-js', get_template_directory_uri() . '/library/js/vendor/custom.modernizr.js', array(), false, false);
	wp_register_script('foundation-js', get_template_directory_uri() . '/library/js/foundation.min.js', array(), false, true);
	wp_register_script('reactor-js', get_template_directory_uri() . '/library/js/reactor.js', array(), false, true);
	wp_register_script('isotope-js', get_template_directory_uri() . '/library/js/isotope.min.js', array(), false, true);
	wp_register_script('jquery-cookie', get_template_directory_uri() . '/library/js/jquery_cookie.min.js', array(), false, true);
	wp_register_script('custom-share', get_template_directory_uri() . '/library/js/jquery.sharrre.min.js', array(), false, true);
	wp_register_script('googleMaps', 'https://maps.google.com/maps/api/js?sensor=false', NULL, NULL, TRUE);
    wp_register_script('gmap3', get_template_directory_uri() . '/library/js/gmap3.min.js', array(), false, true);
    wp_register_script('jflickrfeed', get_template_directory_uri() . '/library/js/jflickrfeed.min.js', array(), false, true);
	wp_register_script('magnificPopup-js', get_template_directory_uri() . '/library/js/jquery.magnific-popup.min.js', array(), false, true);
	wp_register_script('slick-carousel-js', get_template_directory_uri() . '/library/js/slick.min.js', array(), false, true);
	wp_register_script('animation-js', get_template_directory_uri() . '/library/js/animation.min.js', array(), false, true);
	wp_register_script('countdown-js', get_template_directory_uri().'/library/js/jquery.countdown.min.js', array('jquery'), false, false);
	wp_register_script('qr-code-js', get_template_directory_uri().'/library/js/qrcode.min.js', array(), false, false);
    wp_register_script('masterslider', get_template_directory_uri().'/library/js/masterslider.min.js', array('jquery'), null, true);
    wp_register_script( 'vc_pie_crumina', get_template_directory_uri().'/library/js/jquery.vc_chart.js', array( 'jquery', 'progressCircle' ), null, true );

    // ajax pagination
    wp_register_script('ajax-pagination', get_template_directory_uri().'/library/js/ajax-pagination.js', array('jquery'), null, true);

	//Lazysizes loader
	wp_register_script('lazysizes', get_template_directory_uri() . '/library/js/lazysizes.min.js', array(), false, true);

}

function reactor_enqueue_scripts() {

	global $one_touch_option;

	if ( !is_admin() ) { 
		// enqueue scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr-js');
		wp_enqueue_script('foundation-js');
		wp_enqueue_script('reactor-js');
        wp_enqueue_script('slick-carousel-js');
		wp_enqueue_script('jquery-cookie');
		wp_enqueue_script('magnificPopup-js');
		wp_enqueue_script('animation-js');

		wp_enqueue_script('lazysizes');
		// enqueue quicksand on portfolio page template
		//if ( is_page_template('page-templates/portfolio.php') || is_tax( 'portfolio-tag' ) || is_tax( 'portfolio-category' ) ) {
			wp_enqueue_script('isotope-js');
		//}

        // enqueue google map on contacts page
        if ( is_page_template('page-templates/contact.php')){
            wp_enqueue_script('gmap3');
        }



		if ( is_page_template('page-templates/coming-soon.php')){
			wp_enqueue_script('countdown-js');
		}

        if ( is_single() || is_singular('portfolio')) {
            wp_enqueue_script('custom-share');
        }
		
		// comment reply script for threaded comments
		if ( is_singular() && comments_open() && get_option('thread_comments') ) {
			wp_enqueue_script('comment-reply'); 
		}
	}
}
