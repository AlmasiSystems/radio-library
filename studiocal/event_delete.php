<?php 
require_once("includes/config.php");

session_start();

$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());

$db_table = $TBL_PR . "events";
mysql_query("DELETE FROM $db_table WHERE event_id='".addslashes($_GET['id'])."' LIMIT 1");
$_GET['month'] = $_GET['month'] + 1;
?>
                    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
                    <html>
                    <head>
                    <title>Calendar - Delete Event</title>
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                    <script language='javascript' type="text/javascript">
                    <!--
                     function redirect_to(where, closewin)
                     {
                             opener.location= 'index.php?' + where;
                             
                             if (closewin == 1)
                             {
                                     self.close();
                             }
                     }
                      //-->
                     </script>
                    </head>
                    Event should be deleted
                    
                    <body onLoad="javascript:redirect_to('month=<?php echo $_GET['month']."&year=".$_GET['year']; ?>',1);">
                    
                    </body>
                    </html>
