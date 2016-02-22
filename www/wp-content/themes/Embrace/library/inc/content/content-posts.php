<?php
/**
 * Post Content
 * hook in the content for post formats
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */


/**
 * Post featured tag
 * in format-standard
 *
 * @since 1.0.0
 */
function reactor_do_reactor_post_bookmarks() {
	$format      = ( get_post_format( get_the_ID() ) ) ? get_post_format( get_the_ID() ) : 'standard';
	if ( (!is_single())  && reactor_option('news_bookmarks', '1') && (( $format == 'image' ) || ( $format == 'gallery' ) || ( $format == 'video' ) || has_post_thumbnail())) {

		echo '<div class="bookmarks">';

		if (reactor_option( 'news_bookmarks_date', true )) {
			echo '<div class="data">';
			echo '<span class="month">'.date_i18n( 'M', strtotime( get_the_date() ) ).'</span>';
			echo '<span class="day">'.date_i18n( 'd', strtotime( get_the_date() ) ).'</span>';
			echo '</div>';

		}

		if ( is_sticky() ) {
			echo'<div class="entry-icon"><i class="crum-icon crum-star"></i></div>';
		}
		elseif ( reactor_option( 'tumblog_icons', true ) && reactor_option( 'news_bookmarks_icon', true ) ) {
			echo reactor_tumblog_icon($args = array('link' => false));
		}
		if (reactor_option( 'news_bookmarks_avatar', true )) {
			echo get_avatar( get_the_author_meta( 'ID' ), 60 );
		}

		echo '</div>';
	}
}
add_action('reactor_post_bookmarks', 'reactor_do_reactor_post_bookmarks', 1);


/**
 * Post thumbnail
 * in format-standard
 *
 * @since 1.0.0
 */
function reactor_do_standard_thumbnail() {
	$link_titles = reactor_option( 'frontpage_link_titles', 1 );
	$format      = ( get_post_format( get_the_ID() ) ) ? get_post_format( get_the_ID() ) : 'standard';

	if (( $format != 'image' ) && ( $format != 'gallery' ) && ($format != 'video') &&!($format == 'audio')) {
		if ( has_post_thumbnail() ) {
			$url          = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			$url          = $url[0];
			$thumb_width  = reactor_option( false, false, '_cr_post_thumb_width' ) ? reactor_option( false, false, '_cr_post_thumb_width' ) : reactor_option( 'post_thumbnails_width', '300' );;
			$thumb_height = reactor_option( false, false, '_cr_post_thumb_height' ) ? reactor_option( false, false, '_cr_post_thumb_height' ) : reactor_option( 'post_thumbnails_height', '900' );
			$thumb_crop   = reactor_option( 'thumb_image_crop', 1 );
			$thumb_inner  = reactor_option( 'thumb_inner_disp', false );
			?>


			<?php if ( is_single() && $thumb_inner) {
				echo '<div class="entry-thumbnail">';
				echo '<img src ="' . $url . '" class="lazyload" data-src="'.$url.'" alt="' . get_the_title() . '">';
				echo '</div>';
			} elseif ( !is_single() && !$link_titles ) {
				echo '<div class="entry-thumbnail">';
				echo '<img src ="' . theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ) . ' class="lazyload" data-src="'.theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ).'" " alt="' . get_the_title() . '">';
				echo '</div>';
			} elseif (! is_single()) { ?>
				<?php echo '<div class="entry-thumbnail">'; echo '<img src ="' . theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ) . '" class="lazyload" data-src="'.theme_thumb( $url, $thumb_width, $thumb_height, $thumb_crop ).'" alt="' . get_the_title() . '">';  ?>
				<div class="overlay"></div>
				<div class="links"><a href="<?php the_permalink(); ?>" class="link" rel="bookmark" title="<?php the_title_attribute(); ?>"><i class="crumicon-forward"></i></a></div>
				<?php echo '</div>'; } ?>

		<?php
		}
	}
}
add_action('reactor_post_header', 'reactor_do_standard_thumbnail', 1);




/**
 * Post header
 * in format-standard
 *
 * @since 1.0.0
 */
function reactor_do_standard_header_titles() {
	$post_meta = reactor_option( 'post_meta', 1 );
	if ( is_single() ) {
		?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php    if ( $post_meta ) {
			echo '<div class="inner">';
			reactor_post_meta( $args = array(
				'show_tag'      => false,
				'show_icons'    => false,
				'show_comments' => true,
			) );
			echo '</div>';
		}?>
	<?php } else { ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
	<?php
	}
}

add_action( 'reactor_post_header', 'reactor_do_standard_header_titles', 5 );


/**
 * Post meta
 * in all formats
 *
 * @since 1.0.0
 */
function reactor_do_post_meta() {
	$post_meta = reactor_option( 'post_meta', 1 );

	if ( $post_meta && ( ! is_single() ) && !has_post_format('quote')) {
		reactor_post_meta( $args = array(
			'show_tag'      => false,
			'show_icons'    => false,
			'show_comments' => true,
		) );

	}
}
add_action('reactor_post_header', 'reactor_do_post_meta', 6);


/**
 * Page Links
 * in the footer of format-page
 *
 * @since 1.0.0
 */
function reactor_do_post_pagelinks() {
	wp_link_pages( array('before' => '<div class="page-links">' . __('Pages:', 'crum'), 'after' => '</div>') );
}
add_action('reactor_post_footer', 'reactor_do_post_pagelinks',1);


/**
 * Post footer meta
 * in all formats
 *
 * @since 1.0.0
 */
function reactor_do_footer_post_meta() {

	$post_meta = reactor_option('post_meta', 1);

	if ( $post_meta &&  is_single() ) {
		echo '<div class="inner">';
		reactor_post_meta($args = array(
			'show_author'        => false,
			'show_date'          => false,
			'show_cat'           => false,
			'show_icons'         => false,
		));
		echo '</div>';
	}
}
add_action('reactor_post_footer', 'reactor_do_footer_post_meta', 5);





/**
 * Post footer edit
 * in single.php
 *
 * @since 1.0.0
 */
function reactor_do_post_edit() {
	if ( is_single() ) {
		edit_post_link( __('Edit', 'crum'), '<div class="edit-link"><span>', '</span></div>');
	}
}
add_action('reactor_post_footer', 'reactor_do_post_edit', 4);

/**
 * Single post nav
 * in single.php
 *
 * @since 1.0.0
 */
function reactor_do_nav_single() {
	if ( is_single() ) {
		$exclude = ( reactor_option('frontpage_exclude_cat', 1) ) ? reactor_option('frontpage_post_category', '') : ''; ?>
		<nav class="nav-single">
            <span class="nav-previous alignleft">
            <?php previous_post_link('%link', '<span data-tooltip class="meta-nav has-tip tip-right radius"  title="%title">' . _x('<i class="crum-icon crum-arrow-left"></i>', 'Previous post link', 'crum') . '</span>', false, $exclude); ?>
            </span>
            <span class="nav-next alignright">
            <?php next_post_link('%link', '<span data-tooltip class="meta-nav has-tip tip-left radius"  title="%title">' . _x('<i class="crum-icon crum-arrow-right"></i>', 'Next post link', 'crum') . '</span>', false, $exclude); ?>
            </span>
		</nav><!-- .nav-single -->
	<?php }
}
add_action('reactor_post_after', 'reactor_do_nav_single', 1);


/**
 * Share post on social
 * in single.php
 *
 * @since 1.0.0
 */
function reactor_share_post() {
	if ( is_single() ) {
		global $post;

		$url = get_permalink( $post->ID );
		?>


        <div class="share-post-wrapper">

	        <div id="social-share" data-directory="<?php echo get_template_directory_uri(); ?>">
		        <span><a href="#"><i class="soc-icon soc-twitter"></i></a></span> <span><a href="#"><i class="soc-icon soc-facebook"></i></a></span> <span><a href="#"><i class="soc-icon soc-google"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-pinterest"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-linkedin"></i></a></span> <span><a href="#" ><i class="soc-icon soc-stumbleupon"></i></a></span> <span><a href="#"  ><i class="soc-icon soc-digg"></i></a></span>
	        </div>
            <div class="share-post"><i class="crumicon-share "></i><?php _e('Share in social networks','crum');?></div>

        </div>

	<?php
	}
}

add_action('reactor_post_footer', 'reactor_share_post', 6);

/**
 *  Author box
 * in single.php
 *
 * @since 1.0.0
 */
function reactor_do_author_box() {

	$autor_box_disp = reactor_option( 'autor_box_disp', 1 );

	if ( is_singular( 'post' ) && $autor_box_disp ) { ?>

		<div class="about-author">
			<figure class="author-photo">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 73 ); ?>
			</figure>

			<div class="info-wrap">
				<div class="author-name"><?php the_author_posts_link(); ?>
					</div>

				<div class="share-icons">
					<?php if ( get_the_author_meta( 'twitter' ) ) {
						echo '<a href="', the_author_meta( 'twitter' ), '"><i class="soc-icon soc-twitter"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'cr_facebook' ) ) {
						echo '<a href="', the_author_meta( 'cr_facebook' ), '"><i class="soc-icon soc-facebook"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'googleplus' ) ) {
						echo '<a href="', the_author_meta( 'googleplus' ), '"><i class="soc-icon soc-google"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'linkedin' ) ) {
						echo '<a  href="', the_author_meta( 'linkedin' ), '"><i class="soc-icon soc-linkedin"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'vimeo' ) ) {
						echo '<a  href="', the_author_meta( 'vimeo' ), '"><i class="soc-icon soc-vimeo"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'lastfm' ) ) {
						echo '<a  href="', the_author_meta( 'lastfm' ), '"><i class="soc-icon soc-lastfm"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'tumblr' ) ) {
						echo '<a  href="', the_author_meta( 'tumblr' ), '"><i class="soc-icon soc-tumblr"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'skype' ) ) {
						echo '<a  href="', the_author_meta( 'skype' ), '"><i class="soc-icon soc-skype"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'vkontakte' ) ) {
						echo '<a  href="', the_author_meta( 'vkontakte' ), '"><i class="soc-icon soc-vkontakte"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'deviantart' ) ) {
						echo '<a  href="', the_author_meta( 'deviantart' ), '"><i class="soc-icon soc-deviantart"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'picasa' ) ) {
						echo '<a  href="', the_author_meta( 'picasa' ), '"><i class="soc-icon soc-picasa"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'wordpress' ) ) {
						echo '<a  href="', the_author_meta( 'wordpress' ), '"><i class="soc-icon soc-wordpress"></i></a>';
					} ?>
					<?php if ( get_the_author_meta( 'instagram' ) ) {
						echo '<a  href="', the_author_meta( 'instagram' ), '"><i class="soc-icon soc-instagram"></i></a>';
					} ?>
				</div>
			</div>

			<div class="ovh">
				<div class="author-description">
					<p><?php the_author_meta( 'description' ); ?></p>
				</div>
			</div>
		</div>

	<?php
	}
}

add_action( 'reactor_post_after', 'reactor_do_author_box', 3 );



/**
 * Comments
 * in single.php
 *
 * @since 1.0.0
 */
function reactor_do_post_comments() {
	// If comments are open or we have at least one comment, load up the comment template
	if ( is_single() && ( comments_open() || '0' != get_comments_number() ) ) {
		comments_template('', true);
	}
}
add_action('reactor_post_after', 'reactor_do_post_comments', 5);

/**
 * No posts format
 * loop else in page templates
 *
 * @since 1.0.0
 */
function reactor_do_loop_else() {
	get_template_part('post-formats/format', 'none');
}
add_action('reactor_loop_else', 'reactor_do_loop_else', 1);


