<?php
/*-----------------------------------------------------------------------------------*/
/* Tabbed Widget
/*-----------------------------------------------------------------------------------*/

class Crum_Widget_Tabs extends WP_Widget
{
    var $settings = array('number', 'pop', 'latest');


    public function __construct()
    {
        parent::__construct(
            'crum_widget_tabs', // Base ID
            'Crumina: Tabbed Widget', // Name
            array('description' => __('Tabs: Popular posts, Recent Posts', 'crum'),) // Args
        );

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }



    function widget($args, $instance)
    {

        extract($args, EXTR_SKIP);

		$cache = wp_cache_get('widget_tabbed_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		
        $instance = $this->aq_enforce_defaults($instance);
        if(isset( $instance['title']) &&  $instance['title']){
            $title = apply_filters('widget_title', $instance['title']);
        } else {
            $title = '';
        }

        extract($instance, EXTR_SKIP);
        $header_format = $instance['header_format'];
        $thumb_sel = $instance['thumb_sel'];
        $number = $instance['number'];
		$exclude = $instance['exclude'];


        echo $before_widget;

        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;

        }
		
		?>

		<dl class="tabs radius" data-tab>
			<?php if ($header_format == 'popular-recent'): ?>

				<dd class="active"><a href="#popular-p-tab"> <i class="crum-icon crum-heart"></i> <span><?php _e('Popular', 'crum') ?></span></a></dd>
				<dd><a href="#recent-p-tab"> <i class="crum-icon crum-clip"></i> <span><?php _e('Recent', 'crum') ?></span></a></dd>

			<?php else : ?>

				<dd class="active"><a href="#recent-p-tab"> <i class="crum-icon crum-clip"></i> <span><?php _e('Recent', 'crum') ?></span></a></dd>
				<dd><a href="#popular-p-tab"> <i class="crum-icon crum-heart"></i> <span><?php _e('Popular', 'crum') ?></span></a></dd>
			<?php endif; ?>
		</dl>

		<div class="tabs-content">
			<div id="popular-p-tab" <?php echo (($header_format == 'popular-recent')) ? 'class="content active"' : 'class="content"'; ?>>
				<?php if (function_exists('aq_widget_tabs_popular')) aq_widget_tabs_popular($thumb_sel, $number, $exclude); ?>
			</div>
			<div id="recent-p-tab" <?php echo (($header_format !== 'popular-recent')) ? 'class="content active"' : 'class="content"'; ?>>
				<?php if (function_exists('aq_widget_tabs_latest')) aq_widget_tabs_latest($thumb_sel, $number, $exclude); ?>
			</div>
		</div>


        <?php
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_tabbed_posts', $cache, 'widget');
    }

    /*----------------------------------------
       update()
       ----------------------------------------

     * Function to update the settings from
     * the form() function.

     * Params:
     * - Array $new_instance
     * - Array $old_instance
     ----------------------------------------*/

    function update($new_instance, $old_instance)
    {
        $new_instance = $this->aq_enforce_defaults($new_instance);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['thumb_sel'] = $new_instance['thumb_sel'];
        $instance['header_format'] = $new_instance['header_format'];
		$instance['exclude'] = strip_tags($new_instance['exclude']);


		$this->flush_widget_cache();

        return $new_instance;


    } // End update()

    function aq_enforce_defaults($instance)
    {
        $defaults = $this->aq_get_settings();
        $instance = wp_parse_args($instance, $defaults);
        $instance['number'] = intval($instance['number']);
        if ($instance['number'] < 1)
            $instance['number'] = $defaults['number'];


        return $instance;
    }

    /**
     * Provides an array of the settings with the setting name as the key and the default value as the value
     * This cannot be called get_settings() or it will override WP_Widget::get_settings()
     */
    function aq_get_settings()
    {
        // Set the default to a blank string
        $settings = array_fill_keys($this->settings, '');
        // Now set the more specific defaults
        $settings['number'] = 5;
        $settings['thumb_sel'] = 'thumb';
        $settings['header_format'] = 'popular-recent';
        return $settings;
    }

	function flush_widget_cache() {
		wp_cache_delete('widget_tabbed_posts', 'widget');
	}


    function form($instance)
    {
        $instance = $this->aq_enforce_defaults($instance);
        extract($instance, EXTR_SKIP);

        $thumb_sel = $instance['thumb_sel'];
        $header_format = $instance['header_format'];
		$exclude = strip_tags($instance['exclude']);

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>"
                   value="<?php echo esc_attr($instance['number']); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('header_format'); ?>"><?php _e('Select header format:', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('header_format'); ?>"
                    name="<?php echo $this->get_field_name('header_format'); ?>  value="<?php echo esc_attr($header_format); ?>
            " >
            <option
                value='popular-recent' <?php if (esc_attr($header_format) == 'popular-recent') echo 'selected'; ?>><?php _e('Popular-Recent', 'crum'); ?></option>
            <option
                value='recent-popular' <?php if (esc_attr($header_format) == 'recent-popular') echo 'selected'; ?>><?php _e('Recent-Popular', 'crum'); ?></option>
            </select>

        </p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude Category(s):', 'crum'); ?></label> <input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name('exclude'); ?>" id="<?php echo $this->get_field_id('exclude'); ?>" class="widefat" />
			<br />
			<small><?php _e('Category IDs, separated by commas.', 'crum'); ?></small>
		</p>
    <?php
    } // End form()

} // End Class

/*-----------------------------------------------------------------------------------*/
/*  Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('aq_widget_tabs_popular')) {
    function aq_widget_tabs_popular($thumb_sel, $posts = 5, $excluded = array())
    {
        global $post;
	    if(function_exists('pll_current_language')){
		    $popular = get_posts(array('suppress_filters' => false, 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'numberposts' => $posts, 'category__not_in' => explode(',', $excluded), 'lang' => pll_current_language()));
	    } else {
		    $popular = get_posts(array('suppress_filters' => false, 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'numberposts' => $posts, 'category__not_in' => explode(',', $excluded)));
	    }


        foreach ($popular as $post) :
            setup_postdata($post);

            get_template_part('post-formats/format', 'small');

        endforeach;
        wp_reset_query();

    }
}


/*-----------------------------------------------------------------------------------*/
/*  Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('aq_widget_tabs_latest')) {
    function aq_widget_tabs_latest($thumb_sel, $posts = 5, $excluded = array() )
    {
        global $post;
	    if(function_exists('pll_current_language')){
		    $latest = get_posts(array('ignore_sticky_posts' => 1, 'numberposts' => $posts, 'orderby' => 'post_date', 'order' => 'desc', 'category__not_in' => explode(',', $excluded), 'lang' => pll_current_language()));
	    } else {
		    $latest = get_posts(array('ignore_sticky_posts' => 1, 'numberposts' => $posts, 'orderby' => 'post_date', 'order' => 'desc', 'category__not_in' => explode(',', $excluded)));
	    }

        foreach ($latest as $post) :
            setup_postdata($post);

            get_template_part('post-formats/format', 'small');

        endforeach;
        wp_reset_query();
    }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Crum_Widget_Tabs");' ) );

