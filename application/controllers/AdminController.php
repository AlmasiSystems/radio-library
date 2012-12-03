<?php


class AdminController extends MyController {
    function init() {
        //call default init from MyController
        parent::init();
        //load model
        Zend_Loader::loadClass('Admin');
    }
    
    function indexAction(){
        return $this->usersAction();
    }
    
    function usersAction(){
        $this->view->title = "Users";
		require_once('edituser.form.php'); //quickform class
        $form = new edituserForm('/admin/users', 'Add User', false); //pass the action param of form as string, button text, false for no ajax
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
        //get model
        $admin = new Admin();	
	
        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            

            
            //deal with telephone group
            $pri_phone = $data['primary_phone'];
            $data['primary_phone'] = $pri_phone['pri_area'] . '-' . $pri_phone['pri_no1'] . '-' . $pri_phone['pri_no2'];
            
            $sec_phone = $data['secondary_phone'];
            if($sec_phone['sec_area'] == '' || $sec_phone['sec_area'] == '' || $sec_phone['sec_area'] == ''){
                unset($data['secondary_phone']);
            } else {
                $data['secondary_phone'] = $sec_phone['sec_area'] . '-' . $sec_phone['sec_no1'] . '-' . $sec_phone['sec_no2'];
            }
            
            //deal with address group
            $data = array_merge($data, $data['address_group']);
            unset($data['address_group']);
            
            //md5 password
            $data['password'] = md5($data['password1']);
            unset($data['password1']);
            unset($data['password2']);
            
            //var_dump($data);
            
            //insert user            
            $user_id = $admin->updateUser($data);        
            
			$this->view->the_message = $data['username'] . ' added successfully. <a href="/admin/users/">Click to add another</a>';
			
        } else {
            //set defaults grabbed from user entry if editing
            //$form->setDefaults($user);
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        }
        
		$users = $admin->getAllUsers();
		$this->view->the_users = $users;
        $this->render('users');
    }
	
	


}