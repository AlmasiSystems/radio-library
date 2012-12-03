<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');

class forgotPassForm extends HTML_QuickForm {
    function forgotPassForm($action, $button_value) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway

        parent::HTML_QuickForm('forgotpass', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

        
        //begin elements
        $this->addElement('header', '', 'Username');
        $this->addElement('text', 'username', 'Username');
        
        $this->addElement('submit', 'submit', $button_value);

        //rules
        
        // require all user info
        $this->addRule('username', 'Username is required', 'required', '', '');
        
        //globalrules
	    function globalRules($data)  {

            $admin = new Admin();
            $user = $admin->getUserByUsername($data['username']);
            if(!$user){
                return array('username' => 'Username Not Found');
            }

			return true;
	
	    }
    	
		$this->addFormRule('globalRules');
    }
}