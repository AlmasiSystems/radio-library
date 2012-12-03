<?php

class ErrorController extends MyController {
    function preDispatch() {
        
    }
    function indexAction(){
        $this->view->title = "Error";
        $this->render();
    }
    function accessAction(){
        
        $this->view->action = $this->_getParam('action');
        $this->view->controller = $this->_getParam('controller');
        
        $this->render();
    }
}