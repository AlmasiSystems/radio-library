<?php
//QuickForm class loaded in bootstrap

class uploadPlaylistImageForm extends HTML_QuickForm
{
    function uploadPlaylistImageForm($action, $button_value, $season_id) {
		$form_attr = NULL;

        parent::HTML_QuickForm('uploadplaylistimage', 'post', $action, '', $form_attr);
        //remove for xhtml
        $this->removeAttribute('name');

		//get models
		$admin = new Admin();
		$schedule = new Schedule();

		//grab djs and show for use
		
		$this->addElement('header', 'showname_header', 'Playlist Image');

		$this->addElement('text', 'image_url', 'Url of Image', array('size' => '40'));
		
		$this->addElement('hidden', 'id');
		$this->addElement('hidden', 'event_id');
		$this->addElement('hidden', 'show_id');
		$this->addElement('hidden', 'date');
		
		//submit
		$this->addElement('submit', 'submit', 'Grab Picture From Internet');
		
		//rules
    }

}