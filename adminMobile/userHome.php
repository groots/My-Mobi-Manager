<?php
include("session_check.php");
$pagetitle="Dashboard";
$pagetag = "Home Sweet Home!";
?>

<?php include("toppart.php"); ?>

 
	<!--p class="adminLinks" ><a href="global_settings.php">Manage Appearance</a><p/-->	
    <p class="adminLinks"><a href="viewmypage.php">Manage Mobile Pages</a><p/>

<?PHP 
	if ($Userid == '93') {
?>		
    <p class="adminLinks"><a href="viewmypage.php">Manage Advertisements</a><p/>
<?PHP
	}
?>	
	<p class="adminLinks" ><a href="g_analyticstracking.php">System Configuration</a><p/>	
	<p class="adminLinks" ><a href="logout.php">Logout <?= ucfirst($recordu['userName']); ?></a></p> 
	

<?php include("downpart.php"); ?>

