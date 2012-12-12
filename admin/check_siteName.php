<?php 
	require("dbcon.php");
	error_reporting(5);
/*	
	$query = " SELECT Username from ".$projectName."user ";
	
	$result = mysql_query($query);    */
	
if(!isset($_GET['siteName'])){ // If they are trying to view this without ?username=username or ?password=password.
    die("What’s this document for?"); // Lawl what is this document for anyways?
}elseif(isset($_GET['siteName'])){ // ElseIf they are want to check their username.
 // Requires config.php so we can access the database.
    $site=stripslashes(strip_tags(htmlspecialchars($_GET['siteName'], ENT_QUOTES))); // Cleans all nasty input from the username.
    $check=mysql_num_rows(mysql_query(" SELECT SiteName from ".$projectName."moSiteInfo  WHERE SiteName='".$site."'")); // Checks to see if a user is in the `users` table or not.
   
        if($check == 0){ // If there is no username in the database that matches the input one.
            echo '<i>'.$site.' is <span style="color:#009933">Site name is Available!'; // Yay we can use it.
        }else{ // ElseIf there is a username in the database.
            echo '<i>'.$site.' is <span style="color:#CC0000">Not Available!</span>'.'</i>'; // None for you higgans.
        } // End ElseIf.
       
} // End ElseIf.
?>