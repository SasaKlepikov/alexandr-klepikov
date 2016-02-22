<?php

if(!(function_exists('crum_get_remote'))){
function crum_get_remote( $url ) {
	$request = wp_remote_retrieve_body( wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) ) );
	return $request;
}
}

if(!(function_exists('crum_twitter_counter'))){
	function crum_twitter_counter($twitter_username) {
		global $crum_theme_option;
		//$twitter_username 		= $crum_theme_option['tw_username'];
		$twitter['page_url'] = 'http://www.twitter.com/'.$twitter_username;
		$twitter['followers_count'] = get_transient('twitter_count');
		if( empty( $twitter['followers_count']) ){
			try {

				$data = @json_decode(crum_get_remote("https://twitter.com/users/$twitter_username.json") , true);
				if ( isset($data['followers_count']) ) {
					$twitter['followers_count'] = (int) $data['followers_count'];
				}

				$consumerKey 			= $crum_theme_option['tw_consumer_key'];
				$consumerSecret			= $crum_theme_option['tw_consumer_secret'];

				$token = get_option('tie_TwitterToken');

				// getting new auth bearer only if we don't have one
				if(!$token) {
					// preparing credentials
					$credentials = $consumerKey . ':' . $consumerSecret;
					$toSend = base64_encode($credentials);

					// http post arguments
					$args = array(
						'method' => 'POST',
						'httpversion' => '1.1',
						'blocking' => true,
						'headers' => array(
							'Authorization' => 'Basic ' . $toSend,
							'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
						),
						'body' => array( 'grant_type' => 'client_credentials' )
					);

					add_filter('https_ssl_verify', '__return_false');
					$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

					$keys = json_decode(wp_remote_retrieve_body($response));

					if($keys) {
						// saving token to wp_options table
						update_option('tie_TwitterToken', $keys->access_token);
						$token = $keys->access_token;
					}
				}

				// we have bearer token wether we obtained it from API or from options
				$args = array(
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => "Bearer $token"
					)
				);

				add_filter('https_ssl_verify', '__return_false');
				$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_username";
				$response = wp_remote_get($api_url, $args);

				if (!is_wp_error($response)) {
					$followers = json_decode(wp_remote_retrieve_body($response));
					$twitter['followers_count'] = $followers->followers_count;
				}

			} catch (Exception $e) {
				$twitter['followers_count'] = 0;
			}
			if( !empty( $twitter['followers_count'] ) ){
				set_transient( 'twitter_count' , $twitter['followers_count'] , 1200);
				if( get_option( 'followers_count') != $twitter['followers_count'] )
					update_option( 'followers_count' , $twitter['followers_count'] );
			}

			if( $twitter['followers_count'] == 0 && get_option( 'followers_count') )
				$twitter['followers_count'] = delete_option( 'followers_count');

			elseif( $twitter['followers_count'] == 0 && !get_option( 'followers_count') )
				$twitter['followers_count'] = 0;
		}
		return $twitter['followers_count'];
	}
}

if(!(function_exists('crum_facebook_counter'))){
	function crum_facebook_counter( $page_link ){
		$face_link = @parse_url($page_link);

		if( $face_link['host'] == 'www.facebook.com' || $face_link['host']  == 'facebook.com' ){
			$fans = get_transient('facebook_counter');
			if( empty( $fans ) ){
				try {
					$data = @json_decode(crum_get_remote("http://graph.facebook.com/".$page_link));
					if ( is_object($fans) ) {
						$fans = $data->likes;
					}else{
						$fans = 0;
					}
				} catch (Exception $e) {
					$fans = 0;
				}

				if( !empty($fans) ){
					set_transient( 'facebook_counter' , $fans );
					if ( get_option( 'facebook_counter') != $fans )
						update_option( 'facebook_counter' , $fans );
				}

				if( $fans == 0 && get_option( 'facebook_counter') )
					$fans = delete_option( 'facebook_counter');

				elseif( $fans == 0 && !get_option( 'facebook_counter') )
					$fans = 0;
			}
			return $fans;
		}
	}
}

if(!(function_exists('crum_youtube_counter'))){
	function crum_youtube_counter( $channel_link ){
		$youtube_link = @parse_url($channel_link);

		if( $youtube_link['host'] == 'www.youtube.com' || $youtube_link['host']  == 'youtube.com' ){
			$subs = get_transient('youtube_counter');
			if( empty( $subs ) ){
				try {
					if (strpos( strtolower($channel_link) , "channel") === false)
						$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 6);
					else
						$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 9);

					$json = @crum_get_remote("http://gdata.youtube.com/feeds/api/users/".$youtube_name."?alt=json");
					$data = json_decode($json, true);
					$subs = $data['entry']['yt$statistics']['subscriberCount'];
				} catch (Exception $e) {
					$subs = 0;
				}

				if( !empty($subs) ){
					set_transient( 'youtube_counter' , $subs , 1200);
					if( get_option( 'youtube_counter') != $subs )
						update_option( 'youtube_counter' , $subs );
				}

				if( $subs == 0 && get_option( 'youtube_counter') )
					$subs = get_option( 'youtube_counter');

				elseif( $subs == 0 && !get_option( 'youtube_counter') )
					$subs = 0;
			}
			return $subs;
		}
	}
}

if(!(function_exists('crum_vimeo_counter'))){
	function crum_vimeo_counter( $page_link ) {
		$vimeo_link = @parse_url($page_link);

		if( $vimeo_link['host'] == 'www.vimeo.com' || $vimeo_link['host']  == 'vimeo.com' ){
			$vimeo = get_transient('vimeo_counter');
			if( empty( $vimeo ) ){
				try {
					$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 10);
					@$data = @json_decode(crum_get_remote( 'http://vimeo.com/api/v2/channel/' . $page_name  .'/info.json'));

					if ( isset($data->total_subscribers) ) {
						$vimeo = $data->total_subscribers;
					}
				} catch (Exception $e) {
					$vimeo = 0;
				}

				if( !empty($vimeo) ){
					set_transient( 'vimeo_counter' , $vimeo , 1200);
					if( get_option( 'vimeo_counter') != $vimeo )
						update_option( 'vimeo_counter' , $vimeo );
				}

				if( $vimeo == 0 && get_option( 'vimeo_counter') )
					$vimeo = get_option( 'vimeo_counter');
				elseif( $vimeo == 0 && !get_option( 'vimeo_counter') )
					$vimeo = 0;
			}
			return $vimeo;
		}
	}
}

if(!(function_exists('crum_dribbble_counter'))){
	function crum_dribbble_counter( $page_link ) {
		$dribbble_link = @parse_url($page_link);

		if( $dribbble_link['host'] == 'www.dribbble.com' || $dribbble_link['host']  == 'dribbble.com' ){
			$dribbble = get_transient('dribbble_counter');
			if( empty( $dribbble ) ){
				try {
					$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
					@$data = @json_decode(crum_get_remote( 'http://api.dribbble.com/' . $page_name));

					if ( is_object($data) ) {
						$dribbble = $data->followers_count;
					} else {
						$dribbble = 0;
					}
				} catch (Exception $e) {
					$dribbble = 0;
				}

				if( !empty($dribbble) ){
					set_transient( 'dribbble_counter' , $dribbble , 1200);
					if( get_option( 'dribbble_counter') != $dribbble )
						update_option( 'dribbble_counter' , $dribbble );
				}

				if( $dribbble == 0 && get_option( 'dribbble_counter') )
					$dribbble = get_option( 'dribbble_counter');
				elseif( $dribbble == 0 && !get_option( 'dribbble_counter') )
					$dribbble = 0;
			}
			return $dribbble;
		}
	}
}

if(!(function_exists('crum_rss_feed'))){

}