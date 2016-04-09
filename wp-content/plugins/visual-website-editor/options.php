<?php

if(!class_exists('TidioPluginsScheme')){
    require "classes/TidioPluginsScheme.php";	 
}

TidioPluginsScheme::registerPlugin('visual-editor');

if(!class_exists('VisualEditorOptions')){
    require 'classes/VisualEditorOptions.php';
}

$visualEditorOptions = new VisualEditorOptions();
$view = array();

if(!$visualEditorOptions->siteIsValid()){
	$view['mode'] = 'ERR_INVALID_URL';
} else {
    $view['mode'] = 'OK';
    $view['editorUrl'] = $visualEditorOptions->getEditorUrl();
}

wp_register_style('tidio-chat-css', plugins_url('media/css/options.css', __FILE__) );

wp_enqueue_style('tidio-chat-css' );


require 'options-view.php';