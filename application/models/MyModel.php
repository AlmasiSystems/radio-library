<?php
//parent class for all other models (except auth)
class MyModel {
	//not used for anything
	function findAllPossibleValues($cname, $columns, $search_term){
		$complete_list = array();
		$columns = (array)$columns;
        $class = $this->getClass($cname); //returns correct tableClass
		foreach($columns as $col){
			$where = $class->getAdapter()->quoteInto($col . ' LIKE ?', '%'.$search_term.'%');
			$rows = $class->fetchAll($where)->toArray();

			foreach($rows as $row){
				$complete_list[] = $row[$col];
			}

		}
		//now sort it
		sort($complete_list);
		return array_unique($complete_list);
	}
	function findAllAdvanced($cname, $data, $order = null, $limit = 1000, $offset = 0){
		$complete_list = array();
        $class = $this->getClass($cname); //returns correct tableClass
		$where = '';
		
		if(isset($data['id']) && $data['id'] != ''){
			$where .= $class->getAdapter()->quoteInto('id = ?', $data['id']);
			unset($data['id']);
		}
		foreach($data as $col => $val){
			if($val != ''){
				if ($where != ''){
					$where .= ' AND ';
				}
				$where .= $class->getAdapter()->quoteInto($col . ' LIKE ?', '%'.$val.'%');
			}
		}
		if($where == ''){
			return false;
		}
		$rows = $class->fetchAll($where, $order, $limit, $offset);
		if(!$rows){
			return false;
		}
		return $rows->toArray();
	}
	function getObject($cname, $id = false){
        $class = $this->getClass($cname); //returns correct tableClass
        
        if ($id){ //grab specific row
            $row = $class->fetchRow('id = ' . $id);
        } else { //create empty row
            $row = $class->createRow();
        }
        return $row;
    }
    function updateObject($cname, $data){ //function either updates or inserts depending on if data['id'] exists and has 
        $class = $this->getClass($cname); //returns correct tableClass
    	if (isset($data['id']) && $data['id'] != ''){ //update
		    $id = $data['id'];
            unset($data['id']);
		    $row = $class->fetchRow('id = ' . $id);
	    } else { //insert
		    $row = $class->createRow();
	    }
	    //get rid of $data[id] if it exists
	    unset($data['id']);   
	    $row->setFromArray($data);
	    $row->save();
	    return $row->id;
    }
	function deleteObject($cname, $id){
		$class = $this->getClass($cname); //returns correct tableClass
		$where = $class->getAdapter()->quoteInto('id = ?', $id);
		$class->delete($where);
	}
	
	/*utils*/
	
	function swapIndices($data, $col = 'id'){
		$new_array = array();
		foreach($data as $row){
			$new_array[$row[$col]] = $row;
		}
		return $new_array;
	}
}