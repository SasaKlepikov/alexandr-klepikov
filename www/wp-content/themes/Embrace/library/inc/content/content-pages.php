<?php
/**
 * Page Content
 * hook in the content for page templates
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Page Title 
 * in the header of format-page
 * 
 * @since 1.0.0
 */



function reactor_do_page_header_title(){
	global $crum_theme_option;
	if (( !is_page_template('page-templates/news-page.php')) && ( !is_page_template('page-templates/portfolio.php')) && !( isset($crum_theme_option['st_header']) && $crum_theme_option['st_header'] ) && ( reactor_option( '', '', '_page_layout_select' ) != 'full-width') ) { ?>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->
<?php }
}
add_action('reactor_page_header', 'reactor_do_page_header_title');


/**
 * Before sidebars shortcode
 *
 * @since 1.0.0
 */

function before_content_shortcode() {

	echo reactor_option( '','','_page_top_shortcode' );

}

add_action( 'reactor_content_before', 'before_content_shortcode' );


/**
 * Comments
 * in page.php
 *
 * @since 1.0.0
 */
function reactor_do_page_comments() {
    // If comments are open or we have at least one comment, load up the comment template
	if ( (is_page() || is_singular()) && ( comments_open() || '0' != get_comments_number() ) ) {
        comments_template('', true);
    }
}
/*
 * To open comments add action below to your functions php
 */

//add_action('reactor_page_after', 'reactor_do_page_comments', 1);


/**
 * Page Links
 * in the footer of format-page
 * 
 * @since 1.0.0
 */
function reactor_do_page_pagelinks() { 
	if ( !is_page_template() ) {
		wp_link_pages( array('before' => '<div class="page-links">' . __('Pages:', 'crum'), 'after' => '</div>') );
    }
}
add_action('reactor_page_footer', 'reactor_do_page_pagelinks');

/**
 * Page Edit 
 * in the footer of format-page
 * 
 * @since 1.0.0
 */
function reactor_do_page_edit() { 
	edit_post_link( __('Edit', 'crum'), '<div class="edit-link"><span>', '</span></div>');
}
//add_action('reactor_page_footer', 'reactor_do_page_edit');

/**
 * Page links 
 * after the loop in page templates
 * 
 * @since 1.0.0
 */
function reactor_do_page_links() {

	$meta_blog_pagination = reactor_option('','','blog_pagination_type');

    if (reactor_option('posts_list_pagination') && reactor_option('posts_list_pagination') == 'prev_next'){

        $pagination_type = 'prev_next';

    } elseif (reactor_option('posts_list_pagination') && reactor_option('posts_list_pagination') == 'load-more'){

        $pagination_type = 'load-more';

    } else{

        $pagination_type = 'numbered';

    }

	if (!($meta_blog_pagination == 'default')){
		$pagination_type = $meta_blog_pagination;
	}

	if ( is_page_template('page-templates/news-page.php') && current_theme_supports('reactor-page-links') ) {

		reactor_page_links( array('query' => 'newspage_query', 'type' => $pagination_type) );
	}
	elseif ( is_page_template('page-templates/portfolio.php') || is_tax('portfolio-category') || is_tax('portfolio-tag') && current_theme_supports('reactor-page-links') ) {

		$meta_folio_pagination = reactor_option('','','folio_pagination_type');

		if (reactor_option('portfolio_list_pagination') && reactor_option('portfolio_list_pagination') == 'prev_next'){

			$folio_pagination_type = 'prev_next';

		} elseif (reactor_option('portfolio_list_pagination') && reactor_option('portfolio_list_pagination') == 'load-more'){

			$folio_pagination_type = 'load-more';

		} else{

			$folio_pagination_type = 'numbered';

		}

		if (!($meta_folio_pagination == 'default')){
			$folio_pagination_type = $meta_folio_pagination	;
		}
			reactor_page_links( array('query' => 'portfolio_query', 'type' => $folio_pagination_type) );

	} elseif ( current_theme_supports('reactor-page-links') ) {
		reactor_page_links( array('type' => $pagination_type) );
	}

}
add_action('reactor_inner_content_after', 'reactor_do_page_links', 1);

/**
 * WooCommerce Wrappers
 * before and after the loop in WooCommerce templates
 * 
 * @since 1.0.1
 * @see http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 * 
 */

function reactor_woo_wrapper_start() { ?>
    <div class="row">
        <div class="<?php reactor_columns()?>">
<?php }

add_action('woocommerce_before_main_content', 'reactor_woo_wrapper_start', 10);

function reactor_woo_wrapper_end() { ?> 
        </div><!-- .columns -->
<?php }

add_action('woocommerce_after_main_content', 'reactor_woo_wrapper_end', 10);

function reactor_woo_after_sidebar() { ?> 
    </div><!-- .row -->
<?php }

add_action('woocommerce_sidebar', 'reactor_woo_after_sidebar', 999);
?>