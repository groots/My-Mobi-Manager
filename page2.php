<?php
	include("dbcon.php");
	include("rssreader.php");
	$projectName="mobilemanager_";
	$siteName =$_GET['u'];
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	////   Create query that will link mobile website to account manager and check if the site is active and paid up
	
	//$query2="SELECT * FROM ".$projectName."plansettings x, ".$projectName."user y    WHERE x.planid=y.planidno and  y.Username='$userName'";
	$query2 = "SELECT * FROM " . $projectName. "moSiteInfo WHERE SiteName ='$siteName'";
	$result2=mysql_query($query2);
	$planInfo = mysql_fetch_array($result2);
	//$haveiPhone = $planInfo['iphone'];
	$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$siteId = $planInfo['siteId'];
	
	$query3="SELECT * FROM ".$projectName."global_settings WHERE mobiSiteId='$siteId'";
	$result3=mysql_query($query3);
	$settings = mysql_fetch_array($result3);
	$layout = $settings['layout'];
	
	if (preg_match('/iphone/', $userAgent) && $haveiPhone != 0 ) {
 		//include("b.php");
		if ($layout == 0) {
			include("generalpage.php");
		} else if ($layout == 1) {
			include("layout1.php");
		}else if ($layout == 2) {
			include("layout2.php");
		}
	} else {
		if ($layout == 0) {
			include("generalpage.php");
		} else if ($layout == 1) {
			include("layout1.php");
		}else if ($layout == 2) {
			include("layout2.php");
		} else if ("layout4.php") {
			include("layout4.php");
		}
	}
?>