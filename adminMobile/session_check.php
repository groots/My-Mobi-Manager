<?php
include("../dbcon.php");

$Userid=$_SESSION['ID'];
$loggedIn = "yes";
$_SESSION['loggedIn'] = $loggedIn;
if($Userid=="")
header('Location: login.php');
?>