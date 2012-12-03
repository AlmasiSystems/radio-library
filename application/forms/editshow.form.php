<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Admin');
Zend_Loader::loadClass('Schedule');

class editShowForm extends HTML_QuickForm {
    function editShowForm($action, $button_value, $ajax = false) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway
		$form_attr = NULL;
		if($ajax){
			$form_attr = array('onsubmit' => 'submitEditShowForm(this); return false;');
		}
		
        parent::HTML_QuickForm('editshow', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');

		//get models
		$admin = new Admin();
		$schedule = new Schedule();
        //grab all possible select values

		$djs = $this->getSelectArray($admin->getAllDJs(), 'dj_name');
		$show_types = $this->getSelectArray($schedule->getAllShowTypes(), 'description');
		$seasons = $this->getSelectArray($schedule->getAllSeasons(), 'title', false);
        
		$old_shows = $schedule->getAllOldShows();
		
		$old_shows_w_djs = array('' => '');
		foreach($old_shows as $os){
			$old_shows_w_djs[$os['id']] = $os['show_name'] . ' - ' . $os['dj_names'];
		}	

        //begin elements
        $this->addElement('header', '', 'Show Info');
        $this->addElement('hidden', 'id');
		//season
		$this->addElement('select', 'season_id', 'Season', $seasons);
		//show name
        $this->addElement('text', 'show_name', 'Show Name', array('size' => '40'));
        //show type
		$this->addElement('select', 'show_type', 'Show Type', $show_types);
        //show descrioptoin
		$this->addElement('textarea', 'description', 'Show Description', array('rows' => '7', 'cols' => '30'));		

        $this->addElement('header', '', 'DJs');
        //dj1
		$this->addElement('select', 'dj1_id', 'DJ One', $djs);
		//dj2
		$this->addElement('select', 'dj2_id', 'DJ Two', $djs);
		//dj3
		$this->addElement('select', 'dj3_id', 'DJ Three', $djs);

        /**************************
        This section should be created dynamically so that additional genre's may be added
        (not likely to happen soon, as SRFs haven't changed in a long time)
        **************************/


		//show genres
		$this->addElement('header', '', 'Genres');
		
		//checkboxes
		$genres_group1[] = HTML_QuickForm::createElement('advcheckbox', 'genre_metal', '', '-Metal');
		$genres_group1[] = HTML_QuickForm::createElement('advcheckbox', 'genre_international', '', '-International');
		$genres_group1[] = HTML_QuickForm::createElement('advcheckbox', 'genre_reggae', '', '-Reggae');
		$this->addGroup($genres_group1, 'genres_group1', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        
        $genres_group2[] = HTML_QuickForm::createElement('advcheckbox', 'genre_classical', '', '-Classical');
		$genres_group2[] = HTML_QuickForm::createElement('advcheckbox', 'genre_eclectic', '', '-Eclectic');
		$genres_group2[] = HTML_QuickForm::createElement('advcheckbox', 'genre_electronic', '', '-Electronic');
		$this->addGroup($genres_group2, 'genres_group2', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		$genres_group3[] = HTML_QuickForm::createElement('advcheckbox', 'genre_hardcore', '', '-Hardcore');
		$genres_group3[] = HTML_QuickForm::createElement('advcheckbox', 'genre_jazz', '', '-Jazz');
		$genres_group3[] = HTML_QuickForm::createElement('advcheckbox', 'genre_folk', '', '-Folk');
		$genres_group3[] = HTML_QuickForm::createElement('advcheckbox', 'genre_rock', '', '-Rock');
		$this->addGroup($genres_group3, 'genres_group3', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		$genres_group4[] = HTML_QuickForm::createElement('advcheckbox', 'genre_indie', '', '-Indie');
		$genres_group4[] = HTML_QuickForm::createElement('advcheckbox', 'genre_blues', '', '-Blues');
		$genres_group4[] = HTML_QuickForm::createElement('advcheckbox', 'genre_industrial', '', '-Industrial');
		$genres_group4[] = HTML_QuickForm::createElement('advcheckbox', 'genre_punk', '', '-Punk');
		$this->addGroup($genres_group4, 'genres_group4', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

		$genres_group5[] = HTML_QuickForm::createElement('advcheckbox', 'genre_hiphop', '', '-Hip Hop');
		$genres_group5[] = HTML_QuickForm::createElement('advcheckbox', 'genre_latin', '', '-Latin');
		$genres_group5[] = HTML_QuickForm::createElement('advcheckbox', 'genre_noise', '', '-Noise');
		$genres_group5[] = HTML_QuickForm::createElement('advcheckbox', 'genre_experimental', '', '-Experimental');
		$this->addGroup($genres_group5, 'genres_group5', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		//other genres
		$this->addElement('textarea', 'genre_other', 'Other', array('rows' => '3', 'cols' => '30'));
		
		//extra
		$this->addElement('header', '', 'Extra');
		$this->addElement('text', 'website', 'Show Website', array('size' => '40'));
		$this->addElement('text', 'email', 'Show Email', array('size' => '40'));
		
		$this->addElement('header', '', 'Old School Show');
		$this->addElement('select', 'oldschool_show_id', '', $old_shows_w_djs);
		
        $this->addElement('submit', 'submit', $button_value);

        //rules
        
        // require stuff
		$this->addRule('season_id', 'Season is required', 'required', '', '');
        $this->addRule('show_name', 'A show name is required', 'required', '', ''); //'client' adds js validation
        //$this->addRule('dj1_id', 'At least one dj is required', 'required', '', '');
        $this->addRule('show_type', 'Show type is required', 'required', '', '');
        $this->addRule('description', 'Show description is required', 'required', '', '');
        $this->addRule('website', 'Website may not be more than 250 characters', 'maxlength', '250');
        $this->addRule('email', 'Email may not be more than 250 characters', 'maxlength', '250');
    }
    function getSelectArray($data, $col, $blank = true){
		if ($blank){
			$select_array = array('' => '');
		} else {
			$select_array = array();
		}
		foreach($data as $datum){
			$select_array[$datum['id']] = $datum[$col];
		}
		return $select_array;
	}
}