<?php

//create all possible Zend_Db_Tables


class Seasons extends Zend_Db_Table_Abstract {
    protected $_name = 'seasons';
}
class Shows extends Zend_Db_Table_Abstract {
    protected $_name = 'shows';
}
class ShowTypes extends Zend_Db_Table_Abstract {
    protected $_name = 'show_types';
}
class Events extends Zend_Db_Table_Abstract {
    protected $_name = 'schedule';
}
class OldShows extends Zend_Db_Table_Abstract {
    protected $_name = 'oldschool_shows';
}
class OldStreams extends Zend_Db_Table_Abstract {
    protected $_name = 'oldschool_streams';
}
//Master model
class Schedule extends MyModel {
    function getClass($cname){
        switch ($cname) {
            case 'Seasons':
                return new Seasons();
			case 'OldShows':
				return new OldShows();
			case 'OldStreams':
				return new OldStreams();
		    case 'Shows':
                return new Shows();
		    case 'ShowTypes':
                return new ShowTypes();
		    case 'Events':
                return new Events();
            default:
                return false;
            
        }
    }
    function getSeason($id){
        return $this->getObject('Seasons', $id);
    }
    function updateSeason($data){
	    $id = $this->updateObject('Seasons', $data);
	    return $id;
    }
    function getAllSeasons(){ //returns an array of all the labels
        $table = new Seasons();
        $seasons = $table->fetchAll(null, 'end_date')->toArray();
		return array_reverse($seasons);
    }    
    function getCurrentSeasonID(){
        
        $table = new Seasons();
        $db = $table->getAdapter();
        $where = $db->quoteInto('start_date <= ?', date('Y-m-d'));
        $where .= $db->quoteInto(' AND end_date >= ?', date('Y-m-d'));
        $rows = $table->fetchAll($where)->toArray();
        return (int)$rows[0]['id'];

    }
    function getShow($id){
        return $this->getObject('Shows', $id);
    }
    function getOldShow($id){
        return $this->getObject('OldShows', $id);
    }
	function getAllOldShows(){
		$class = new OldShows();
		$db = $class->getAdapter();
		$rows = $class->fetchAll(null, 'show_name')->toArray();
		return $rows;
	}
	function getAllOldStreams(){
		$class = new OldStreams();
		$db = $class->getAdapter();
		$rows = $class->fetchAll()->toArray();
		return $rows;
	}
	function findShowsBySeason($search_term, $season_id){
		$class = new Shows();
		$db = $class->getAdapter();

		$where = $db->quoteInto('show_name LIKE ?', '%'.$search_term.'%');
		$where .= $db->quoteInto(' AND season_id = ?', $season_id);
		$order = 'show_name';
		$rows = $class->fetchAll($where,$order)->toArray();
		return $rows;
	}
	function getAllShowsBySeason($season_id, $swap = false){
		$class = new Shows();
		$db = $class->getAdapter();

		$where = $db->quoteInto('season_id = ?', $season_id);
		$order = 'show_name';
		$rows = $class->fetchAll($where,$order)->toArray();
		if($swap){
			return $this->swapIndices($rows);
		} else {
			return $rows;
		}
	}
    function updateShow($data){
	    $id = $this->updateObject('Shows', $data);
	    return $id;
    }
    function getAllShowTypes(){ //returns an array of all the labels
        $table = new ShowTypes();
        $rows = $table->fetchAll(null, 'description')->toArray();
        $new_array = array();
		foreach($rows as $row){
			$new_array[$row['id']] = $row;
		}
		return $new_array;
    }
	function getEvent($id){
        return $this->getObject('Events', $id);
    }
    function getEventByShowID($show_id){
        $class = new Events();
		$db = $class->getAdapter();

		$where = $db->quoteInto('show_id = ?', $show_id);
		$where .= $db->quoteInto(' OR alt_show_id = ?', $show_id);
		$order = array('start_time','dotw');
		$rows = $class->fetchAll($where,$order);
		if(!$rows){
		    return false;
	    }
	    
	    $rows = $rows->toArray();
	    return $rows;

    }
    function updateEvent($data){
	    $id = $this->updateObject('Events', $data);
	    return $id;
    }
	function deleteEvent($id){
        return $this->deleteObject('Events', $id);
    }

	function getAllEventsBySeason($season_id){
		$class = new Events();
		$db = $class->getAdapter();

		$where = $db->quoteInto('season_id = ?', $season_id);
		$order = array('start_time','dotw');
		$rows = $class->fetchAll($where,$order)->toArray();
		return $rows;
	}
	function getAllJoinedEventsBySeason($season_id){
		$events = $this->getAllEventsBySeason($season_id);
		$shows = $this->getAllShowsBySeason($season_id, true);
		
		Zend_Loader::loadClass('Admin');
		$admin = new Admin();
		$djs = $admin->getAllDJInfo();
		
		$joined_events = array();
		foreach($events as $event){
			$joined_events[$event['id']] = $this->getJoinedEvent($event, $djs, $shows);
		}
		return $joined_events;
	}
	function getJoinedEvent($event, $dj_array = false, $show_array = false){
		//using php to join db tables to prevent mysql choking
				
		if(!is_array($event)){
			$event = $this->getEvent($event)->toArray();
		}
				
		if(!$dj_array){
			Zend_Loader::loadClass('Admin');
			$admin = new Admin();
			$djs = $admin->getAllDJInfo();
		} else {
			$djs = $dj_array;
		}


		//grab shows using db calls or by using values from arrays passed as args
		$show_id = (int)$event['show_id'];
		if(!$show_array){
			$show = $this->getShow($show_id)->toArray();
		} elseif(isset($show_array[$show_id])) {
			$show = $show_array[$show_id];
		} else {
			$show = false;
		}
		if($event['alt_show_id'] && (int)$event['alt_show_id'] != 0){
			$alt_show_id = (int)$event['alt_show_id'];
			if(!$show_array){
				$alt_show = $this->getShow($alt_show_id)->toArray();
			} elseif(isset($show_array[$alt_show_id])) {
				$alt_show = $show_array[$alt_show_id];
			}
		} else {
			unset($event['alt_show_id']);
		}
		//combine data with event
		
		//add show info
		$joined_event = $event;
		if($show){
			unset($show['id']);
			$joined_event = array_merge($joined_event, $show);
		
			//add dj name info
			if($show['dj1_id'] && (int)$show['dj1_id'] != 0){
			    $joined_event['dj1_name'] = $djs[$show['dj1_id']]['dj_name'];
			}
			if($show['dj2_id'] && (int)$show['dj2_id'] != 0){
				$joined_event['dj2_name'] = $djs[$show['dj2_id']]['dj_name'];
			}
			if($show['dj3_id'] && (int)$show['dj3_id'] != 0){
				$joined_event['dj3_name'] = $djs[$show['dj3_id']]['dj_name'];
			}		
			//add alt show info if avail
			if(isset($alt_show)){
				unset($alt_show['id']);
				foreach($alt_show as $key => $val){
					$joined_event['alt_' . $key] = $val;
				}
				//add dj name info
				if($alt_show['dj1_id'] && (int)$alt_show['dj1_id'] != 0){
					$joined_event['alt_dj1_name'] = $djs[$alt_show['dj1_id']]['dj_name'];
				}
				if($alt_show['dj2_id'] && (int)$alt_show['dj2_id'] != 0){
					$joined_event['alt_dj2_name'] = $djs[$alt_show['dj2_id']]['dj_name'];
				}
				if($alt_show['dj3_id'] && (int)$alt_show['dj3_id'] != 0){
					$joined_event['alt_dj3_name'] = $djs[$alt_show['dj3_id']]['dj_name'];
				}
			}
		}
		return $joined_event;
	}	
	function getJoinedShow($show_id, $dj_array = false){
		//using php to join db tables to prevent mysql choking
	
		if(!$dj_array){
			Zend_Loader::loadClass('Admin');
			$admin = new Admin();
			$djs = $admin->getAllDJInfo();
		} else {
			$djs = $dj_array;
		}

		//grab shows using db calls or by using values from arrays passed as args
		$show = $this->getShow($show_id);
		
		if(!$show){
			return false;
		}
		$show = $show->toArray();
		
		//add dj name info
		if($show['dj1_id'] && (int)$show['dj1_id'] != 0){
		    $show['dj1_name'] = $djs[$show['dj1_id']]['dj_name'];
		}
		if($show['dj2_id'] && (int)$show['dj2_id'] != 0){
			$show['dj2_name'] = $djs[$show['dj2_id']]['dj_name'];
		}
		if($show['dj3_id'] && (int)$show['dj3_id'] != 0){
			$show['dj3_name'] = $djs[$show['dj3_id']]['dj_name'];
		}		

		return $show;
	}
}