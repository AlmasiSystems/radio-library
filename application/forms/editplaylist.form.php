<?php
//QuickForm class loaded in bootstrap

class editPlaylistForm extends HTML_QuickForm
{
    function editPlaylistForm($action, $button_value, $season_id) {
		$form_attr = NULL;

        parent::HTML_QuickForm('editplaylist', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');

		//get models
		$admin = new Admin();
		$schedule = new Schedule();

		//grab djs and show for use
		$djs = $this->getSelectArray($admin->getAllDJs(), 'dj_name');
		$shows = $this->getSelectArray($schedule->getAllShowsBySeason($season_id), 'show_name', false);
		
		$this->addElement('header', 'showname_header', 'Show Name');
		$this->addElement('select', 'show_id', 'Show Name', $shows);
		$this->addElement('header', 'showname_header', 'Playlist Image Url');

		$this->addElement('text', 'image_url', array('Url of Image'), array('size' => '40'));
		
		$this->addElement('header', 'comments_header', 'Comments');
		
		$this->addElement('hidden', 'id');
		$this->addElement('hidden', 'event_id');
		$this->addElement('hidden', 'date');
		$this->addElement('hidden', 'start_time');
		$this->addElement('hidden', 'end_time');
		$toggle_link = '<div style="text-align: center;"> '
		             . 'Use HTML button on editor to insert/edit HTML &nbsp;'
		             . '[<a href="javascript:toggleEditor(\'comments\');">Add/Remove editor</a>]<br />'
		             . '<span align="left">Guidelines for show announcements:'
		             . '<ul>'
		             . '	<li>- Relevant to the content of your show.</li>'
		             . '	<li>- Provide additional information to supplement your show.</li>'
		             . '	<li>- Should give an idea of what listeners will hear.</li>'
		             . '	<li>- <b>May not contain offensive or pornographic material.</b></li>'
		             . '	<li>- <b>May not contain profane or offensive language.</b></li>'
		             . '	<li>- <b>May not jeopardize the station\'s ability to get sponsors or pledges.</b></li>'
		             . '</ul></span>'
		             . '</div>';


        $this->addElement('textarea', 'comments', array('Comments', $toggle_link), array('cols' => '40', 'rows' => '12'));
        
		//submit
		$this->addElement('submit', 'submit', $button_value);

		$this->addElement('header', '', 'Options');
		//checkboxes
		$options_group1[] = HTML_QuickForm::createElement('advcheckbox', 'opt_live', '', '-Live Performance');
		$options_group1[] = HTML_QuickForm::createElement('advcheckbox', 'opt_guest', '', '-On Air Guest');
		$options_group1[] = HTML_QuickForm::createElement('advcheckbox', 'opt_sports', '', '-Sports');
        $options_group1[] = HTML_QuickForm::createElement('advcheckbox', 'opt_theme', '', '-Themed Show');
		$options_group1[] = HTML_QuickForm::createElement('advcheckbox', 'opt_tickets', '', '-Ticket Giveaway');		
		$this->addGroup($options_group1, 'options_group1', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        

		//$this->addGroup($options_group2, 'options_group2', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		$this->addElement('header', '', 'Subbing DJs');
		$subs_group[] = HTML_QuickForm::createElement('select', 'sub_dj1_id', 'Subbing DJ One', $djs);
		$subs_group[] = HTML_QuickForm::createElement('select', 'sub_dj2_id', 'Subbing DJ Two', $djs);
		$this->addGroup($subs_group, 'subs_group', '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		//submit
		$this->addElement('submit', 'submit', $button_value);
		
		//rules
		
		//globalrules
	    function globalRules($data)  {
		
	
			/*
			if($data['picture_url'] != '' && !strstr($data['picture_url'], 'kdvs.org')){
				    require_once('./public/phpThumb/phpthumb.class.php');


					$phpThumb = new phpThumb();

					// Set error handling (optional)
					$phpThumb->config_error_die_on_error = TRUE;

					// set data
					$phpThumb->setSourceFilename($data['image_url']);

					// set parameters (see "URL Parameters" below)
					$phpThumb->w = 500;

					// set options (see phpThumb.config.php)
					// here you must preface each option with "config_"
				//	$phpThumb->config_cache_directory = '/public/phpThumb/cache/';
					$phpThumb->config_output_format = 'jpeg';
					$phpThumb->config_nohotlink_enabled = false;

					$new_name = (string)$data['event_id'] . '_' . (string)$data['date'] . '.jpg';
					$new_path = './public/pictures/playlist/';


					if ($phpThumb->GenerateThumbnail()) {

						if (!$phpThumb->RenderToFile($new_path . $new_name)) {
							// do something with debug/error messages
							//ERROR HANDLER
							//$this->add_error($picture_type, implode("<br /><br />", $phpThumb->debugmessages));
							//return FALSE;

							return array('image_url' => 'Image Grab Failure:<br /> ' . implode("<br /><br />", $phpThumb->debugmessages));
						}

					} else {
						return array('image_url' => 'Image Grab Failure:<br /> ' . implode("<br /><br />", $phpThumb->debugmessages));
					}
			}
			*/
			return true;

	    }
    	
		$this->addFormRule('globalRules');
		
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

