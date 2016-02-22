<?php

class Crum_Flickr_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(

            'widget-flickr', // Base ID

            'Crumina: Flickr Feed', // Name

            array( 'description' => __( 'Displays your Flickr feed', 'crum' ), ) // Args

        );
    }

	function widget( $args, $instance ) {

	extract( $args );

		$widget_id = $args['id'];

	/* User-selected settings. */
	 $title = $instance['title'] ;
     $id = $instance['id'];
	 $num = $instance['num'];

     wp_enqueue_script('jflickrfeed');


  /* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;

        }

		/* Display Latest Tweets */
		if ( $num ) { ?>
        <div id="flickr-<?php echo $widget_id ?>" class="flickr-latest small-format magnific-gallery-several"></div>

        <script type="text/javascript">
            <!--
            jQuery(document).ready(function() {
                jQuery('#flickr-<?php echo $widget_id ?>').jflickrfeed({
                    limit: <?php echo $num; ?>,
                    qstrings: {
                        id: '<?php echo $id; ?>'
                    },
                    itemTemplate:
                            '<span class="entry-thumb">' +
                                '<img src="{{image_q}}"  />' +
								'<div class="overlay"></div>'+
								'<div class="links"><a class="zoom"  href="{{image}}" title="{{title}}"><i class="crumicon crumicon-search"></i></a></div>'+
                            '</span>'

                });
            });
            // -->
        </script>


		<?php }

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = $new_instance['title'];

		$instance['num'] = strip_tags( $new_instance['num'] );
		$instance['id'] = strip_tags( $new_instance['id'] );

		return $instance;
	}
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Flickr Photos',  'id'=>'31472375@N06', 'num' => '4' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
        <input class="widefat"  type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID:', 'crum'); ?></label>
        <input class="widefat"  type="text" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $instance['id']; ?>"/>
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of photos:', 'crum'); ?></label>
        <input class="widefat"  type="text" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" value="<?php echo $instance['num']; ?>"/>
    </p>

        <?php
	}
}



function Crum_Flickr_Widget_init() {
    register_widget('Crum_Flickr_Widget');
}

add_action('widgets_init', 'Crum_Flickr_Widget_init');
