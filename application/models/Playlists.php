<?php

//create all possible Zend_Db_Tables


class Playlist extends Zend_Db_Table_Abstract {
    protected $_name = 'playlists';
}
class Tracks extends Zend_Db_Table_Abstract {
    protected $_name = 'tracks';
}

class OldTracks extends Zend_Db_Table_Abstract {
    protected $_name = 'oldschool_tracks';
}
class OldPlaylist extends Zend_Db_Table_Abstract {
    protected $_name = 'oldschool_playlists';
}

//Master model
class Playlists extends MyModel {
    function getClass($cname){
        switch ($cname) {
            case 'Playlist':
                return new Playlist();
            case 'OldPlaylist':
                return new OldPlaylist();
            case 'OldTracks':
                return new OldTracks();
            case 'Tracks':
                return new Tracks();
            default:
                return false;
        }
    }
    function getPlaylist($id){
        return $this->getObject('Playlist', $id);
    }

    function getPlaylistJoined($id){
		Zend_Loader::loadClass('Schedule');
		$schedule = new Schedule();
        $playlist =  $this->getObject('Playlist', $id);
		if(!$playlist){
			return false;
		}
		$playlist = $playlist->toArray();
		$event = $schedule->getJoinedEvent($playlist['event_id']);
		
		if($event){
			$playlist['start_time'] = $event['start_time'];
			$playlist['end_time'] = $event['end_time'];
			if (isset($event['alt_show_id']) && $event['alt_show_id'] == $playlist['show_id']){
				$playlist['show_name'] = $event['alt_show_name'];
			} else {
				$playlist['show_name'] = $event['show_name'];
			}
		}
		
		return $playlist;
		
    }
    function updatePlaylist($data){
	    $id = $this->updateObject('Playlist', $data);
	    return $id;
    }

    function getPlaylistsByEvent($event_id){
        $class = new Playlist();
		$db = $class->getAdapter();

	
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('event_id = ?', $event_id);
		$order = 'date';
		$rows = $class->fetchAll($where,$order);
		
		//so controller/view knows there are no events
		if(!$rows){
		    return false;
	    }
		
		return $rows->toArray();
    }
    function getPlaylistsByShow($show_id){
        $class = new Playlist();
		$db = $class->getAdapter();

	
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('show_id = ?', $show_id);
		$order = 'date';
		$rows = $class->fetchAll($where,$order);
		
		//so controller/view knows there are no events
		if(!$rows){
		    return false;
	    }
		
		return $this->swapIndices($rows->toArray());
    }
    function getOldPlaylistsByShow($show_id){
        $class = new OldPlaylist();
		$db = $class->getAdapter();
	
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('show_id = ?', $show_id);
		$order = 'date';
		$rows = $class->fetchAll($where,$order);
		
		//so controller/view knows there are no events
		if(!$rows){
		    return false;
	    }
		
		return $rows->toArray();
    }
	function getPastPlaylists($limit = 200){
        $class = new Playlist();
		$db = $class->getAdapter();

	
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('date < ?', date('Y-m-d'));
		$order = 'date';
		$rows = $class->fetchAll($where,$order);
		
		//so controller/view knows there are no events
		if(!$rows){
		    return false;
	    }
		
		return $this->swapIndices($rows->toArray());
	}
	function deleteTrack($id){
        return $this->deleteObject('Tracks', $id);
    }
    function updateTrack($data){
	    $id = $this->updateObject('Tracks', $data);
	    return $id;
    }

    function getAllTracksByPlaylist($playlist_id){ //returns an array of all the songs of a playlist
        $class = new Tracks();
		$db = $class->getAdapter();

		$where = $db->quoteInto('playlist_id = ?', $playlist_id);
		$order = 'position';
		$tracks = $class->fetchAll($where,$order);
		return $tracks;
    }
	function getAllOldTracksByPlaylist($playlist_id){ //returns an array of all the songs of a playlist
        $class = new OldTracks();
		$db = $class->getAdapter();

		$where = $db->quoteInto('playlist_id = ?', $playlist_id);
		$order = 'position';
		$tracks = $class->fetchAll($where,$order);
		return $tracks;
    }
	function getTopSpinsGrouped($start_date, $end_date){
		$class = new Tracks();
		$db = $class->getAdapter();
		
				
    /*
		$sql = "SELECT t.album_id, t.album_name, t.artist_name, t.label_name, count(*) as spins
				FROM tracks as t, playlists as p
				WHERE t.album_id <> 0 AND t.current = 1 AND ( p.date >= ? AND p.date <= ?)
				 		AND t.playlist_id = p.id
				GROUP BY t.album_id
				ORDER BY spins DESC
		        ";
    */
		$sql = "SELECT vt.album_id, vt.album_name, vt.artist_name, vt.label_name, count(*) as spins
            FROM playlists as p, 
                 (SELECT DISTINCT t.album_id, t.album_name, t.artist_name, t.label_name, t.current, t.playlist_id
            			   FROM tracks as t
            			   WHERE t.current = 1) as vt
            WHERE vt.album_id <> 0
              AND vt.current = 1
              AND (p.date >= ? AND p.date <= ?)
              AND vt.playlist_id = p.id
              GROUP BY vt.album_id
              ORDER BY spins DESC
		        ";
		
		$stmt = $db->query($sql, array($start_date, $end_date));

		$rows = $stmt->fetchAll();
		return $rows;
	}
}