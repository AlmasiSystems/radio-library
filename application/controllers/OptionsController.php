<?php


class OptionsController extends MyController {
    function init() {
        //call default init from MyController
        parent::init();
        //load model
        Zend_Loader::loadClass('Admin');
    }
    function preDispatch(){
		//override to allow everyone access
	}
    function indexAction(){
        $this->render();
    }
	function userDetailsAction(){
		require_once('userdetails.form.php'); //quickform class
        $form = new userDetailsForm('/options/userDetails', 'Edit Account', false); //pass the action param of form as string, button text, false for no ajax
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
		
		//get user info from auth saved at login (and sent to view from parent init())
		$namespace = new Zend_Session_Namespace();
		$user_id = $namespace->user_id;
		
		//grab their info to populate into the form
		$admin = new Admin();
		$user = $admin->getUser($user_id)->toArray();
		
		//check for post and if valid
        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            //get model
            $admin = new Admin();
            
            //insert user            
            $user_id = $admin->updateUser($data);        
            
			$this->view->the_message = 'Profile Information Updated Successfully.';
	
        } else {
            //set defaults grabbed from user entry if editing
            $form->setDefaults($user);
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        }
        
        $this->render();
	}
	function changepassAction(){
		require_once('changepass.form.php'); //quickform class
        $form = new changePassForm('/options/changepass', 'Change Password', false); //pass the action param of form as string, button text, false for no ajax
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
		
		//get user info from auth saved at login (and sent to view from parent init())
		$namespace = new Zend_Session_Namespace();
		$user_id = $namespace->user_id;
		
		
		//check for post and if valid
        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            $data['password'] = md5($data['password1']);
            
            //remove unwanted elements
            unset($data['old_pass']);
            unset($data['password1']);
            unset($data['password2']);
            
            //get model
            $admin = new Admin();
            
            //insert user            
            $user_id = $admin->updateUser($data);        
            
			$this->view->the_message = 'Password Updated Successfully.';
			
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        } else {
            //set defaults grabbed from user entry if editing
            $user['id'] = $user_id;
            $form->setDefaults($user);
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        }
        
        $this->render();
	}
	function notificationsAction(){
		
	}
	

}