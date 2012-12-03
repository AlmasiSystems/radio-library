<?php
//auth controller class (ACL class below)
class AuthController extends MyController {
    function init() {
        //call default init
        parent::init();
        Zend_Loader::loadClass('Auth');
    }
    function preDispatch() {
        //just here to override from MyController
    }
    
    function indexAction(){
        $this->_redirect('/');
    }

    function loginAction(){
        require_once('login.form.php'); //quickform class
        $form = new loginForm('/auth/login'); //pass the action param of form as string
        
        $this->view->message = ''; //message to display on login failure
        
        if ($form->validate()) {
            //get values from validated form post
            $username = $form->exportValue('username');
            $password = $form->exportValue('password');
            // setup Zend_Auth adapter for a database table
            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
            $dbAdapter = Zend_Registry::get('dbAdapter');
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
            $authAdapter->setTableName('users');
            $authAdapter->setIdentityColumn('username');
            $authAdapter->setCredentialColumn('password');
            
            // Set the input credential values to authenticate against
            $authAdapter->setIdentity($username);
            $authAdapter->setCredential(md5($password));
            
            // do the authentication 
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);
            if ($result->isValid()) {
                // success : store some of database row to auth's storage system (also access stuff)
                // (not the password or id though!)
                $data = $authAdapter->getResultRowObject(null, array('password'));
                //var_dump($data);
         
                //grab access permissions
                $auth_id = $data->auth_id;
                $table = new Auth();
                $access = $table->fetchRow('id = ' . $auth_id)->toArray();
                
                //store access role in and id session, then remove from access
                unset($access['id']);
                unset($access['role']);
                
                //store username and id for later reference
				$namespace = new Zend_Session_Namespace();
				$namespace->user_id = $data->id;
				$namespace->username = $data->username;
                
                //figure out which controllers the user has access to, and store in access
                $access['controllers'] = $this->determineControllerAccess($access);
                
                //store access for later
                $auth->getStorage()->write($access);
                
                $this->_redirect('/');
            } else {
                // failure:
                $auth->clearIdentity();
                $this->view->flashmsg = 'Login failed. Please <a href="">try again</a>.';
            }
            
        } else { //user input something incorrectly, display errors
            $this->view->the_form = $form->toHtml();
        }
        
        $this->render();
    }
    
    function logoutAction(){
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
    function resetpassAction(){
		require_once('resetpass.form.php'); //quickform class
        $form = new resetPassForm('/auth/resetpass', 'Reset Password', false); //pass the action param of form as string, button text, false for no ajax
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
	
		
		//check for post and if valid
        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            $data['password'] = md5($data['password1']);
            
            //remove unwanted elements
            unset($data['magic_code']);
            unset($data['password1']);
            unset($data['password2']);
            
            //get model
            $admin = new Admin();
            $user = $admin->getUserByUsername($data['username']);
            $data['id'] = $user['id'];
            unset($data['username']);
            //insert user     

            $user_id = $admin->updateUser($data);        
            
			$this->view->the_message = 'Password Updated Successfully. <a href="/auth/login/">Click Here To Login</a>';
			
        } else {
            $form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        }
        
        $this->render('resetpass');
	}
	function forgotpassAction(){
 		require_once('forgotpass.form.php'); //quickform class
         $form = new forgotPassForm('/auth/forgotpass', 'Send Email', false); //pass the action param of form as string, button text, false for no ajax
         //change renderer for xhtml
 		$renderer = new HTML_QuickForm_Renderer_Tableless();


 		//check for post and if valid
         if ($form->validate()) {
             //get data from form
             $data = $form->exportValues();

             $admin = new Admin();
             $user = $admin->getUserByUsername($data['username']);
  
             Zend_Loader::loadClass('Zend_Mail');

             //make sure email form is not being used for evil deeds!
             $mail = new Zend_Mail();
             $mail->addTo($user['email'], $user['name_first']);
             $mail->setFrom('donotreply@' + Zend_Registry::get('config')->application->station_email_domain, STATION_NAME + ' Library');

             $mail->setSubject(STATION_NAME + " Library Password Reset Information");
             
             $body = $user['name_first'] . ", \n\n";
             $body .= "To reset your password goto the following address: \n\n";
             $body .= Zend_Registry::get('config')->application->url + "auth/resetpass/ \n\n";
             $body .= "And Use the following information: \n\n";
             $body .= "username: " .$user['username']  . "\n";
             $body .= "magic code: " .$user['password']  . "\n\n";
             $body .= "and then provide your new password (and repeat) and your password will be changed. \n\n";
             
             $mail->setBodyText($body);
             $mail->send();
          

 		     $this->view->the_message = 'An email has been sent to <strong>'. $user['email']. '</strong> with details on how to reset your password.';
             $this->view->the_message .= '<br /><br /><strong>Be Sure to check your Spam Box</strong>';
         } else {
             $form->accept($renderer);
             $this->view->the_form = $renderer->toHtml();
         }

         $this->render('forgotpass');
 	}
    function determineControllerAccess($access){
        $controllers = array();
        foreach($access as $key => $value){
            if($value){
                $controller_action = split("_", $key);
                $controller = $controller_action[0];
                if(!array_key_exists($controller, $controllers)){
                    $controllers[] = $controller;
                }
            }   
        }
        return array_unique($controllers);
    }
    
}

