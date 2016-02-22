<?php
/**
 *  Name - Installer Panel
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

class IOAEasyFrontInstaller extends PLUGIN_IOA_PANEL_CORE {


	// init menu
	function __construct () {

		add_action('admin_menu',array(&$this,'manager_admin_menu'));
		add_action('admin_init',array(&$this,'manager_admin_init'));

	}

	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 }

	function manager_admin_menu(){

		add_theme_page('Installer Panel', 'Installer Panel', 'edit_theme_options', 'easint' ,array($this,'manager_admin_wrap'));


	}

	public function beginInstall($import_file, $easy_metadata)
	{
		//global $easy_metadata;
		//EASYFInstallerHelper::createImages();

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


	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){
		?>
		<div id="qode-metaboxes-general" class="wrap">
		<h2><?php _e('Embrace - One-Click Import Demo Content', 'qode') ?></h2>
		<form method="post" action="" id="importContentForm">
			<div id="poststuff" class="metabox-holder">
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
						<table class="form-table">
							<tbody>
							<tr valign="middle">
								<td scope="row" width="150"><?php esc_html_e('Import', 'qode'); ?></td>
								<td>
									<select name="import_example" id="import_example">
										<option value="data1">Style 1</option>
										<option value="data2">Style 2</option>
									</select>
									<select name="import_option" id="import_option">
										<option value="complete_content">Content with attacments</option>
									</select>
									<input type="submit" value="Import" name="import" id="import_demo_data" />
								</td>
							</tr>
							<tr class="loading-row"><td></td><td><div class="import_load"><span><?php _e('The import process may take some time. Please be patient.', 'qode') ?> </span><br />
										<div class="qode-progress-bar-wrapper html5-progress-bar">
											<div class="progress-bar-wrapper">
												<progress id="progressbar" value="0" max="100"></progress>
												<span class="progress-value">0%</span>
											</div>
											<div class="progress-bar-message">
											</div>
										</div>
									</div></td></tr>
							<tr><td colspan="2">
									<?php _e('<strong>Please, pay attention to the information below!</strong>', 'qode') ?><br />
									- <?php _e('Before importing demo data, make sure you have clean Wordpress installation. It means there shouldn\'t be any other themes, content, categories, sliders or other types of content there. ', 'qode'); ?><br />
									- <?php _e('Make sure that all plugins, provided with the theme, are installed. You can check that in “Appearance>Install plugins” section.', 'qode') ?>
								</td></tr>
							<tr><td></td><td><div class="success_msg" id="success_msg"><?php echo $this->message; ?></div></td></tr>
							</tbody>
						</table>
					</div>
				</div>
				<br class="clear"/>
			</div>
		</form>
		<script type="text/javascript">
			(function ($j) {
			$j(document).ready(function() {
				$j(document).on('click', '#import_demo_data', function(e) {
					e.preventDefault();
					if (confirm('Are you sure, you want to import Demo Data now?')) {
						$j('#import_demo_data').attr("disabled", true).attr("value", "In progress"); 
						$j('.import_load').css('display','block');
						var progressbar = $j('#progressbar')
						var import_opt = $j( "#import_option" ).val();
						var import_expl = $j( "#import_example" ).val();
						var p = 0;
						if(import_opt == 'complete_content'){
							for(var i=1;i<10;i++){
								var str;
								if (i < 10) str = 'attachments_0'+i+'.xml';
								else str = 'attachments_'+i+'.xml';
								jQuery.ajax({
									type: 'POST',
									url: ajaxurl,
									data: {
										action: 'crum_dataImport',
										xml: str,
										example: import_expl

									},
									success: function(data, textStatus, XMLHttpRequest){
										p+= 10;
										$j('.progress-value').html((p) + '%');
										progressbar.val(p);
										if (p == 90) {
											str = 'attachments_10.xml';
											jQuery.ajax({
												type: 'POST',
												url: ajaxurl,
												data: {
													action: 'crum_dataImport',
													xml: str,
													example: import_expl

												},
												success: function(data, textStatus, XMLHttpRequest){
													jQuery.ajax({
														type: 'POST',
														url: ajaxurl,
														data: {
															action: 'crum_otherImport',
															example: import_expl,
															xml_config: 'config.xml'
														},
														success: function(data, textStatus, XMLHttpRequest){
															$j('.progress-value').html((100) + '%');
															progressbar.val(100);
															$j('.progress-bar-message').html('<br />Import is completed.');
														},
														error: function(MLHttpRequest, textStatus, errorThrown){
														}
													});
												},
												error: function(MLHttpRequest, textStatus, errorThrown){
												}
											});
										}
									},
									error: function(MLHttpRequest, textStatus, errorThrown){
									}
								});
							}

						}

					}
					return false;
				});
			});
			})(jQuery);
		</script>

		</div>

	<?php



	}


}
global $crum_installer;
$crum_installer = new IOAEasyFrontInstaller();

if(!function_exists('crum_dataImport'))
{
	function crum_dataImport()
	{
		global $crum_installer;

		$folder = "data/";
		if (!empty($_POST['example']))
			$folder = $_POST['example']."/";

		$config_xml = 'config.xml';
		if (!empty($_POST['xml_config']))
			$config_xml = $_POST['xml_config'];

		$easy_metadata = array(
			"config" => EASY_F_PLUGIN_PATH."/demo_data_here/".$folder.$config_xml,
			"image" => "dummy.jpg"
		);

		if(file_exists($easy_metadata['config'])) :
			$xml= simplexml_load_file($easy_metadata['config']);
			$easy_metadata['data'] = $xml;
		else :
			$easy_metadata['data'] = false;
		endif;

		$crum_installer->beginInstall(EASY_F_PLUGIN_PATH ."/demo_data_here/".$folder.$_POST['xml'], $easy_metadata);

		die();
	}

	add_action('wp_ajax_crum_dataImport', 'crum_dataImport');
}

if (!function_exists('crum_otherImport')){
	function crum_otherImport(){
		// global $easy_metadata;

		// if(!$easy_metadata['data']) return; // No Config File Return

		$folder = "data/";
		if (!empty($_POST['example']))
			$folder = $_POST['example']."/";

		$config_xml = 'config.xml';
		if (!empty($_POST['xml_config']))
			$config_xml = $_POST['xml_config'];

		$easy_metadata = array(
			"config" => EASY_F_PLUGIN_PATH."/demo_data_here/".$folder.$config_xml,
			"image" => "dummy.jpg"
		);

		if(file_exists($easy_metadata['config'])) :
			$xml= simplexml_load_file($easy_metadata['config']);
			$easy_metadata['data'] = $xml;
		else :
			$easy_metadata['data'] = false;
		endif;

		easy_import_after_xml();

		EASYFInstallerHelper::setMenus($easy_metadata);
		EASYFInstallerHelper::setOptions($easy_metadata);
		EASYFInstallerHelper::setMediaData($easy_metadata);
		EASYFInstallerHelper::setWidgets($easy_metadata);
		EASYFInstallerHelper::setHomePage($easy_metadata);
		EASYFInstallerHelper::crum_masterslider_impot($folder);

		if ( $folder == 'data1' ) {
			EASYFInstallerHelper::crum_megamenu_settings('2746');
			EASYFInstallerHelper::crum_megamenu_settings('2758');

			EASYFInstallerHelper::crum_megamenu_columns('4','2746');
			EASYFInstallerHelper::crum_megamenu_columns('2','2758');

			EASYFInstallerHelper::crum_megamenu_full('2746');
		} else {
			EASYFInstallerHelper::crum_megamenu_settings('3392');

			EASYFInstallerHelper::crum_megamenu_columns('4','3392');

			EASYFInstallerHelper::crum_megamenu_full('3392');
		}
		
		EASYFInstallerHelper::crum_say_hello();
		
		EASYFInstallerHelper::crum_custom_css_import($folder);
		
		update_option('cps_shortcode_count','3');

		easy_import_end();
	}
	add_action('wp_ajax_crum_otherImport', 'crum_otherImport');
}
