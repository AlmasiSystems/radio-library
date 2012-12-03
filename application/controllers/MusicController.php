<?php

class MusicController extends MyController
{
    function indexAction()
    {
        //return $this->albumsAction();
		$this->render();
    }
    
    function testAction()
    {
		$this->view->artist = $this->getRequest()->getParam('artist');
		$this->render();
	}
	
    function albumsAction()
    {
		return $this->addAlbumAction();
	}

    function addAlbumAction()
    {
        $this->view->title = "Album Manager";
		require_once('editalbum.form.php'); //quickform class
        $form = new editAlbumForm('/music/albums', 'Add Album', false); //pass the action param of form as string, button text, false for no ajax
        //change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();
		
		if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
			
			//remove all other form stuff that could be about label (only want id)
			unset($data['label_selected']);
			unset($data['label_autocomplete']);
			unset($data['label_name']);
			unset($data['label_website']);
			unset($data['label_email']);

			//custom formating

			//disc count
			$data['disc_count'] = 1; 

			//add date
			$data['add_datetime'] = date('Y-m-d H:i:s');
			
			//adder
			$namespace = new Zend_Session_Namespace();
			$data['adders'] = $namespace->username;
			
			//release date
			//$data['release_day'] = $data['release_date']['d'];
			//$data['release_month'] = $data['release_date']['m'];
			$data['release_year'] = $data['release_date']['Y'];
			unset($data['release_date']);
			
			//tracking stuff
			$num_track_months = '3'; //number of months to track
			//only do if track_con is set (should be), contains the radio element, and that element is true
			if(isset($data['track_con']) && isset($data['track_con']['track_condition']) && $data['track_con']['track_condition']){
				$data['trackend_date'] = date('Y-m-d', strtotime($data['add_datetime'] . '+'. $num_track_months .' months'));
				$data['track_con'] = true; //to remove the array that is the default
			} else {
				$data['track_con'] = false;
			}
			//unset($data['track_months']);

            //get model
            $music = new Music();
            
            //insert album            
            $album_id = $music->updateAlbum($data);        
            
			$this->view->the_message = '<b>'. $data['artist_display'] . '</b> - <i>' . $data['title'] . '</i> added successfully. <a href="/music/albums/">Click to add another</a>';
			
			//add label printing buttons to message
			$joined_album = $music->getAlbumJoined($album_id);
			$joined_album['id'] = $album_id;
			$album_genre = $music->getGenre($joined_album['genre_id']);
			if($album_genre){
				$album_genre = $album_genre->toArray();
				$album_genre = $album_genre['name'];
				$joined_album['genre'] = $album_genre;
			} else {
				$joined_album['genre'] = 'Error: Unknown Genre';
			}
			
			$this->view->the_message .= '<br /><br />' . $this->view->CreateLabelPrintButtons($joined_album); 
						
			//change form to look like a nice preview
			$temp_element = $form->getElement('artist');
			$temp_element->setLabel('Artist Name');
			$temp_element = $form->getElement('artist_display');
			$temp_element->setLabel('Artist Display Name');
			$temp_element = $form->getElement('label_selected');
			$temp_element->setLabel('Label');
			
			//remove elements
			$form->removeElement('label_autocomplete');
			$form->removeElement('submit');
			
			$form->freeze();
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        } else {
            //set defaults grabbed from user entry if editing
            //$form->setDefaults($user);
			$form->accept($renderer);
            $this->view->the_form = $renderer->toHtml();
        }
        
        $this->render('addalbum');
    }
    
	function editAlbumAction()
	{
		$this->view->title = "Album Manager";
		
		if($this->getRequest()->getParam('id')){
			$this->view->album_id = $this->getRequest()->getParam('id');
		}
		
		$this->render();
	}
	
	/*label stuff */
    function labelsAction()
    {
        return $this->addLabelAction();
    }
    
	function addLabelAction()
	{
		$this->view->title = "Label Manager";
		
		//load model
	    Zend_Loader::loadClass('Music'); //admin has Users which we need
		
		require_once('editlabel.form.php'); //quickform class
        $form = new editLabelForm('/music/addLabel', 'Add Label', false); //pass the action param of form as string, button val, and true for ajax
		
		//change renderer for xhtml
		$renderer = new HTML_QuickForm_Renderer_Tableless();

        if ($form->validate()) {
            //get data from form
            $data = $form->exportValues();
            //remove submit element (so it wont clog up db update/insert)
            unset($data['submit']);
            
            //get model
            $music = new Music();
            
            //insert user            
            $user_id = $music->updateLabel($data);        
            
			$this->view->the_message = 'Label Added Successfully. <a href="/music/addLabel/">Add Another</a>';
        } else {
			$form->accept($renderer);
			$this->view->the_form = $renderer->toHtml();
        }
        $this->render('addlabel');	
	}
	
	function editLabelAction()
	{
		$this->view->title = "Label Manager";
		
		if($this->getRequest()->getParam('id')){
			$this->view->label_id = $this->getRequest()->getParam('id');
		}
		
		$this->render();
	}
	
	function browseLabelsAction()
	{
		$this->view->title = "Label Manager";
		
		if($this->getRequest()->getParam('letter')){
			$letter = $this->getRequest()->getParam('letter');
			$this->view->the_letter = $letter;
			//load model
		    Zend_Loader::loadClass('Music');
	
			$music = new Music();
			if ($letter == 'all'){
				$labels = $music->getAllLabels();
			} else if ($letter == 'sym'){
				$labels = $music->getAllLabelsStartingWithSymbol();
			} else { //must be valid 
				$labels = $music->getAllLabelsStartingWith($letter);
			}
			
			//give instructions to view
			$this->view->the_message = 'To edit a label just click what you would like to edit to begin editing';
			
			//give labels to view
			$this->view->the_labels = $labels;
		}
		
		$this->render('browselabels');
	}
	
    function artistsAction()
    {
        $this->view->title = "Artist Manager";
        $this->render('index');
    }
    
	function recentAction()
	{
        //get model
		Zend_Loader::loadClass('Music');
        $music = new Music();
		//echo APPLICATION_PATH;
		if($this->getRequest()->getParam('view') == 'month'){
		    $num_weeks = 4;
		    $this->view->header_text = "Adds in Last Month";
	    } else {
	        $num_weeks = 1;
	        $this->view->header_text = "Adds in Last Week";
        }
        $found_albums = $music->getRecentAdds($num_weeks);        
		
		if($found_albums){
			$this->view->results = $found_albums;
		} else {
			$this->view->the_message = 'No Recent Adds';
		}
        $this->render('list');
	}
	
    function spinsAction()
    {
		Zend_Loader::loadClass('Playlists');

		if($this->getRequest()->getParam('start_date') && $this->getRequest()->getParam('end_date')){
			$end_date = $this->getRequest()->getParam('end_date');
			$start_date = $this->getRequest()->getParam('start_date');
		} else {
			$end_date = date('Y-m-d', strtotime('yesterday'));
			$start_date = date('Y-m-d', strtotime($end_date . '- 1 week + 1 day'));			
		}	
		$this->view->header_text = "Grouped Spins (" . $start_date . " to " . $end_date  .")";
		
		$play = new Playlists();
		$spins = $play->getTopSpinsGrouped($start_date, $end_date);

		$this->view->start_date = $start_date;
		$this->view->end_date = $end_date;
		$this->view->the_spins = $spins;

        $this->render();
    }
    
    function topspinsAction()
    {
        Zend_Loader::loadClass('Music2');
        $model = new Music2();
        
        $formAdd = $model->getAddForm();
        $formEdit = $model->getEditForm();
        
        // get values for default out of the databse
        // if !post THEN date = today ELSE date = posted_date
        // pass date to a function in Music2 that returns hidden id, top5, and top30
        // set default values for editForm
        // 
        
        if (isset($_POST['lookup'])) {
            $data = $model->getTopByDate($_POST['post_date']);
            $data = $data[0];
			//var_dump($data);
            //BWS- need check for if row not found
            $data['top_5'] = $this->clean_string($data['top_5']);
            $data['top_30'] = $this->clean_string($data['top_30']);
			echo "<h1>$data[top_30]</h1>";
			
			//var_dump($data['top_30']);
			
            // need to use setConstants instead of setDefaults so it overrides user input
            $formEdit->setConstants($data);
			
        } else if (isset($_POST['edit'])) {
            if ($formEdit->validate()) {
                unset($_POST['edit']);
				unset($_POST['lookup']);
				unset($_POST['id']);
				$model->updateEdit($_POST);
				
            } else {
				
                echo "invalid form data for editing";
            }
        } else if (isset($_POST['add'])) {
            if ($formAdd->validate()) {
                unset($_POST['add']);
				unset($_POST['lookup']);
				unset($_POST['id']);
				$model->updateAdd($_POST);
            } else {
                echo "invalid form data for adding";
            }
        }
            
        $this->view->addForm = $model->getFormHtml($formAdd);
        $this->view->editForm = $model->getFormHtml($formEdit);
    }
    
	function clean_string($string, $curly = false) 
	{
	    $search = array(
	        chr(212),
	        chr(213),
			chr(210),
			chr(211),
			chr(209),
			chr(208),
			chr(201),
			chr(145),
			chr(146),
			chr(147),
			chr(148),
			chr(151),
			chr(150),
			chr(133)
		);
			
	    if ($curly) {
	        $replace = array(
				'&#8216;',
				'&#8217;',
				'&#8220;',
				'&#8221;',
				'&#8211;',
				'&#8212;',
				'&#8230;',
				'&#8216;',
				'&#8217;',
				'&#8220;',
				'&#8221;',
				'&#8211;',
				'&#8212;',
				'&#8230;'
			);
		} else {
	        $replace = array(
				'&#8216;',
				'&#8217;',
				'&#8220;',
				'&#8221;',
				'&#8211;',
				'&#8212;',
				'&#8230;',
				"'",
				"'",
				'"',
				'"',
				'&#8211;',
				'&#8212;',
				'&#8230;'
			);
	    }
	    
	    //removed nl2br
	    return trim(str_replace($search, $replace, $string));
	}
}