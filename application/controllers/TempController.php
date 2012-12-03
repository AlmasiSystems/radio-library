<?php

class TempController extends MyController {
    function preDispatch(){
		//override to allow everyone access
		
		//set login timeout to 20 min (3600 sec)
		$authSession = new Zend_Session_Namespace('Zend_Auth');
		$authSession->setExpirationSeconds(3600);
	}
    function indexAction()  {
		Zend_Loader::loadClass('Schedule');
        $schedule = new Schedule();
		//$season_id = $schedule->getCurrentSeasonID();
		$season_id = 26;
		$the_events = $schedule->getAllJoinedEventsBySeason($season_id);
		
		$this->view->the_events = $the_events;

        $this->render();
    }

}