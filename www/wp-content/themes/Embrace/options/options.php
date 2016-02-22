<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/

/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options(){
    $args = array();


    // For use with a tab below
		$tabs = array();

		ob_start();

		$ct = wp_get_theme();
        $theme_data = $ct;
        $item_name = $theme_data->get('Name'); 
		$tags = $ct->Tags;
		$screenshot = $ct->get_screenshot();
		$class = $screenshot ? 'has-screenshot' : '';

		$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'crum' ), $ct->display('Name') );

		?>
		<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
					<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				</a>
				<?php endif; ?>
				<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			<?php endif; ?>

			<h4>
				<?php echo $ct->display('Name'); ?>
			</h4>

			<div>
				<ul class="theme-info">
					<li><?php printf( __('By %s','crum'), $ct->display('Author') ); ?></li>
					<li><?php printf( __('Version %s','crum'), $ct->display('Version') ); ?></li>
					<li><?php echo '<strong>'.__('Tags','crum').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
				</ul>
				<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
				<?php if ( $ct->parent() ) {
					printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
						 'http://codex.wordpress.org/Child_Themes',
						$ct->parent()->display( 'Name' ) );
				} ?>
				
			</div>

		</div>

		<?php
		$item_info = ob_get_contents();
		    
		ob_end_clean();


	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}  		
		$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
	}


    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
    $args['dev_mode_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'crum_theme_option';

    // Setting system info to true allows you to view info useful for debugging.
    // Default: true
    $args['system_info'] = false;

    
	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyBv5MVQ465Vd_Dq5tpxflBNxdXMvqA_awI';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    //$args['admin_stylesheet'] = 'standard';

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

    // Set a custom menu icon.
    //$args['menu_icon'] = '';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Theme Options', 'crum');

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Theme Options', 'crum');

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = 'theme_options';

    $args['default_show'] = false;
    $args['default_mark'] = '*';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options_general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    //$args['page_position'] = null;

    // Set a custom page icon class (used to override the page icon next to heading)
    $args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-1',
        'title' => __('Theme Information 1', 'crum'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
    );
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-2',
        'title' => __('Theme Information 2', 'crum'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
    );

    // Set the help sidebar for the options page.                                        
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'crum');


    // Add HTML before the form.
    /*if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
    	if (!empty($args['global_variable'])) {
    		$v = $args['global_variable'];
    	} else {
    		$v = str_replace("-", "_", $args['opt_name']);
    	}
    	$args['intro_text'] = __('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$'.$v.'</strong></p>', 'crum');
    } else {
    	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'crum');
    }

    // Add content after the form.
    $args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'crum');

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'crum');
*/




    $sections = array();              

    //Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
	$assets_folder = get_template_directory_uri() . '/library/img';
    $sample_patterns      = array();


	$site_name = esc_attr( get_bloginfo( 'name', 'display' ) );

    if ( is_dir( $sample_patterns_path ) ) :
    	
      if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
      	$sample_patterns = array();

        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

          if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
          	$name = explode(".", $sample_patterns_file);
          	$name = str_replace('.'.end($name), '', $sample_patterns_file);
          	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
          }
        }
      endif;
    endif;



    $sections[] = array(
        'icon' => 'el-icon-cog',
        'icon_class' => 'icon-large',
        'title' => __('Main Options', 'crum'),
        'desc' => __('<p class="description">Main options of site</p>', 'crum'),

        'fields' => array(
	        array(
		        'id' => 'envato-api-key',
		        'type' => 'text',
		        'title' => __('Item purchase code', 'crum'),
		        'desc' => __('<p>Insert item purchase code to receive automatic theme updates.</p>', 'crum'),
		        'std' => ''
	        ),

            array(
                'id' => 'custom_favicon',
                'type' => 'media',
                'preview'=> false,
                'title' => __('Favicon', 'crum'),
                'desc' => __('Select a 16px X 16px image from the file location on your computer and media it as a favicon of your site', 'crum'),
                'default' => '/favicon.ico',
            ),

            array(
                'id' => 'responsive_mode',
                'title' => __('Responsive mode', 'crum'),
                'type' => 'switch',
                'desc' => __('Enable or disable Responsive CSS', 'crum'),
                "default" 		=> 1,
            ),

            array(
                'id' => 'backtotop',
                'title' => __('Back to top button', 'crum'),
                'type' => 'switch',
                'desc' => __('Enable or disable Back to top button', 'crum'),
                "default" 		=> 1,
            ),



            array(
                'id'=>'footer-text',
                'type' => 'editor',
                'title' => __('Footer Text', 'crum'),
                'subtitle' => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'crum'),
                'default' => 'Powered by [wp-url]. Built on the [theme-url].',
            ),


        ),
    );
	$sections[] = array(
		'icon' => 'el-icon-cogs',
		'icon_class' => 'icon-large',
		'title' => __('Header Options', 'crum'),
		'desc' => __('<p class="description">Main options of site</p>', 'crum'),
		'fields' => array(

			array(
				'id' => 'header-style',
				'type' => 'button_set',
				'title' => __('Header Style', 'crum'),
				'desc' => __('Select variant of Header styling', 'crum'),
				'options'  => array(
					'header-style-1' => __('Left align','crum'),
					'header-style-2' => __('With banner','crum'),
					'header-style-3' => __('Centered','crum'),
					'header-style-4' => __('Semitransparent','crum')
				),
				'default' => 'header-style-4'
			),

            array(
                'id'=>'header-top-text',
                'type' => 'editor',
                'required' => array('header-style','=','header-style-2'),
                'title' => __('Text in front of logo', 'crum'),
                'desc' => __('Text that will be shown in header near logotype', 'crum'),
            ),

            array(
                'id' => 'header-background-color',
                'type'     => 'color_rgba',
                'title'    => __('Header background color', 'crum'),
                'desc'     => __('Easy change your header background or transparency', 'crum'),
                'default'  => array(
                    'color' => '#171717',
                    'alpha' => '0.23'
                ),
                'output'   => array('#header, #header.fixed .header-inside'),
                'mode'     => 'background',
            ),
            array(
                'id' => 'header-text-color',
                'type'     => 'color',
                'title'    => __('Header text color', 'crum'),
                'desc'     => __('Easy change header text color', 'crum'),
                'default'  => '#ffffff',
                'output'   => array('#header'),
                'mode'     => 'color',
            ),

			array(
				'id' => 'custom_logo_media',
				'type' => 'media',
				'title' => __('Logotype image', 'crum'),
				'desc' => __('Select an image from the file location on your computer and media it as a header logotype', 'crum'),
				'default' => array('url' => $assets_folder . '/logo.png')
			),
			array(
				'id' => 'custom_logo_retina',
				'type' => 'media',
				'title' => __('Retina Logo', 'crum'),
				'desc' => __('Select an image from the file location on your computer and media it as a header logotype', 'crum'),
				'default' => array('url' => $assets_folder . '/logo@2x.png')
			),

            array(
                'id'=>'header_search',
                'type' => 'switch',
                'title' => __('Search field', 'crum'),
                'subtitle'=> __('Display search field in Header', 'crum'),
                "default"    => 1,
            ),
            array(
                'id'=>'header_cart',
                'type' => 'switch',
                'title' => __('Woo Commerce cart', 'crum'),
                'subtitle'=> __('Display shop icon in Header', 'crum'),
                "default"    => 1,
            ),
            array(
                'id'=>'header_side_menu',
                'type' => 'switch',
                'title' => __('Secondary Side menu', 'crum'),
                'subtitle'=> __('Additional side menu link in header', 'crum'),
                "default"    => 1,
            ),
			array(
				'id' => 'sticky_header',
				'title' => __('Fixed header', 'crum'),
				'type' => 'switch',
				'desc' => __('Enable or disable fixed header', 'crum'),
				"default" 	=> 1,
			),
            array(
                'id'=>'header_size',
                'type' => 'button_set',
                'title' => __('Header layout', 'crum'),
                'subtitle'=> __('Switch width style of header', 'crum'),
                'required' => array('top_panel','=','1'),
                'options' => array('0' => 'Full width','1' => 'Boxed'),
                "default"    => 1,
            ),

			array(
				'id' => 'info_top_panel',
				'type' => 'info',
				'desc' => __('Top panel options', 'crum')
			),
			array(
				'id' => 'top_panel',
				'title' => __('Top panel display', 'crum'),
				'type' => 'switch',
				'desc' => __('Enable or disable top panel', 'crum'),
				"default" 		=> 0,
			),
			array(
				'id'=>'top_panel_size',
				'type' => 'button_set',
				'title' => __('Top Panel layout', 'crum'),
				'subtitle'=> __('Switch width style of top panel', 'crum'),
				'required' => array('top_panel','=','1'),
				'options' => array('0' => 'Full width','1' => 'Boxed'),
				"default"    => 1,
			),
			array(
				'id' => 'top_panel_bg_color',
				'type' => 'color',
				'required' => array('top_panel','=','1'),
				'title' => __('Top panel background color', 'crum'),
				'desc'     => __('Easy change your top panel background or transparency', 'crum'),
				'validate' => 'color',
			),
			array(
				'id' => 'top_panel_text_color',
				'type' => 'color',
				'required' => array('top_panel','=','1'),
				'fold' => array('switch-boxed'),
				'title' => __('Top panel text color', 'crum'),
				'desc'     => __('Easy change top panel text color', 'crum'),
				'validate' => 'color',
			),
			array(
				'id'=>'top_panel_social',
				'type' => 'switch',
				'title' => __('Social icons', 'crum'),
				'subtitle'=> __('Display social icons in top panel', 'crum'),
				'required' => array('top_panel','=','1'),
				"default"    => 1,
			),

            array(
                'id'=>'top_panel_search',
                'type' => 'switch',
                'title' => __('Search field', 'crum'),
                'subtitle'=> __('Display search field in top panel', 'crum'),
                'required' => array('top_panel','=','1'),
                "default"    => 0,
            ),

			array(
				'id'=>'left-panel',
				'type' => 'select',
				'required' => array('top_panel','=','1'),
				'title' => __('Left side', 'crum'),
				'subtitle' => __('Set elements to left  side on top-panel', 'crum'),
				'options' => array('menu' => 'Menu','text' => 'Text','cart' => 'Woocomerce cart','wpml' => 'WPML Switcher','none' => 'None'),
				'default' => 'text'
			),

			array(
				'id'=>'left-panel-text',
				'type' => 'text',
				'required' => array('left-panel','=','text'),
				'title' => __('Left side text', 'crum'),
			),

			array(
				'id'=>'right-panel',
				'type' => 'select',
				'required' => array('top_panel','=','1'),
				'title' => __('Right side', 'crum'),
				'subtitle' => __('Set elements to right side on top-panel', 'crum'),
				'options' => array('menu' => 'Menu','text' => 'Text','cart' => 'Woocomerce cart','wpml' => 'WPML Switcher','none' => 'None'),
				'default' => 'socicons'
			),

			array(
				'id'=>'right-panel-text',
				'type' => 'text',
				'required' => array('right-panel','=','text'),
				'title' => __('Left side text', 'crum'),
			),

			array(
				'id' => 'info_st_header',
				'type' => 'info',
				'desc' => __('Stunning header options', 'crum')
			),

			array(
				'id' => 'st_header',
				'title' => __('Stunning page header', 'crum'),
				'type' => 'switch',
				'desc' => __('Enable or disable Stunning page header', 'crum'),
				"default" 	=> 1,
			),
			array(
				'id' => 'breadcrumbs',
				'title' => __('Breadcrumbs', 'crum'),
				'type' => 'switch',
				'desc' => __('Enable or disable Breadcrumbs', 'crum'),
				'required' => array('st_header','=','1'),
				"default" 	=> 1,
			),

			array(
				'id'=>'st-header-style',
				'type' => 'select',
				'required' => array('st_header','=','1'),
				'title' => __('Stunning header style', 'crum'),
				'subtitle' => __('Select style stunning page header', 'crum'),
				'options' => array('left' => 'Left Aligned','right' => 'Right Aligned','center' => 'Centered','both' => 'Separate'),
				'default' => 'both'
			),
			array(
				'id' => 'st-header-title',
				'type' => 'typography',
				'required' => array('st_header','=','1'),
				'title' => __('Title Typography', 'crum'),
				//'compiler' => true, // Use if you want to hook in your own CSS compiler
				'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
				'font-backup' => true, // Select a backup non-google font in addition to a google font
				'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
				'subsets'=>true, // Only appears if google is true and subsets not set to false
				'font-size'=>true,
				'text-align'=>false,
				'line-height' => false,
				'color'         => false,
				'letter-spacing'=>false,
				'preview'=>true, // Disable the previewer
				'output' => array('#stunning-header .page-title'), // An array of CSS selectors to apply this font style to dynamically
				'units' => 'px', // Defaults to px
				'subtitle' => __('Please select font for site headings', 'crum'),
				'default' => array(
					'font-style'  => 'normal',
					'font-weight' => 'lighter'
				),
			),
			array(
				'id' => 'st-header-text-color',
				'type' => 'color',
				'required' => array('st_header','=','1'),
				'title' => __('Select custom color', 'crum'),
				'subtitle' => __('Pick a text color for the stunning header panel.', 'crum'),
				'validate' => 'color',
				'default' => '#ffffff'
			),

			array(
				'id' => 'st-header-bg-color',
				'type' => 'color',
				'required' => array('st_header','=','1'),
				'title' => __('Select background color', 'crum'),
				'subtitle' => __('Pick a background color for the stunning header panel.', 'crum'),
				'default' => '#00aeff',
				'validate' => 'color',
			),


			array(
				'id' => 'st-header-bg-image',
				'type' => 'media',
				'url' => true,
				'required' => array('st_header','=','1'),
				'title' => __('Page Header Image', 'crum'),
				'desc' => __('We recommend image  between 1600px - 2000px wide and have a minimum height of 475px for best results', 'crum'),
				'default' => array('url' => ''),
			),

			array(
				'id' => 'st-header-height',
				'type' => 'text',
				'title' => __('Page Header Height', 'crum'),
				'subtitle' => __('How tall do you want your header? ', 'crum'),
				'desc' => __('Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image.', 'crum'),
				'validate' => 'numeric',
				'required' => array('st_header','=','1'),
				'default' => '0',
				'class' => 'small-text'
			),
		)
	);

    $sections[] = array(
        'title' => __('Social accounts', 'crum'),
        'desc' => __('<p class="description">Type links for social accounts</p>', 'crum'),
        'icon' => 'el-icon-group',
        'icon_class' => 'icon-large',
        'fields' => array(
            array(
                'id' => 'fb_link',
                'type' => 'text',
                'title' => __('Facebook link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://facebook.com'
            ),
            
            array(
                'id' => 'vk_link',
                'type' => 'text',
                'title' => __('Vkontakte link', 'crum'),

                'desc' => __('Paste link to your account', 'crum'),
                "default" => 'http://vk.com'
            ),
            
            array(
                'id' => 'tw_link',
                'type' => 'text',
                'title' => __('Twitter link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://twitter.com'
            ),
			array(
				'id' => 'in_link',
				'type' => 'text',
				'title' => __('Instagram link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'validate' => 'url',
				"default" => 'http://instagram.com'
			),
			array(
				'id' => 'de_link',
				'type' => 'text',
				'title' => __('Devianart link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'validate' => 'url',
				"default" => 'http://www.deviantart.com'
			),
            array(
                'id' => 'fli_link',
                'type' => 'text',
                'title' => __('Flickr link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://flickr.com'
            ),
            array(
                'id' => 'vi_link',
                'type' => 'text',
                'title' => __('Vimeo link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://vimeo.com'
            ),
            array(
                'id' => 'lf_link',
                'type' => 'text',
                'title' => __('Last FM link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://lastfm.com'
            ),
            array(
                'id' => 'dr_link',
                'type' => 'text',
                'title' => __('Dribble link', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://dribble.com'
            ),
            array(
                'id' => 'yt_link',
                'type' => 'text',
                'title' => __('YouTube', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://youtube.com'
            ),
            array(
                'id' => 'ms_link',
                'type' => 'text',
                'title' => __('Microsoft ID', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'https://accountservices.passport.net/'
            ),
            array(
                'id' => 'li_link',
                'type' => 'text',
                'title' => __('LinkedIN', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://linkedin.com'
            ),
            array(
                'id' => 'gp_link',
                'type' => 'text',
                'title' => __('Google +', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'https://accounts.google.com/'
            ),
            array(
                'id' => '500_link',
                'type' => 'text',
                'title' => __('500 PX', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://500px.com'
            ),
            array(
                'id' => 'pt_link',
                'type' => 'text',
                'title' => __('Pinterest', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://pinterest.com'
            ),
            array(
                'id' => 'wp_link',
                'type' => 'text',
                'title' => __('Wordpress', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://wordpress.com'
            ),
            array(
                'id' => 'be_link',
                'type' => 'text',
                'title' => __('Behance', 'crum'),
                
                'desc' => __('Paste link to your account', 'crum'),
                'validate' => 'url',
                "default" => 'http://behance.com'
            ),
            array(
                'id' => 'rss_link',
                'type' => 'text',
                'title' => __('RSS', 'crum'),
                
                'desc' => __('Paste alternative link to Rss', 'crum'),
				"default" => ""
            ),
        ),
    );

	$sections[] = array(
		'title' => __('Social networks API', 'crum'),
		'desc' => __('<p class="description">Type API keys for social accounts</p>', 'crum'),
		'icon' => 'el-icon-twitter',
		'icon_class' => 'icon-large',
		'fields' => array(
			array(
				'id' => 'info_tw_keys',
				'type' => 'info',
				'desc' => __('Twitter API keys', 'crum')
			),
			array(
				'id' => 'tw_consumer_key',
				'type' => 'text',
				'title' => __('Consumer key', 'crum'),
				'desc' => __('Enter Twitter Consumer Key', 'crum'),
			),

			array(
				'id' => 'tw_consumer_secret',
				'type' => 'text',
				'title' => __('Consumer Secret', 'crum'),
				'desc' => __('Enter Twitter Consumer Secret', 'crum'),
			),
			array(
				'id' => 'tw_access_token',
				'type' => 'text',
				'title' => __('Access Token', 'crum'),
				'desc' => __('Enter Twitter Access Token', 'crum'),
			),

			array(
				'id' => 'tw_access_token_secret',
				'type' => 'text',
				'title' => __('Access Token Secret', 'crum'),
				'desc' => __('Enter Twitter Access Token Secret', 'crum'),
			),
			array(
				'id' => 'info_tw_get_api',
				'type' => 'info',
				'desc' => __('If you don\'t know, how to get api keys, please check <a target="_blank" href="http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/">Our tutorial</a>', 'crum')
			),
		));

    $sections[] = array(
        'title' => __('Posts list options', 'crum'),
        'desc' => __('<p class="description">Parameters for posts and archives (social share etc)</p>', 'crum'),
        'icon_class' => 'icon-large',
        'icon' => 'el-icon-folder-open',
        'fields' => array(
			/*array(
				'title'    => __( 'Post Columns', 'crum' ),
				'desc'     => 'Number of posts columns',
				'id'       => 'news_post_columns',
				'type' => 'button_set',
				'options' => array(
					'1' => __('1 Column', 'crum'),
					'2' => __('2 Columns', 'crum'),
					'3' => __('3 Columns', 'crum'),
					'4' => __('4 Columns', 'crum'),
				),
				"default" => '1'
			),*/

			/*array(
				'id' => 'news_bookmarks',
				'type' => 'switch',
				'title' => __('Bookmarks', 'crum'),
				'desc'     => __( 'Date & Icon on left of thumbnail', 'crum' ),
				"default"  => 1
			),

			array(
				'id' => 'news_bookmarks_date',
				'type' => 'switch',
				'title' => __('Bookmarks Date', 'crum'),
				'desc' => __('Show date', 'crum'),
				'required' => array( 'news_bookmarks', 'equals', '1' ),
				"default" => 1
			),
			array(
				'id' => 'news_bookmarks_avatar',
				'type' => 'switch',
				'title' => __('Bookmarks Avatar', 'crum'),
				'desc' => __('Show post author avatar', 'crum'),
				'required' => array( 'news_bookmarks', 'equals', '1' ),
				"default" => 1
			),
			array(
				'id' => 'news_bookmarks_icon',
				'type' => 'switch',
				'title' => __('Bookmarks Icon', 'crum'),
				'desc' => __('Show icon', 'crum'),
				'required' => array( 'news_bookmarks', 'equals', '1' ),
				"default" => 1
			),
*/
			array(
				'id' => 'post_meta',
				'type' => 'switch',
				'title' => __('Post additional info on standard blog', 'crum'),
				'desc' => __('Show or hide post author and categories', 'crum'),
				"default" => 1
			),

			array(
				'id' => 'info_msc',
				'type' => 'info',
				'desc' => __('Thumbnails options', 'crum')
			),

            array(
                'id' => 'thumb_image_crop',
                'type' => 'switch',
                'title' => __('Crop thumbnails', 'crum'),
                'desc' => __('Post thumbnails image crop', 'crum'),
                "default" => 1
            ),

            array(
                'id' => 'post_thumbnails_width',
                'title' => __('Post thumbnail width (in px)', 'crum'),
                'type' => 'slider',
                "default" 	=> "900",
                "min" 		=> "300",
                "step"		=> "50",
                "max" 		=> "1200",
            ),

            array(
                'id' => 'post_thumbnails_height',
                'title' => __('Post  thumbnail height (in px)', 'crum'),
                'validate' => 'numeric',
                'type' => 'slider',
                "default" 	=> "400",
                "min" 		=> "100",
                "step"		=> "50",
                "max" 		=> "1200",
            ),

			array(
				'id' => 'info_post_readmore',
				'type' => 'info',
				'title' => __('Post Excerpt options', 'crum')
			),

			array(
				'id' => 'auto_excerpt',
				'type' => 'switch',
				'title' => __('Automatic Excerpt', 'crum'),
				'desc' => __('Trim content automatic to short excerpt?', 'crum'),
				"default" => false
			),

			array(
				'id' => 'excerpt_length',
				'type' => 'text',
				'required' => array('auto_excerpt','=','1'),
				'title' => __('Excerpt length', 'crum'),
				'desc' => __('Number of words to trim excerpt', 'crum'),
			),

			array(
				'id' => 'post_readmore',
				'type' => 'text',
				'required' => array('auto_excerpt','=','1'),
				'title' => __('"Read more" text', 'crum'),
				'desc' => __('Customize "Read more" text', 'crum'),
			),

			array(
				'id' => 'info_pag_opt',
				'type' => 'info',
				'desc' => __('Blog pagination options', 'crum')
			),

            array(
                'id' => 'posts_per_page',
                'type' => 'text',
                'title' => __('Number of items','crum'),
                'desc' => __('Number of items that will be show on page','crum'),
            ),

            array(
                'title'   => __( 'Pagination type', 'crum' ),
                'desc'    => '',
                'id'      => 'posts_list_pagination',
                'type'    => 'button_set',
                'options' => array(
                    'prev_next' => __('Prev / Next', 'crum'),
                    'numbered' => __('Page Numbers', 'crum'),
                    'load-more'   => __( 'Ajax loading button', 'crum' ),
                ),
            ),

			array(
				'id' => 'info_msc',
				'type' => 'info',
				'title' => __('Inner post page options', 'crum')
			),

			array(
				'id' => 'autor_box_disp',
				'type' => 'switch',
				'title' => __('Author Info', 'crum'),
				'desc' => __('This option enables you to insert information about the author of the post.', 'crum'),
				"default" => 1
			),
			array(
				'id' => 'thumb_inner_disp',
				'type' => 'switch',
				'title' => __('Thumbnail on inner page', 'crum'),
				'desc' => __('Display featured image on single post', 'crum'),
				"default" => 0
			),
        ),
    );


	$sections[] = array(
		'title'      => __( 'Portfolio Options', 'crum' ),
		'icon_class' => 'icon-large',
		'icon'       => 'el-icon-camera',
		'fields'     => array(
			array(
				'id'    => 'portfolio_page_select',
				'type'  => 'select',
				'data'  => 'pages',
				'title' => __( 'Portfolio page', 'crum' ),
				'desc'  => __( 'Please select main portfolio page (for proper breadcrumbs)', 'crum' ),
			),

			array(
				'id' => 'custom_portfolio-slug',
				'type' => 'text',
				'title' => __('Custom slug for portfolio items', 'crum'),
				'desc' => __('Please write on latin without spaces<br>After change please go to <a href="options-permalink.php">Settings -> Permalinks</a> and press "Save changes" button to Save new Permalinks', 'crum'),
				'std' => ''
			),

			array(
				'title'   => __( 'Portfolio select template', 'crum' ),
				'desc'    => '',
				'id'      => 'folio_template',
				'type'    => 'button_set',
				'options' => array(
					'list'    => __( 'List style', 'crum' ),
					'grid'   => __( 'Grid + Sorting', 'crum' ),
                    'grid-inline'   => __( 'Grid + Inline box', 'crum' )
				),
			),
			array(
				'id'       => '_folio_inline_grid_read_more',
				'type'     => 'text',
				'title'    => __( 'Read more text', 'crum' ),
				'required' => array(
					array( 'folio_template', 'contains', 'grid-inline' )
				),
			),

            array(
                'title'   => __( 'Select style', 'crum' ),
                'desc'    => '',
                'id'      => 'list_style',
                'type'    => 'button_set',
                'required' => array( 'folio_template', 'equals', 'list' ),
                'options' => array(
                    'left'    => __( 'Left thumbnail', 'crum' ),
                    'right'   => __( 'Right thumbnail', 'crum' ),
                    'both'   => __( 'Alternately align', 'crum' ),
                ),
                "default"  => 'both'
            ),

			array(
				'id' => '_folio_number_to_display',
				'type' => 'text',
				'title' => __('Number of portfolios','crum'),
				'desc' => __('Number of portfolios that will be show on page','crum'),
			),

			array(
				'title'   => __( 'Pagination type', 'crum' ),
				'desc'    => '',
				'id'      => 'portfolio_list_pagination',
				'type'    => 'button_set',
				'options' => array(
					'prev_next' => __('Prev / Next', 'crum'),
					'numbered' => __('Page Numbers', 'crum'),
					'load-more'   => __( 'Ajax loading button', 'crum' ),
				),
			),

			array(
				'title'    => __( 'Post Columns', 'crum' ),
				'desc'     => 'Number of porfolio posts columns',
				'id'       => 'folio_post_columns',
				'type'     => 'slider',
				'required' => array(
                    array( 'folio_template', 'contains', 'grid')
                ),
				"default"  => "3",
				"min"      => "2",
				"step"     => "1",
				"max"      => "6",
			),

			array(
				'id'       => 'folio_items_space',
				'type'     => 'switch',
                'required' => array(
                    array( 'folio_template', 'contains', 'grid')
                ),
				'title'    => __( 'Item spacing', 'crum' ),
				'desc'     => __( 'Display space gap between grid items', 'crum' ),
				"default"  => 1
			),

            array(
                'id'       => 'folio_sort_panel',
                'type'     => 'switch',
                'required' => array( 'folio_template', 'equals', 'grid'),
                'title'    => __( 'Panel for items sorting ', 'crum' ),
                'desc'     => __( 'Display panel for portfolio isotope items sorting by category', 'crum' ),
                "default"  => 1
            ),
			array(
				'id'       => 'folio_item_separate_titles',
				'type'     => 'switch',
				'title'    => __( 'Title / description under item', 'crum' ),
                'required' => array(
                    array( 'folio_template', 'equals', 'grid')
                ),
				"default"  => 1
			),

			array(
				'id'       => 'folio_item_read_more',
				'type'     => 'switch',
				'title'    => __( 'Show "Read more" button', 'crum' ),
				'required' => array( 'folio_template', 'equals', 'grid-inline' ),
				"default"  => 1
			),

			array(
				'title'   => 'Sorting field',
				'desc'    => 'Select type of sorting category',
				'id'      => 'folio_sort_field',
				'type'    => 'select',
				'options' => array(
					'date'     => __( 'Order by date', 'crum' ),
					'title'    => __( 'Order by title', 'crum' ),
					'name'     => __( 'Order by post name (post slug)', 'crum' ),
					'author'   => __( 'Order by author', 'crum' ),
					'modified' => __( 'Order by last modified date', 'crum' ),
					'ID'       => __( 'Order by post ID', 'crum' ),
				),
			),
			array(
				'title'   => __( 'Post Order', 'crum' ),
				'desc'    => '',
				'id'      => 'folio_post_order',
				'type'    => 'button_set',
				'options' => array(
					'DESC' => __( 'Descending', 'crum' ),
					'ASC'  => __( 'Ascending', 'crum' ),
				),
			),

			array(
				'id'   => 'folio-info',
				'type' => 'info',
				'title' => __( 'Section for customize single portfolio page', 'crum' ),
			),

			array(
				'id'      => 'portfolio_single_style',
				'type'    => 'button_set',
				'title'   => __( 'Portfolio text location', 'crum' ),
				'desc'    => __( 'Select text layout on inner page', 'crum' ),
				'options' => array(
					''     => 'To the right',
					'full' => 'Full width',
				),
				"default" => 'left',
			),

			array(
				'id'      => 'portfolio_gallery_type',
				'type'    => 'select',
				'title'   => __( 'Portfolio image display', 'crum' ),
				'desc'    => __( 'Display attached images of inner portfolio page as:', 'crum' ),
                'options'  => array(
                    'default' => __('Default', 'crum'),
                    'big_images_list'=> __('Big images', 'crum'),
                    'middle_image_list'=> __('Middle image list', 'crum'),
                    'small_images_list'=> __('Small images list', 'crum'),
                    'advanced_gallery' => __('Advanced gallery', 'crum')
                ),
				"default" => 'default',
			),
		),
	);

    $sections[] = array(
        'title' => __('Styling Options', 'crum'),
        'desc' => __('<p class="description">Style parameters of body and footer</p>', 'crum'),
        'icon_class' => 'icon-large',
        'icon' => 'el-icon-brush',
        'fields' => array(

            array(
                'id' => 'main_site_color',
                'type' => 'color',
                'title' => __('Main site color', 'crum'),
                'desc' => __('Color of buttons, tabs, links, borders etc.', 'crum'),
            ),
            array(
                'id' => 'secondary_site_color',
                'type' => 'color',
                'title' => __('Secondary site color', 'crum'),
                'desc' => __('Color of inactive or hovered elements', 'crum'),
            ),

            array(
                'id'=>'link-color',
                'type' => 'link_color',
                'title' => __('Links Color Option', 'crum'),
                'subtitle' => __('Set custom colors for links', 'crum'),
                'default' => array(
                    'show_regular' => true,
                    'show_hover' => true,
                    'show_active' => true
                )
            ),
	        array(
		        'id'    => 'mobile_menu_bg_color',
		        'type'  => 'color',
		        'title' => __( 'Mobile menu background', 'crum' ),
		        'desc'  => __( 'Color of menu background on mobile devices only!', 'crum' ),
	        ),
	        array(
		        'id'    => 'mobile_menu_text_color',
		        'type'  => 'color',
		        'title' => __( 'Mobile menu text color', 'crum' ),
		        'desc'  => __( 'Color of menu text on mobile devices only!', 'crum' ),
	        ),

            array(
                'id' => 'info_sth',
                'type' => 'divide'
            ),

            array(
                'id' => 'switch-boxed',
                'type' => 'switch',
                'title' => __('Boxed Body Layout', 'crum'),
                "default" => 0,
                'on' => 'Enabled',
                'off' => 'Disabled',
            ),

            array(
                'id' => 'body_background_image',
                'type' => 'media',
                'fold' => array('switch-boxed'),
                'title' => __('Boxed Body background image', 'crum'),
                'desc' => __('Upload your own background image or pattern.', 'crum'),
                'required' => array('switch-boxed','=','1'),
                "default" => ''
            ),

            array(
                'id' => 'body_custom_repeat',
                'type' => 'select',
                'fold' => array('switch-boxed'),
                'title' => __('Boxed Body background image repeat', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                'required' => array('switch-boxed','=','1'),
                "default" => 'repeat'
            ),
            array(
                'id' => 'body_background_fixed',
                'type' => 'switch',
                'fold' => array('switch-boxed'),
                'title' => __('Fixed Body background image', 'crum'),
                'required' => array('switch-boxed','=','1'),
                "default" => 0
            ),
            array(
                'id' => 'body_background_color',
                'type' => 'color',
                'fold' => array('switch-boxed'),
                'title' => __('Boxed Body background color', 'crum'),
                'desc' => __('Select background color.', 'crum'),
                'required' => array('switch-boxed','=','1'),
                'validate' => 'color',
            ),

            array(
                'id' => 'infos_sdi',
                'type' => 'divide'
            ),


            //Body wrapper
            array(
                'id' => 'wrapper_bg_color',
                'type' => 'color',
                'title' => __('Content background color', 'crum'),
                'desc' => __('Select background color.', 'crum'),
            ),
            array(
                'id' => 'wrapper_bg_image',
                'type' => 'media',
                'title' => __('Content background image', 'crum'),
                'desc' => __('Upload your own background image or pattern.', 'crum')
            ),
            array(
                'id' => 'wrapper_custom_repeat',
                'type' => 'select',
                'title' => __('Content bg image repeat', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                "default" => 'repeat'
            ),


            array(
                'id' => 'info_foot',
                'type' => 'info',
                'desc' => __('Footer section options', 'crum')
            ),

            array(
	            'id' => 'footer_columns_count',
	            'title' => __('Footer columns count', 'crum'),
	            'type' => 'slider',
	            "default" 	=> "4",
	            "min" 		=> "1",
	            "step"		=> "1",
	            "max" 		=> "6",
            ),

	        array(
                'id' => 'footer_bg_color',
                'type' => 'color',
                'title' => __('Footer background color', 'crum'),
                'desc' => __('Select footer background color. ', 'crum'),
            ),
            array(
                'id' => 'footer_font_color',
                'type' => 'color',
                'title' => __('Footer font color', 'crum'),
                'desc' => __('Select footer font color.', 'crum'),
            ),
            array(
                'id' => 'footer_bg_image',
                'type' => 'media',
                'title' => __('Custom footer background image', 'crum'),
                'desc' => __('Upload your own footer background image or pattern.', 'crum')
            ),

            array(
                'id' => 'footer_custom_repeat',
                'type' => 'select',
                'title' => __('Footer background image repeat', 'crum'),
                'desc' => __('Select type background image repeat', 'crum'),
                'options' => array('repeat-y' => 'vertically','repeat-x' => 'horizontally','no-repeat' => 'no-repeat', 'repeat' => 'both vertically and horizontally', ),//Must provide key => value pairs for select options
                "default" => 'repeat'
            ),
        ),
    );

    $sections[] = array(
        'title' => __('Typography', 'crum'),
        'header' => __('Theme typography settings', 'crum'),
        'icon_class' => 'icon-large',
        'icon' => 'el-icon-fontsize',
        'fields' => array(

            array(
                'id' => 'body-font',
                'type' => 'typography',
                'title' => __('Body Font', 'crum'),
                'subtitle' => __('Specify the body font properties.', 'crum'),
                'google' => true,
				'font-backup' => true,
                'line-height' => true,
				'output' => array('body, p'), // An array of CSS selectors to apply this font style to dynamically
            ),

            array(
                'id' => 'headings-font-h1',
                'type' => 'typography',
                'title' => __('H1 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>false,
				'text-align'=>false,
                'line-height' => false,
				'letter-spacing'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),


            array(
                'id' => 'headings-font-h2',
                'type' => 'typography',
                'title' => __('H2 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>true,
                'line-height' => false,
				'text-align'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),

            array(
                'id' => 'headings-font-h3',
                'type' => 'typography',
                'title' => __('H3 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>true,
                'line-height' => false,
				'text-align'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),

            array(
                'id' => 'headings-font-h4',
                'type' => 'typography',
                'title' => __('H4 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>true,
                'line-height' => false,
				'text-align'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),

            array(
                'id' => 'headings-font-h5',
                'type' => 'typography',
                'title' => __('H5 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>true,
                'line-height' => false,
				'text-align'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),

            array(
                'id' => 'headings-font-h6',
                'type' => 'typography',
                'title' => __('H6 Typography', 'crum'),
                //'compiler' => true, // Use if you want to hook in your own CSS compiler
                'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                'font-backup' => true, // Select a backup non-google font in addition to a google font
                'font-style'=>true, // Includes font-style and weight. Can use font-style or font-weight to declare
                'subsets'=>true, // Only appears if google is true and subsets not set to false
                'font-size'=>true,
                'line-height' => false,
				'text-align'=>false,
                'preview'=>true, // Disable the previewer
                'output' => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                'units' => 'px', // Defaults to px
                'subtitle' => __('Please select font for site headings', 'crum'),
            ),

        ),
    );

    $sections[] = array(
        'icon' => 'el-icon-list',
        'icon_class' => 'icon-large',
        'title' => __('Layouts Settings', 'crum'),
        'desc' => __('<p class="description">Configure layouts of different pages</p>', 'crum'),
        'fields' => array(
            array(
                'id' => 'pages_layout',
                'type' => 'image_select',
                'title' => __('Single pages layout', 'crum'),
                'sub_desc' => __('Select one type of layout for single pages', 'crum'),
                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
                ),
                'default' => '2c-r-fixed'
            ),
            array(
                'id' => 'archive_layout',
                'type' => 'image_select',
                'title' => __('Archive Pages Layout', 'crum'),
                'sub_desc' => __('Select one type of layout for archive pages', 'crum'),

                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
                ),
                'default' => '3c-fixed'
            ),
            array(
                'id' => 'single_layout',
                'type' => 'image_select',
                'title' => __('Single posts layout', 'crum'),
                'sub_desc' => __('Select one type of layout for single posts', 'crum'),

                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
                ),
                'default' => '3c-fixed'
            ),
            array(
                'id' => 'search_layout',
                'type' => 'image_select',
                'title' => __('Search results layout', 'crum'),
                'sub_desc' => __('Select one type of layout for search results', 'crum'),

                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
                ),
                'default' => '3c-fixed'
            ),
            array(
                'id' => '404_layout',
                'type' => 'image_select',
                'title' => __('404 Page Layout', 'crum'),
                'sub_desc' => __('Select one of layouts for 404 page', 'crum'),

                'options' => array(
                    '1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
                    '2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                    '2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                    '3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
                    '3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
                    '3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
                ),
                'default' => '1col-fixed'
            ),
			array(
				'id' => 'portfolio_layout',
				'type' => 'image_select',
				'title' => __('Single Portfolio Layout', 'crum'),
				'sub_desc' => __('Select one of layouts for inner portfolio pages', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
					'3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
				),
				'default' => '1col-fixed'
			),
			array(
				'id' => 'woocommerce_layout',
				'type' => 'image_select',
				'title' => __('Woocommerce shop Layout', 'crum'),
				'sub_desc' => __('Select one of layouts for Shop pages', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => 'No sidebars', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => 'Sidebar on left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => 'Sidebar on right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => '2 left sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => 'Sidebar on either side', 'img' => ReduxFramework::$_url.'assets/img/3cm.png'),
					'3c-r-fixed' => array('title' => '2 right sidebars', 'img' => ReduxFramework::$_url.'assets/img/3cr.png'),
				),
				'default' => '2c-r-fixed'
			)
        ),
    );


    $sections[] = array(
        'title' => __('Advanced options', 'crum'),
        'desc' => __('<p class="description">JS, CSS, API options</p>', 'crum'),
        'icon_class' => 'icon-large',
        'icon' => 'el-icon-css',
        'fields' => array(
			array(
				'id' => 'info_cpo',
				'type' => 'info',
				'title' => __('Contact options', 'crum'),
			),

			array(
				'id' => 'contact_email_to',
				'type' => 'text',
				'title' => __('Send email to address', 'crum'),
				'desc' => __('Email address for contact form', 'crum'),
				"default" => get_option('admin_email')
			),

			array(
				'id' => 'info_misc',
				'type' => 'info',
				'title' => __('Misc', 'crum'),
				'desc' => __('', 'crum'),
			),

            array(
                'id' => 'tracking-code',
                'type' => 'textarea',
                'title' => __('Tracking Code', 'crum'),
                'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'crum'),
            ),

            array(
                'id' => 'css-code',
                'type' => 'ace_editor',
                'title' => __('CSS Code', 'crum'),
                'subtitle' => __('Paste your CSS code here.', 'crum'),
                'mode' => 'css',
                'theme' => 'chrome',
                'default' => ""
            ),
            array(
                'id' => 'js-code',
                'type' => 'ace_editor',
                'title' => __('JS Code', 'crum'),
                'subtitle' => __('Paste your JS code here.', 'crum'),
                'mode' => 'javascript',
                'theme' => 'chrome',
                'default' => "jQuery(document).ready(function(){\n\n});"
            ),


        ),
    );

	//Login page customozation

	$sections[] = array(
		'title' => __('Login customization', 'crum'),
		'icon_class' => 'icon-large',
		'icon' => 'el-icon-user',
		'fields' => array(
			array(
				'id' => 'login_logo',
				'type' => 'media',
				'title' => __('Login logo', 'crum'),
				'desc' => __('Select custom login logo', 'crum'),
			),
			array(
				'id' => 'login_logo_url',
				'type' => 'text',
				'title' => __('Login URL', 'crum'),
				'desc' => __('Select url, login form leads to', 'crum'),
			),
			array(
				'id' => 'custom_login_bg',
				'type' => 'media',
				'title' => __('Login page background', 'crum'),
				'desc' => __('Select picture for login page background', 'crum'),

			),

		),
	);

	//theme update options
	//$crum_has_update = get_option('envato-toolkit-has-update');
	//$crum_has_update_errors = get_option('envato-toolkit-last-errors');

	/*
	$sections[] = array(
		'title' => __('Theme update', 'crum'),
		'icon_class' => 'icon-large',
		'icon' => 'el-icon-repeat',
		'fields' => array(
			array(
				'id' => 'themeforest_username',
				'type' => 'text',
				'title' => __('ThemeForest Username', 'crum'),
				'std' => ''
			),

			array(
				'id' => 'themeforest_api_key',
				'type' => 'text',
				'title' => __('Secret API Key', 'crum'),
				'std' => ''
			),

			array(
				'id' => 'info_envato_get_api',
				'type' => 'info',
				'desc' => __('If you don\'t know, how to get api keys, please check <a target="_blank" href="http://crumina.net/envato-api-key/">Our tutorial</a>', 'crum')
			),

			array(
				'id' => 'crum_envato_update',
				'type' => 'callback',
				'title' => __('Update theme','crum'),
				'callback' => 'crum_update_callback',
			),
/*
			array(
				'id' => 'theme_update_button',
				'type' => 'raw',
				'content' => (!empty($crum_has_update) && empty($crum_has_update_errors))
						? '<p style="text-align: center;">'
						  . '<a onclick="return confirm(\'Start theme upgrade?\')" href="'.add_query_arg(array(
								'_nonce' => wp_create_nonce('sb_theme_upgrade'),
								'upgrade_theme' => 1,
							)).'" class="button button-primary">'.__('Upgrade theme', 'crum').'</a></p>'
						: '',
			),
*/
//		),
//	);

	$tabs = array();

	if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
	}

	$theme_info = '<div class="redux-framework-section-desc">';
	$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'crum').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'crum').$author.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'crum').$version.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'crum').implode(', ', $tags).'</p>';
	$theme_info .= '</div>';

	if(file_exists(dirname(__FILE__).'/README.md')){
	$tabs['theme_docs'] = array(
				'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
				'title' => __('Documentation', 'crum'),
				'content' => file_get_contents(dirname(__FILE__).'/README.md')
				);
	}//if


	// You can append a new section at any time.


    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', 'crum'),
        'content' => $item_info
    );
    
    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', 'crum'),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }

    global $ReduxFramework;
    $ReduxFramework = new ReduxFramework($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);


/**
	Use this function to hide the activation notice telling users about a sample panel.
**/
function removeReduxAdminNotice() {
	delete_option('REDUX_FRAMEWORK_PLUGIN_ACTIVATED_NOTICES');
}
add_action('redux_framework_plugin_admin_notice', 'removeReduxAdminNotice');

	function crum_update_callback() {
		$theme_update = new Envato_WP_Toolkit;

		return $theme_update->_envato_menu_page();
	}