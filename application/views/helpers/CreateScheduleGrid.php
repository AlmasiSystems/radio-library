<?php

class My_View_Helper_CreateScheduleGrid {

    public function createScheduleGrid($schedule, $url_prefix) {
    	$output = "";
    	$output .= "<div id=\"schedule\">\n";
    	$output .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
    	$output .= "	<tr>\n";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Sunday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Monday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Tuesday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Wednesday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Thursday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Friday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Saturday</th>";
     	$output .= "	</tr>\n";
     	
     	//now start output for individual events
     	$current_time = strtotime('00:00:00');
     	
     	$output .= "	<tr>\n";
        foreach($schedule as $event){
        	$end_time = strtotime($event['end_time']);
        	$start_time = strtotime($event['start_time']);
        	$time_diff = ($end_time - $start_time);
        	if($time_diff < 0){
        		$time_diff = $time_diff + 24*3600; //to deal with 00:00:00 being midnight
        	}
        	$rowspan = ciel($time_diff / (1800)); //number of half hours in show
        	if ($start_time > $current_time){
        		$current_time = $start_time;
        		$output .= "	</tr>\n<tr>";
        	}
    		$output .= "<td valign=\"top\" rowspan=\"$rowspan\" class=\"music\">";
    		$output .= $event['description'];
    		$output .= "</td>";

        }
        
        //close last tr and put day info on bottom of table
        $output .= "	</tr>\n<tr>\n";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Sunday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Monday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Tuesday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Wednesday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Thursday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Friday</th>";
     	$output .= "	<th align=\"center\" valign=\"top\" width=\"14%\">Saturday</th>";
     	$output .= "	</tr>\n";
     	$output .= "</table>\n";
        
    }
}

