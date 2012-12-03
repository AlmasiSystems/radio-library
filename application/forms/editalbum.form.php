<?php
//QuickForm class loaded in bootstrap
Zend_Loader::loadClass('Music');

class editAlbumForm extends HTML_QuickForm {
    function editAlbumForm($action, $button_value, $ajax = false) {
        // call the parent contructor specifying the name of the form
        // I'm setting 'post' here as the action type, but post 
        // is the default anyway
		$form_attr = NULL;
		if($ajax){
			$form_attr = array('onsubmit' => 'submitEditAlbumForm(this); return false;');
		}
		//prevents enter key from submitting form
		$form_attr['onkeypress'] = 'return(event.keyCode!=13)';

        parent::HTML_QuickForm('editalbum', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');
        
		//get model
		$music = new Music();

        //grab all possible select values

		$formats = $this->getSelectArray($music->getAllFormats());
  		$promoters = $this->getSelectArray($music->getAllPromoters());
		$genres = $this->getSelectArray($music->getAllGenres());

		$track_months = array(
			'3' => '3',
			'6' => '6'
			);
     

        //begin elements
		//tracking info
		$this->addElement('header', '', 'Tracking Information');
		$tracking_radios[] = HTML_QuickForm::createElement('radio', 'track_condition', '', 'Yes', 1);
		$tracking_radios[] = HTML_QuickForm::createElement('radio', 'track_condition', '', 'No', 0);
		$this->addGroup($tracking_radios, 'track_con', 'Enable Tracking?', '&nbsp;');
		//$this->addElement('select', 'track_months', '# Months to Track', $track_months);		
		$this->addElement('hidden', 'add_datetime');
		
        $this->addElement('header', '', 'Album Information');

		//album id
        $this->addElement('hidden', 'id');

		//artist name
        $this->addElement('text', 'artist', array('Artist Name', 'Ex: <b>Pierce, Garrett</b> or <b>Dead Science, The</b>'));
		
		$this->addElement('text', 'artist_display', array('Artist Display Name', 'Ex: <b>Garrett Pierce</b> or <b>The Dead Science</b>'));
		
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
		$this->addElement('header', '', 'Label / Promo Information');
		$this->addElement('html', '<div id="addLabelForm" style="display: hidden;"></div>');
		
		$this->addElement('text', 'label_autocomplete', array('Magic Label Selector', '<span id="label_autocomplete_indicator" style="display: none;"><img src="/public/images/loading_small.gif" alt="Loading..." /></span>', 'Begin by typing Name of Label Above (at least 2 chars)'), array('size' => '30'));
		$this->addElement('html', '<div id="label_autocomplete_choices" class="autocomplete" style="display: none;"></div>');	

		//$label_group2[] = HTML_QuickForm::createElement('text', 'label_selected', '', array('id' => 'label_selected', 'readonly' => 'readonly', 'size' => '30'));
		//$label_group2[] = HTML_QuickForm::createElement('link', 'show_label_form', '', 'javascript:void(0)', 'Add Label', array('onclick' => 'showLabelForm();'));
		//$this->addGroup($label_group2, 'label_group2', 'Selected Label', '&nbsp;');
		$this->addElement('text', 'label_selected', array('Label Selected', '<a onclick="showLabelForm();" href="javascript:void(0)">Add Label</a>'), 
						array('id' => 'label_selected', 'readonly' => 'readonly', 'size' => '30'));
		$this->addElement('hidden', 'label_id');
		
		//promoter
        $this->addElement('select', 'promoter_id', 'Promoter', $promoters);


		
		//extra
		$this->addElement('header', '', 'Extra Information');        
		$this->addElement('text', 'artist_website', 'Artist Website');
		$this->addElement('text', 'artist_email', 'Artist Email');

        //submit
        $this->addElement('submit', 'submit', $button_value);

		//filters
		$this->applyFilter('__ALL__', 'trim');

        //rules
        
        // require all album info
        $this->addRule('artist', 'Artist name is required', 'required', '', ''); //'client' adds js validation
		$this->addRule('artist', 'Must be less than 250 characters', 'maxlength', '250', '');
		$this->addRule('artist_display', 'Artist Display Name is required', 'required', '', ''); //'client' adds js validation
		$this->addRule('artist_display', 'Must be less than 250 characters', 'maxlength', '250', '');
        $this->addRule('title', 'Album Title is required', 'required', '', '');
		$this->addRule('title', 'Must be less than 250 characters', 'maxlength', '250', '');
        $this->addRule('format_id', 'Format required', 'required', '', '');
	//  $this->addRule('disc_count', 'Disc Count required', 'required', '', '');
	//	$this->addRule('disc_count', 'Must be a numeric value', 'numeric', '', '');
		$this->addRule('genre_id', 'Genre is required', 'required', '', '');
/*		
		//grouprule for label
		$this->addGroupRule('label_group2', array(
		    'label_selected' => array(
		        array('Label is required', 'required')
		    )
		));
*/
		//grouprule for tracking
 		$this->addGroupRule('track_con', array(
		    'track_condition' => array(
		        array('Tracking conditon is required', 'required')
		    )
		));       
		$this->addRule('track_con', '', 'required', '', ''); //just adds *
		//grouprule for release date
 		$this->addGroupRule('release_date', array(
		    'Y' => array(
		        array('Release Year required', 'required')
		    )
		));       
		
		$this->addRule('artist_email', 'Must be less than 250 characters', 'maxlength', '250', '');
		$this->addRule('artist_website', 'Must be less than 250 characters', 'maxlength', '250', '');
		$this->addRule('title', 'Must be less than 250 characters', 'maxlength', '250', '');
		
       
        //custom rules
        
        //make sure doesn't already exist
	    function checkForDuplicates($data)  {
			$music = new Music();
			$rows = $music->findDuplicateAlbums($data['artist'], $data['title'], $data['format_id']);
	        if (count($rows) > 0){
				foreach($rows as $row){
	            	if ((int)$row['id'] != (int)$data['id']){	
						return array('title' => 'This album exists already (and of same format type)');
					}
				}
	        } 
			return true;
	    }		
		
		$this->addFormRule('checkForDuplicates');

  
		//make sure hidden label_id is numeric
	    function checkLabelId($data)  {
			if(isset($data['label_id']) && is_numeric($data['label_id'])){
				return true;
			} else {
				return array('label_group2' => 'Label is required');
			}
	    }
		$this->addFormRule('checkLabelId');
		
    }

    function getSelectArray($data){
		$select_array = array('' => '');
		foreach($data as $datum){
			$select_array[$datum['id']] = $datum['name'];
		}
		return $select_array;
	}

}