<?php

class IndexController extends MyController {
    
    function indexAction()  {
        $this->view->title = "Index";

        $this->render();
    }

}