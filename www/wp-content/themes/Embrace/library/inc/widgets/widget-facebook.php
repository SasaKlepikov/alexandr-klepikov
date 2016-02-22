<?php

class Crum_Facebook_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(

			'facebook-widget', // Base ID

			'Crumina: Facebook widget', // Name

			array( 'description' => __( 'Facebook Social widget', 'crum' ), ) // Args

		);

	}


	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title'        => __( 'Facebook', 'crum' ),
			'url'          => '',
			'width'        => '',
			'height'       => '',
			'small_header' => '',
			'hide_cover'   => '',
			'show_faces'   => '',
			'page_posts'   => '',
		) );

		$title        = $instance['title'];
		$url          = $instance['url'];
		$width        = $instance['width'];
		$height       = $instance['height'];
		$small_header = $instance['small_header'] ? 'checked="checked"' : '';;
		$hide_cover = $instance['hide_cover'] ? 'checked="checked"' : '';;
		$show_faces = $instance['show_faces'] ? 'checked="checked"' : '';;
		$page_posts = $instance['page_posts'] ? 'checked="checked"' : '';;

		$widget_output = '';

		//Widget title
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . __( 'Title', 'crum' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'url' ) ) . '">' . __( 'URL:', 'crum' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'url' ) ) . '" name="' . esc_attr( $this->get_field_name( 'url' ) ) . '" type="text" value="' . esc_attr( $url ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'width' ) ) . '">' . __( 'Width', 'crum' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'width' ) ) . '" name="' . esc_attr( $this->get_field_name( 'width' ) ) . '" type="text" value="' . esc_attr( $width ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'height' ) ) . '">' . __( 'Height', 'crum' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'height' ) ) . '" name="' . esc_attr( $this->get_field_name( 'height' ) ) . '" type="text" value="' . esc_attr( $height ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'small_header' ) ) . '" name="' . esc_attr( $this->get_field_name( 'small_header' ) ) . '" type="checkbox" ' . esc_attr( $small_header ) . '>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'small_header' ) ) . '">' . __( 'Small header', 'crum' ) . '</label>';
		$widget_output .= '<br />';

		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'hide_cover' ) ) . '" name="' . esc_attr( $this->get_field_name( 'hide_cover' ) ) . '" type="checkbox" ' . esc_attr( $hide_cover ) . '>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'hide_cover' ) ) . '">' . __( 'Hide Cover Photo', 'crum' ) . '</label>';
		$widget_output .= '<br />';

		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'show_faces' ) ) . '" name="' . esc_attr( $this->get_field_name( 'show_faces' ) ) . '" type="checkbox" ' . esc_attr( $show_faces ) . '>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'show_faces' ) ) . '">' . __( 'Show Friend\'s Faces', 'crum' ) . '</label>';
		$widget_output .= '<br />';

		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'page_posts' ) ) . '" name="' . esc_attr( $this->get_field_name( 'page_posts' ) ) . '" type="checkbox" ' . esc_attr( $page_posts ) . '>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'page_posts' ) ) . '">' . __( 'Show Page Posts', 'crum' ) . '</label>';
		$widget_output .= '<br />';

		$widget_output .= '</p>';

		echo $widget_output;

	}


	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['url'] = strip_tags( $new_instance['url'] );


		$instance['width'] = strip_tags( $new_instance['width'] );

		$instance['height'] = strip_tags( $new_instance['height'] );

		$instance['small_header'] = strip_tags( $new_instance['small_header'] );

		$instance['hide_cover'] = strip_tags( $new_instance['hide_cover'] );

		$instance['show_faces'] = strip_tags( $new_instance['show_faces'] );

		$instance['page_posts'] = strip_tags( $new_instance['page_posts'] );

		return $instance;

	}


	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );



		if (strpos($instance['url'],'http') !== false){

			$url = $instance['url'];

		} else {
			$url = 'https://www.facebook.com/' . $instance['url'];
		}

		$width = isset($instance['width']) ? $instance['width'] : '';

		$height = isset($instance['height']) ? $instance['height'] : '';

		$small_headder = isset($instance['small_header']) ? $instance['small_header'] : '';

		$hide_cover = isset($instance['hide_cover']) ? $instance['hide_cover'] : '';

		$show_faces = isset($instance['show_faces']) ? $instance['show_faces'] : '';

		$page_posts = isset($instance['page_posts']) ? $instance['page_posts'] : '';

		if ( isset($small_headder) && ($small_headder == 'on') ) {
			$small_header_show = 'true';
		} else {
			$small_header_show = 'false';
		}

		if ( (isset($hide_cover))&&($hide_cover == 'on') ) {
			$hide_cover_show = 'true';
		} else {
			$hide_cover_show = 'false';
		}

		if ( (isset($show_faces)) && ($show_faces == 'on') ) {
			$show_faces_show = 'true';
		} else {
			$show_faces_show = 'false';
		}

		if ( (isset($page_posts)) && ($page_posts == 'on') ) {
			$page_posts_show = 'true';
		} else {
			$page_posts_show = 'false';
		}

		?>

		<?php echo $args['before_widget'];

		if ( $title ) {

			echo $args['before_title'];
			echo $title;
			echo $args['after_title'];

		} ?>

		<div class="fb-page"
		     data-href="<?php echo $url; ?>"
		     data-width="<?php echo $width; ?>"
		     data-height="<?php echo $height; ?>"
		     data-small-header="<?php echo $small_header_show; ?>"
		     data-adapt-container-width="true"
		     data-hide-cover="<?php echo $hide_cover_show; ?>"
		     data-show-facepile="<?php echo $show_faces_show; ?>"
		     data-show-posts="<?php echo $page_posts_show; ?>">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="https://www.facebook.com/facebook">
					<a href="https://www.facebook.com/facebook">Facebook</a></blockquote>
			</div>
		</div>

		<div id="fb-root"></div>
		<script>(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/<?php echo esc_html( get_locale() ) ?>/sdk.js#xfbml=1&version=v2.3";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

		<?php
		echo $args['after_widget'];

	}

}

function Crum_Facebook_Widget_init() {
	register_widget( 'Crum_Facebook_Widget' );
}

add_action( 'widgets_init', 'Crum_Facebook_Widget_init' );