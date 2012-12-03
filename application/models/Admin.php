<?php

//create all possible Zend_Db_Tables


class Users extends Zend_Db_Table_Abstract {
    protected $_name = 'users';
}

//Master model
class Admin extends MyModel {
    function getClass($cname){
        switch ($cname) {
            case 'Users':
                return new Users();
            case 'DJs':
                return new DJs();
            default:
                return false;
            
        }
    }
    function getUser($id){
        return $this->getObject('Users', $id);
    }
    function getUserByUsername($username){
        $users = $this->findRowByColumn($username, 'username');
        if(!$users){
            return false;
        }
        return $users[0];
    }
    function updateUser($data){
	    $id = $this->updateObject('Users', $data);
	    return $id;
    }

    function findUsersByName($search_term){
		$class = new Users();
		$db = $class->getAdapter();
		//uses fulltext search for quick and dirty magic search
		$sql = "    SELECT *,
		                MATCH(username,email,name_last, name_first, dj_name, dj_email) AGAINST(? IN BOOLEAN MODE) AS score
		                FROM users
		            WHERE MATCH(username,email,name_last, name_first, dj_name, dj_email) AGAINST(? IN BOOLEAN MODE)
		            ORDER BY score DESC
		        ";
		$stmt = $db->query($sql, array($search_term.'*', $search_term.'*'));
		$rows = $stmt->fetchAll();

		/*
		$where = '';
		$where .= $db->quoteInto('username LIKE ?', '%'.$search_term.'%');
		$where .= $db->quoteInto(' OR name_last LIKE ?', '%'.$search_term.'%');
		$where .= $db->quoteInto(' OR name_first LIKE ?', '%'.$search_term.'%');
		$order = array('name_last', 'name_first');
		$rows = $class->fetchAll($where,$order); */

		return $rows;
		
		
	}
	function findRowByColumn($value, $column){
		
		$table = new Users();
		
		$where = $table->getAdapter()->quoteInto($column . ' = ?', $value);
		
		$rows = $table->fetchAll($where);
		
		if(!$rows){
		    return false;
	    }
		$rows = $rows->toArray();
		return $rows;
	}
    function getAllUsers(){ //returns an array of all the users
        $table = new Users();
        $rows = $table->fetchAll(null, 'id');
        return $rows->toArray();
    }
    function getAllDJs(){ //returns an array of all the djs
        $table = new Users();
        $rows = $table->fetchAll(null, 'dj_name');
        return $rows->toArray();
    }
	function getAllDJInfo(){ //returns an array of all the djs with each dj indexed by their id
        $table = new Users();
        $rows = $table->fetchAll(null, 'dj_name')->toArray();
        $new_array = array();
		foreach($rows as $row){
			$new_array[$row['id']] = $row;
		}
		return $new_array;
    }

}