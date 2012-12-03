<?php
echo '<?phpxml version="1.0" ?>';

/* Input to this file:

$_GET['year'];
$_GET['month'];
$_GET['day'];

*/

$startOfWeek = date("Y-m-d H:i:s",mktime(0,0,0,$_GET['month'],$_GET['day'],$_GET['year']));
$endOfWeek = strtotime($startOfWeek."+1 WEEK");

// You will typically make a db query like this:
/*
$res = mysql_query("select * from weekSchedule where eventStartDate>='$startOfWeek' and eventEndDate<'$endOfWeek'");
while($inf = mysql_fetch_array($res)){
	?>
	<item>
		<id><?php echo $inf["ID"]; ?></id>
		<description><?php echo $inf["description"]; ?></description>
		<eventStartDate><?php echo gmdate('D, d M Y H:i:s',strtotime($inf["eventStartDate"])) . ' GMT'; ?></eventStartDate>
		<eventEndDate><?php echo gmdate('D, d M Y H:i:s',strtotime($inf["eventEndDate"])) . ' GMT'; ?></eventEndDate>
		<bgColorCode><?php echo $inf["bgColorCode"]; ?></bgColorCode>
	</item>
	<?php
	
}

*/


/**************************************************************************************
*
* The code below is just an example used for the demo
*
***************************************************************************************/

$week1 = date("2006-02-13 00:00:00");
$week2 = date("2006-02-20 00:00:00");
$week3 = date("2006-02-27 00:00:00");
$week4 = date("2006-03-06 00:00:00");
$week5 = date("2006-03-13 00:00:00");

if($startOfWeek>=$week1 && $startOfWeek<$week2){
?>

<item>
	<id>1</id>
	<description>Lunch</description>
	<eventStartDate>Mon, 13 Feb 2006 11:30 GMT</eventStartDate>
	<eventEndDate>Mon, 13 Feb 2006 12:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<item>
	<id>2</id>
	<description>Working with my project which is quite exciting.</description>
	<eventStartDate>Mon, 13 Feb 2006 12:00 GMT</eventStartDate>
	<eventEndDate>Mon, 13 Feb 2006 14:30 GMT</eventEndDate>
	<bgColorCode>#FFFF00</bgColorCode>
</item>
<item>
	<id>3</id>
	<description>Meeting with clients</description>
	<eventStartDate>Tue, 14 Feb 2006 13:00 GMT</eventStartDate>
	<eventEndDate>Tue, 14 Feb 2006 15:00 GMT</eventEndDate>
	<bgColorCode>#FFFF00</bgColorCode>
</item>
<item>
	<id>4</id>
	<description>Create requirement specification for the new project</description>
	<eventStartDate>Wed, 15 Feb 2006 07:00 GMT</eventStartDate>
	<eventEndDate>Wed, 15 Feb 2006 10:00 GMT</eventEndDate>
	<bgColorCode>#EEEEEE</bgColorCode>
</item>
<item>
	<id>6</id>
	<description>Reading an exiting book</description>
	<eventStartDate>Thu, 16 Feb 2006 18:00 GMT</eventStartDate>
	<eventEndDate>Thu, 16 Feb 2006 20:00 GMT</eventEndDate>
	<bgColorCode>#EEEEEE</bgColorCode>
</item>
<item>
	<id>7</id>
	<description>Playing chess</description>
	<eventStartDate>Sat, 18 Feb 2006 12:00 GMT</eventStartDate>
	<eventEndDate>Sat, 18 Feb 2006 13:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<item>
	<id>8</id>
	<description>Watch TV and do nothing</description>
	<eventStartDate>Sun, 19 Feb 2006 17:00 GMT</eventStartDate>
	<eventEndDate>Sun, 19 Feb 2006 19:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<item>
	<id>9</id>
	<description>Ouch!!! Dentist appointment</description>
	<eventStartDate>Fri, 17 Feb 2006 09:00 GMT</eventStartDate>
	<eventEndDate>Fri, 17 Feb 2006 10:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<?php


}



if($startOfWeek>=$week2 && $startOfWeek<$week3){
?>

<item>
	<id>11</id>
	<description>Lunch</description>
	<eventStartDate>Mon, 20 Feb 2006 11:30 GMT</eventStartDate>
	<eventEndDate>Mon, 20 Feb 2006 12:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<item>
	<id>12</id>
	<description>Working with my project which is quite exciting.</description>
	<eventStartDate>Mon, 20 Feb 2006 12:00 GMT</eventStartDate>
	<eventEndDate>Mon, 20 Feb 2006 14:30 GMT</eventEndDate>
	<bgColorCode>#FFFF00</bgColorCode>
</item>
<item>
	<id>13</id>
	<description>Meeting with clients</description>
	<eventStartDate>Tue, 21 Feb 2006 13:00 GMT</eventStartDate>
	<eventEndDate>Tue, 21 Feb 2006 15:00 GMT</eventEndDate>
	<bgColorCode>#FFFF00</bgColorCode>
</item>
<item>
	<id>14</id>
	<description>Create requirement specification for the new project</description>
	<eventStartDate>Wed, 22 Feb 2006 07:00 GMT</eventStartDate>
	<eventEndDate>Wed, 22 Feb 2006 10:00 GMT</eventEndDate>
	<bgColorCode>#EEEEEE</bgColorCode>
</item>
<item>
	<id>16</id>
	<description>Reading an exiting book</description>
	<eventStartDate>Thu, 23 Feb 2006 17:00 GMT</eventStartDate>
	<eventEndDate>Thu, 23 Feb 2006 19:30 GMT</eventEndDate>
	<bgColorCode>#EEEEEE</bgColorCode>
</item>
<item>
	<id>17</id>
	<description>Dinner appointment</description>
	<eventStartDate>Sat, 25 Feb 2006 17:00 GMT</eventStartDate>
	<eventEndDate>Sat, 25 Feb 2006 19:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<item>
	<id>18</id>
	<description>Playing board games</description>
	<eventStartDate>Sun, 26 Feb 2006 14:00 GMT</eventStartDate>
	<eventEndDate>Sun, 26 Feb 2006 16:30 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<?php
}


if($startOfWeek>=$week4 && $startOfWeek<$week5){
?>

<item>
	<id>11</id>
	<description>Lunch with some of my friends from school</description>
	<eventStartDate>Mon, 06 Mar 2006 09:30 GMT</eventStartDate>
	<eventEndDate>Mon, 06 Mar 2006 11:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<?php
}
if($startOfWeek>=$week3 && $startOfWeek<$week4){
?>

<item>
	<id>11</id>
	<description>Taking some time off to just do fun stuff.</description>
	<eventStartDate>Tue, 28 Feb 2006 11:30 GMT</eventStartDate>
	<eventEndDate>Tue, 28 Feb 2006 15:00 GMT</eventEndDate>
	<bgColorCode>#FFFFFF</bgColorCode>
</item>
<?php
}

?>



