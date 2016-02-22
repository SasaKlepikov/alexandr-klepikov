<?php

class Crum_Social_Networks_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'soc-networks-widget',
			'Crumina: Social networks',
			array( 'description' => __( 'Social networks widget', 'crum' ), )
		);
	}

	public function form( $instance ) {

		$facebook    = isset ( $instance ['fb_link'] ) ? $instance['fb_link'] : false;
		$google_plus = isset ( $instance ['gp_link'] ) ? $instance['gp_link'] : false;
		$twitter     = isset ( $instance ['tw_link'] ) ? $instance['tw_link'] : false;
		$instagram   = isset ( $instance ['in_link'] ) ? $instance['in_link'] : false;
		$vimeo       = isset ( $instance ['vi_link'] ) ? $instance['vi_link'] : false;
		$last_fm     = isset ( $instance ['lf_link'] ) ? $instance['lf_link'] : false;
		$dribble     = isset ( $instance ['dr_link'] ) ? $instance['dr_link'] : false;
		$vkontakte   = isset ( $instance ['vk_link'] ) ? $instance['vk_link'] : false;
		$youtube     = isset ( $instance ['yt_link'] ) ? $instance['yt_link'] : false;
		$microsoft   = isset ( $instance ['ms_link'] ) ? $instance['ms_link'] : false;
		$devianart   = isset ( $instance ['ms_link'] ) ? $instance['ms_link'] : false;
		$linkedin    = isset ( $instance ['li_link'] ) ? $instance['li_link'] : false;
		$pixels      = isset ( $instance ['px_link'] ) ? $instance['px_link'] : false;
		$pintrest    = isset ( $instance ['pt_link'] ) ? $instance['pt_link'] : false;
		$wordpress   = isset ( $instance ['wp_link'] ) ? $instance['wp_link'] : false;
		$behance     = isset ( $instance ['be_link'] ) ? $instance['be_link'] : false;
		$flickr      = isset ( $instance ['fli_link'] ) ? $instance['fli_link'] : false;
		$rss         = isset ( $instance ['rss_link'] ) ? $instance['rss_link'] : false;

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'fb_link' ); ?>"><?php _e( 'Facebook Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fb_link' ) ?>" name="<?php echo $this->get_field_name( 'fb_link' ) ?>" type="text" value="<?php echo $facebook; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'gp_link' ); ?>"><?php _e( 'Google plus Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'gp_link' ) ?>" name="<?php echo $this->get_field_name( 'gp_link' ) ?>" type="text" value="<?php echo $google_plus; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tw_link' ); ?>"><?php _e( 'Twitter Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tw_link' ) ?>" name="<?php echo $this->get_field_name( 'tw_link' ) ?>" type="text" value="<?php echo $twitter; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'in_link' ); ?>"><?php _e( 'Instagram Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'in_link' ) ?>" name="<?php echo $this->get_field_name( 'in_link' ) ?>" type="text" value="<?php echo $instagram; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'vi_link' ); ?>"><?php _e( 'Vimeo Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vi_link' ) ?>" name="<?php echo $this->get_field_name( 'vi_link' ) ?>" type="text" value="<?php echo $vimeo; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'lf_link' ); ?>"><?php _e( 'Last Fm Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'lf_link' ) ?>" name="<?php echo $this->get_field_name( 'lf_link' ) ?>" type="text" value="<?php echo $last_fm; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dr_link' ); ?>"><?php _e( 'Dribble Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'dr_link' ) ?>" name="<?php echo $this->get_field_name( 'dr_link' ) ?>" type="text" value="<?php echo $dribble; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'vk_link' ); ?>"><?php _e( 'Vkontakte Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vk_link' ) ?>" name="<?php echo $this->get_field_name( 'vk_link' ) ?>" type="text" value="<?php echo $vkontakte; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'yt_link' ); ?>"><?php _e( 'Youtube Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'yt_link' ) ?>" name="<?php echo $this->get_field_name( 'yt_link' ) ?>" type="text" value="<?php echo $youtube; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ms_link' ); ?>"><?php _e( 'Microsoft Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ms_link' ) ?>" name="<?php echo $this->get_field_name( 'ms_link' ) ?>" type="text" value="<?php echo $microsoft; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'de_link' ); ?>"><?php _e( 'Devianart Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'de_link' ) ?>" name="<?php echo $this->get_field_name( 'de_link' ) ?>" type="text" value="<?php echo $devianart; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'li_link' ); ?>"><?php _e( 'Linkedin Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'li_link' ) ?>" name="<?php echo $this->get_field_name( 'li_link' ) ?>" type="text" value="<?php echo $linkedin; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'px_link' ); ?>"><?php _e( '500px Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'px_link' ) ?>" name="<?php echo $this->get_field_name( 'px_link' ) ?>" type="text" value="<?php echo $pixels; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'pt_link' ); ?>"><?php _e( 'Pintrest Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pt_link' ) ?>" name="<?php echo $this->get_field_name( 'pt_link' ) ?>" type="text" value="<?php echo $pintrest; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'wp_link' ); ?>"><?php _e( 'Wordpress Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'wp_link' ) ?>" name="<?php echo $this->get_field_name( 'wp_link' ) ?>" type="text" value="<?php echo $wordpress; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'be_link' ); ?>"><?php _e( 'Behance Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'be_link' ) ?>" name="<?php echo $this->get_field_name( 'be_link' ) ?>" type="text" value="<?php echo $behance; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fli_link' ); ?>"><?php _e( 'Flickr Page URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fli_link' ) ?>" name="<?php echo $this->get_field_name( 'fli_link' ) ?>" type="text" value="<?php echo $flickr; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'rss_link' ); ?>"><?php _e( 'RSS feed URL:', 'crum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss_link' ) ?>" name="<?php echo $this->get_field_name( 'rss_link' ) ?>" type="text" value="<?php echo $rss; ?>" />
		</p>

	<?php

	}

	public function widget( $args, $instance ) {

		extract( $args );

		$fb_link  = isset( $instance['fb_link'] ) ? $instance['fb_link'] : '';
		$gp_link  = isset( $instance['gp_link'] ) ? $instance['gp_link'] : '';
		$tw_link  = isset( $instance['tw_link'] ) ? $instance['tw_link'] : '';
		$in_link  = isset( $instance['in_link'] ) ? $instance['in_link'] : '';
		$vi_link  = isset( $instance['vi_link'] ) ? $instance['vi_link'] : '';
		$lf_link  = isset( $instance['lf_link'] ) ? $instance['lf_link'] : '';
		$dr_link  = isset( $instance['dr_link'] ) ? $instance['dr_link'] : '';
		$vk_link  = isset( $instance['vk_link'] ) ? $instance['vk_link'] : '';
		$yt_link  = isset( $instance['yt_link'] ) ? $instance['yt_link'] : '';
		$ms_link  = isset( $instance['ms_link'] ) ? $instance['ms_link'] : '';
		$de_link  = isset( $instance['de_link'] ) ? $instance['de_link'] : '';
		$li_link  = isset( $instance['li_link'] ) ? $instance['li_link'] : '';
		$px_link  = isset( $instance['px_link'] ) ? $instance['px_link'] : '';
		$pt_link  = isset( $instance['pt_link'] ) ? $instance['pt_link'] : '';
		$wp_link  = isset( $instance['wp_link'] ) ? $instance['wp_link'] : '';
		$be_link  = isset( $instance['be_link'] ) ? $instance['be_link'] : '';
		$fli_link = isset( $instance['fli_link'] ) ? $instance['fli_link'] : '';
		$rss_link = isset( $instance['rss_link'] ) ? $instance['rss_link'] : '';
		?>

		<?php echo $before_widget; ?>

		<?php
		$social_networks = array(
			"fb"  => "Facebook",
			"gp"  => "Google +",
			"tw"  => "Twitter",
			"in"  => "Instagram",
			"vi"  => "Vimeo",
			"lf"  => "Last FM",
			"dr"  => "Dribble",
			"vk"  => "Vkontakte",
			"yt"  => "YouTube",
			"ms"  => "Microsoft",
			"de"  => "Devianart",
			"li"  => "LinkedIN",
			"px"  => "500 px",
			"pt"  => "Pinterest",
			"wp"  => "Wordpress",
			"be"  => "Behance",
			"fli" => "Flickr",
			"rss" => "RSS",
		);
		$social_icons    = array(
			"fb"  => "soc-facebook",
			"gp"  => "soc-google",
			"tw"  => "soc-twitter",
			"in"  => "soc-instagram",
			"vi"  => "soc-vimeo",
			"lf"  => "soc-lastfm",
			"dr"  => "soc-dribbble",
			"vk"  => "soc-vkontakte",
			"yt"  => "soc-youtube",
			"ms"  => "soc-windows",
			"de"  => "soc-deviantart",
			"li"  => "soc-linkedin",
			"px"  => "soc-500px",
			"pt"  => "soc-pinterest",
			"wp"  => "soc-wordpress",
			"be"  => "soc-behance",
			"fli" => "soc-flickr",
			"rss" => "soc-rss",
		);?>

		<span class="soc-icons-wrap">

		 <?php foreach ( $social_networks as $short => $original ) {
			 $link = $instance[ $short . "_link" ];
			 $icon = $social_icons[ $short ];
			 if ( $link != '' && $link != 'http://' ) {
				 ?>
				 <span><a href="<?php echo $link; ?>" class="soc-icon <?php echo $icon; ?> " title="<?php echo $original; ?>"></a></span>
			 <?php
			 }
		 }?>
		 </span>



		<?php echo $after_widget; ?>

	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['fb_link']  = strip_tags( $new_instance['fb_link'] );
		$instance['gp_link']  = strip_tags( $new_instance['gp_link'] );
		$instance['tw_link']  = strip_tags( $new_instance['tw_link'] );
		$instance['in_link']  = strip_tags( $new_instance['in_link'] );
		$instance['vi_link']  = strip_tags( $new_instance['vi_link'] );
		$instance['lf_link']  = strip_tags( $new_instance['lf_link'] );
		$instance['dr_link']  = strip_tags( $new_instance['dr_link'] );
		$instance['vk_link']  = strip_tags( $new_instance['vk_link'] );
		$instance['yt_link']  = strip_tags( $new_instance['yt_link'] );
		$instance['ms_link']  = strip_tags( $new_instance['ms_link'] );
		$instance['de_link']  = strip_tags( $new_instance['de_link'] );
		$instance['li_link']  = strip_tags( $new_instance['li_link'] );
		$instance['px_link']  = strip_tags( $new_instance['px_link'] );
		$instance['pt_link']  = strip_tags( $new_instance['pt_link'] );
		$instance['wp_link']  = strip_tags( $new_instance['wp_link'] );
		$instance['be_link']  = strip_tags( $new_instance['be_link'] );
		$instance['fli_link'] = strip_tags( $new_instance['fli_link'] );
		$instance['rss_link'] = strip_tags( $new_instance['rss_link'] );

		return $instance;
	}

}

function Crum_Social_Networks_Widget_Init() {
	register_widget( 'Crum_Social_Networks_Widget' );
}

add_action( 'widgets_init', 'Crum_Social_Networks_Widget_Init' );


