<?php
include("../dbcon.php");


$username=$_SESSION['username'];
$password=$_SESSION['password'];

//echo "user ".$username." pass : ".$password."<br>";


if(($username!="admin") && ($password!="123"))
{header('Location: login.php');}




?>



<?php include("toppart.php");?>
<center>





</center>
<?php include("downpart.php");?>