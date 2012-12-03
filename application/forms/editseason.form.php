<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Schedule');

class editSeasonForm extends HTML_QuickForm
{
    function editSeasonForm($action, $button_value) {
		$form_attr = NULL;

        parent::HTML_QuickForm('editseason', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');

		$this->addElement('header', '', $button_value);
		
		$this->addElement('hidden', 'id');
        $this->addElement('text', 'title', array('Title','Ex: <strong>Fall Quarter 2007</strong>'));
        $this->addElement('text', 'start_date', array('Start Date', '<img src="/public/images/cal.gif" onclick="scwShow(scwID(\'start_date\'),this);">'),
 							array('readonly' => 'readonly', 'onfocus' => 'scwShow(scwID(\'start_date\'),this);'));
		$this->addElement('text', 'end_date', array('End Date', '<img src="/public/images/cal.gif" onclick="scwShow(scwID(\'end_date\'),this);">'),
							array('readonly' => 'readonly', 'onfocus' => 'scwShow(scwID(\'end_date\'),this);'));
		$this->addElement('submit', 'submit', $button_value);
		//rules

        $this->addRule('title', 'Season Title is required', 'required');
		$this->addRule('start_date', 'Start Date is required', 'required');
		$this->addRule('end_date', 'End Date is required', 'required');
		$this->addRule('title', 'Title may not be more than 250 characters', 'maxlength', '250');
		
        //make sure dates work
	    function globalRules($data)  {
			//check to make sure start date is before end date
			
			//check to see if season is at least a week long
			
			//check to see if dates conflict with other seasons
		/*	$model = new Schedule();
			$date = $date;
			$season = $model->getSeasonByDate($date);
	        if (count($season) > 0){
	            return array('start_date' => 'Start date is within date range of another season');
	        } */
	
			
	
	        return true;

	    }
    	
		$this->addFormRule('globalRules');
    }
}