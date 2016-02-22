<?php
class EASYFInstallerHelper
	{
		
		static function beginInstall($import_file,$easy_metadata )
		{
			//global ;
				EASYFInstallerHelper::createImages($easy_metadata);

				if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

				if ( !class_exists( 'WP_Import' ) ) {
				  $class_wp_import = EASY_F_PLUGIN_PATH . '/admin/importer/wordpress-importer.php';
				  if ( file_exists( $class_wp_import ) )
				  require_once($class_wp_import);
			    }


					  
				  if(is_file($import_file))
				  {
			  
					  $wp_import = new WP_Import();
					  $wp_import->fetch_attachments = false;

					  if(isset($easy_metadata['data']->allow_attachment) && $easy_metadata['data']->allow_attachment == "yes")
					  	 $wp_import->fetch_attachments = true;

					  $wp_import->import($import_file);
					
				  }

		}


		static function setMediaData($easy_metadata)
		{
			//global ;

			
			$attach_ids = get_option('easy_demo_images');

			if(!$attach_ids) return;

			$pattern = '(\bhttps?:\/\/\S+?\.(?:jpg|png|gif))';

			$fn_i = array();
			foreach ($attach_ids as $key => $id) {
				$fn_i[]  = wp_get_attachment_image_src($id,'full'); 
			}
	 		
	 		$image_metas = explode(',',$easy_metadata['data']->post_meta_replace);
	 		$mi = count($image_metas);

			$post_types = explode(',',$easy_metadata['data']->post_type);
			
			$wp_query = new WP_Query(array(
					"post_type" => $post_types,
					"posts_per_page" => -1
				));
	 		while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$id =  get_the_ID();
	    		set_post_thumbnail($id,   $attach_ids[0] );

	    		if( $easy_metadata['data']->force_image_replace == "yes" )
	    		{
	    			 $content = get_the_content(); 
	    			 $content = preg_replace($pattern,addslashes($fn_i[0][0]),$content);
	    			 wp_update_post(array( "ID" => $id , "post_content" => $content )); 
	    		}

	    		for ($i=0; $i < $mi; $i++) 
	    		{
	    			update_post_meta($id,$image_metas[$i],$fn_i[0][0]);
	    		}	

			endwhile; 
			
		}

		static function setOptions($easy_metadata)
		{

			global  $wpdb;
			$input = json_decode( base64_decode($easy_metadata['data']->options),true);

			$excludes = explode(',',$easy_metadata['data']->options_exclude);
			foreach($input as $key => $val)
			{
			  	if( is_serialized($val["option_value"]) )
						update_option($val["option_name"],unserialize($val["option_value"]));
					else
						update_option($val["option_name"],$val["option_value"]);
			}

			$sn = $easy_metadata['data']->option_shortname;

			foreach ($excludes as $key => $value) {

				delete_option($sn.$value);
			}

		}

		static function setMenus($easy_metadata)
		{
			global $wpdb;
		    $table_db_name = $wpdb->prefix . "terms";
		   	
		   
		   	$menus = explode(',',$easy_metadata['data']->menu_data);

		   	$mappedMenus = array();
		   	$db_str = array();
		   	foreach ($menus as $key => $menu) {
		   		$t = explode(':', $menu);
		   		$mappedMenus[] = array("menu" => trim($t[0]) , "location" => trim($t[1]));
	   			$db_str[] = "name='".trim($t[0])."'";
		   	}

		   	$query = "SELECT * FROM $table_db_name where ".implode(' OR ',$db_str)." ";
		   	$rows = $wpdb->get_results($query,ARRAY_A);
		    
		    
		   $menu_ids = array();
		   foreach($rows as $row)
			$menu_ids[$row["name"]] = $row["term_id"] ; 

		  $menu_locs = array();
		  
		  foreach ($mappedMenus as $key => $menu) {
		  		 $menu_locs[$menu['location']] = $menu_ids[$menu['menu']];
		  	}


		  	set_theme_mod( 'nav_menu_locations', array_map( 'absint', $menu_locs) );
			
			
		}
		static function setHomePage($easy_metadata)
		{
			//global ;
			$page = get_page_by_title( $easy_metadata['data']->home_page );
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
		}

		static function setWidgets($easy_metadata)
		{
			//global , $wpdb;
			
			$widgets = json_decode(base64_decode($easy_metadata['data']->sidebar_widgets),true);

			update_option('sidebars_widgets',$widgets);


			$inputs = base64_decode($easy_metadata['data']->widgets_data);	
			$inputs = json_decode($inputs,true);

			//$excludes = explode(',',$easy_metadata['data']->widgets_list);
			 foreach ($inputs as $key => $input) {
			 			update_option($key,$input);

			 }


		}


		static function createImages($easy_metadata)
		 {
		 	//global ;

		 	if(!file_exists(EASY_F_PLUGIN_PATH."/demo_data_here/".$easy_metadata['image']))
		 	{
		 		return;
		 	}

		 	if( get_option('easy_demo_images') ) return get_option('easy_demo_images');

		 	$images = array( $easy_metadata['image'] );
		 	$attach_ids = array();
		 	foreach ($images as $image) {
		 		
		 		$path = wp_upload_dir(); 
		     	$cstatus =   copy( EASY_F_PLUGIN_PATH."/demo_data_here/".$image,  $path['path'].'/'.$image  );
				$filename = $path['path'].'/'.$image;
			 
			 	$wp_filetype = wp_check_filetype(basename($filename), null );
			 	$attachment = array(
			  	  'guid' => $path['baseurl'] . _wp_relative_upload_path( $filename ), 
			   	  'post_mime_type' => $wp_filetype['type'],
			   	  'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			   	  'post_content' => '',
			      'post_status' => 'inherit'
				);
				
				$attach_id = wp_insert_attachment( $attachment, $filename );
		    	require_once(ABSPATH . 'wp-admin/includes/image.php');
		    	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		    	wp_update_attachment_metadata( $attach_id, $attach_data );

		    	$attach_ids[] =  $attach_id; 	

		 	}

		 	update_option('easy_demo_images',$attach_ids);

		 }

	static function crum_masterslider_impot($folder){
		if ( !class_exists('MSP_Importer') ) {
			require_once ( EASY_F_PLUGIN_PATH.'admin/importer/class-msp-importer.php');

			$new_importer = new MSP_Importer;

			$import_data_1 = file_get_contents( EASY_F_PLUGIN_PATH . "/demo_data_here/".$folder."/1_For_creative_layout.json" );
			$new_importer->import_data( $import_data_1 );
			$import_data_3 = file_get_contents( EASY_F_PLUGIN_PATH . "/demo_data_here/".$folder."/3_For_homepage_layout.json" );
			$new_importer->import_data( $import_data_3 );

		}
	}

	static function crum_megamenu_columns($columns, $post_id){
		global $wpdb;
		$wpdb->update(
			'wp_postmeta',
			array(
				'meta_value'=>$columns
			),
			array(
				'post_id'=>$post_id,
				'meta_key'=>'_crum_mega_menu_columns',
			)
		);
	}

	static function crum_megamenu_full( $post_id){
		global $wpdb;
		$wpdb->update(
			'wp_postmeta',
			array(
				'meta_value'=> '1'
			),
			array(
				'post_id'=>$post_id,
				'meta_key'=>'_crum_mega_menu_full',
			)
		);
	}

	static function crum_megamenu_settings($post_id){
		global $wpdb;
		$wpdb->update(
			'wp_postmeta',
			array(
				'meta_value'=>'1'
			),
			array(
				'post_id'=>$post_id,
				'meta_key'=>'_crum_mega_menu_enabled',
			)
		);
	}
	
	static function crum_say_hello(){
		wp_delete_post( 1, true );
	}

	static function crum_custom_css_import($folder){
		
		global $ReduxFramework;
		
		$custom_css = file_get_contents( EASY_F_PLUGIN_PATH . "/demo_data_here/".$folder."/custom.css" );
		
		$ReduxFramework->set('css-code', $custom_css);
				
	}

	}