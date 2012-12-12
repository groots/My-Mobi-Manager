<? header("location: https://mymobimanager.com/login.php"); ?>

<?php
include("dbcon.php");

$_SESSION['userName']="";
$_SESSION['password']="";
$_SESSION['ID']="";

	if($_POST['submit']){
       $username=$_POST['username'];
	   $password =$_POST['password'];
	  
	$sql="SELECT Userid,userName, password FROM ".$projectName."user WHERE userName ='$userName' AND password ='$password' AND active=1";
	$result=mysql_query($sql); 
	
	$record=mysql_fetch_array($result);
				
	if($password==$record['password'] && $userName==$record['userName']) {
		
		$_SESSION['password']=$record['password'];
			//$_SESSION['password']=$record['password'];
		   $_SESSION['userName']=$record['userName'];
		   $loggedinuserID=$record['Userid'];
			$_SESSION['ID']=$record['Userid'];
		   $_SESSION['loggedinusertype']=$record['type'];
	$session_id = session_id();
      header("location: http://$userName.$domainname/admin/userHome.php?session_id=". $session_id );
	} else {
  //echo "Wrong Username or Password";
		$errormessage=$errormessage . "Wrong Username or Password!";	

	  }
	}

include('includes/header.php');
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mobile Website Manager</title>
<script src="javascript.js"></script>
<script src="sorttable.js"></script>
<script src="CalendarPopup.js"></script>

<link href="mycss.css" rel="stylesheet" />
</head>

<body-->
<table width="100%" border="0" cellspacing="0" cellpadding="0"   >
<tr><td>&nbsp;<!--PIC--></td>
</tr>

<tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450px;"   >
		<tr>
			<td valign="top" height="200" width="20%" align="left" ><br />
				
  		    </td>
			<td valign="top" width="80%" align="center">
			<h4><?=$pageTitle?></h4>


<? if ($successmessage!=""){?>
<table  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="40px"><img src="success.PNG" /></td>
    <td class="greenmessage" align="left" valign="middle"><?=$successmessage?></td>
  </tr>
</table>
<? } ?>


<? if ($errormessage!=""){?>
<table  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="40px"><img src="error.PNG" /></td>
    <td class="redmessage" align="left" valign="middle"><?=$errormessage?></td>
  </tr>
</table>
<?}?>

<form action="login.php" method="post">
<table align="center" class="generaltable">
<tr><td>UserName </td><td><input type="text" id="userName" name="userName"></td></tr>
<tr><td>Password </td><td><input type="password" id="password" name="password"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Log-in!"></td></tr>
</table>
</form>

<?php
include("downpart.php");
?>