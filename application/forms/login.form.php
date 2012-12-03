<?php
//QuickForm class loaded in bootstrap

class loginForm extends HTML_QuickForm
{
    function loginForm($action) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway
        parent::HTML_QuickForm('loginForm', 'post', $action);

        $this->addElement('text', 'username', 'Username');
        $this->addElement('password', 'password', 'Password');
        $this->addElement('submit', 'submit', 'login');

        
        // require a username and password
        $this->addRule('username', 'A username is required', 'required', '', 'client'); //'client' adds js validation
        $this->addRule('password', 'A password is required', 'required', '', 'client');
        $this->removeAttribute('name');
    }

}