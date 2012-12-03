<?php

class SearchController extends MyController {
	function init() {
        //call default init from MyController
        parent::init();
        //load model
        Zend_Loader::loadClass('Music');
    }
    function indexAction(){
        /*$this->view->title = "Search Library";
        $this->render();*/
		return $this->albumsAction();
    }
    function albumsAction(){
        $this->view->title = "Album Search";
		require_once('searchalbums.form.php'); //quickform class
        $form = new searchAlbumForm('/search/albums', 'Search Albums');
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
		
    
		if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
			
			//remove all other form stuff that could be about label (only want id)
			unset($data['label_autocomplete']);

			//custom formating
			
			//release date
			$data['release_year'] = $data['release_date']['Y'];
			unset($data['release_date']);
			
			//tracking stuff

			//only do if track_con is set, contains the radio element
			if(isset($data['track_con'])){
				if($data['track_con']['track_condition']){
					$data['track_con'] = 1; //to remove the array that is the default
				} else {
					$data['track_con'] = 0;
				}
			}
		
			//give special options to adders
			$auth = Zend_Auth::getInstance();
	        $access = $auth->getStorage()->read();
		
			if(isset($access['music_editalbum']) && $access['music_editalbum']){
				$this->view->is_adder = true;
			} else {
				$this->view->is_adder = false;
			}
		
            //get model

            $music = new Music();
 
            $found_albums = $music->findAllAlbumsAdvanced($data);        
			
			if($found_albums){
				$this->view->results = $found_albums;
			} else {
				$this->view->the_message = 'No Albums Found. <a href="/search/albums/">Back to Advanced Search</a>';
				$form->accept($renderer);
	            $this->view->advanced_form = $renderer->toHtml();
			}
			
        } else {
            //set defaults grabbed from user entry if editing
            //$form->setDefaults($user);
			$form->accept($renderer);
            $this->view->advanced_form = $renderer->toHtml();
			
        }
        $this->render('albums');
	}
}
	