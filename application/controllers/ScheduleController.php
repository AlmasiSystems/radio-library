<?php


class ScheduleController extends MyController {
    function init() {
        //call default init from MyController
        parent::init();
		//load model
		Zend_Loader::loadClass('Schedule');
    }
    function indexAction(){
		$this->view->title = "Schedule Manipulator";
        $this->render('index');
    }
	function seasonsAction(){
		return $this->addSeasonAction();
	}
	function addSeasonAction(){
		$this->view->title = "Schedule Manipulator";
		
		require_once('editseason.form.php'); //quickform class
        $form = new editSeasonForm('/schedule/addSeason', 'Add Season'); //pass the action param of form as string, button val
		
		//change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();

        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            //get model
            $model = new Schedule();
            
            //insert user            
            $season_id = $model->updateSeason($data);        
            
			$this->view->the_message = 'Season Added Successfully. <a href="/schedule/showtransfer/">Click to transfer shows from past seasons</a>';
        } else {
			$form->accept($renderer);
			$this->view->the_form = $renderer->toHtml();
        }
		$this->render('addseason');
	}
	function editSeasonAction(){

		$model = new Schedule();
		
		if($this->getRequest()->getParam('season_id')){
			$season_id = $this->getRequest()->getParam('season_id');
			require_once('editseason.form.php'); //quickform class
	        $form = new editSeasonForm('/schedule/editSeason/id/'.$season_id, 'Edit Season');
	
			//change renderer for xhtml
			$renderer = new HTML_QuickForm_Renderer_Tableless();
			
			if ($form->validate()) { //posted and validated
	            //get data from form
	            $data = $form->exportValues();
	            //remove submit element (so it wont clog up db update/insert)
	            unset($data['submit']);

	            //insert user            
	            $season_id = $model->updateSeason($data);        

				$this->view->the_message = 'Season Edited Successfully. <a href="/schedule/editSeason/">Edit Another</a>';
	        } else { //grab data from db
			
				$season = $model->getSeason($season_id)->toArray();
				
				$form->setDefaults($season);
						
				$form->accept($renderer);
				$this->view->the_form = $renderer->toHtml();
	        }
			
		} else {
			$this->view->seasonselector = true;
			$this->view->seasons = $model->getAllSeasons();
			$this->view->the_action = 'editSeason';
		}
		$this->render('editseason');
	}
	function showsAction(){
		return $this->addShowAction();
	}
	function addShowAction(){
		$this->view->title = "Schedule Manipulator";
		
		require_once('editshow.form.php'); //quickform class
        $form = new editShowForm('/schedule/addShow', 'Add Show'); //pass the action param of form as string, button val
		
		//change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();

        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            //get model
            $model = new Schedule();
            
            //deal with genre groups
            $num_genre_groups = 5;
            for($i = 1; $i <= $num_genre_groups; $i++){
                if(isset($data['genres_group'.$i])){
                    foreach($data['genres_group'.$i] as $key => $val){
                        $data[$key] = (int)$val;
                    }
                    unset($data['genres_group'.$i]);
                }
            }

            //insert show            
            $season_id = $model->updateShow($data);        
            
			$this->view->the_message = 'Show Added Successfully. <a href="/schedule/addShow/">Add Another</a>';
        } else {
			$form->accept($renderer);
			$this->view->the_form = $renderer->toHtml();
        }
		$this->render('addshow');
	}
	function editShowAction(){
		$this->view->title = "Schedule Manipulator";
		$model = new Schedule();
		
		if($this->getRequest()->getParam('season_id')){
			$season_id = $this->getRequest()->getParam('season_id');
			$season = $model->getSeason($season_id)->toArray();
			
			$this->view->season_title = $season['title'];
			$this->view->season_id = $season_id;
			
			//automatically show show to edit if passed show_id as param
			if($this->getRequest()->getParam('show_id')){
				$this->view->show_id = $this->getRequest()->getParam('show_id');
			}
			
		} else {
			$this->view->seasonselector = true;
			$this->view->seasons = $model->getAllSeasons();
			$this->view->the_action = 'editShow';
		}
		$this->render('editshow');
	}
	function browseShowsAction(){
		$this->view->title = "Schedule Manipulator";
		$model = new Schedule();
		
		if($this->getRequest()->getParam('season_id')){
			$season_id = $this->getRequest()->getParam('season_id');
			$season = $model->getSeason($season_id)->toArray();
			
			$this->view->season_title = $season['title'];
			$this->view->season_id = $season_id;
			
			//grab shows for the particular season
			$shows = $model->getAllShowsBySeason($season_id);
			$this->view->the_shows = $shows;
			
			//grab all show types
			$show_types = $model->getAllShowTypes();
			$this->view->show_types = $show_types;			
			
			//grab all users and pass to view
			Zend_Loader::loadClass('Admin');
			$user_model = new Admin();
			$this->view->the_djs = $user_model->getAllDJInfo();
			
		} else {
			$this->view->seasonselector = true;
			$this->view->seasons = $model->getAllSeasons();
			$this->view->the_action = 'browseShows';
		}
		$this->render('browseshows');
	}
	function scheduleAction(){
		$this->view->title = "Schedule Manipulator";
		$model = new Schedule();
		
		if($this->getRequest()->getParam('season_id')){
			$season_id = $this->getRequest()->getParam('season_id');
			$season = $model->getSeason($season_id)->toArray();
			
			$this->view->season_title = $season['title'];
			$this->view->season_id = $season_id;
					
		} else {
			$this->view->seasonselector = true;
			$this->view->seasons = $model->getAllSeasons();
			$this->view->the_action = 'schedule';
		}
		$this->render('schedule');
	}	
	function editEventAction(){
		$model = new Schedule();
		if($this->getRequest()->getParam('season_id')){
			$season_id = $this->getRequest()->getParam('season_id');
			$event_id = $this->getRequest()->getParam('id');
			require_once('editevent.form.php'); //quickform class
	        $form = new editEventForm('/schedule/editEvent/season_id/'.$season_id, 'Edit Show Spot', $season_id);
	
			//change renderer for xhtml
			$renderer = new HTML_QuickForm_Renderer_Tableless();
			
			if ($form->validate()) { //posted and validated
	            //get data from form
	            $data = $form->exportValues();
	            //remove submit element (so it wont clog up db update/insert)
	            unset($data['submit']);
					
				//add some stuff
				$data['season_id'] = $season_id;	
					
	            //insert event            
	            $event_id = $model->updateEvent($data);        
				
				//send stuff to view for js stuff
				$this->view->event_saved = true;
				
	        } else { //grab data from db
			
				$event = $model->getEvent($event_id);
				if($event){
					$form->setDefaults($event->toArray());
				}		
				$form->accept($renderer);
				$this->view->the_form = $renderer->toHtml();
				
	        }
			
		} else {
			die('no season sent to window');
		}
		$this->render('editevent');
	}
}