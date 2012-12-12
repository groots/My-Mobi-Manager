<?php

include("session_check.php");
	include("../rssreader.php");
	$projectName="mobilemanager_";
	$_GET['u'] = $_SESSION['iUsr'];
	$userName = $_GET['u'];
	$query2="SELECT * FROM ".$projectName."plansettings x, ".$projectName."user y    WHERE x.planid=y.planidno and  y.Username='$userName'";

	$result2=mysql_query($query2);
	$planInfo = mysql_fetch_array($result2);
	$haveiPhone = $planInfo['iphone'];
	$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$UserId = $planInfo['Userid'];
	
	$query3="SELECT * FROM ".$projectName."global_settings WHERE Userid='$UserId'";
	$result3=mysql_query($query3);
	$settings = mysql_fetch_array($result3);
	$layout = $settings['layout'];
	
	//include("b.php");
	if ($layout == 0) {
		include("../generalpage.php");
	} else if ($layout == 1) {
		include("../layout1.php");
	}else if ($layout == 2) {
		include("../layout2.php");
	}
?>