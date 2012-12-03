<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');
Zend_Loader::loadClass('Schedule');

class editEventForm extends HTML_QuickForm {
    function editEventForm($action, $button_value, $season_id) {
        parent::HTML_QuickForm('editevent', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

		//get models
		$admin = new Admin();
		$schedule = new Schedule();
        //grab all possible select values

		$shows = $this->getSelectArray($schedule->getAllShowsBySeason($season_id), 'show_name');
        //begin elements
        $this->addElement('header', '', $button_value);
        $this->addElement('hidden', 'id');
		
		//show
		$this->addElement('select', 'show_id', 'Show', $shows);
		//alt show
		$this->addElement('select', 'alt_show_id', 'Alternate Show', $shows);
		
        $this->addElement('submit', 'submit', $button_value, array('onclick' => 'return processEventForm();'));
 
    }
    function getSelectArray($data, $col, $blank = true){
		if ($blank){
			$select_array = array('' => '');
		} else {
			$select_array = array();
		}
		foreach($data as $datum){
			$select_array[$datum['id']] = $datum[$col];
		}
		return $select_array;
	}
}