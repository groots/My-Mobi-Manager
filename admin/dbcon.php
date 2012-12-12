<?php
session_start(); 

	include("functions.php");
	include("core.php");

/*

$con=mysql_connect("localhost","root","");
 if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mobilemanager", $con);



mysql_connect("bdnewsarchive.powwebmysql.com", "pt_demuser", "9cjwn*230%") or die(mysql_error());

mysql_select_db("pt_demoappdb") or die(mysql_error());

*/

	$con=mysql_connect("localhost","squish7_expert","XmjujdK*I;6%");
	 if (!$con){
		die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("squish7_miMoby", $con);
	$projectName="mobilemanager_";

?>
