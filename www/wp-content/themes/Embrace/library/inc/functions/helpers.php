<?php
/**
 * Clean Up WordPress Output
 *
 * @package Reactor
 * @since   1.0.0
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author  Eddie Machado (@eddiemachado / themeble.com/bones)
 * @link    http://codex.wordpress.org/Function_Reference/register_post_type#Example
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * 1. Head Clean Up
 * 2. remove WP version from RSS
 * 3. remove WP version from scripts
 * 4. remove injected CSS for recent comments widget
 * 5. remove injected CSS from gallery
 * 6. remove the p tags from around images
 * 7. Change the default excerpt more link
 * 8. Change the content more link
 * 9. Custom excerpt length
 * 10. Customize the output of captions
 * 11. Better Title Display in header.php
 * 12. Add the permalink to the end of an aside posts
 * 13. Add blockquote tags around quote posts
 * 14. Add flex-video div around video posts
 * 15. Changes the CSS for the admin bar on the front end
 * 16. Remove WP CSS for Admin Bar on front end
 * 17. Add classes to a single post
 * 18. Add classes to body tag
 * 19. Return dynamic sidebar content
 * 20. Change Sticky Class
 * 21. Add Comment Reply Class
 * 22. Exclude Front Page Posts
 * 23. Plugins helpers
 */

/**
 * The default wordpress head is
 * a mess. Let's clean it up by
 * removing all the junk we don't
 * need. -Bones
 */
add_action( 'after_setup_theme', 'reactor_wp_helpers', 15 );

if ( ! function_exists( 'reactor_wp_helpers' ) ) {
	function reactor_wp_helpers() {

		// remove WP version from RSS
		add_filter( 'the_generator', 'reactor_rss_version' );

		// creates a nicely formatted title in the header
		add_filter( 'wp_title', 'reactor_wp_title', 10, 2 );

		// remove injected css for recent comments widget
		add_filter( 'wp_head', 'reactor_remove_wp_widget_recent_comments_style', 1 );
		// clean up comment styles in the head
		add_action( 'wp_head', 'reactor_remove_recent_comments_style', 1 );
		// fixes CSS output for front end admin bar
		add_action( 'wp_head', 'reactor_admin_bar_fix', 5 );
		add_action( 'get_header', 'reactor_remove_admin_bar_css' );

		// adds class to body
		add_filter( 'body_class', 'reactor_topbar_body_class' );
		// Add specific CSS class by filter
		add_filter( 'body_class', 'crumina_header_class' );


		// change sticky class
		add_filter( 'post_class', 'reactor_change_sticky_class' );
		// adds class to single posts
		add_filter( 'post_class', 'reactor_single_post_class' );

		// cleaning up code around images
		add_filter( 'the_content', 'reactor_img_unautop', 30 );
		// add permalink to aside posts
		add_filter( 'the_content', 'reactor_add_link_to_asides', 9 );
		// add blockquote tag to quote posts
		add_filter( 'the_content', 'reactor_add_blockquote_to_quotes' );
		// add blockquote tag to quote posts
		//add_filter('the_content', 'reactor_add_flexvideo_to_videos');

		// changes excerpt more link
		add_filter( 'excerpt_more', 'reactor_excerpt_more' );
		// custom excerpt length
		add_filter( 'excerpt_length', 'reactor_excerpt_length', 999 );
		// changes content more link
		add_filter( 'the_content_more_link', 'reactor_content_more', 10, 2 );

		// add html5 captions
		add_filter( 'img_caption_shortcode', 'reactor_cleaner_caption', 10, 3 );

		// Add lightbox to link on images
		add_filter('wp_get_attachment_link', 'crum_addlightboxrel');

		// add comment reply class
		add_filter( 'comment_reply_link', 'reactor_comment_reply_class' );

		// do shortcodes in widgets
		add_filter( 'widget_text', 'do_shortcode' );

		// exclude front page posts
		add_action( 'pre_get_posts', 'exclude_category' );

		/* Filter the content of chat posts. */
		add_filter( 'the_content', 'my_format_chat_content' );

		/* Auto-add paragraphs to the chat text. */
		add_filter( 'my_post_format_chat_text', 'wpautop' );

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			//add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_second_product_thumbnail', 11);

			//add_filter( 'post_class', 'product_has_gallery' );

		}

	}
}


/**
 * 2. Remove WP version from RSS
 *
 * @since 1.0.0
 */
function reactor_rss_version() {
	return '';
}

/**
 * 3. Remove WP version from scripts
 *
 * @since 1.0.0
 */
function reactor_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', urlencode($src) );
	}

	return $src;
}

/**
 * 4. Remove injected CSS for recent comments widget
 *
 * @since 1.0.0
 */
function reactor_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

function reactor_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action(
			'wp_head', array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style'
			)
		);
	}
}

/**
 * 5. Remove injected CSS from gallery
 *
 * @since 1.0.0
 */
function reactor_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>( .*? )</style>!s", '', $css );
}

/**
 * 6. Remove the p tags from around images
 *
 * @link  http://blog.fublo.net/2011/05/wordpress-p-tag-removal/
 * @since 1.0.0
 */
function reactor_img_unautop( $content ) {
	$content = preg_replace( '/<p>\s*( <a .*> )?\s*( <img .* \/> )\s*( <\/a> )?\s*<\/p>/iU', '\1\2\3', $content );

	return $content;
}

/**
 * 7. Change the default excerpt more link
 *
 * @since 1.0.0
 */
function reactor_excerpt_more( $output ) {
	global $post;
	$readmore = reactor_option( 'post_readmore', __( 'Read more &raquo;', 'crum' ) );

	if (empty($readmore)){
		$readmore = __( 'Read more', 'crum' );
	}

	return '&hellip;  <div class="read-more-button"><a class="button" href="' . get_permalink( $post->ID ) . '" title="Read ' . get_the_title( $post->ID ) . '">' . $readmore . '</a></div>';
}

/**
 * 8. Change the content more link
 *
 * @since 1.0.0
 */
function reactor_content_more( $link, $link_text ) {
	global $post;
	$readmore = '<div class="read-more-button"><a class="button" href="' . get_permalink( $post->ID ) . '" title="Read ' . get_the_title( $post->ID ) . '">' . __( 'Read more', 'crum' ) . '</a></div>';

	return str_replace( $link_text, $readmore, $link );
}

/**
 * 9. Custom excerpt length
 *
 * @link  http://codex.wordpress.org/Function_Reference/the_excerpt#Control_Excerpt_Length_using_Filters
 * @since 1.0.0
 */
function reactor_excerpt_length( $length ) {
	$excerpt_length = reactor_option( 'excerpt_length', '45' );
	$excerpt_length = $excerpt_length ? $excerpt_length : '45';

	return $excerpt_length;
}

/**
 * 10. Customize the output of captions
 *
 * @since 1.0.0
 */
function reactor_cleaner_caption( $output, $attr, $content ) {
	if ( is_feed() ) {
		return $output;
	}
	$defaults = array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	);
	$attr     = shortcode_atts( $defaults, $attr );
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) {
		return $content;
	}
	$attributes = ' class="figure wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$output     = '<figure' . $attributes . '>';
	$output .= do_shortcode( $content );
	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}

/**
 * 11. Better Title Display in header.php
 * from TwentyTwelve theme
 *
 * @since 1.0.0
 */
function reactor_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'crum' ), max( $paged, $page ) );
	}

	return $title;
}

/**
 * 12. Add the permalink to the end of an aside posts
 *
 * @author Justin Tadlock
 * @link   http://justintadlock.com/archives/2012/09/06/post-formats-aside
 * @since  1.0.0
 */
function reactor_add_link_to_asides( $content ) {
	if ( has_post_format( 'aside' ) && ! is_singular() ) {
		$content .= ' <a href="' . get_permalink() . '" rel="bookmark" title="' . esc_attr( sprintf( the_title_attribute( 'echo=0' ) ) ) . '">&#8734;</a>';
	}

	return apply_filters( 'reactor_aside_format_link', $content );
}

/**
 * 13. Add blockquote tags around quote posts if not in the content
 *
 * @author Justin Tadlock
 * @link   http://justintadlock.com/archives/2012/08/27/post-formats-quote
 * @since  1.0.0
 */
function reactor_add_blockquote_to_quotes( $content ) {
	$post_meta = reactor_option( 'post_meta', 1 );
	global $post;
	$quote_source = get_post_meta( $post->ID, '_format_quote_source_name', true );
	if ( $post_meta && has_post_format( 'quote' ) ) {

		preg_match( '/<blockquote.*?>/', $content, $matches );
		if ( empty( $matches ) ) {
			$content = '<blockquote>' . $content .'<div class="quote-source">'.$quote_source.'</div>'. reactor_post_meta( $args = array(
					'show_tag'      => false,
					'show_icons'    => false,
					'show_comments' => true,
				) ).'</blockquote>';
		}
	}


	return apply_filters( 'reactor_quote_format_blockquote', $content );
}

/**
 * 14. Add flex-video div around video posts if not in the content
 *
 * @since 1.0.0
 */
function reactor_add_flexvideo_to_videos( $content ) {
	if ( has_post_format( 'video' ) ) {
		global $post;
		$post_meta = get_post_meta( $post->ID, '_format_video_embed', true );
		preg_match( '/<div.*?class="flex-video.*?>/', $content, $matches );
		if ( empty( $matches ) ) {
			$content = '<div class="flex-video">' . $content . '</div>';
		}
	}

	return apply_filters( 'reactor_add_flexvideo_to_videos', $content );
}

/**
 * 15. Changes the CSS for the admin bar on the front end
 *
 * @since 1.0.0
 */
function reactor_admin_bar_fix() {
	if ( ! is_admin() && is_admin_bar_showing() ) {
		$output = '<style type="text/css">' . "\n\t";
		$output .= 'body.admin-bar { padding-top: 32px; }' . "\n";
		$output .= '</style>' . "\n";
		echo $output;
	}
}

/**
 * 16. Remove default CSS for WP admin bar on front end
 *
 * @since 1.2.0
 */
function reactor_remove_admin_bar_css() {
	if ( ! is_admin() && is_admin_bar_showing() ) {
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

/**
 * 17. Add classes to a single post
 *
 * @link  http://codex.wordpress.org/Function_Reference/post_class#Add_Classes_By_Filters
 * @since 1.0.0
 */
function reactor_single_post_class( $classes ) {
	if ( is_single() ) {
		$classes[] = 'single';
	}
	if ( is_single() && 'portfolio' == get_post_type() ) {
		$classes[] = 'single';
		$classes[] .= 'single-portfolio';
	}
	$classes[] .= ' init ';

    if ( is_page() ) {
        $classes = array_diff( $classes, array( 'hentry' ) );
    }

	return $classes;
}

/**
 * 18. Add classes to body tag
 *
 * @since 1.0.0
 */
function reactor_topbar_body_class( $classes ) {
	if(reactor_option('top_panel', false)) {
		$classes[] = 'has-top-bar';
	}

	return $classes;
}

function crumina_header_class( $classes ) {
	if ( !(is_search()) ) {
		$custom_header_style = reactor_option('','','meta_header_style');
	}
	if ( isset($custom_header_style) && !($custom_header_style == '')) {
		$classes[] = $custom_header_style;
	} else {
		$classes[] = reactor_option( 'header-style', '' );
	}
	$classes[] = reactor_option( 'sticky_header', false ) ? 'fixed-header' : '';

	return $classes;
}

/**
 * 19. Return dynamic sidebar content
 * for some reason this isn't in WP
 *
 * @link  http://core.trac.wordpress.org/ticket/13169
 * @since 1.0.0
 */
function get_dynamic_sidebar( $index = 1 ) {
	$sidebar_contents = '';
	ob_start();
	dynamic_sidebar( $index );
	$sidebar_contents = ob_get_clean();

	return $sidebar_contents;
}

/**
 * 20. Change Sticky Class
 * sticky class on posts conflicts with Foundation js
 *
 * @since 1.0.0
 */
function reactor_change_sticky_class( $classes ) {
	$count = count( $classes );
	for ( $i = 0; $i < $count; $i ++ ) {
		if ( $classes[$i] == 'sticky' ) {
			$classes[$i] = 'sticky-post';
			$classes[]   = 'featured';
		}
	}

	return $classes;
}

/**
 * 21. Add Comment Reply Class
 * add the button class to the reply link in comments
 *
 * @since 1.0.0
 */
function reactor_comment_reply_class( $link ) {
	return str_replace( "class='comment-reply-link'", "class='comment-reply-link small'", $link );
}

/**
 * 22. Exclude Front Page Posts
 * If option is set in customizer to exlude front page posts
 * then remove them from the main query
 *
 * @since 1.0.0
 */
function exclude_category( $query ) {
	$exclude = ( reactor_option( 'frontpage_exclude_cat', 1 ) ) ? - reactor_option( 'frontpage_post_category', '' ) : '';
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'cat', $exclude );
	}
}


/*-----------------------------------------------------------------------------------*/
/* Adds a secondary image on product archives that is revealed on hover.
/* Perfect for displaying front/back shots of clothing and other products.
/*-----------------------------------------------------------------------------------*/

// Add class to products that have a gallery
function product_has_gallery( $classes ) {
	global $product;

	$post_type = get_post_type( get_the_ID() );

	if ( $post_type == 'product' ) {

		$attachment_ids = $product->get_gallery_attachment_ids();

		if ( $attachment_ids ) {
			$classes[] = 'prod-has-gallery';
		}
	}

	return $classes;
}
// Display the second thumbnails
function woocommerce_template_loop_second_product_thumbnail() {
	global $product, $woocommerce;

	$attachment_ids = $product->get_gallery_attachment_ids();

	if ( $attachment_ids ) {
		$secondary_image_id = $attachment_ids['0'];

		echo '<div class="secondary-image">'.wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => ' attachment-shop-catalog' ) ).'</div>';
	}
}


// Limit content function

function content( $num ) {
	$theContent = get_the_content();

	if ( ! $theContent ) {
		$theContent = get_the_excerpt();
	}
	$output  = preg_replace( '/<img[^>]+./', '', $theContent );
	$output  = preg_replace( '/<blockquote>.*<\/blockquote>/', '', $output );
	$output  = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );
	$output  = strip_tags( $output );
	$limit   = $num + 1;
	$content = explode( ' ', $output, $limit );
	array_pop( $content );
	$content = implode( " ", $content ) . "...";
	echo $content;
}

if ( function_exists( 'is_bbpress' ) ) {

    add_filter( 'bbp_no_breadcrumb', '__return_true' );

}

/*
 * Pages layout select function
 */

function set_layout( $page, $open = true, $page_lay = false ) {
	global $crum_theme_option;
	$page = $crum_theme_option[$page . "_layout"];

	if ( ( $page == "1col-fixed" && $page_lay == false ) || $page_lay == "1col-fixed" ) {
		$cr_layout = '';
		$cr_width  = '12';
	}
	if ( ( $page == "3c-l-fixed" && $page_lay == false ) || $page_lay == "3c-l-fixed" ) {
		$cr_layout = 'sidebar-left2';
		$cr_width  = '6';

	}
	if ( ( $page == "3c-r-fixed" && $page_lay == false ) || $page_lay == "3c-r-fixed" ) {
		$cr_layout = 'sidebar-right2';
		$cr_width  = '6';
	}
	if ( ( $page == "2c-l-fixed" && $page_lay == false ) || $page_lay == "2c-l-fixed" ) {
		$cr_layout = 'sidebar-left';
		$cr_width  = '9';
	}
	if ( ( $page == "2c-r-fixed" && $page_lay == false ) || $page_lay == "2c-r-fixed" ) {
		$cr_layout = 'sidebar-right';
		$cr_width  = '9';
	}
	if ( ( $page == "3c-fixed" && $page_lay == false ) || $page_lay == "3c-fixed" ) {
		$cr_layout = 'sidebar-both';
		$cr_width  = '6';
	}

	// Open content wrapper
	if ( $open ) {

		if ( $page_lay != "full-width" ) {
			echo '<div class="row">';
			echo '<div class="blog-section ' . $cr_layout . '">';
			echo '<section id="main-content" class="';
			reactor_columns( $cr_width );
			echo '">';
		}


		// Close content wrapper
	}
	else {


		if ( $page_lay != "full-width" ) {

			echo ' </section>';

			if ( ( ( $page == "2c-l-fixed" ) || ( $page == "3c-fixed" ) ) && $page_lay == false || ( $page_lay == "2c-l-fixed" ) || ( $page_lay == "3c-fixed" ) ) {
				get_template_part( 'sidebar', 'left' );
				echo ' </div>';
			}
			if ( ( $page == "3c-l-fixed" && $page_lay == false ) || $page_lay == "3c-l-fixed" ) {
				get_template_part( 'sidebar', 'right' );
				echo ' </div>';
				get_template_part( 'sidebar', 'left' );
			}
			if ( ( $page == "3c-r-fixed" && $page_lay == false ) || $page_lay == "3c-r-fixed" ) {
				get_template_part( 'sidebar', 'left' );
				echo ' </div>';
			}
			if ( ( ( $page == "2c-r-fixed" ) || ( $page == "3c-fixed" ) || ( $page == "3c-r-fixed" ) ) && $page_lay == false || ( $page_lay == "2c-r-fixed" ) || ( $page_lay == "3c-fixed" ) || ( $page_lay == "3c-r-fixed" ) ) {
				get_template_part( 'sidebar', 'right' );
			}
			if ( ( $page == "1col-fixed" && $page_lay == false ) || $page_lay == "1col-fixed" ) {
				echo ' </div>';
			}
		}
	}
}


/**
 * This function filters the post content when viewing a post with the "chat" post format.  It formats the
 * content with structured HTML markup to make it easy for theme developers to style chat posts.  The
 * advantage of this solution is that it allows for more than two speakers (like most solutions).  You can
 * have 100s of speakers in your chat post, each with their own, unique classes for styling.
 *
 * @author    David Chandra
 * @link      http://www.turtlepod.org
 * @author    Justin Tadlock
 * @link      http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 *
 * @param string $content               The content of the post.
 *
 * @return string $chat_output The formatted content of the post.
 */
function my_format_chat_content( $content ) {
	global $_post_format_chat_ids;

	/* If this is not a 'chat' post, return the content. */
	if ( ! has_post_format( 'chat' ) ) {
		return $content;
	}

	/* Set the global variable of speaker IDs to a new, empty array for this chat. */
	$_post_format_chat_ids = array();

	/* Allow the separator (separator for speaker/text) to be filtered. */
	$separator = apply_filters( 'my_post_format_chat_separator', ':' );

	/* Open the chat transcript div and give it a unique ID based on the post ID. */
	$chat_output = "\n\t\t\t" . '<div id="chat-transcript-' . esc_attr( get_the_ID() ) . '" class="chat-transcript">';

	/* Split the content to get individual chat rows. */
	$chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );

	/* Loop through each row and format the output. */
	foreach ( $chat_rows as $chat_row ) {

		/* If a speaker is found, create a new chat row with speaker and text. */
		if ( strpos( $chat_row, $separator ) ) {

			/* Split the chat row into author/text. */
			$chat_row_split = explode( $separator, trim( $chat_row ), 2 );

			/* Get the chat author and strip tags. */
			$chat_author = strip_tags( trim( $chat_row_split[0] ) );

			/* Get the chat text. */
			$chat_text = trim( $chat_row_split[1] );

			/* Get the chat row ID (based on chat author) to give a specific class to each row for styling. */
			$speaker_id = my_format_chat_row_id( $chat_author );

			/* Open the chat row. */
			$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

			/* Add the chat row author. */
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-author ' . sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) . ' vcard"><cite class="fn">' . apply_filters( 'my_post_format_chat_author', $chat_author, $speaker_id ) . '</cite>' . $separator . '</div>';

			/* Add the chat row text. */
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace(
					array(
						"\r",
						"\n",
						"\t"
					), '', apply_filters( 'my_post_format_chat_text', $chat_text, $chat_author, $speaker_id )
				) . '</div>';

			/* Close the chat row. */
			$chat_output .= "\n\t\t\t\t" . '</div><!-- .chat-row -->';
		}

		/**
		 * If no author is found, assume this is a separate paragraph of text that belongs to the
		 * previous speaker and label it as such, but let's still create a new row.
		 */
		else {

			/* Make sure we have text. */
			if ( ! empty( $chat_row ) ) {

				/* Open the chat row. */
				$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

				/* Don't add a chat row author.  The label for the previous row should suffice. */

				/* Add the chat row text. */
				$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace(
						array(
							"\r",
							"\n",
							"\t"
						), '', apply_filters( 'my_post_format_chat_text', $chat_row, $chat_author, $speaker_id )
					) . '</div>';

				/* Close the chat row. */
				$chat_output .= "\n\t\t\t</div><!-- .chat-row -->";
			}
		}
	}

	/* Close the chat transcript div. */
	$chat_output .= "\n\t\t\t</div><!-- .chat-transcript -->\n";

	/* Return the chat content and apply filters for developers. */

	return apply_filters( 'my_post_format_chat_content', $chat_output );
}

/**
 * This function returns an ID based on the provided chat author name.  It keeps these IDs in a global
 * array and makes sure we have a unique set of IDs.  The purpose of this function is to provide an "ID"
 * that will be used in an HTML class for individual chat rows so they can be styled.  So, speaker "John"
 * will always have the same class each time he speaks.  And, speaker "Mary" will have a different class
 * from "John" but will have the same class each time she speaks.
 *
 * @author    David Chandra
 * @link      http://www.turtlepod.org
 * @author    Justin Tadlock
 * @link      http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link      http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 *
 * @param string $chat_author           Author of the current chat row.
 *
 * @return int The ID for the chat row based on the author.
 */
function my_format_chat_row_id( $chat_author ) {
	global $_post_format_chat_ids;

	/* Let's sanitize the chat author to avoid craziness and differences like "John" and "john". */
	$chat_author = strtolower( strip_tags( $chat_author ) );

	/* Add the chat author to the array. */
	$_post_format_chat_ids[] = $chat_author;

	/* Make sure the array only holds unique values. */
	$_post_format_chat_ids = array_unique( $_post_format_chat_ids );

	/* Return the array key for the chat author and add "1" to avoid an ID of "0". */

	return absint( array_search( $chat_author, $_post_format_chat_ids ) ) + 1;
}


// Add/Remove Contact Methods
function add_remove_contactmethods( $contactmethods ) {

	$contactmethods['twitter']     = 'Twitter';
	$contactmethods['googleplus']  = 'Google Plus';
	$contactmethods['linkedin']    = 'Linked In';
	$contactmethods['vimeo']       = 'Vimeo';
	$contactmethods['lastfm']      = 'LastFM';
	$contactmethods['tumblr']      = 'Tumblr';
	$contactmethods['skype']       = 'Skype';
	$contactmethods['cr_facebook'] = 'Facebook';
	$contactmethods['deviantart']  = 'Deviantart';
	$contactmethods['vkontakte']   = 'Vkontakte';
	$contactmethods['picasa']      = 'Picasa';
	$contactmethods['linkedin']    = 'Linkedin';
	$contactmethods['wordpress']   = 'Wordpress';
	$contactmethods['instagram']   = 'Instagram';

	// Remove Contact Methods
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );

	return $contactmethods;
}

add_filter( 'user_contactmethods', 'add_remove_contactmethods', 10, 1 );








// thumbnail resizes
if(!function_exists('theme_thumb')):
    function theme_thumb( $url, $width, $height = 0, $crop, $align = '' ) {
	    if ( extension_loaded('gd') ) {
		    return mr_image_resize( $url, $width, $height, $crop, $align, false );
	    } else {
		    return $url;
	    }
    }
endif;
function crum_int_image( $id, $width, $height = 0, $crop, $align = '' ) {
    $url = wp_get_attachment_url( $id );

	if ( extension_loaded('gd') ) {
		return mr_image_resize( $url, $width, $height, $crop, $align );
	} else {
		return $url;
	}
}


add_filter( 'widget_tag_cloud_args', 'crumina_set_number_tags' );
function crumina_set_number_tags( $args ) {
    $args = array( 'smallest' => 10, 'largest' => 10 );

    return $args;
}

/*********************************************************************
 *-------------Function for conversion hex colors to rgb---------------
 **********************************************************************/

if ( ! function_exists( 'ultimate_hex2rgb' ) ) {
    function ultimate_hex2rgb( $hex, $opacity = 1 ) {
        $hex = str_replace( "#", "", $hex );

        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        }
        else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        $rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';

        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgba; // returns an array with the rgb values
    }
}


function crum_addlightboxrel($content) {
    global $post;
    $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replacement = '<a$1href=$2$3.$4$5 class="magnific-gallery" title="'.$post->post_title.'"$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}



/*---------------------------------------------------
 *
 *  WOO COMMERCE FUNCTIONS
 *
 ---------------------------------------------------*/


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10, 0 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10, 0 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );

// Change number or products per row to 3
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

// Per Page Dropdown
function woocommerce_crum_show_product_perpage() {
	$per_page = '9';

	if ( isset( $_REQUEST['per_page'] ) ) {
		$woo_per_page = $_REQUEST['per_page'];
	}
	elseif ( ! isset( $_REQUEST['per_page'] ) && isset( $_COOKIE['per_page'] ) ) {
		$woo_per_page = $_COOKIE['per_page'];
	}
	else {
		$woo_per_page = $per_page;
	}

	?>
	<form class="woocommerce-ordering" method="post">
		<select name="per_page" class="per_page" onchange="this.form.submit()">
			<?php
			$x = 1;
			while ( $x <= 5 ) {
				$value    = $per_page * $x;
				$selected = selected( $woo_per_page, $value, false );
				$label    = __( "Display {$value} Products Per Page", 'crum' );
				echo "<option value='{$value}' {$selected}>{$label}</option>";
				$x ++;
			}
			?>
		</select>
	</form>
<?php
}

// Products per page
function woocommerce_crum_products_per_page() {
	$per_page = '9';
	if ( isset( $_COOKIE['per_page'] ) ) {
		$per_page = $_COOKIE['per_page'];
	}
	if ( isset( $_POST['per_page'] ) ) {
		setcookie( 'per_page', $_POST['per_page'], time() + 1209600, '/' );
		$per_page = $_POST['per_page'];
	}

	return $per_page;
}

function woocommerce_crum_toggle_view() {
	?>
	<nav class="gridlist-toggle">
		<a href="#" id="grid" title="<?php _e( 'Grid view', 'crum' ); ?>"><i class="crumicon-layout"></i></a>
		<a href="#" id="list" title="<?php _e( 'List view', 'crum' ); ?>"><i class="crumicon-list"></i></a>
	</nav>

<?php
}

function woocommerce_crum_add_more() {

	echo '<a href="' . get_permalink() . '" class="datails" > ' . __( 'Details', 'crum' ) . ' </a>';
}
function crum_woocommerce_single_subtitle() {
        global $product;
        $categ = $product->get_categories();
        $term = get_term_by('name', strip_tags($categ), 'product_cat');
     if ($term) {
        echo '<span class="prod-cat">' . $term->name . '</span>';
    }
    echo '<div class="clear"></div>';
}
function crum_woocommerce_prev_next() { ?>
    <nav class="nav-buttons">

				<span class="nav-previous">
            		<?php previous_post_link('%link', '<i class="crumicon-arrow-left"></i>', false); ?>
            	</span>
                <span class="nav-next">
            		<?php next_post_link('%link', '<i class="crumicon-arrow-right"></i>', false); ?>
            	</span>
        <!-- .nav-single -->
    </nav>
    <?php
}


/*Loop modifications*/

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 3 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_crum_add_more', 5 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_crum_toggle_view', 30 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_crum_show_product_perpage', 25 );

add_filter( 'loop_shop_per_page', 'woocommerce_crum_products_per_page', 9 );


add_filter( 'woocommerce_product_tabs', 'crum_remove_product_tabs', 98 );

function crum_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;

}

/*Single item page modifications*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 2 );
add_action( 'woocommerce_before_single_product_summary', 'crum_woocommerce_single_subtitle', 3 );
add_action( 'woocommerce_before_single_product_summary', 'crum_woocommerce_prev_next', 1 );

add_action( 'woocommerce_single_product_summary', 'the_content', 20 );

add_filter( 'woocommerce_output_related_products_args', 'crum_related_products_args' );
function crum_related_products_args( $args ) {

    $args['posts_per_page'] = 3; // 4 related products
    $args['columns'] = 3; // arranged in 2 columns
    return $args;
}

add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
/**
 * Remove WooCommerce Generator tag, styles, and scripts from the homepage.
 * Tested and works with WooCommerce 2.0+
 *
 * @author Greg Rickaby
 * @since  2.0.0
 */
function child_manage_woocommerce_styles() {
	if ( class_exists('WooCommerce') ) {
		remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		if ( ( function_exists( 'is_woocommerce' ) ) && ( is_woocommerce() || is_page( 'store' ) || is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() ) ) {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'prettyPhoto-init' );

		}
	}
}

/**
 * Define image sizes
 */
/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	add_action( 'init', 'crumina_woocommerce_image_dimensions', 1 );
}

function crumina_woocommerce_image_dimensions() {
	$catalog = array(
		'width'  => '300', // px
		'height' => '300', // px
		'crop'   => 0 // true
	);

	$single = array(
		'width'  => '418', // px
		'height' => '418', // px
		'crop'   => 0 // true
	);

	$thumbnail = array(
		'width'  => '200', // px
		'height' => '200', // px
		'crop'   => 1 // false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
	update_option( 'shop_single_image_size', $single ); // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
}

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;

    ob_start(); ?>

    <a class="cd-img-replace" href="#cart"><i class="crumicon-bag"></i><span class="count"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>

    <?php

    $fragments['a.cd-img-replace'] = ob_get_clean();

    ob_start(); ?>

    <div id="cd-cart-inner">
        <ul class="cd-cart-items">

            <?php if (sizeof(WC()->cart->get_cart()) > 0) : ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {

                        $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                        ?>
                        <li>
                            <a href="<?php echo get_permalink($product_id); ?>">
                                <?php echo str_replace(array('http:', 'https:'), '', $thumbnail) . $product_name; ?>
                            </a>
                        </li>
                    <?php
                    }
                }
            else : ?>

                <li class="empty"><?php _e('No products in the cart.', 'woocommerce'); ?></li>

            <?php endif; ?>

        </ul>
        <!-- end product list -->

        <?php if (sizeof(WC()->cart->get_cart()) > 0) : ?>

            <div class="cd-cart-total">
                <p class="total"><strong><?php _e('Subtotal', 'woocommerce'); ?>
                        :</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
            </div> <!-- cd-cart-total -->
            <a href="<?php echo WC()->cart->get_checkout_url(); ?>"
               class="checkout-btn"><?php _e('Checkout', 'woocommerce'); ?></a>
            <p class="cd-go-to-cart">
                <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e('View Cart', 'woocommerce'); ?></a>
            </p>


        <?php endif; ?>
    </div>
    <?php

    $fragments['#cd-cart-inner'] = ob_get_clean();

    return $fragments;
}

if (function_exists('vc_map_update')){
	$settings = array(
		"as_parent"               =>
			array(
				'only' => 'client, vc_column_text, vc_single_image, vc_text_separator, vc_cta_button2, vc_video, vc_button2, ult_countdown, icon_counter,
								heading, bsf-info-box, ultimate_info_table, just_icon, ultimate_pricing, pricing_table, qr_code, stat_counter, testimonial'
			),
	);

	vc_map_update('vc_tab', $settings);
}

//Add custom meta field to category edit page

// Edit term page
if (!function_exists('crum_category_custom_field')){
	function crum_category_custom_field($term) {

		// put the term ID into a variable
		$t_id = $term->term_id;

		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" );
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_meta[custom_category_bg_image]"><?php _e( 'Custom header background', 'crum' ); ?></label></th>
			<td>
				<input type="text" class="edit-menu-item-_crum_mega_menu_image" name="term_meta[custom_category_bg_image]" id="term_meta[custom_category_bg_image]" value="<?php echo esc_attr( $term_meta['custom_category_bg_image'] ) ? esc_attr( $term_meta['custom_category_bg_image'] ) : ''; ?>">
				<p class="description"><?php _e( 'Select custom background image for category header','crum' ); ?></p>
			</td>
		</tr>
	<?php
	}
	add_action( 'category_edit_form_fields', 'crum_category_custom_field', 10, 2 );
	add_action( 'product_cat_edit_form_fields', 'crum_category_custom_field', 10, 2 );
}

//Save field value
if (!function_exists('save_taxonomy_custom_meta')) {
	function save_taxonomy_custom_meta( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id      = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys  = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][ $key ] ) ) {
					$term_meta[ $key ] = $_POST['term_meta'][ $key ];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	}

	add_action( 'edited_category', 'save_taxonomy_custom_meta', 10, 2 );
	add_action( 'create_category', 'save_taxonomy_custom_meta', 10, 2 );
	add_action( 'created_term', 'save_taxonomy_custom_meta', 10, 3 );
	add_action( 'edit_term', 'save_taxonomy_custom_meta', 10, 3 );
}

if ( ! ( function_exists( 'crum_update_fonts' ) ) ) {
	function crum_update_fonts() {

		$is_updated = get_option( 'crum_is_font_updated' );

		$old_font_path = wp_upload_dir();
		$old_font_dir  = $old_font_path['basedir'] . '/embrace_fonts/picons';

		if ( is_dir( $old_font_dir ) && ( $is_updated == false ) ) {

			$fonts = get_option( 'embrace_fonts' );

			if ( ! isset( $fonts['picons'] ) || ( $fonts['picons'] == '' ) ) {
				$fonts['picons'] = array(
					'include' => 'embrace_fonts/picons/',
					'folder'  => 'embrace_fonts/picons/',
					'style'   => 'picons' . '/' . 'picons' . '.css',
					'config'  => 'charmap.php'
				);
			}
			update_option( 'embrace_fonts', $fonts );
			update_option( 'crum_is_font_updated', 1 );
		}
	}

	add_action( 'admin_init', 'crum_update_fonts' );
}

function crumina_redefine_vc_params() {

	if ( class_exists( 'WPBMap' ) ) {
		if ( function_exists( 'vc_update_shortcode_param' ) ) {

			$vc_single_image_size_std = WPBMap::getParam( 'vc_single_image', 'img_size' );
			$vc_single_image_size_std['value'] = 'full';
			vc_update_shortcode_param( 'vc_single_image', $vc_single_image_size_std );

		}
	}
}
add_action( 'vc_after_init', 'crumina_redefine_vc_params' );

if(!(function_exists('crum_typography_option'))){
	function crum_typography_option($option_name, $tag){

		$custom_css = '';

		$crum_theme_option = get_option('crum_theme_option');
		$tag_typography = $crum_theme_option[$option_name];
		if(isset($tag_typography) && !(empty($tag_typography))){

			$custom_css .= $tag.'{';

			if(isset($tag_typography['font-family']) && !(empty($tag_typography['font-family']))){
				$custom_css .= 'font-family:'.$tag_typography['font-family'].'; ';
			}

			if(isset($tag_typography['font-backup']) && !(empty($tag_typography['font-backup']))){
				$custom_css .= 'font-family:'.$tag_typography['font-backup'].'; ';
			}

			if(isset($tag_typography['font-weight']) && !(empty($tag_typography['font-weight']))){
				$custom_css .= 'font-weight:'.$tag_typography['font-weight'].'; ';
			}

			if(isset($tag_typography['font-style']) && !(empty($tag_typography['font-style']))){
				$custom_css .= 'font-style:'.$tag_typography['font-style'].'; ';
			}

			if(isset($tag_typography['font-size']) && !(empty($tag_typography['font-size']))){
				$custom_css .= 'font-size:'.$tag_typography['font-size'].'; ';
			}

			if(isset($tag_typography['font-color']) && !(empty($tag_typography['font-color']))){
				$custom_css .= 'font-color:'.$tag_typography['font-color'].'; ';
			}

			$custom_css .= '}';

		}

		return $custom_css;

	}
}
