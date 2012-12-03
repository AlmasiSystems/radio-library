<?php
//******************************************************************************************************
//   ATTENTION: THIS FILE HEADER MUST REMAIN INTACT. DO NOT DELETE OR MODIFY THIS FILE HEADER.
//
//   Name: ubr_default_config.php
//   Revision: 1.0
//   Date: 24/12/2007 9:26AM
//   Link: http://uber-uploader.sourceforge.net
//   Initial Developer: Peter Schmandra  http://www.webdice.org
//   Description: Configure upload options
//
//   Licence:
//   The contents of this file are subject to the Mozilla Public
//   License Version 1.1 (the "License"); you may not use this file
//   except in compliance with the License. You may obtain a copy of
//   the License at http://www.mozilla.org/MPL/
//
//   Software distributed under the License is distributed on an "AS
//   IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or
//   implied. See the License for the specific language governing
//   rights and limitations under the License.
//********************************************************************************************************

$_CONFIG['config_file_name']           = 'ubr_default_config';
//$_CONFIG['upload_dir']                 = $_SERVER['DOCUMENT_ROOT'] . '/ubr_uploads/';
$_CONFIG['upload_dir']                 = '/var/www/uploads/';
$_CONFIG['multi_upload_slots']         = 1;
$_CONFIG['max_upload_slots']           = 10;
$_CONFIG['embedded_upload_results']    = 0;
$_CONFIG['check_file_name_format']     = 1;
$_CONFIG['check_allow_extensions']     = 1;  //Client side only. Server side is "always" checked
$_CONFIG['check_null_file_count']      = 1;
$_CONFIG['check_duplicate_file_count'] = 1;
$_CONFIG['show_percent_complete']      = 1;
$_CONFIG['show_files_uploaded']        = 1;
$_CONFIG['show_current_position']      = 1;
$_CONFIG['show_elapsed_time']          = 1;
$_CONFIG['show_est_time_left']         = 1;
$_CONFIG['show_est_speed']             = 1;
$_CONFIG['cedric_progress_bar']        = 1;
$_CONFIG['progress_bar_width']         = 400;
$_CONFIG['get_status_speed']           = 1000;  //1000=1 second, 500=0.5 seconds, 250=0.25 seconds etc.
$_CONFIG['unique_upload_dir']          = 0;
$_CONFIG['unique_upload_dir_length']   = 16;
$_CONFIG['unique_file_name']           = 0;
$_CONFIG['unique_file_name_length']    = 16;
$_CONFIG['max_upload_size']            = 5242880 * 40; //(5 * 1024 * 1024 = 5242880 = 5MB)
$_CONFIG['overwrite_existing_files']   = 0;
$_CONFIG['redirect_url']               = 'http://library.kdvs.org/upload/ubr_finished.php';
$_CONFIG['redirect_using_location']    = 1;
$_CONFIG['redirect_using_html']        = 0;
$_CONFIG['redirect_using_js']          = 0;
$_CONFIG['allow_extensions']           = '(wav|mp3|jpg)'; //Include file extentions you want to upload
$_CONFIG['normalize_file_names']       = 1;
$_CONFIG['normalize_file_delimiter']   = '_';
$_CONFIG['normalize_file_length']      = 48;
$_CONFIG['link_to_upload']             = 0;
$_CONFIG['path_to_upload']             = 'http://kdvs.ucdavis.edu/uploads/'; //Used for in web link
$_CONFIG['send_email_on_upload']       = 0;
$_CONFIG['html_email_support']         = 0;
$_CONFIG['link_to_upload_in_email']    = 0;
$_CONFIG['email_subject']              = 'Uber File Upload';
$_CONFIG['to_email_address']           = 'webmaster@kdvs.org';
$_CONFIG['from_email_address']         = 'donotreply@kdvs.org';
$_CONFIG['log_uploads']                = 0;
$_CONFIG['log_dir']                    = '/tmp/ubr_logs/';
$_CONFIG['opera_browser']              = (strstr(getenv("HTTP_USER_AGENT"), "Opera"))  ? 1 : 0;
$_CONFIG['safari_browser']             = (strstr(getenv("HTTP_USER_AGENT"), "Safari")) ? 1 : 0;

?>
