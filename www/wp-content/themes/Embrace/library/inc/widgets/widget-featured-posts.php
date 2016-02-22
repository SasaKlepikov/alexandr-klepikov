<?php

/**
 * Featured posts Widget Class
 * This allows specific posts to be shown on Sidebar
 *
 */
class Crum_Widget_Featured_Posts extends WP_Widget {

	function __construct() {
		$widget_options = array(
			'classname'   => 'crum_widget_featured_posts',
			'description' => __( "Selected posts to display in featured style", "crum" )
		);
		parent::__construct( 'crum-widget-featured-posts', __( "Crumina: Featured Posts", "crum" ), $widget_options );
		$this->alt_option_name = 'crum_widget_featured_posts';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function get_excerpt_by_id($post_id){
		$the_post = get_post($post_id); //Gets post ID
		$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
		$excerpt_length = 20; //Sets excerpt length by word count
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
		$words = explode(' ', $the_excerpt, $excerpt_length + 1);
		if(count($words) > $excerpt_length) :
			array_pop($words);
			array_push($words, '…');
			$the_excerpt = implode(' ', $words);
		endif;
		$the_excerpt = '<p>' . $the_excerpt . '</p>';
		return $the_excerpt;
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_featured_posts', 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];

			return;
		}

		ob_start();

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Featured Posts', 'crum' ) : $instance['title'], $instance, $this->id_base );

		$selected_posts = $instance['selected_posts'];

		$external_link = isset( $instance['external_link'] ) ? $instance['external_link'] : '';
		$external_text = isset( $instance['external_text'] ) ? $instance['external_text'] : '';
		$show_excerpt  = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : '';

		echo $before_widget;

		if ( is_array( $selected_posts ) ) {
			?>

			<div class="featured-posts">

			<?php if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			foreach ( $selected_posts as $single_post ) {
				?>

				<article id="post-<?php echo $single_post; ?>" <?php post_class(); ?>>

					<?php
					if ( has_post_format( 'audio', $single_post ) ) {
						$featured_icon = '<i class="embrace-music2"></i>';
					} elseif ( has_post_format( 'video', $single_post ) ) {
						$featured_icon = '<i class="embrace-film_strip"></i>';
					} elseif ( has_post_format( 'quote', $single_post ) ) {
						$featured_icon = '<i class="crumicon-quote-left"></i>';
					} elseif ( has_post_format( 'gallery', $single_post ) ) {
						$featured_icon = '<i class="embrace-photos_alt2"></i>';
					} elseif ( has_post_format( 'image', $single_post ) ) {
						$featured_icon = '<i class="embrace-photo2"></i>';
					} else {
						$featured_icon = '<i class="embrace-forward2"></i>';
					}

					if(has_post_thumbnail($single_post)){
						$url          = wp_get_attachment_image_src( get_post_thumbnail_id( $single_post ), 'full' );
						$url          = $url[0];
						$thumbnail_width  = '300';
						$thumbnail_height = '300';

						$thumb_crop   = true;

					} else {
						$url          = get_template_directory_uri() . '/library/img/no-image/large.png';
						$thumbnail_width  = '300';
						$thumbnail_height = '300';

						$thumb_crop   = true;
					}

					$img_link =  theme_thumb( $url, $thumbnail_width, $thumbnail_height, $thumb_crop )

					?>

					<div class="single-thumbnail">
						<img src ="<?php echo $img_link;?>" alt="<?php get_the_title($single_post) ?>">
						<div class="overlay"></div>
						<div class="links"><a href="<?php echo get_the_permalink($single_post)?>" class="link" rel="bookmark" title="<?php echo get_the_title($single_post)?>"><?php echo $featured_icon; ?></a>
							<h4 class="post-title">
                                <a href="<?php echo get_the_permalink($single_post)?>" class="link" rel="bookmark" title="<?php echo get_the_title($single_post)?>">
								    <?php echo get_the_title($single_post);?>
                                </a>
							</h4>

							<?php if($show_excerpt == 'on'): ?>

							<div class="featured-excerpt">

								<?php

								$post_excerpt = $this->get_excerpt_by_id($single_post);

								echo $post_excerpt;

								?>

							</div>

							<?php endif; ?>

						</div>

						</div>


				</article>

			<?php
			}

			if ( isset( $external_link ) && ! ( $external_link == '' ) ) {

				if ( isset( $external_text ) && ! ( $external_text == '' ) ) {
					$button_text = $external_text;
				} else {
					$button_text = __( 'Read more', 'crum' );
				}?>

				<a class="button" title="<?php echo $button_text; ?>" href="<?php echo $external_link; ?>"><?php echo $button_text; ?></a>

			<?php
			}

		} else {
			echo __( 'Please, select posts!', 'crum' );
		} ?>

		</div><!-- .featured-posts -->

		<?php echo $after_widget;

		$cache[ $args['widget_id'] ] = ob_get_flush();
		wp_cache_set( 'widget_featured_posts', $cache, 'widget' );

	}

	function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['title']          = $new_instance['title'];
		$instance['selected_posts'] = $new_instance['selected_posts'];
		$instance['external_link']  = $new_instance['external_link'];
		$instance['external_text']  = $new_instance['external_text'];
		$instance['show_excerpt']   = $new_instance['show_excerpt'];

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['crum_widget_featured_posts'] ) ) {
			delete_option( 'crum_widget_featured_posts' );
		}

		return $instance;

	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_featured_posts', 'widget' );
	}

	function form( $instance ) {
		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$selected_posts = isset( $instance['selected_posts'] ) ? $instance['selected_posts'] : '';
		$external_link  = isset( $instance['external_link'] ) ? $instance['external_link'] : '';
		$external_text  = isset( $instance['external_text'] ) ? $instance['external_text'] : '';
		$show_excerpt   = isset( $instance['show_excerpt'] ) ? (bool)$instance['show_excerpt'] : false;

		$posts_array = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => - 1,
			'post_status'    => 'publish'
		) );

		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>



		<p>
			<label for="<?php echo $this->get_field_id( 'selected_posts' ); ?>"><?php _e( 'Select posts:', 'crum' ); ?></label>

			<select multiple id="<?php echo $this->get_field_id( 'selected_posts' ); ?>" name="<?php echo $this->get_field_name( 'selected_posts' ) . '[]'; ?>">

				<option disabled>Select post</option>

				<?php while ( $posts_array->have_posts() ) : $posts_array->the_post(); ?>
					<?php if ( is_array( $selected_posts ) ) {

						if ( in_array( ( esc_attr( get_the_ID() ) ), $selected_posts ) ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}

					}?>
					<option class="widefat" value="<?php echo get_the_ID(); ?>" <?php if ( isset( $selected ) ) {
						echo $selected;
					} ?> >
						<?php echo get_the_title(); ?>
					</option>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>

			</select>

		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'external_link' ); ?>"><?php _e( 'External link:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'external_link' ); ?>" name="<?php echo $this->get_field_name( 'external_link' ); ?>" type="text" value="<?php echo $external_link; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'external_text' ); ?>"><?php _e( 'Button text:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'external_text' ); ?>" name="<?php echo $this->get_field_name( 'external_text' ); ?>" type="text" value="<?php echo $external_text; ?>" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>"<?php checked( $show_excerpt ); ?> />
			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e( 'Show posts excerpt','crum' ); ?></label><br />
		</p>
	<?php
	}

}

function Crum_Widget_Featured_Posts_Init() {
	register_widget( 'Crum_Widget_Featured_Posts' );
}

add_action( 'widgets_init', 'Crum_Widget_Featured_Posts_Init' );