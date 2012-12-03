<?php 
//if($data['picture_url'] != '' && !strstr($data['picture_url'], 'kdvs.org')){
    require_once('../public/phpThumb/phpthumb.class.php');


	$phpThumb = new phpThumb();

	// Set error handling (optional)
	$phpThumb->config_error_die_on_error = TRUE;

	// set data
	$phpThumb->setSourceFilename('http://www.beyondmainstream.com/img/thumb_volunteer.jpg');

	// set parameters (see "URL Parameters" below)
	$phpThumb->w = 500;

	// set options (see phpThumb.config.php)
	// here you must preface each option with "config_"
//	$phpThumb->config_cache_directory = '/public/phpThumb/cache/';
	$phpThumb->config_output_format = 'jpeg';
	$phpThumb->config_nohotlink_enabled = false;

	$new_name = 'blahblah.jpg';
	$new_path = '../public/pictures/playlist/';


	if ($phpThumb->GenerateThumbnail()) {
		
		if (!$phpThumb->RenderToFile($new_path . $new_name)) {
			// do something with debug/error messages
			//ERROR HANDLER
			//$this->add_error($picture_type, implode("<br /><br />", $phpThumb->debugmessages));
			//return FALSE;
			
			echo 'Image Grab Failure:<br /> ' . implode("<br /><br />", $phpThumb->debugmessages);
		}
		
	} else {
		echo 'Image Grab Failure:<br /> ' . implode("<br /><br />", $phpThumb->debugmessages);
	} 
//}

return true;