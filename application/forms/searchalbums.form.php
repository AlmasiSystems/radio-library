<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Music');

class searchAlbumForm extends HTML_QuickForm {
    function searchAlbumForm($action, $button_value) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway
		$form_attr = NULL;

        parent::HTML_QuickForm('editalbum', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');
        
		//get model
		$music = new Music();

        //grab all possible select values

		$formats = $this->getSelectArray($music->getAllFormats());
  		$promoters = $this->getSelectArray($music->getAllPromoters());
		$genres = $this->getSelectArray($music->getAllGenres());
    

        //begin elements
        $this->addElement('header', '', 'Album Information');

		$tracking_radios[] = HTML_QuickForm::createElement('radio', 'track_condition', '', 'Yes', 1);
		$tracking_radios[] = HTML_QuickForm::createElement('radio', 'track_condition', '', 'No', 0);
		$this->addGroup($tracking_radios, 'track_con', 'Tracked', '&nbsp;');
		
		//album id
        $this->addElement('text', 'id', 'Album ID', array('size' => '7'));

		//artist name
        $this->addElement('text', 'artist', array('Artist Name'));
		
		//title
        $this->addElement('text', 'title', array('Album Title', ''));


		
		//format
		$this->addElement('select', 'format_id', 'Format', $formats);
		//$this->getElement('format_id')->setSize(5);
		//$this->getElement('format_id')->setMultiple(true);		
		
		//disc count
		//$this->addElement('text', 'disc_count', 'Disc Count');
		
		//genre
		$this->addElement('select', 'genre_id', 'Genre', $genres);
		//$this->getElement('genre_id')->setSize(5);
		//$this->getElement('genre_id')->setMultiple(true);
		
		//release date
		$next_year = date('Y', strtotime('+1 year'));
		$this->addElement('date', 'release_date', 'Release Date', array('format'=>'Y', 'minYear'=>$next_year, 'maxYear'=>1900)); 
		//$this->addElement('date', 'release_date', 'Release Date', array('format'=>'mdY', 'minYear'=>$next_year, 'maxYear'=>1900)); 
		
		//label
		
		$this->addElement('text', 'label_autocomplete', array('Label', '<span id="label_autocomplete_indicator" style="display: none;"><img src="/public/images/loading_small.gif" alt="Loading..." /></span>'), array('size' => '30'));
		$this->addElement('html', '<div id="label_autocomplete_choices" class="autocomplete"></div>');	
		$this->addElement('hidden', 'label_id');
		
		//promoter
        $this->addElement('select', 'promoter_id', 'Promoter', $promoters);

        //submit
        $this->addElement('submit', 'submit', $button_value );

		//filters
		$this->applyFilter('__ALL__', 'trim');
		
    }

    function getSelectArray($data){
		$select_array = array('' => '');
		foreach($data as $datum){
			$select_array[$datum['id']] = $datum['name'];
		}
		return $select_array;
	}

}