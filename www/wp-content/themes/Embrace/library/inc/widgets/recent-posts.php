<?php
/**
 * Recent Posts widget w/ category exclude class
 * This allows specific Category IDs to be removed from the Sidebar Recent Posts list
 *
 * @link http://wordpress.org/support/topic/recent-posts-widget-with-category-exclude
 */
class WP_Widget_Recent_Posts_Exclude extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __("The most recent posts on your site", 'crum') );
		parent::__construct('crumina-widget-recent-posts', __('Crumina: Recent Posts', 'crum'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'crum') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
 		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];

		if(function_exists('pll_current_language')){
			$r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'category__not_in' => explode(',', $exclude), 'lang' => pll_current_language() ));
		} else {
			$r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'category__not_in' => explode(',', $exclude) ));
		}

		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<div class="tiny-post-list">
		<?php  while ($r->have_posts()) : $r->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" class="small-format mini-news clearfix">
				<div class="entry-body">

					<div class="entry-thumb">

						<?php
						if( has_post_thumbnail() ){
							$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
						} else {
							$image_url = get_template_directory_uri() . '/library/img/no-image/small.png';
						}
						$thumb = theme_thumb( $image_url, 70, 70, true );
						echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

						?>
						<div class="overlay"></div>
						<div class="links">
							<a href="<?php the_permalink(); ?>"><i class="crumicon-forward"></i></a>
						</div>

					</div>

					<h6 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h6>

					<?php
					$date = get_the_date();?>
                    <span class="post-date">
                    <?php
					echo $date;
					?>
                    </span>

				</div><!-- .entry-body -->
			</article><!-- #post -->

		<?php endwhile; ?>
		</div>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['exclude'] = ( $new_instance['exclude'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$exclude = isset($instance['exclude']) ? esc_attr( $instance['exclude'] ) : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'crum'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude Category(s):', 'crum'); ?></label> <input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name('exclude'); ?>" id="<?php echo $this->get_field_id('exclude'); ?>" class="widefat" />
			<br />
			<small><?php _e('Category IDs, separated by commas.', 'crum'); ?></small>
		</p>
<?php
	}
}

function WP_Widget_Recent_Posts_Exclude_init() {
    //unregister_widget('WP_Widget_Recent_Posts');
    register_widget('WP_Widget_Recent_Posts_Exclude');
}

add_action('widgets_init', 'WP_Widget_Recent_Posts_Exclude_init');

?>