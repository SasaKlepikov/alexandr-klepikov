<?php
/**
 * Reactor Post Meta
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @credit TewentyTwelve Theme
 * @usees $post
 * @param $args Optional. Override defaults.
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Meta information for current post: categories, tags, author, and date
 */
if ( !function_exists('reactor_post_meta') ) {
	function reactor_post_meta( $args = '' ) {

		do_action('reactor_post_meta', $args);

		global $post; $meta = ''; $output = '';

		$defaults = array(
			'show_author'        => true,
			'show_date'          => true,
			'show_cat'           => true,
			'show_tag'           => true,
			'show_icons'         => false,
			'show_uncategorized' => false,
			'show_comments'      => false,
		);
		$args = wp_parse_args( $args, $defaults );

		if ( 'portfolio' == get_post_type() ) {
			$categories_list = get_the_term_list( $post->ID, 'portfolio-category', '', ', ', '' );
		} else {
			// $categories_list = get_the_category_list(', ');
			$count = 0;
			$categories_list = '';
			$categories = get_the_category();
			foreach ( $categories as $category ) {
				$count++;
				if ( $args['show_uncategorized'] ) {
					$categories_list .= '<a href="' . get_category_link( $category->term_id ) . '" title="'.sprintf( __('View all posts in %s', 'crum'), $category->name ) . '">' . $category->name . '</a>';
					if ( $count != count( $categories ) ){
						$categories_list .= ', ';
					}
				} else {
					if ( $category->slug != 'uncategorized' || $category->name != 'Uncategorized' ) {
						$categories_list .= '<a href="' . get_category_link( $category->term_id ) . '" title="'.sprintf( __('View all posts in %s', 'crum'), $category->name ) . '">' . $category->name . '</a>';
						if ( $count != count( $categories ) ){
							$categories_list .= ', ';
						}
					}
				}

			}
		}

		if ( 'portfolio' == get_post_type() ) {
			$tag_list = get_the_term_list( $post->ID, 'portfolio-tag', '', ', ', '' );
		} else {
			$tag_list = get_the_tag_list( '', ', ', '' );
		}

		$date = sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>',
			esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ),
			esc_attr( sprintf( __('View all posts from %s %s', 'crum'), get_the_time('M'), get_the_time('Y') ) ),
			esc_attr( get_the_date('c') ),
			esc_html( get_the_date() )
		);

		$author = sprintf('<span class="author"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta('ID') ) ),
			esc_attr( sprintf( __('View all posts by %s', 'crum'), get_the_author() ) ),
			get_the_author()
		);

		$comments = get_comments_number();

		if ( $comments == 0 ) {
			$num_comments = __('No Comments');
		} elseif ( $comments > 1 ) {
			$num_comments = $comments . __(' Comments');
		} else {
			$num_comments = __('1 Comment');
		}

		$comments_link = get_comments_link();

		/**
		 * 1 is category, 2 is tag, 3 is the date and 4 is the author's name
		 */
		if ( $date || $categories_list || $author || $tag_list  ) {
			if ( $args['show_icons'] ) {
				$meta .= ( $author && $args['show_author'] ) ? '<i class="crum-icon crum-user" title="Written by"></i> <span class="by-author">%4$s</span>' : '';
				$meta .= ( $date && $args['show_date'] ) ? '<i class="crum-icon crum-calendar" title="Publish on"></i> <span class="post-date">%3$s</span>' : '';
				$meta .= ( $categories_list && $args['show_cat'] ) ? '<i class="crum-icon crum-folder-open" title="Posted in"></i><span class="entry-categories">%1$s</span>' : '';
				$meta .= ( $tag_list && $args['show_tag'] ) ? '<i class="crum-icon crum-tags" title="Tagged with"></i><span class="entry-tags">%2$s</span>' : '';

				if ( $meta ) {
					$output = '<span class="entry-meta icons">' . $meta . '</span>';
				}
			} else {
				$meta .= ( $date && $args['show_date'] ) ? '<span>%3$s</span>' : '';
				$meta .= ( $author && $args['show_author'] ) ? '<span class="post-author">'. __('Posted by', 'crum') . ' <span class="by-author">%4$s</span></span>' : '';
				if ( comments_open() ) {
					if ( is_single() ) {
						$meta .= ( $comments && $args['show_comments'] ) ? '<span>%5$s</span>' : '';
					} else {
						$meta .= ( $comments && $args['show_comments'] ) ? '<span><a href="' . $comments_link . '">%5$s</a></span>' : '';
					}
				}
				$meta .= ( $categories_list && $args['show_cat'] ) ?  '<span class="entry-categories">' .__('in', 'crum') . ' %1$s ' .'</span>' : '';
				$meta .= ( $tag_list && $args['show_tag'] ) ? '<span class="entry-tags">' . __('Tags:', 'crum') . ' %2$s</span>' : '';


				if ( $meta ) {
					$output = '<span class="entry-meta">' . $meta . '</span>';
				}
			}

			$post_meta = sprintf( $output, $categories_list, $tag_list, $date, $author, $num_comments);

			if (has_post_format('quote')){
				return $post_meta;
			}

			echo apply_filters('reactor_post_meta', $post_meta, $defaults);
		}
	}
}