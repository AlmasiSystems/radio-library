<?php

class ApiController extends MyController {
	function init() {
        //call default init from MyController
        //parent::init();
        //load model
        Zend_Loader::loadClass('Schedule');
		Zend_Loader::loadClass('Playlists');
		Zend_Loader::loadClass('Admin');
		Zend_Loader::loadClass('Zend_Filter_HtmlEntities');
		Zend_Loader::loadClass('Zend_Json');
    $this->view->addHelperPath('application/views/helpers', 'My_View_Helper');
    }
    function preDispatch() {

	  }
  
  function showAction(){

  		if($show_id = $this->getRequest()->getParam('show_id')){

  			$play = new Playlists();
  			$schedule = new Schedule();
  			$playlists = $play->getPlaylistsByShow($show_id); //indexed by playlist_id, ordered by date
  			$playlists = array_reverse($playlists, true); //order from newest to oldest
  			$show = $schedule->getJoinedShow($show_id);
  			$the_tracks = false;

  			/*
  			// added for connecting past playlists
  			if (isset($show['past_show_id']) && $show['past_show_id']){
                  $temp_past_show_id = $show['past_show_id'];
              }

              while($temp_past_show_id){    
                  $last_playlists = $play->getPlaylistsByShow($temp_past_show_id);
                  if($last_playlists){
                      $last_playlists = array_reverse($last_playlists, true); //order from newest to oldest
                      $playlists = array_merge($playlists, $last_playlists);
                  }
                  $temp_past_show = $schedule->getJoinedShow($temp_past_show_id);
                  if (isset($temp_past_show['past_show_id']) && $temp_past_show['past_show_id']){
                      $temp_past_show_id = $temp_past_show['past_show_id'];
                  } else {
                      $temp_past_show_id = false;
                  }
              }


  			if(isset($show['oldschool_show_id']) && $show['oldschool_show_id']){
  				$oldschool_playlists = $play->getOldPlaylistsByShow($show['oldschool_show_id']); //indexed by date, ordered by date



  				if($oldschool_playlists){
  					$oldschool_playlists = array_reverse($oldschool_playlists, true);
  					$playlists = array_merge($playlists, $oldschool_playlists);
  				}
  			}
  		    */
  			if($playlists){ //playlists have been found!
  				$new_playlists = array();
  				foreach($playlists as $t_play){
  					$new_playlists[$t_play['date']] = $t_play;
  				}
  				$playlists = $new_playlists;		



  				$playlist_to_view = false;
  				if($date = $this->getRequest()->getParam('date')){
  					$playlist_to_view = $playlists[$date];
  				} else {
  					//figure out most recent playlist (but do not show one that has not happened yet
  					$time_now = time();
  					$upcoming_playlist = false;
  					foreach($playlists as $pl){
  						if(strtotime($pl['date']) < $time_now){
  							$playlist_to_view = $pl;
  							$playlist_id = $pl['id'];
  							break;
  						}

  						$upcoming_playlist = $pl;
  					}
  				}

  				if (isset($playlist_to_view['image_url']) &&  $playlist_to_view['image_url'] != ''){
  					$this->view->the_image = '<img src="/public/phpThumb/phpThumb.php?w=200&src=' . $playlist_to_view['image_url'] .'" />';
  				} else {
  					$this->view->the_image = false;
  				}

  				$playlist_to_view['date_formatted'] = date('l m/d/Y', strtotime($playlist_to_view['date']));
  				$playlist_to_view['show_name'] = $show['show_name'];
  				$playlist_to_view['show_id'] = $show['id'];
  				$dj_output = '';

  				if (isset($show['dj1_name'])){
  					$dj_output .= $show['dj1_name'];
  				}
  				if (isset($show['dj2_name'])){
  					$dj_output .= ' & ' . $show['dj2_name'];
  				}
  				if (isset($show['dj3_name'])){
  					$dj_output .= ' & ' . $show['dj3_name'];
  				}
  				if(!isset($playlist_to_view['dj_names']) || $playlist_to_view['dj_names'] == ''){
  					$playlist_to_view['dj_names'] = $dj_output;
  				}

  				if(!isset($playlist_to_view['description'])){
  					$playlist_to_view['description'] = $show['description'];
  				}


  				//grab the tracks for the playlist
  				$the_tracks = false;
  				$new_tracks = $play->getAllTracksByPlaylist($playlist_to_view['id']);
  				$old_tracks = $play->getAllOldTracksByPlaylist($playlist_to_view['id']);
  				if (count($new_tracks)){
  					$the_tracks = $new_tracks->toArray();
  				} else if (count($old_tracks)){
  					$the_tracks = $old_tracks->toArray();
  				}

  			} else {
  				//no playlists to show, just give em their description
  				$playlist_to_view = false;
  				$playlist_id = 0;
  			}


  			//probably should check to see if it should be made avail? (syndicated)


  			$this->view->the_m3u = '<a href="http://169.237.101.62/archives/' . $show['id'] . '_(128kbps).m3u">MP3 Stream (128kbps, broadband)</a>';

  			$this->view->the_podcast = '<a href="http://169.237.101.62/archives/' . $show['id'] . '.xml">Subscribe to Podcast</a>';



  			//pass everything to view

  			$this->view->the_show = $show;
  			$this->view->the_playlists = $playlists;

  			//var_dump($playlists);

  			$this->view->playlist_to_view = $playlist_to_view;
  			//$this->view->upcoming_playlist = $upcoming_playlist;
  			$this->view->the_tracks = $the_tracks;


        $this->view->json = Zend_Json::encode($show);

  		} else {
  			$this->_redirect('/shows/');
  		}
  		$this->render('json');
  	}
}