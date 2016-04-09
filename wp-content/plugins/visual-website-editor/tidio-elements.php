<?php

/**
 * Plugin Name: Visual Website Editor
 * Plugin URI: http://www.tidioelements.com
 * Description: Visual Website Editor for WordPress powered by Tidio Elements
 * Version: 1.4.2
 * Author: Tidio Ltd.
 * Author URI: http://www.tidioelements.com
 * License: GPL2
 */
 
if(!class_exists('TidioPluginsScheme')){
	 require "classes/TidioPluginsScheme.php";
}
 
if(!defined('VISUAL_EDITOR_PATH')){
	define('VISUAL_EDITOR_PATH', plugin_dir_path(__FILE__));
}


class TidioVisualEditor {
	
	private $scriptUrl = 'https://www.tidioelements.com/redirect/';
	
	private $apiHost = 'http://visual-editor.tidioelements.com/';
	
	private $pageId = '';
	
	private $projectPublicKey;
	
	private $parseMode = false;
				
	public function __construct() {
								
		add_action('admin_menu', array($this, 'addAdminMenuLink'));
		
		add_action('deactivate_'.plugin_basename(__FILE__), array($this, 'uninstall'));	

		add_action('admin_footer', array($this, 'adminJS'));

		add_action('wp_ajax_visual_editor_redirect', array($this, 'ajaxVisualEditorRedirect'));
				
		if(!is_admin()){
			add_action('wp_head', array($this, 'jsRedirectCodeRescure'));
		}
		
		// Parse - Init
				
		$this->parseStart();
		
	}

	public function __destruct(){
		
		if($this->projectPublicKey && !is_admin()){
			$this->parseEnd();
		}
		
	}
	
	// JS Code - Rescure
	
	public function jsRedirectCodeRescure(){
		
		echo "
		<script data-type='tidioelements' type='text/javascript'>
		if(typeof tidioElementsEditedElements=='undefined'){
			var s = document.createElement('script');
			s.type = 'text/javascript';
			s.src = 'https://tidioelements.com/redirect/".get_option('tidio-visual-public-key').".js';
			document.getElementsByTagName('head')[0].appendChild(s);
		}
		</script>
		";
		
	}
	
	// Visual Editor Redirect
	
	public function ajaxVisualEditorRedirect(){
		
		$view = array(); 
		if(get_option('tidio-visual-private-key')){
			
			$view['mode'] = 'redirect';
			$view['url_redirect'] = $this->getRedirectUrl();
		} else if(empty($_GET['mode'])){
			
			$view['mode'] = 'loading';
			$view['url_access'] = $this->getAccessUrl();
		} else if($_GET['mode']=='update_access_data' && !empty($_GET['public_key']) && !empty($_GET['access_key'])){
			
			update_option('tidio-visual-public-key', $_GET['public_key']);
			update_option('tidio-visual-private-key', $_GET['access_key']);
			
			$view['mode'] = 'redirect';
			$view['url_redirect'] = $this->getRedirectUrl();
		}
		
				
		include VISUAL_EDITOR_PATH.'views/ajax-redirect.php';
		
		exit;
		
	}
	
	// Admin JS
	
	public function adminJS(){
		
		// Stop if site is on localhost
		if($_SERVER['HTTP_HOST']=='localhost'){
			return false;
		}

		if(!get_option('tidio-visual-private-key')){ // If is not installed
			$redirectUrl = get_site_url().'/wp-admin/admin-ajax.php?action=visual_editor_redirect';
		} else { // If installed
			$redirectUrl = $this->getRedirectUrl();
		}
		
		// Print code
		
		echo 
		"<script>".
			"try { ".
			"var ele = document.querySelector('a[href=\"admin.php?page=tidio-visual-editor\"]');".
			"if(ele){".
				"ele.setAttribute('href', '".$redirectUrl."'); ele.setAttribute('target', '_blank');".
			"}".
			"} catch(e){} ".
		"</script>";
		
	}
	
	/*
	** URLs
	*/
	
	private function getAccessUrl(){
	
		$privateKey = md5(microtime().mt_rand(1,100000).get_site_url());
		
		$siteUrl = get_site_url();
		
		$accessUrlData = array(
			'key' => $privateKey,
			'url' => $siteUrl,
			'platform' => 'wordpress',
			'_ip' => $_SERVER['REMOTE_ADDR']
		);
				
		if(ini_get('allow_url_fopen')!=='1'){
			$accessUrlData['remote'] = true;
		}
		
		//
		
		return $this->apiHost.'editor-visual/accessProject?'.http_build_query($accessUrlData);
		
	}
	
	private function getRedirectUrl(){
		return $this->apiHost.'editor-visual/'.get_option('tidio-visual-public-key').'?key='.get_option('tidio-visual-private-key').'&platform=wordpress';
	}
	
		
	/*
	** Parsing
	*/
	 
	private function parseStart(){

		// if this is site page, and integrator options dosen't exsist

		if(!is_admin() && !get_option('tidio-elements-project-data')){	
			$this->parseMode = true;
		}
		
		if($this->parseMode){
									
			$this->projectPublicKey = get_option('tidio-visual-public-key');
			
			if($this->projectPublicKey){
				
				if(!class_exists('TidioElementsParser'))
					require 'classes/TidioElementsParser.php';
				
				TidioElementsParser::start($this->projectPublicKey);
				
			}
			
		}
	}
	
	private function parseEnd(){
		
		if($this->parseMode){
			TidioElementsParser::end();
		}
				
	}
	
	// Uninstall
	
	public function uninstall(){
		delete_option('tidio-visual-public-key');
		delete_option('tidio-visual-private-key');
		TidioPluginsScheme::removePlugin('visual-editor');
	}
	
	// Menu Positions
	
	public function addAdminMenuLink(){
		
        $optionPage = add_menu_page(
			'Visual Editor', 'Visual Editor', 'manage_options', 'tidio-visual-editor', array($this, 'addAdminPage'), plugins_url(basename(__DIR__) . '/media/img/icon.png')
        );
        $this->pageId = $optionPage;
		
	}
	
    public function addAdminPage() {
        // Set class property
        $dir = plugin_dir_path(__FILE__);
        include $dir . 'options.php';
    }

			
	public function ajaxResponse($status = true, $value = null){
		
		echo json_encode(array(
			'status' => $status,
			'value' => $value
		));	
		
		exit;
			
	}
}

$TidioVisualEditor = new TidioVisualEditor();



