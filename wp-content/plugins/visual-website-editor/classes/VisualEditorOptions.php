<?php

class VisualEditorOptions {
	
	private $apiHost = 'http://visual-editor.tidioelements.com/';
	
	private $siteUrl;
	
	private $siteIsValid = true;
	
	private static $integratorProjectData;
	
	public function __construct(){
		
		$this->siteUrl = $this->recognizeSiteUrl();
				
		$this->siteIsValid = $this->checkSiteIsValid();
		
	}
	
	public function recognizeSiteUrl(){
		
		if(!isset($_SERVER['HTTP_HOST']) || !isset($_SERVER['REQUEST_URI'])){
			
			return get_option('siteurl');
			
		}
		
		$siteUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				
		//
		
		preg_match('@(.*?)\/wp\-admin\/@si', $siteUrl, $matches);
		
		if(!empty($matches[1])){
			
			return $matches[1].'/';
			
		}
		
		return get_option('siteurl');
		
		
	}
	
	public function getPublicKey(){
		
		if(!$this->siteIsValid)
			
			return '';
		
		// integrator options check
		
		if($this->integratorProjectData()){
			
			return self::$integratorProjectData['public_key'];
			
		}
			
		//

		$publicKey = get_option('tidio-visual-public-key');

		if(!empty($publicKey))
			
			return $publicKey;
			
		//
		
		$apiData = $this->getContentData($this->apiHost.'editor-visual/accessProject?'.http_build_query(array(
			'key' => $this->getPrivateKey(),
			'url' => $this->siteUrl,
			'platform' => 'wordpress',
			'_ip' => $_SERVER['REMOTE_ADDR']
		)));
		
		$apiData = json_decode($apiData, true);
		
		if(!$apiData['status'])
		
			return false;
		
		$apiData = $apiData['value'];
		
		update_option('tidio-visual-public-key', $apiData['public_key']);
			
		return $apiData['public_key'];
	}
	
	public function getPrivateKey(){
		
		if(!$this->siteIsValid)
			
			return '';
		
		// integrator options check
		
		if($this->integratorProjectData()){
			
			return self::$integratorProjectData['private_key'];
			
		}
		
		//  
		
		$privateKey = get_option('tidio-visual-private-key');
		
		if(!empty($privateKey))
			
			return $privateKey;
			
		//
		
		$privateKey = md5(SECURE_AUTH_KEY.mt_rand(1,1000000).microtime());
		
		update_option('tidio-visual-private-key', $privateKey);
		
		return $privateKey;
		
	}
	
	public function getEditorUrl(){
				
		return $this->apiHost.'editor-visual/'.$this->getPublicKey().'?key='.$this->getPrivateKey().'&platform=wordpress';
				
	}
	
	public function siteIsValid(){
		
		return $this->siteIsValid;
		
	}
	
	public function integratorProjectData(){
		
		if(self::$integratorProjectData!==null){
			return self::$integratorProjectData;
		}
		
		$options = get_option('tidio-elements-project-data');
		
		if(!$options){
			self::$integratorProjectData = false;
			return false;
		}
		
		$options = json_decode($options, true);
		
		self::$integratorProjectData = $options;
		
		return self::$integratorProjectData;
		
	}
		
	private function checkSiteIsValid(){
		
		$urlParse = parse_url($this->siteUrl);
		
		if(empty($urlParse['host']))
			
			return false;
					
		if(in_array($urlParse['host'], array('127.0.0.1', 'localhost')))
			
			return false;
		
		//
			
		return true;
		
	}

	private function getContentData($url, $urlData = array()){
				
		if(!empty($urlData)){
			
			$url = $url.'?'.http_build_query($urlData);
			
		}
		
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
	
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
		
	}
	
}