<?php

if(!is_admin()) return;




/**
 * Add CSS & JS Files
 */

add_action('admin_enqueue_scripts','addEASYJSFScripts');

function addEASYJSFScripts() {
			if(  isset($_GET['page']) && $_GET['page'] == 'easint'  )
			{
				wp_enqueue_style('easy-instf-css',EASY_F_PLUGIN_URL.'sprites/custom.css');
			}
		
	}
		

