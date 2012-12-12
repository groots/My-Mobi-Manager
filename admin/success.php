<?php
include("session_check.php");
$enc = $_REQUEST['enc'];
$query = "SELECT * FROM mobilemanager_temp WHERE enc='".$enc."'";
$res   = mysql_query($query);
$temp_row   = mysql_fetch_array($res);
$userid     = $temp_row['userid'];
$planid     = $temp_row['planid'];
$query2     = "SELECT * FROM mobilemanageruser_plan WHERE user_id='".$userid."'";
$res2		= mysql_query($query2);
$row2 		= mysql_fetch_array($res2);
if($row2['user_id']!=""){
	$query3 	= "UPDATE mobilemanageruser_plan SET planid='".$planid."' WHERE user_plan_id='".$row2['user_plan_id']."'";
	mysql_query($query3);
}else{
	$query 		= "INSERT INTO mobilemanageruser_plan VALUES('','".$userid."','".$planid."')"; 
	mysql_query($query);
}
?>
<script>location='managesubscription.php';</script>