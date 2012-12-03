<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');

class changePassForm extends HTML_QuickForm {
    function changePassForm($action, $button_value) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway

        parent::HTML_QuickForm('changepass', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

        
        //begin elements
        $this->addElement('header', '', 'Old Password');
        $this->addElement('hidden', 'id');
        $this->addElement('password', 'old_pass', 'Current Password');

        $this->addElement('header', '', 'New Password');
        $this->addElement('password', 'password1', 'New Password');
        $this->addElement('password', 'password2', 'Repeat Password');
        
        $this->addElement('submit', 'submit', $button_value);

        //rules
        
        // require all user info
        $this->addRule('old_pass', 'Current password is required', 'required', '', '');
        $this->addRule('password1', 'New password is required', 'required', '', '');
        $this->addRule('password1', 'Password must be at least 5 characters', 'minlength', 5);
        $this->addRule('password2', 'Repeated password is required', 'required', '', '');
        
        //globalrules
	    function globalRules($data)  {
	        
	        //password compare
			if ($data['password1'] != $data['password2']){
				return array('password2' => 'Passwords do not match');
			}

            $admin = new Admin();
            
            $user = $admin->getUser($data['id'])->toArray();

            if ($user['password'] != md5($data['old_pass'])){
                return array('old_pass' => 'Invalid Password');
            }
            
			return true;
	
	    }
    	
		$this->addFormRule('globalRules');
    }
}