<?php
class Crum_Social_Counters_Widget extends WP_Widget {

	public function  __construct() {
		parent::__construct(
			  'social-buttons-widget',
				  'Crumina: Social counters widget',
				  array( 'description' => __( 'Social counters widget', 'crum' ), )
		);
	}

	public function form( $instance ) {

		$twitter = isset( $instance['twitter'] ) ? $instance['twitter'] : false;

		$facebook = isset( $instance['facebook'] ) ? $instance['facebook'] : false;

		$youtube = isset( $instance['youtube'] ) ? $instance['youtube'] : false;

		$vimeo = isset( $instance['vimeo'] ) ? $instance['vimeo'] : false;

		$dribbble = isset( $instance['dribbble'] ) ? $instance['dribbble'] : false;

		$rss = isset( $instance['rss'] ) ? $instance['rss'] : false;
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter username', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ) ?>" name="<?php echo $this->get_field_name( 'twitter' ) ?>" type="text" value="<?php echo $twitter; ?>"/>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Make sure you Setup Twitter API OAuth settings under <a href="admin.php?page=theme_options&tab=3" target="_blank">Theme options</a> ', 'crum' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ) ?>" name="<?php echo $this->get_field_name( 'facebook' ) ?>" type="text" value="<?php echo $facebook; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube Channel URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ) ?>" name="<?php echo $this->get_field_name( 'youtube' ) ?>" type="text" value="<?php echo $youtube; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e( 'Vimeo Channel URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ) ?>" name="<?php echo $this->get_field_name( 'vimeo' ) ?>" type="text" value="<?php echo $vimeo; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e( 'Dribbble Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ) ?>" name="<?php echo $this->get_field_name( 'dribbble' ) ?>" type="text" value="<?php echo $dribbble; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e( 'Feed URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ) ?>" name="<?php echo $this->get_field_name( 'rss' ) ?>" type="text" value="<?php echo $rss; ?>"/>
		</p>

	<?php

	}

	public function widget( $args, $instance ) {

		global $crum_theme_option;
		extract( $args );

		$twitter = $instance['twitter'];

		$facebook = $instance['facebook'];

		$youtube = $instance['youtube'];

		$vimeo = $instance['vimeo'];

		$dribbble = $instance['dribbble'];

		$rss = $instance['rss'];

		?>
		<?php echo $before_widget; ?>
		<section class="widget">
			<div class="follow-widget">
				<?php if ( $twitter ): ?>
					<a href="http://www.twitter.com/<?php echo $twitter?>" target="_blank" class="tw">
						<?php $twitter_followers_count = crum_twitter_counter($twitter);?>
						<i class="soc-icon soc-twitter"></i>
						<span class="number"><?php echo @number_format( $twitter_followers_count )?></span>
						<span class="text">followers</span>
					</a>
				<?php endif; ?>
				<?php if ( $facebook ): ?>
					<?php $facebook_followers_count = crum_facebook_counter($facebook);?>
					<a href="<?php echo $facebook;?>" target="_blank" class="fb">
						<i class="soc-icon soc-facebook"></i>
						<span class="number"><?php echo @number_format( $facebook_followers_count )?></span>
						<span class="text">fans</span>
					</a>
				<?php endif; ?>
				<?php if ( $youtube ): ?>
					<?php $youtube_followers_count = crum_youtube_counter($youtube);?>
					<a href="<?php echo $youtube?>" target="_blank" class="yt">
						<i class="soc-icon soc-youtube"></i>
						<span class="number"><?php echo @number_format( $youtube_followers_count )?></span>
						<span class="text">followers</span>
					</a>
				<?php endif; ?>
				<?php if ( $vimeo ): ?>
					<?php $vimeo_followers_count = crum_vimeo_counter($vimeo)?>
					<a href="<?php echo $vimeo;?>" target="_blank" class="vi">
						<i class="soc-icon soc-vimeo"></i>
						<span class="number"><?php echo @number_format( $vimeo_followers_count )?></span>
						<span class="text">subscribers</span>
					</a>
				<?php endif; ?>
				<?php if ( $dribbble ): ?>
					<?php $dribbble_followers_count = crum_dribbble_counter($dribbble);?>
					<a href="<?php echo $dribbble?>" target="_blank" class="dr">
						<i class="soc-icon soc-dribbble"></i>
						<span class="number"><?php echo @number_format( $dribbble_followers_count )?></span>
						<span class="text">followers</span>
					</a>
				<?php endif; ?>
				<?php if ( $rss ): ?>
					<a href="<?php echo $rss;?>" target="_blank" class="rss">
						<i class="soc-icon soc-rss"></i>
						<span class="number">Subscribe</span>
						<span class="text">To RSS</span>
					</a>
				<?php endif; ?>
			</div>

		</section>
		<?php echo $after_widget; ?>
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['twitter'] = strip_tags( $new_instance['twitter'] );

		$instance['facebook'] = strip_tags( $new_instance['facebook'] );

		$instance['youtube'] = strip_tags( $new_instance['youtube'] );

		$instance['vimeo'] = strip_tags( $new_instance['vimeo'] );

		$instance['dribbble'] = strip_tags( $new_instance['dribbble'] );

		$instance['rss'] = strip_tags( $new_instance['rss'] );

		delete_transient('twitter_count');
		delete_transient('facebook_counter');
		delete_transient('youtube_counter');
		delete_transient('vimeo_counter');
		delete_transient('dribbble_counter');

		return $instance;

	}


}

function Crum_Social_Counters_Widget_Init() {
	register_widget( 'Crum_Social_Counters_Widget' );
}

add_action( 'widgets_init', 'Crum_Social_Counters_Widget_Init' );