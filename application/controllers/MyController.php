<?php

class MyController extends Zend_Controller_Action {
    function init(){
        $this->initView();
        $this->view->addHelperPath('application/views/helpers', 'My_View_Helper');
        
        //for urls
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->c_action = strtolower($this->_request->getActionName());
        $this->view->c_controller = strtolower($this->_request->getControllerName());
        
        //get auth
        $auth = Zend_Auth::getInstance();
        
        //get user info
        $this->view->user = $auth->getIdentity();

	    //commonly needed
	    define('STATION_NAME', Zend_Registry::get('config')->application->station_name);
	    define('STATION_MAIN_SITE', Zend_Registry::get('config')->application->station_main_site);
    }
    
    function preDispatch() {
        //make sure user is logged in for ALL actions (except Auth/Options controller, which overrides preDispatch())
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_forward('login', 'auth');
        }
        //set login timeout to 20 min (3600 sec)
		$authSession = new Zend_Session_Namespace('Zend_Auth');
		$authSession->setExpirationSeconds(3600);
		
        //figure out privledges (are they allowed to be at the current action?)
        $access = $auth->getStorage()->read();
        
        $current_action = strtolower($this->_request->getActionName());
        $current_controller = strtolower($this->_request->getControllerName());
        if(!$this->hasAccess($current_controller, $current_action, $access)){
//	    	echo "denied<br />";
            $this->_forward('access', 'error', null, array('action' => $current_action, 'controller' => $current_controller));
        }
//      echo "allowed<br />";
    }
    //function returns bool based on if users stored access allows for controller_action pair
    function hasAccess($controller, $action, $access){
        //controllers everyone that is logged into can see (this should be in a config)
        // and get access to ALL actions for these controllers
        $allowed_controllers = array('index', 'auth', 'error');
        
//        print_r($access);
//        echo "||controller_action - ".$controller . "_" . $action."|access[] - ".$access[$controller . "_" . $action]."||";
        
        //if you can login, you can access the allowed_controllers
        if (in_array($controller, $allowed_controllers)){ 
            return true;
        //if the action is index, then we just test if controller has access
        }elseif($action == 'index'){
            return in_array($controller, $access['controllers']);
        //else, see if controller_action exists and is true
        }elseif (isset($access[$controller . "_" . $action]) && $access[$controller . "_" . $action]){
            return true;
        }
        //fall back to no access
        return false;
    }
    //returns an array of "action" => "Menu Item Title" pairs for use with CreateMenu helper

}