<?php
/**
 * Tag cloud widget class
 *
 * @since 2.8.0
 */
class Crumina_Tag_Cloud_Widget extends WP_Widget {


	public function __construct(){
		parent::__construct(
			'crumina_widget_tag_cloud',
			'Crumina: Tag cloud',
			array('description' => __('A cloud of your most used tags.','crum'))
		);
	}

	public function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		$tags_count = $instance['tags_count'];

		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div class="tagcloud">';

		/**
		 * Filter the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 2.8.0
		 * @since 3.0.0 Added taxonomy drop-down.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $current_taxonomy The taxonomy to use in the tag cloud. Default 'tags'.
		 */
		$tag_args = array(
			'taxonomy' => $current_taxonomy,
			'number' => $tags_count
		);

		wp_tag_cloud($tag_args);

		//wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
		//	'taxonomy' => $current_taxonomy
		//) ) );

		echo "</div>\n";
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		$instance['tags_count'] = (int)($new_instance['tags_count']);
		return $instance;
	}

	public function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
			<?php foreach ( get_taxonomies() as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
				?>
				<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
			<?php endforeach; ?>
		</select></p>
		<p><label for="<?php echo $this->get_field_id('tags_count'); ?>"><?php _e('Tags number:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('tags_count'); ?>" name="<?php echo $this->get_field_name('tags_count'); ?>" value="<?php if (isset ( $instance['tags_count'])) {echo esc_attr( $instance['tags_count'] );} ?>" /></p>
	<?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}

function Crum_Widget_Tag_cloud(){
	register_widget('Crumina_Tag_Cloud_Widget');
}

add_action('widgets_init','Crum_Widget_Tag_cloud');

