<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');

class userDetailsForm extends HTML_QuickForm {
    function userDetailsForm($action, $button_value) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway

        parent::HTML_QuickForm('edituser', 'post', $action);
        //remove for xhtml
        $this->removeAttribute('name');

        
        //begin elements
        $this->addElement('header', '', 'User Info');
        $this->addElement('hidden', 'id');
        $this->addElement('text', 'name_first', 'First Name');
        $this->addElement('text', 'name_last', 'Last Name');
        $this->addElement('text', 'email', 'Email');
        
        $this->addElement('submit', 'submit', $button_value);

        //rules
        
        // require all user info
        $this->addRule('name_first', 'A first name is required', 'required', '', '');
        $this->addRule('name_last', 'A last name is required', 'required', '', '');
        $this->addRule('email', 'A valid email is required', 'required', '', '');
        
        //value specific rules
        $this->addRule('email', 'Email address must be valid', 'email', '', '');
    }
}