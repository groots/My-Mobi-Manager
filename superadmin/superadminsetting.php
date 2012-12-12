<?php
include("../dbcon.php");

$username=$_SESSION['username'];
$password=$_SESSION['password'];

//echo "user ".$username." pass : ".$password."<br>";


if(($username!="admin") && ($password!="123"))
{header('Location: login.php');}



if($_GET['edit']=='E')
{
$result=mysql_query("select * from ".$projectName."setting");

$record=mysql_fetch_array($result);

}



if($_POST['editEmail'])
{
$email=$_POST['email'];

mysql_query("UPDATE ".$projectName."setting SET value='".$email."'");

$message="<h4>Edit Successfully</h4>";

}




if($_POST['submit'])
{
$email=$_POST['email'];

$issue="superadminpaypallaccount";


mysql_query("INSERT INTO ".$projectName."setting (issue, value) VALUES('$issue','$email')");

$message="Success";

}




?>

<?php include("toppart.php");?>

<?php echo $message; ?>

<center>

<form action="superadminsetting.php" method="post">
<p>Enter PayPall Email Address : 
<input type="text" name="email" id="email" value="<?=$record['value']?>"/>

<?php if($_GET['edit']=='E'){ ?>

<input type="submit" name="editEmail" value="Edit"/>

<?php } else {?>

<input type="submit" name="submit" value="Submit"/>

<?php } ?>

</p>
</form> 




<table border="0" cellpadding="2" cellspacing="1" bgcolor="#0000FF">
  <tr>
    <th bgcolor="#FFFFFF">Paypal Email Address</th>
    <th bgcolor="#FFFFFF">Edit</th>
  </tr>

<?php

$result=mysql_query("select * from ".$projectName."setting");

$row=mysql_fetch_array($result);


?>

  <tr>
    <td bgcolor="#FFFFFF"><?=$row['value']?></td>
    <td bgcolor="#FFFFFF"><a href="../superadmin/superadminsetting.php?edit=E">E</a></td>

  </tr>
 
 

</table>
</center>



<?php include("downpart.php");?>