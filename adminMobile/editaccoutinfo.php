<?php
include("../dbcon.php");

if($Userid=$_SESSION['ID'])
{
	$sql="select * from ".$projectName."user, ".$projectName."plansettings where planidno=planid and Userid='$Userid'";
	
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$userId=$row['Userid'];
	$dateofregistration=$row['ApplyDate'];

}

if($_POST['submit2']) {
	$firstName=$_POST['firstName'];
	if($firstName=="")
	$message=$message."First Name could not be empty.<br>";
	
	$lastName=$_POST['lastName'];
	if($lastName=="")
	$message=$message."Last Name could not be empty.<br>";
	
	$userName=$_POST['userName'];
	if($userName=="")
	$message=$message."User Name could not be empty.<br>";

	
	$userType=$_POST['userType'];
	if($userType=="")
	$message=$message."Membership could not be empty.<br>";
	
	$email=$_POST['email'];
	if($email=="")
	$message=$message."Email could not be empty.<br>";
	
	$company=$_POST['company'];
	if($company=="")
	$message=$message."Company could not be empty.<br>";
	
	

	$userIdAfterPost=$_POST['userId'];

		$sqlEdit = "update ".$projectName."user set Firstname='".$firstName."', Lastname='".$lastName."', password='".$password."',Email='".$email."', Company='".$company."', ApplyDate=Now() where Userid = '".$userIdAfterPost."' and Username='".$userName."' ";
		
		
		$resultEdit=mysql_query($sqlEdit);
		$message="<h4>Update successfully.</h4>";
		
		$sql="select * from ".$projectName."user, ".$projectName."plansettings where planidno=planid and Userid='$userIdAfterPost'";
		
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		
		echo mysql_error();
	} else {
		$message="Password and retype password do not match";
	}

?>

<?php include("toppart.php"); ?>
<center>
<?php echo $message; ?>
<form action="editaccoutinfo.php" method="post" enctype="multipart/form-data" onsubmit="return validation_registration()">
<table>
<caption>Edit Registration Form<br /><br /></caption>
	<tr>
		<td>First Name : </td>
		<td><input type="text" name="firstName" id="firstName" value="<?=$row['Firstname']?>"/></td>
	</tr>
	<tr>
		<td>Last Name : </td>
		<td><input type="text" name="lastName" id="lastName" value="<?=$row['Lastname']?>"/></td>
	</tr>
	<tr>
		<td>Username : </td>
		<td><input type="text" name="userName" id="userName" value="<?=$row['Username']?>" readonly=""  /> <div id="usernameresult"></div> </td>
	</tr>
	<tr>
		<td>Password : *</td>
		<td><input type="password" name="password" id="password" value="<?=$row['password']?>"/></td>
	</tr>
	<tr>
		<td>Retype Password : </td>
		<td><input type="password" name="repassword" id="repassword" value="<?=$row['password']?>" /></td>
	</tr>
	<tr>
		<td>Membership : </td>
		<td><input type="text" name="userType" id="userType" disabled="disabled" value="<?=$row['planname']?>" readonly=""/><input type="hidden" name="userType" id="userType" value="<?=$row['planname']?>" readonly=""/></td>
	</tr>
	<tr>
		<td>Email : </td>
		<td><input type="text" name="email" id="email" value="<?=$row['Email']?>"/></td>
	</tr>
	<tr>
		<td>Company : </td>
		<td><input type="text" name="company" id="company" value="<?=$row['Company']?>"/></td>
	</tr>
	<tr>
		<td>Company Email : </td>
		<td><input type="text" name="companyEmail" id="companyEmail" value="<?=$row['bizEmail']?>"/></td>
	</tr>
	<tr>
		<td>Company Phone : </td>
		<td><input type="text" name="companyPhone" id="companyPhone" value="<?=$row['bizPhone']?>"/></td>
	</tr>
	<tr>
		<td>Company Website : </td>
		<td><input type="text" name="companyPhone" id="companyPhone" value="<?=$row['bizWebsite']?>"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<input type="hidden" name="userId" id="userId" value="<?=$userId?>"/>
		<input type="submit" name="submit2" value="Edit"/></td>
	</tr>

</table>
</form>
</center>

<?php include("downpart.php"); ?>
