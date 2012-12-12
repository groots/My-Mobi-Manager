<?PHP
	include("session_check.php");
	/*-------------------------------------------------------------*/
	//DELETE MOBILE WEBSITES
	if($_GET['siteIdForDel'] != ""){
		//echo "about to delete";
		$mobiDeleteId = $_GET['siteIdForDel'];
		$userDeleteId = $_GET['userIdToUpdate'];
	
		$sql1 = "DELETE FROM mobilemanager_google_analytics WHERE mobiSiteId = '$mobiDeleteId'";
		$sql2 = "DELETE FROM mobilemanager_page WHERE mobiSiteId = '$mobiDeleteId'";
		$sql3 = "DELETE FROM mobilemanager_global_settings WHERE mobiSiteId = '$mobiDeleteId'";
		$sqlAccess = mysql_query("SELECT siteAccess FROM mobilemanager_user WHERE Userid = " . $userDeleteId );
		$siteAccess = mysql_fetch_array($sqlAccess);
		$massagedAccess = ", " . $mobiDeleteId;
		$newAccess = str_replace($massagedAccess, "", $siteAccess['siteAccess']); 
		$sql4 = "UPDATE mobilemanager_user SET siteAccess = '$newAccess' WHERE Userid = '$userDeleteId'";
		$sql5 = "DELETE FROM mobilemanager_moSiteInfo WHERE siteId = '$mobiDeleteId'";

		mysql_query($sql1) or die("Site Add Ons Could not be Deleted");
		mysql_query($sql2) or die("Site Pages Could Not be Deleted");
		mysql_query($sql3) or die("Sited Style Could Not Be Deleted");
		mysql_query($sql4) or die("User's Site Access Could Not Be Updated");
		mysql_query($sql5) or die("Sited Info Could Not Be Deleted");
	
		header("location: userHome.php?successmessage=sDelete");	
	}
	
	//DELETE MOBILE USERS
	if($_GET['userIdForDel'] != ""){
		
		$userDeleteId = $_GET['userIdForDel'];	
		$sql1 = "DELETE FROM mobilemanager_user WHERE Userid = '$userDeleteId'";
		mysql_query($sql1) or die("User could not be deleted");	
		//echo $sql1;
		
		header("location: userHome.php?successmessage=uDelete");	
	}
	
	
?>