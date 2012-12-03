<?php
//QuickForm class loaded in bootstrap

class editLabelForm extends HTML_QuickForm
{
    function editLabelForm($action, $button_value, $ajax = false) {
		$form_attr = NULL;

        parent::HTML_QuickForm('editlabel', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');

		$this->addElement('header', '', $button_value);
		
		$this->addElement('hidden', 'id');
        $this->addElement('text', 'label_name', 'Label Name', array('size' => '35'));
        $this->addElement('text', 'label_website', array('Website URL', '', '(needs http://)'), array('size' => '35'));
		$this->addElement('text', 'label_email', 'Email', array('size' => '35'));
		
		if($ajax){
			$this->addElement('button', 'submit', $button_value, array("onclick" => "submitEditLabelForm();"));
		} else {
			$this->addElement('submit', 'submit', $button_value);
		}
        

		//rules

        $this->addRule('label_name', 'Label name is required', 'required');
		$this->addRule('label_email', 'Must be a valid email', 'email', '', '');
		
		//make sure doesn't already exist
	    function globalRules($data)  {
			if (strlen($data['label_name']) < 2){
				return array('label_name' => 'A Label name must be at least 2 characters');
			}
		
			$music = new Music();
			$rows = $music->findDuplicateLabels($data['label_name']);
	        if (count($rows) > 0){
				foreach($rows as $row){
	            	if ((int)$row['id'] != (int)$data['id']){	
						return array('label_name' => 'A Label with this name already exists');
					}
				}
	        }
			
			//website needs http
			if($data['label_website'] != '' && !strstr($data['label_website'], 'http://')){
				return array('label_website' => 'Website URL must have <b>http://</b> in front');
			}
			return true;
	
	    }
    	
		$this->addFormRule('globalRules'); 
    }
	
}