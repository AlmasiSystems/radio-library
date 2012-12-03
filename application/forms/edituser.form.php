<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');

class edituserForm extends HTML_QuickForm {
    function edituserForm($action, $button_value, $ajax = false) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway
		$form_attr = NULL;
		if($ajax){
			$form_attr = array('onsubmit' => 'submitEditUserForm(this); return false;');
		}

        parent::HTML_QuickForm('edituser', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');
        

        //grab all possible auth id's (static for now, cause we're lazy)
        $access_levels = array(
            '' => '',
            '10' => 'Disabled',
            '4' => 'DJ',
            '13' => 'Fundraiser',
            '3' => 'Adder',
            '2' => 'Admin'           
            );
            
 
        
        //begin elements
        $this->addElement('header', '', 'User Info');
        $this->addElement('hidden', 'id');
        $this->addElement('text', 'username', 'Username', array('class' => 'text'));
        $this->addElement('text', 'name_first', 'First Name');
        $this->addElement('text', 'name_last', 'Last Name');
        
        $this->addElement('header', '', 'Contact Info');
        $this->addElement('text', 'email', 'Email');
  
        //address
        $this->addElement('text', 'address_street', 'Street Address');
    
        $address_city = HTML_QuickForm::createElement('text', 'address_city', null, array('size' => 10));
        $address_state = HTML_QuickForm::createElement('text', 'address_state', null, array('size' => 2, 'maxlength' => 2));
        $address_zip = HTML_QuickForm::createElement('text', 'address_zip', null, array('size' => 5, 'maxlength' => 5));
        $this->addGroup(array($address_city, $address_state, $address_zip), 'address_group', 'City, State Zip', '&nbsp;');

       // Creates a phone group
        $pri_areaCode = HTML_QuickForm::createElement('text', 'pri_area', null, array('size' => 3, 'maxlength' => 3));
        $pri_phoneNo1 = HTML_QuickForm::createElement('text', 'pri_no1', null, array('size' => 3, 'maxlength' => 3));
        $pri_phoneNo2 = HTML_QuickForm::createElement('text', 'pri_no2', null, array('size' => 4, 'maxlength' => 4));
        $this->addGroup(array($pri_areaCode, $pri_phoneNo1, $pri_phoneNo2), 'primary_phone', 'Primary Phone', '-');
 
        $sec_areaCode = HTML_QuickForm::createElement('text', 'sec_area', null, array('size' => 3, 'maxlength' => 3));
        $sec_phoneNo1 = HTML_QuickForm::createElement('text', 'sec_no1', null, array('size' => 3, 'maxlength' => 3));
        $sec_phoneNo2 = HTML_QuickForm::createElement('text', 'sec_no2', null, array('size' => 4, 'maxlength' => 4));
        $this->addGroup(array($sec_areaCode, $sec_phoneNo1, $sec_phoneNo2), 'secondary_phone', 'Second Phone', '-');
         
        //dj info
        $this->addElement('header', '', 'DJ Info');
        $this->addElement('text', 'dj_name', 'DJ Name');
        $this->addElement('text', 'dj_email', 'DJ Email');
             
        //access level
        $this->addElement('header', '', 'Access Level');
        $this->addElement('select', 'auth_id', 'Access', $access_levels);
        
        //password
        $this->addElement('header', 'pass_head', 'Password');
        $this->addElement('password', 'password1', 'Password');
        $this->addElement('password', 'password2', 'Repeat');
        
        $this->addElement('submit', 'submit', $button_value);

        //rules
        
        // require all user info
        $this->addRule('username', 'A username is required', 'required', '', ''); //'client' adds js validation
        $this->addRule('name_first', 'A first name is required', 'required', '', '');
        $this->addRule('name_last', 'A last name is required', 'required', '', '');
        $this->addRule('email', 'An email address is required', 'required', '', '');
        
        //require access level
        $this->addRule('auth_id', 'Please select a user access level', 'required', '', '');
        
		//require dj name
		$this->addRule('dj_name', 'A dj name is required', 'required', '', '');

        //value specific rules
        $this->addRule('email', 'Email address must be valid', 'email', '', '');
        $this->addRule('username', 'Username length cannot exceed 20 characters.', 'maxlength', 20, '');
        
        //phone group rules
        $this->addRule('primary_phone', 'Valid Primary Phone Number Required', 'required');
        $this->addGroupRule('primary_phone', array(
		    'pri_area' => array(
		        array('Valid Primary Phone Number Required', 'required'),
		        array('Not a Valid Primary Phone Number', 'numeric'),
		        array('Not a Valid Primary Phone Number', 'minlength', 3)
		    ),
		    'pri_no1' => array(
		        array('Valid Primary Phone Number Required', 'required'),
		        array('Not a Valid Primary Phone Number', 'numeric'), 
		        array('Not a Valid Primary Phone Number', 'minlength', 3)
		    ),
		    'pri_no2' => array(
		        array('Valid Primary Phone Number Required', 'required'),
		        array('Not a Valid Primary Phone Number', 'numeric'), 
		        array('Not a Valid Primary Phone Number', 'minlength', 4)
		    ),
		));
        $this->addGroupRule('secondary_phone', array(
    	    'sec_area' => array(
    	        array('Not a Valid Primary Phone Number', 'numeric'), 
    	        array('Not a Valid Secondary Phone Number', 'minlength', 3)
    	    ),
    	    'sec_no1' => array(
    	        array('Not a Valid Primary Phone Number', 'numeric'), 
    	        array('Not a Valid Secondary Phone Number', 'minlength', 3)
    	    ),
    	    'sec_no2' => array(
    	        array('Not a Valid Primary Phone Number', 'numeric'), 
    	        array('Not a Valid Secondary Phone Number', 'minlength', 4)
    	    ),
    	));    
    	
    	//address rules
    	$this->addRule('address_street', 'A street address is required', 'required');
    	$this->addRule('address_group', 'Complete Address Required', 'required');
    	$this->addGroupRule('address_group', array(
    	    'address_city' => array(
    	        array('Valid City Required', 'required')
    	    ),
    	    'address_state' => array(
    	        array('Valid State Required', 'required'),
    	        array('Not a Valid State', 'lettersonly'), 
    	        array('Not a Valid Secondary Phone Number', 'minlength', 2)
    	    ),
    	    'address_zip' => array(
    	        array('Valid Zipcode Required', 'required'),
    	        array('Not a Valid Zipcode', 'numeric'), 
    	        array('Not a Valid Secondary Phone Number', 'minlength', 5)
    	    ),
    	));
    	
    	//password rules
    	$this->addRule('password1', 'Password is required', 'required');
    	$this->addRule('password1', 'Password must be at least 5 characters', 'minlength', 5);
    	$this->addRule('password2', 'You must repeat your password', 'required');
        //custom rules
        
        // register and add a rule to check if a username is free
        $this->registerRule('checkusername', 'callback', 'usernameOK', $this);
        $this->addRule('username', 'Username is taken, please try another.', 'checkusername');
        
        //globalrules
	    function globalRules($data)  {
	        
	        //password compare
	        if(isset($data['password1']) && isset($data['password2'])){
    			if ($data['password1'] != $data['password2']){
    				return array('password2' => 'Passwords do not match');
    			}
			}
			return true;
	
	    }
    	
		$this->addFormRule('globalRules');
        
    }
    
    //custome rules that require db callbacks
    
    function usernameOK($username)  {
        // in a real world situation, you would query the database here
        // to see if the username was free
		$admin = new Admin();
		$rows = $admin->findRowByColumn($username, 'username');
        if (count($rows) > 0){
            return false;
        } else {
            return true;
        }
    }
}