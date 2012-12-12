<?php
include("session_check.php");
$pagetitle="Change Password";
$pagetag = "Treat your password like your toothbrush. Don't let anybody else use it, and get a new one every six months -Clifford Stoll quote";


$Userid=$_SESSION['ID'];

if($_POST['submitPassword'])
	{
 	
	$newPassword=$_POST['newPassword'];
	 	
	$retypePassword=$_POST['retypePassword'];
	
	if ($newPassword=='')
	$errormessage=$errormessage . "  Password cann't be empty<br>";	
	
	if( $newPassword==$retypePassword)
	{
	$sqlUp="UPDATE ".$projectName."user SET password='$newPassword' WHERE Userid='$Userid' ";
//echo $sqlUp;
	$resSuccess=mysql_query($sqlUp);
	//echo $resSuccess;
	$successmessage=" Password Changed Successfully.  ";
		
	}
	else
	$errormessage="Your current password did not Match, type again.";
if($resSuccess)
//echo $successmessage;

if(!($password==$oldPassword && $newPassword==$retypePassword))
$errormessage=$errormessage;
	
}

?> 

<?php
include("toppart.php");
?>

<br><br>
	<form action="change_password.php" method="post" onSubmit="return validate_pass()">	
	
	<table border="0" cellpadding="0" cellspacing="0" class="generaltable">
 

	 <tr>
	<td>New Password :</td>	 
	 <td><input type="password" name="newPassword" id="newPassword" /> </td>
	 </tr>
	 
	 <tr>
	<td>Retype New Password :</td>
	 <td><input type="password" name="retypePassword" id="retypePassword"/> </td>
	 </tr>
	 
	 <tr><td></td>
	 <td><input type="submit"name="submitPassword" id="submitPassword" value="Change Password"/> </td></tr>
	 </table>
	 
	 </form>

<?php
include("downpart.php");
?>