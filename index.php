<?php
error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');

set_include_path('.' . PATH_SEPARATOR . './library/'
	 . PATH_SEPARATOR . './application/models'
	 . PATH_SEPARATOR . './application/controllers'
	 . PATH_SEPARATOR . './application/classes'
	 . PATH_SEPARATOR . './application/forms'
	 . PATH_SEPARATOR . './library/PEAR'
	 . PATH_SEPARATOR . './library/phpbrainz'
	 . PATH_SEPARATOR . get_include_path());
include("Zend/Loader.php");

Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_Session_Namespace');
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Config_Ini');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Debug');
Zend_Loader::loadClass('Zend_Auth');
Zend_Loader::loadClass('MyController'); //custom controller class, in /controllers
Zend_Loader::loadClass('MyModel'); //custom model class, in /models

//non zend classes
require_once('HTML/QuickForm.php');
require_once('HTML/QuickForm/Renderer/Tableless.php');


// load configuration
$config = new Zend_Config_Ini('./application/config.ini', 'general');
Zend_Registry::set('config', $config);

// setup database
$dbAdapter = Zend_Db::factory($config->db->adapter, 
        $config->db->config->toArray());
Zend_Db_Table::setDefaultAdapter($dbAdapter);
Zend_Registry::set('dbAdapter', $dbAdapter);

// setup controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory('./application/controllers');

// run!
$frontController->dispatch();
