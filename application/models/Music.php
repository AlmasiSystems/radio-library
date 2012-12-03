<?php

//create all possible Zend_Db_Tables


class Albums extends Zend_Db_Table_Abstract {
    protected $_name = 'library_albums';
}
class Labels extends Zend_Db_Table_Abstract {
    protected $_name = 'library_labels';
}
class Genres extends Zend_Db_Table_Abstract {
    protected $_name = 'library_genres';
}
class Promoters extends Zend_Db_Table_Abstract {
    protected $_name = 'library_promoters';
}
class Formats extends Zend_Db_Table_Abstract {
    protected $_name = 'library_formats';
}
class Songs extends Zend_Db_Table_Abstract {
    protected $_name = 'library_songs';
}
//Master model
class Music extends MyModel
{
    function __construct()
    { /* empty */ }

    function getClass($cname){
        switch ($cname) {
            case 'Albums':
                return new Albums();
		    case 'Labels':
                return new Labels();
		    case 'Songs':
                return new Songs();
		    case 'Genres':
                return new Genres();
            default:
                return false;
            
        }
    }
    function getSong($id){
        return $this->getObject('Songs', $id);
    }

    function updateSong($data){
	    $id = $this->updateObject('Songs', $data);
	    return $id;
    }
    function getAlbum($id){
        return $this->getObject('Albums', $id);
    }

    function updateAlbum($data){
	    $id = $this->updateObject('Albums', $data);
	    return $id;
    }
	function deleteAlbum($id){
        return $this->deleteObject('Albums', $id);
    }
	function getAlbumJoined($album, $with_songs = true){
		//using php to join db tables to prevent mysql choking
				
		if(!is_array($album)){
			$album = $this->getAlbum($album);
			if(!$album){
				return false;
			}
			$album = $album->toArray();
		}
		
		$label = $this->getLabel($album['label_id']);
		if($label){
			$label = $label->toArray();
		} else {
			$label['label_name'] = 'Not Found';
			$label['label_email'] = '';
			$label['label_website'] = '';
		}
		
		//combine data with album
		$joined_album = $album;
		unset($label['id']);
		$joined_album = array_merge($joined_album, $label);
		
		
		
		if($with_songs){
			$songs = $this->getAllSongsByAlbum($album['id']);
			$songs = $this->swapIndices($songs, 'track_num');
			$joined_album['songs'] = $songs;
		}		
		
		return $joined_album;
	}
	function findAllAlbumsAdvanced($data){
		$albums = $this->findAllAdvanced('Albums', $data, array('artist', 'title'));
		$formats = $this->swapIndices($this->getAllFormats());
		$genres = $this->swapIndices($this->getAllGenres());
		$promoters = $this->swapIndices($this->getAllPromoters());
		$joined_albums = array();
		if($albums){
			foreach($albums as $album){
				$temp_joined = $this->getAlbumJoined($album, false);
				$temp_joined['format'] = $formats[$temp_joined['format_id']]['name'];
				$temp_joined['genre'] = $genres[$temp_joined['genre_id']]['name'];
				if(isset($temp_joined['promoter_id']) && ($temp_joined['promoter_id'] || $temp_joined['promoter_id'] != '')){
					$temp_joined['promoter'] = $promoters[$temp_joined['promoter_id']]['name'];
				}
				$joined_albums[$album['id']] = $temp_joined;
							
			}
		} else {
			return false;
		}
		return $joined_albums;
	}
	function getRecentAdds($num_weeks = 1){
		$class = new Albums();
		$db = $class->getAdapter();
		$where = $db->quoteInto('add_datetime >= ?', date('Y-m-d H:i:s', strtotime('-'.$num_weeks.' weeks')));
		$order = 'add_datetime DESC';
		$albums = $class->fetchAll($where,$order)->toArray();
		
		$formats = $this->swapIndices($this->getAllFormats());
		$genres = $this->swapIndices($this->getAllGenres());
		$promoters = $this->swapIndices($this->getAllPromoters());
		$joined_albums = array();
		if($albums){
			foreach($albums as $album){
				$temp_joined = $this->getAlbumJoined($album, false);
				$temp_joined['format'] = $formats[$temp_joined['format_id']]['name'];
				$temp_joined['genre'] = $genres[$temp_joined['genre_id']]['name'];
				if(isset($temp_joined['promoter_id']) && ($temp_joined['promoter_id'] || $temp_joined['promoter_id'] != '')){
					$temp_joined['promoter'] = $promoters[$temp_joined['promoter_id']]['name'];
				}
				$joined_albums[$album['id']] = $temp_joined;
							
			}
		} else {
			return false;
		}
		return $joined_albums;
	}	
	
    function getLabel($id){
        return $this->getObject('Labels', $id);
    }

    function updateLabel($data){
	    $id = $this->updateObject('Labels', $data);
	    return $id;
    }
    function getAllLabels(){ //returns an array of all the labels
        $table = new Labels();
        return $table->fetchAll(null, 'label_name')->toArray();
    }
	function getAllLabelsStartingWith($letter){
		$class = new Labels();
		$db = $class->getAdapter();

	
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('label_name LIKE ?', $letter.'%');
		$order = 'label_name';
		$rows = $class->fetchAll($where,$order)->toArray();
		return $rows;
	}
	function getAllLabelsStartingWithSymbol(){
		$class = new Labels();
		$db = $class->getAdapter();

	
		//create the where clause for the oldschool search 
		$where = "ASCII(label_name) <= 64";
		$order = 'label_name';
		$rows = $class->fetchAll($where,$order)->toArray();
		return $rows;
	}
	function getAllSongsByAlbum($album_id){ //returns an array of all the labels
        $class = new Songs();
		$db = $class->getAdapter();

		$where = $db->quoteInto('album_id = ?', $album_id);
		$order = 'track_num';
		$rows = $class->fetchAll($where,$order);
		if($rows){
			$rows = $rows->toArray();
		}
		return $rows;
    }
    function getGenre($id){
        return $this->getObject('Genres', $id);
    }
    function getAllGenres(){ //returns an array of all the labels
        $table = new Genres();
        return $table->fetchAll()->toArray();
    }
    function getAllFormats(){ //returns an array of all the formats
        $table = new Formats();
        return $table->fetchAll()->toArray();
    }
    function getAllPromoters(){ //returns an array of all the promoters
        $table = new Promoters();
        return $table->fetchAll()->toArray();
    }	
    function findLabels($search_term){ //returns an array of all the labels
		$class = new Labels();
		$db = $class->getAdapter();
		

		$use_fulltext = false;
		
		
		$where = $db->quoteInto('label_name LIKE ?', $search_term.'%');
		
		
		//create the where clause for the oldschool search 
		/*
		//explode the terms and if any of them are < 4 do not use fulltext
		
		$terms = explode(' ', $search_term);		
		$where = $db->quoteInto('label_name LIKE ?', '%'.$search_term.'%');
		foreach($terms as $term){
			$where .= $db->quoteInto('OR label_name LIKE ?', '%'.$term.'%');
			if(strlen($term) < 4){
				$use_fulltext = false;
			}
		}
		*/
		/*
		//if searching with less than 4 letters 
		if(strlen($search_term) < 4){
			$where = $db->quoteInto('label_name LIKE ?', '%'.$search_term.'%');
			$use_fulltext = false;
		}*/
		
		if($use_fulltext){ 

			//uses fulltext search for quick and dirty magic search
			$sql = "    SELECT *,
			                MATCH(label_name, label_website, label_email) AGAINST(? IN BOOLEAN MODE) AS score
			                FROM library_labels
			            WHERE MATCH(label_name, label_website, label_email) AGAINST(? IN BOOLEAN MODE)
			            ORDER BY score DESC
			        ";
			$stmt = $db->query($sql, array($search_term.'*', $search_term.'*'));
			$rows = $stmt->fetchAll();			
		} else { //small stuff doesn't work with fulltext
			$order = array('label_name');
			$rows = $class->fetchAll($where,$order)->toArray();
		}


		return $rows; //an arrray (not rowset)

    }
	function findDuplicateLabels($label_name){
		$table = new Labels();
		$where = '';
		$where .= $table->getAdapter()->quoteInto(' label_name = ?', $label_name);
	
		$rows = $table->fetchAll($where)->toArray();
		
		return $rows;
	}
	function findDuplicateAlbums($artist, $title, $format_id){
		$table = new Albums();
		$where = '';
		$where .= $table->getAdapter()->quoteInto(' artist = ?', $artist);
		$where .= $table->getAdapter()->quoteInto(' AND title = ?', $title);
		$where .= $table->getAdapter()->quoteInto(' AND format_id = ?', $format_id);
		
		$rows = $table->fetchAll($where)->toArray();
		
		return $rows;
	}
	function findAlbums($search_term){ //returns an array of all the albums
		$class = new Albums();
		$db = $class->getAdapter();
		
		//explode the terms and if any of them are < 4 do not use fulltext
		$use_fulltext = true;
		$terms = explode(' ', $search_term);
		
		//create the where clause for the oldschool search 
		$where = $db->quoteInto('artist LIKE ?', '%'.$search_term.'%');
		$where .= $db->quoteInto(' OR artist_display LIKE ?', '%'.$search_term.'%');
		$where .= $db->quoteInto(' OR title LIKE ?', '%'.$search_term.'%');
		
		foreach($terms as $term){
			$where .= $db->quoteInto(' OR artist LIKE ?', '%'.$term.'%');
			$where .= $db->quoteInto(' OR artist_display LIKE ?', '%'.$term.'%');
			$where .= $db->quoteInto(' OR title LIKE ?', '%'.$term.'%');
			if(strlen($term) < 4){
				$use_fulltext = false;
			}
		}
		if($use_fulltext){ 
			//uses fulltext search for quick and dirty magic search
			$sql = "    SELECT *,
			                MATCH(artist, artist_display, title) AGAINST(? IN BOOLEAN MODE) AS score
			                FROM library_albums
			            WHERE MATCH(artist, artist_display, title) AGAINST(? IN BOOLEAN MODE)
			            ORDER BY score DESC
			        ";
			$stmt = $db->query($sql, array($search_term.'*', $search_term.'*'));
			$rows = $stmt->fetchAll();			
		} else { //small stuff doesn't work with fulltext
			$order = array('artist', 'title');
			$rows = $class->fetchAll($where,$order)->toArray();
		}


		return $rows; //an arrray (not rowset)

    }

}