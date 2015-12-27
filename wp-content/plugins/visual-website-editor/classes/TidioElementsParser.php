<?php

if(!class_exists('phpQuery'))

	require 'TidioElementsParser/PhpQuery.php';
	
//

class TidioElementsParser {
	
	private static $cache = false;
	private static $apiData = null;
	private static $apiHost = 'http://apps.tidioelements.com/api-parse-data/';
	private static $projectPublicKey;
	private static $editedElements = array();
	private static $sitePath;
	private static $htmlElements = array();
	private static $parseMode = false;
	public static $cacheDirectory = null;
			
	public static function start($projectPublicKey){
						
		self::$sitePath = $_SERVER['REQUEST_URI'];
		
		if(empty(self::$sitePath)){
			self::$sitePath = '/';
		}
						
		//		
				
		self::$projectPublicKey = $projectPublicKey;
				
		self::loadApiData();
		 
		self::refreshApiDataCache();
		
		//
											
		if(!self::$apiData || !is_array(self::$apiData) || empty(self::$apiData['wysiwyg_elements']) || ini_get('allow_url_fopen')!=='1'){
			return false;
		}
					
		self::$parseMode = true;

		ob_start('TidioElementsParser::render');
		
		
	}

	public static function end(){

		if(!self::$apiData || !self::$parseMode)
			
			return false;
		
		@ob_end_flush();
				
		
	}
	
	public static function render($html){
									
		$html = preg_replace('@\<head(.*?)\>@si', '<head>', $html, 1);
		
		// Prepare "html"	
				
		// Replace "doctype"
		
		preg_match('@(.*?)\<html>@si', $html, $htmlTagMatch);
		
		$htmlDoctypeReplace = '';
		
		if(strstr(strtolower($htmlTagMatch[1]), 'dtd xhtml')){ // is xhtml
			$htmlDoctypeReplace = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		} else if(strstr(strtolower($htmlTagMatch[1]), 'dtd html 4')){ // is html4
			$htmlDoctypeReplace = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		} else if(strstr(strtolower($htmlTagMatch[1]), '<!doctype html')){ //is html5
			$htmlDoctypeReplace = '<!doctype html>';
		}
		
		
		if(!empty($htmlDoctypeReplace)){
			$html = str_replace($htmlTagMatch[1], $htmlDoctypeReplace, $html);
		}
				
		// Render
		
		$doc = phpQuery::newDocument($html);
		
		//
		
		$docHtml = $doc->find('html');
		
		if(!$docHtml->attr('id')){
			$docHtml->attr('id', 'tidio-editor-page');
		}
				
		// If "head" dosen't exsits we gonna added ownself
		
		$eleHead = $doc->find('head');
		
		if(!$eleHead->length){
			
			$headContent = '';
			
			preg_match('@\<head\>(.*?)\<\/head\>@si', $html, $headMatches);
			
			if(!empty($headMatches[1])){
				$headContent = $headMatches[1];
			}
			
			//
			
			$eleHtml = $doc->find('html');
			
			$eleHtml->prepend('<head__>'.$headContent.'</head__>');
			
		}
		
		// Plugin List
		
		if(!empty(self::$apiData)){
		
			$editedElements = array();
					
			foreach(self::$apiData['wysiwyg_elements'] as $e){
					
				// compare url	
				
				if(!self::compareURL($e)){
					
					continue;
					
				}
								
				//
				
				$ele = null;
				
				if(!empty($e['data']['selector_source'])){
					$ele = $doc->find($e['data']['selector_source']);
				}
				
				if(!$ele || !$ele->length){
					$ele = $doc->find($e['selector']);
				}
				
				if(!$ele || !$ele->length){
					continue;
				}
									
				//
				
				if($e['type']=='edit'){
					$ele->html($e['html']);
				}
				
				if($e['type']=='delete'){
					$ele->remove();
				}
				
				$editedElements[] = $e['id'];
				
			}
			
			self::$editedElements = $editedElements;
		
		}
				
		// wp - compability mode
		
		if(class_exists('TidioPluginsScheme')){
			
			foreach(TidioPluginsScheme::$insertCode as $e){
				self::$htmlElements[] = array(
					'placement' => 'prependHead',
					'html' => $e
				);
			}
			
		}
						
		// Append JavaScript
		
		$head = $doc->find('head');
		
		//
				
		$head->prepend('<script type="text/javascript" src="https://www.tidioelements.com/redirect/'.self::$projectPublicKey.'.js"></script>');		

		$head->prepend('<script type="text/javascript">var tidioElementsEditedElements = '.json_encode(self::$editedElements).';</script>');
		
		//

		foreach(self::$htmlElements as $e){
			if($e['placement']=='prependHead'){
				$head->prepend($e['html']);
			}
		}
		
		// Render HTML
		
		$docHtml = $doc->htmlOuter();
		
		$docHtml = str_replace('head__', 'head', $docHtml);
				
		return $docHtml;
		
	}
	
	public static function addHtml($html, $placement = 'prependHead'){
		
		self::$htmlElements[] = array(
			'html' => $html,
			'placement' => $placement
		);
		
	}
	
	private static function compareURL($e){
		
		if($e['url_global']){	
			return true;
		}
		
		if(!is_array($e['url']) && $e['url']==self::$sitePath){
			return true;
		}
		
		return false;
		
	}
		
	private static function loadApiData($noCache = false){
			
		if(!$noCache){	
			
			self::$apiData = self::getApiDataCache();	
			
			if(self::$apiData){
				return true;
			}
		
		}
				
		//
		
		$apiUrl = self::$apiHost.'?projectPublicKey='.self::$projectPublicKey;
				
		$apiData = self::loadUrlData($apiUrl);
		
		if(!$apiData)
			return false;
			
		$apiData = json_decode($apiData, true);
		
		if(!$apiData || !$apiData['status'])
			
			return false;
			
		//
			
		self::$apiData = $apiData['value'];
		
		if(self::$apiData==null){	
			self::$apiData = true;
		}
				
		
		return true;		
	}
	
	// AddOn Get Cache
	
	private static function getApiDataCache($reload = false){
		
		$cache = get_option('tidio-visual-cache');
		
		if(!$cache || $reload){
			
			self::loadApiData(true);
			
			$cache = serialize(self::$apiData);
			
			update_option('tidio-visual-cache', $cache);
			
			// Update Parser Status
			
			self::updateParserStatus('1');
			
		}
		
		return unserialize($cache);
		
	}
	
	private static function updateParserStatus($status){
		
		self::loadUrlData('http://www.tidioelements.com/apiEditor/updateParserStatus/'.self::$projectPublicKey.'?parserStatus='.$status);
		
	}
	
	private static function refreshApiDataCache(){
		
		if(empty($_GET['tidioElementsRefreshCache'])){
			return false;
		}
		
		self::getApiDataCache(true);
		
		echo json_encode(array(
			'status' => true,
			'value' => true
		));
		
		exit;
		
	}
	
	//
		
	private static function loadUrlData($url){
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
		$content = curl_exec($ch);
		curl_close($ch);
			
		return $content;
		
	}
	
}

$wpUpload = wp_upload_dir();

TidioElementsParser::$cacheDirectory = $wpUpload['basedir'].'/tidioElementsCache/';



