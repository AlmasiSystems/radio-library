<?php
/*this page needs auth work done */

class PlaylistsController extends MyController {

	function init() {
        //call default init from MyController
        parent::init();
		//load model
		Zend_Loader::loadClass('Schedule');
		Zend_Loader::loadClass('Playlists');
		Zend_Loader::loadClass('Admin');
    }
    /*
	function preDispatch(){
		parent::init();
		$authSession = new Zend_Session_Namespace('Zend_Auth');
		$authSession->setExpirationSeconds(3600*3);
	}*/
    function indexAction()  {
        return $this->selectShowAction();
    }
    function selectSeasonAction()  {
        $this->view->title = "Playlist System";

        $this->render();
    }
    function selectShowAction()  {
        $this->view->title = "Playlist System";
		
		$schedule = new Schedule();
		$season_id = $schedule->getCurrentSeasonID();
		$the_season = $schedule->getSeason($season_id)->toArray();
		
		$the_events = $schedule->getAllJoinedEventsBySeason($season_id);
		
		$this->view->the_events = $the_events;
		$this->view->the_season = $the_season;
        $this->render('selectshow');
    }
    function manageAction()  {
        $this->view->title = "Playlist System";
		
		if($event_id = $this->getRequest()->getParam('event_id')){
		    
	
		    //load some classes
		    
			$schedule = new Schedule();
			$play = new Playlists();
			$admin = new Admin();
			$event = $schedule->getJoinedEvent($event_id);
			$season_id = $event['season_id'];
			$shows = $schedule->getAllShowsBySeason($season_id, true); //array indexed by show_id
			$djs = $admin->getAllDJInfo();
			
			//grab playlists created for this event already
			$playlists = $play->getPlaylistsByEvent($event_id);

            //make playlist array with date => playlist_id pairs
            $playlist_dates = array();
            if($playlists){
                //make playlist array indexed by playlist_id
                $playlists = $this->swapIndices($playlists);
                foreach($playlists as $pl){
                    $playlist_dates[$pl['date']] = $pl['id'];
                }
            }

            //get season info and figure out the date range
            $season = $schedule->getSeason($season_id)->toArray();
            
            $dotw = (int)$event['dotw'];

            //there should be a function that does this (couldn't find it)
            switch($dotw){
                case 0:
                    $dotw_name = "Sunday";
                    break;
                case 1:
                    $dotw_name = "Monday";
                    break;     
                case 2:
                    $dotw_name = "Tuesday";
                    break;
                case 3:
                    $dotw_name = "Wednesday";
                    break;
                case 4:
                    $dotw_name = "Thursday";
                    break;
                case 5:
                    $dotw_name = "Friday";
                    break;  
                case 6:
                    $dotw_name = "Saturday";
                    break;     
            }

            $season_start_time = strtotime($season['start_date']);
            $thegetdate = getdate($season_start_time);
            $season_start_dotw = $thegetdate['wday'];
            $season_end_time = strtotime($season['end_date']);
            $thegetdate = getdate(strtotime($season['end_date']));
            $season_end_dotw = $thegetdate['wday'];
            

            //current_time is the current time of the day to show in the looop
            if($dotw == $season_start_dotw){
                $current_time = $season_start_time;
            } else {
                $current_time = strtotime('next ' . $dotw_name, $season_start_time);
            }
            $the_dates = array();
            $the_playlists = array(); //the index with be playlist_date
            $upcoming_date = false;
			$last_show_id = 0;
            $today_start_time = strtotime('today'); //today at 12:00am
            $end_loop_time = strtotime('+1 day', $season_end_time);

			//this loop creates the possible dates for an event given a season
            while($current_time < $end_loop_time){
                $temp_mysql_date = date("Y-m-d", $current_time);

        
                if(isset($playlist_dates[$temp_mysql_date])){
                    $temp_playlist_id = $playlist_dates[$temp_mysql_date];
					$the_temp_playlist = $playlists[$temp_playlist_id];
                    

					//add show name for easy access
					$the_temp_playlist['show_name'] = $shows[$the_temp_playlist['show_id']]['show_name'];
					
					//add times for easy access
					$the_temp_playlist['start_time'] = $event['start_time'];
					$the_temp_playlist['end_time'] = $event['end_time'];

					//add groups to form
					$the_temp_playlist['options_group1']['opt_live'] = $the_temp_playlist['opt_live'];
					$the_temp_playlist['options_group1']['opt_guest'] = $the_temp_playlist['opt_guest'];
					$the_temp_playlist['options_group1']['opt_sports'] = $the_temp_playlist['opt_sports'];
					$the_temp_playlist['options_group1']['opt_theme'] = $the_temp_playlist['opt_theme'];
					$the_temp_playlist['options_group1']['opt_tickets'] = $the_temp_playlist['opt_tickets'];
					
					$the_temp_playlist['subs_group']['sub_dj1_id'] = $the_temp_playlist['sub_dj1_id'];
					$the_temp_playlist['subs_group']['sub_dj2_id'] = $the_temp_playlist['sub_dj2_id'];
					
					//update last show_id so that alternating shows alternate default shows
					$last_show_id = $the_temp_playlist['show_id'];

					//now add to array
					$the_playlists[$the_temp_playlist['date']] = $the_temp_playlist;
                } else {
                    $temp_play_array = array(
                        "date" => $temp_mysql_date,
                        "event_id" => $event_id, 
						"start_time" => $event['start_time'],
						"end_time" => $event['end_time']
                        );
					//guess which show should be used for alternating shows
					if(isset($event['alt_show_id'])){
						if($last_show_id == $event['alt_show_id']){
							$use_alternate_bool = false;
							$last_show_id = $event['show_id'];
						} else {
							$use_alternate_bool = true;
							$last_show_id = $event['alt_show_id'];
						}
					} else {
						$use_alternate_bool = false;
						$last_show_id = $event['show_id'];
						
					}
					if(isset($event['alt_show_id']) && $event['alt_show_id'] && $use_alternate_bool){
						$temp_play_array['show_id'] = $event['alt_show_id'];
						$temp_play_array['show_name'] = $event['alt_show_name'];
					} else {
						$temp_play_array['show_id'] = $event['show_id'];
						$temp_play_array['show_name'] = $event['show_name'];
					}
					$the_playlists[$temp_play_array['date']] = $temp_play_array;
                }
     
                if(!$upcoming_date && $current_time >= $today_start_time){
                    $upcoming_date = $temp_mysql_date;
                    $upcoming_playlist = $the_playlists[$upcoming_date];
                }
                
     
                //go to next week
                $old_time = $current_time;
                $current_time = strtotime('next ' . $dotw_name, $current_time);
            }
            
            //if the user is selecting something other than the upcoming
            if($playlist_date = $this->getRequest()->getParam('date')){
                $playlist_to_edit = $the_playlists[$playlist_date];

            } else {
                $playlist_to_edit = $upcoming_playlist;
				$playlist_date = $upcoming_date;
            }
            
            
            //now that everything is figured out, lets get onto the form (for comments)
            require_once('editplaylist.form.php'); //quickform class
            $form = new editPlaylistForm("/playlists/manage/event_id/$event_id/date/$playlist_date/", 'Update Show Details', $season_id); 

    		//change renderer for xhtml
    		$renderer = new HTML_QuickForm_Renderer_Tableless();
			//change template for form element explanations
			$elementTemplate = "\n\t\t\t<li><div class=\"element<!-- BEGIN error --> error<!-- END error -->\"><!-- BEGIN error --><span class=\"error\">{error}</span><br /><!-- END error -->{element}<!-- BEGIN label_2 --><span class=\"explanation\">{label_2}</span><!-- END label_2 --></div><!-- BEGIN label_3 --><br /><span class=\"details\">{label_3}</span><!-- END label_3 --><br /></li>";
	        
	        $renderer->setElementTemplate($elementTemplate);

			
            if ($form->validate()) {
                //get data from form
                $data = $form->exportValues();
                //remove submit element (so it wont clog up db update/insert)
                unset($data['submit']);
				
				//fix the groups for playlist options/subs
	            $element_groups = array('options_group1', 'subs_group');
	            foreach($element_groups as $grp){
	                if(isset($data[$grp])){
	                    foreach($data[$grp] as $key => $val){
	                        $data[$key] = (int)$val;
	                    }
	                    unset($data[$grp]); //for sql unclog
	                }
	            }

				//fix possible sub dj2 without dj1 existing
				if(isset($data['sub_dj1_id']) && !$data['sub_dj1_id'] && isset($data['sub_dj1_id']) && $data['sub_dj1_id']){
					$data['sub_dj1_id'] = $data['sub_dj2_id'];
					unset($data['sub_dj2_id']);
				}
				/*
				//image url rename
				$new_name = (string)$data['event_id'] . '_' . (string)$data['date'] . '.jpg';
				$new_path = './public/pictures/playlist/';
				if (file_exists($new_path . $new_name) && $data['image_url'] != ''){
					$new_url = 'http://kdvs.org/public/pictures/playlist/' . $new_name;
					$data['image_url'] = $new_url;
					$data['picture'] = 1;
				
					//fix for playlist to edit
					$playlist_to_edit['image_url'] = $new_url;
				} else {
					$data['image_url'] = "";
					$data['picture'] = 0;
				}
				*/
                //update playlist            
                $playlist_id = $play->updatePlaylist($data);        

    			$this->view->the_message = 'Show Details Edited Successfully.';

				$this->_redirect("/playlists/manage/event_id/$event_id/date/$playlist_date/");
            } 
            
	
			

			//gives form all info it needs
			$form->setDefaults($playlist_to_edit);
			
            $form->accept($renderer);
    		$this->view->comment_form = $renderer->toHtml();
		
			$img_name = (string)$playlist_to_edit['event_id'] . '_' . (string)$playlist_to_edit['date'] . '.jpg';
			if (isset($playlist_to_edit['image_url']) &&  $playlist_to_edit['image_url'] != ''){
				$this->view->the_image = '<img src="/public/phpThumb/phpThumb.php?w=200&src=' . $playlist_to_edit['image_url'] .'" />';
			} else {
				$this->view->the_image = '<div style="height: 200px">No Image URL Provided</div>';
			}
			
			
			//pass to view
			$this->view->the_event = $event;
			$this->view->event_id = $event_id;
			$this->view->date_formatted = date("l F j, Y", strtotime($playlist_to_edit['date']));
			$this->view->the_playlists = $the_playlists;
			$this->view->playlist_to_edit = $playlist_to_edit;
			$this->view->upcoming_date = $upcoming_date;
			$this->view->the_shows = $shows;
			$this->view->the_djs = $djs;
			
			//are they trying to change the date?
			if($this->getRequest()->getParam('switch')){
				$this->render('selectdate');
			} else {		
        		$this->render('manage');
			}
		} else { //just go to select show
			return $this->selectShowAction();
		}
    }

	function tracksAction(){
	    //make auto log off 3 times longer
	    $authSession = new Zend_Session_Namespace('Zend_Auth');
		$authSession->setExpirationSeconds(3600*3);
		
		$this->view->title = "Playlist Track Manipulator";

		Zend_Loader::loadClass('Playlists');
		$play = new Playlists();
		if($playlist_id = $this->getRequest()->getParam('playlist_id')){
			$playlist = $play->getPlaylistJoined($playlist_id);
			
			$the_tracks = $play->getAllTracksByPlaylist($playlist_id);
			if ($the_tracks){
				$the_tracks = $the_tracks->toArray();
			}
			
			$this->view->playlist_id = $playlist_id;
			$this->view->the_playlist = $playlist;
			$this->view->the_tracks = $the_tracks;
			$this->view->date_formatted = date("l F j, Y", strtotime($playlist['date']));
			$this->view->show_name = $playlist['show_name'];
        	$this->render('tracks');
	
		} else {
			$this->_redirect('/playlists/');
		}
	}
	function createAction(){
					
		
		$data = array();
		$data['event_id'] = $this->getRequest()->getParam('event_id');
		$data['date'] = $this->getRequest()->getParam('date');
		$data['show_id'] = $this->getRequest()->getParam('show_id');
		$data['start_time'] = $this->getRequest()->getParam('start_time');
		$data['end_time'] = $this->getRequest()->getParam('end_time');

		$play = new Playlists();
		$playlist_id = $play->updatePlaylist($data);
		
		if($playlist_id){
			$this->_redirect("/playlists/tracks/playlist_id/$playlist_id/");
		} else { //something broke (shouldn't happen ;)
			$this->_redirect('/playlists/');
		}
		
	}
    /*util*/
    function swapIndices($data){
		$new_array = array();
		foreach($data as $row){
			$new_array[$row['id']] = $row;
		}
		return $new_array;
	}
}
