<?php $rowHeight = 59; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>DHTMLgoodies - week planner</title>
<style type="text/css">
html{
	margin:0px;
	padding:0px;
	height:100%;
	width:100%;
}
body{
	margin:0px;
	padding:0px;
	font-family:arial;
	font-size:0.8em;	
	height:100%;
	width:100%;
}

p,h2{
	margin:2px;
}

h1{
	font-size:1.4em;
	margin:2px;
}
h2{
	font-size:1.3em;
}
.weekButton{
	width:80px;
	font-size:0.8em;
	font-family:arial;
}
#weekScheduler_container{
	border:1px solid #000;
	width:986px;	
}

.weekScheduler_appointments_day{	/* Column for each day */
	width:130px;
	float:left;
	background-color: #EEE;
	border-right:1px solid #ccc;	
	position:relative;
}
#weekScheduler_top{
	background-color:buttonface;
	height:20px;
	border-bottom:1px solid #ACA899;
}
.calendarContentTime,.spacer{
	background-color:buttonface;
	text-align:center;
	font-family:arial;
	font-size:28px;
	line-height:<?phpphp echo $rowHeight; ?>px;
	height:<?php echo $rowHeight; ?>px;	/* Height of hour rows */
	
	border-right:1px solid #ccc;
	width:50px;
}

.weekScheduler_appointmentHour{	/* Small squares for each hour inside the appointment div */
	height:<?php echo $rowHeight; ?>px; /* Height of hour rows */
	border-bottom:1px solid #ccc;	
}

.spacer{
	height:20px;
	float:left;
}	

#weekScheduler_hours{
	width:50px;
	float:left;
}
.calendarContentTime{
	border-bottom:1px solid #ACA899;

}

#weekScheduler_appointments{	/* Big div for appointments */
	width:917px;
	float:left;
}
.calendarContentTime .content_hour{
	font-size:10px;
	text-decoration:superscript;	
	vertical-align:top;
	line-height:<?php echo $rowHeight; ?>px;
}
	
#weekScheduler_top{
	position:relative;
	clear:both;
}
#weekScheduler_content{
	clear:both;
	height:540px;
	position:relative;
	overflow:auto;
}
.days div{
	width:130px;
	float:left;
	background-color:buttonface;
	text-align:center;
	font-family:arial;
	height:20px;
	font-size:0.9em;
	line-height:20px;
	border-right:1px solid #ACA899;	
}

.weekScheduler_anAppointment{	/* A new appointment */
	position:absolute;
	background-color:#FFF;
	border:1px solid #000;
	z-index:1000;
	overflow:hidden;


}

.weekScheduler_appointment_header{	/* Appointment header row */
	height:4px;
	background-color:#ACA899;
}
.weekScheduler_appointment_headerActive{ /* Appointment header row  - when active*/
	height:4px;
	background-color:#00F;
}

.weekScheduler_appointment_textarea{	/* Textarea where you edit appointments */
	font-size:0.7em;
	font-family:arial;
}

.weekScheduler_appointment_txt{
	font-size:0.9em;
	font-family:arial;
	padding:2px;
	padding-top:5px;
	overflow:hidden;

}

.weekScheduler_appointment_footer{
	position:absolute;
	bottom:-1px;
	border-top:1px solid #000;
	height:4px;
	width:100%;
	font-size:0.8em;
	background-color:#000;
}

.weekScheduler_appointment_time{
	position:absolute;
	border:0px;
	right:0px;
	top:0px;
	width:70px;
	height:16px;
	z-index:100000;
	font-size:1em;
	padding:1px;
	background-color:#ccc;
}
.eventIndicator{
	background-color:#00F;
	z-index:50;
	display:none;
	position:absolute;
}

</style>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript">
// It's important that this JS section is above the line below wher dhtmlgoodies-week-planner.js is included
var itemRowHeight=<?php echo $rowHeight; ?>;
var initDateToShow = '2006-02-13';	// Initial date to show
</script>
<script src="js/dhtmlgoodies-week-planner.js?random=20060214" type="text/javascript"></script>
</head>
<body>
<h1>Week planner</h1>
<form>
<input type="button" class="weekButton" value="<" onclick="displayPreviousWeek();return false">
<input type="button" class="weekButton" value=">" onclick="displayNextWeek();return false">
<div id="weekScheduler_container">
	<div id="weekScheduler_top">
		<div class="spacer"><span></span></div>
		<div class="days" id="weekScheduler_dayRow">
			<div>Monday <span></span></div>
			<div>Tuesday <span></span></div>
			<div>Wednesday <span></span></div>
			<div>Thursday <span></span></div>
			<div>Friday <span></span></div>
			<div>Saturday <span></span></div>
			<div>Sunday <span></span></div>		
		</div>	
	</div>
	<div id="weekScheduler_content">
		<div id="weekScheduler_hours">
		<?php
		
		$startHourOfWeekPlanner = 0;	// Start hour of week planner
		$endHourOfWeekPlanner = 23;	// End hour of weekplanner.
		
		$date = mktime($startHourOfWeekPlanner,0,0,5,5,2006);
		for($no=$startHourOfWeekPlanner;$no<=$endHourOfWeekPlanner;$no++){
			
			$hour = $no;
			
			// Remove these two lines in case you want to show hours like 08:00 - 23:00
			$suffix = date("a",$date);
			$hour = date("g",$date);
			
			// $suffix = "00"; // Enable this line in case you want to show hours like 08:00 - 23:00 
			
			
			$time = $hour."<span class=\"content_hour\">$suffix</span>";	
			$date = $date + 3600;		
			?>
			<div class="calendarContentTime"><?php echo $time; ?></div>
			<?php			
		}
		?>
		</div>	
		
		<div id="weekScheduler_appointments">
			<?php
			for($no=0;$no<7;$no++){	// Looping through the days of a week
				?>
				<div class="weekScheduler_appointments_day">
				<?php
				for($no2=$startHourOfWeekPlanner;$no2<=$endHourOfWeekPlanner;$no2++){
					echo "<div id=\"weekScheduler_appointment_hour".$no."_".$no2."\" class=\"weekScheduler_appointmentHour\"></div>\n";					
				}				
				?>				
				</div>
				<?php
			}
			?>		
		</div>
	</div>
</div>

<!--	DEMO -->
<h2>How it works</h2>
<p>This script uses Ajax(Asyncron Javascript and XML) to read event data from the server.</p>
<p>New event: Hold your mouse down and drag</p>
<p>Move event: Hold your mouse down at the top of an event and drag</p>
<p>Resize event: Hold your mouse down at the bottom of an event and drag</p> 
<p>Edit event: Hold your mouse down at the middle of an event and wait until a textarea appears. Click outside of the textarea when you're finished or hit
the escape key to cancel the changes</p>
<p>Delete event: Click on event and press delete key on your keyboard</p>
</form>
</body>
</html>