<?php

class ArchiveController extends MyController {
    function preDispatch(){
		//override to allow everyone access
		
		//set login timeout to 20 min (3600 sec)
		$authSession = new Zend_Session_Namespace('Zend_Auth');
		$authSession->setExpirationSeconds(3600);
		
		Zend_Loader::loadClass('Schedule');
		Zend_Loader::loadClass('Playlists');
	}
    function indexAction()  {
        Zend_Loader::loadClass('Schedule');
        $schedule = new Schedule();
        if(!$season_id = $this->getRequest()->getParam('season_id')){
        	$season_id = $schedule->getCurrentSeasonID();
        }
		
		$the_season = $schedule->getSeason($season_id)->toArray();
		
		$the_events = $schedule->getAllJoinedEventsBySeason($season_id);
		
		$this->view->the_events = $the_events;
		$this->view->the_season = $the_season;

        $this->render();
    }
    
    function selectSeasonAction(){
    	Zend_Loader::loadClass('Schedule');
        $schedule = new Schedule();
    	$seasons = $schedule->getAllSeasons();
    	
    	//only show seasons with archives
    	$a_seasons = array();
    	foreach($seasons as $s){
    		if($s['id'] >= 24){
    			$a_seasons[] = $s;
    		}
    		
    	}
    	
    	$this->view->the_seasons = $a_seasons; 
    	$this->render();
	}

    /*
    function viewAction(){
		Zend_Loader::loadClass('Schedule');
		Zend_Loader::loadClass('Playlists');
		if($show_id = $this->getRequest()->getParam('show_id')){
			
			$play = new Playlists();
			$schedule = new Schedule();
			$playlists = $play->getPlaylistsByShow($show_id); //indexed by playlist_id, ordered by date
			$playlists = array_reverse($playlists, true); //order from newest to oldest
			$show = $schedule->getJoinedShow($show_id);
			$the_tracks = false;

		
			if($playlists){ //playlists have been found!
				$new_playlists = array();
				foreach($playlists as $t_play){
					var_dump($t_play);
				}

				
			} else {
				//no playlists to show, just give em their description
				$playlist_to_view = false;
				$playlist_id = 0;
			}
			

		
			$this->view->the_show = $show;
			$this->view->the_playlists = $playlists;
		
			
		} 
		$this->render('view');
	}
	*/
	function viewAction()  {
        $this->view->title = "Show Archives";
		
		if($show_id = $this->getRequest()->getParam('show_id')){
		    
	
		    //load some classes
		    
			$schedule = new Schedule();
			$play = new Playlists();
			$show = $schedule->getShow($show_id)->toArray();
			//$season_id = $schedule->getCurrentSeasonID();
			$season_id = $show['season_id'];
			$show = $schedule->getJoinedShow($show_id); //array indexed by show_id

			
			//grab playlists created for this show
			$playlists = $play->getPlaylistsByShow($show_id);

            //make playlist array with date => playlist_id pairs
            /*
            $playlist_dates = array();
            if($playlists){
                //make playlist array indexed by playlist_id
                $playlists = $this->swapIndices($playlists);
                foreach($playlists as $pl){
                    $playlist_dates[$pl['date']] = $pl['id'];
                }
            }
            */
            //get season info and figure out the date range
            $season = $schedule->getSeason($season_id)->toArray();
            
            $events = $schedule->getEventByShowID($show_id);
	        $the_shows = array();
			foreach($events as $event){
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

	            $upcoming_date = false;
				$last_show_id = 0;
	            $today_start_time = strtotime('today'); //today at 12:00am
	            //$end_loop_time = strtotime('+1 day', $season_end_time);
	            if($season_id == $schedule->getCurrentSeasonID()){
	                $end_loop_time = strtotime('+1 day', $today_start_time);
	                $bitrates = array('32', '128', '192', '320');
	            } else {
	                $end_loop_time = $season_end_time;
	                $bitrates = array('32','192');
	            }
				//this loop creates the possible dates for an event given a season
				$server_address = 'http://169.237.101.62/archives/';
	            while($current_time < $end_loop_time){
	                $temp_mysql_date = date("Y-m-d", $current_time);
	                $temp_show = array();
	                $temp_mp3_prefix = $temp_mysql_date . '_' .$show_id . '_';
	                $temp_show['date'] = $temp_mysql_date;
                
	                $temp_mp3s = array();
	                foreach($bitrates as $br){
	                    $temp_mp3s[$br] = $server_address . $temp_mp3_prefix . $br . 'kbps.mp3'; 
	                }
	                $temp_show['mp3s'] = $temp_mp3s;
	                $the_shows[$temp_mysql_date] = $temp_show;
	                //go to next week
	                $old_time = $current_time;
	                $current_time = strtotime('next ' . $dotw_name, $current_time);
	            }

 			}
			
			//sort by index (date)
			sort($the_shows);
			//and reverse to give better order
            $the_shows = array_reverse($the_shows, true); //order from newest to oldest

			//pass to view
			$this->view->the_mp3s = $the_shows;
			$this->view->the_show = $show;
	
        	$this->render('view');

		}
    }
}
