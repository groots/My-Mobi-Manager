<?php
include("dbcon.php");

$message='';
$userType=$_GET['plan'];

if($_POST['submit']) {	
	$email=$_POST['email'];
	if($email=="")
	$message=$message."Email could not be empty.<br>";

$res=mysql_query("select Email from ".$projectName."user where Email='$email'");
$countEmail=mysql_num_rows($res);

if($countEmail==1) {
	$message=$message."This email address is already exist!";
}


	$userName=$_POST['userName'];
	if($userName=="")
	$message=$message."User Name could not be empty.<br>";
	
	
	

$rest=mysql_query("select Email from ".$projectName."user where Username='$userName'");
$countName=mysql_num_rows($rest);

if($countName==1) {
	$message=$message."This username is already exist!";
}

	$firstName=$_POST['firstName'];
	if($firstName=="")
		$message=$message."First Name could not be empty.<br>";
	
	$lastName=$_POST['lastName'];
	if($lastName=="")
		$message=$message."Last Name could not be empty.<br>";
	
	$userType=$_POST['userType'];
	if($userType=="")
		$message=$message."User Type could not be empty.<br>";
	
	$company=$_POST['company'];
	if($company=="")
		$message=$message."Company could not be empty.<br>";
	
	$password=$_POST['password'];
	if($password=="")
		$message=$message."Password could not be empty.<br>";
	
	$repassword=$_POST['repassword'];
	if($repassword=="")
		$message=$message."Retype password could not be empty.<br>";
	
//echo $message."<br>";
	
	
	if (preg_match ("/[&<>%\*\,\.]/i", $userName)) {
  		// display error
		echo "works";
		exit;
		
	}  
	
	exit;
	if($password==$repassword) {
		if($message=='') {
			$randnumber=rand(111111, 999999);
			$sqlin="INSERT INTO ".$projectName."user(Firstname, Lastname, Username, Email, Company, usertype, randnumber, Logo, ApplyDate, password) VALUES('$firstName', '$lastName', '$userName', '$email', '$company', '$userType', '$randnumber', '', Now(), '$password')";

//echo $sqlin;
	
		if(mysql_query($sqlin)) {
		//$randnumber=rand(111111, 999999);		
			$to="$email";
			$subject="Thank you for registration at mymobilemanager.com";
			$message="Hello $lastName,
					 Welcome and thanks from mymobilemanager.com 
				 For active your account please click following link
 				 http://www.powertruns.com/it/projects/mobilemanager/activation.php?u=$userName&randN=$randnumber
				 
				 
				 Thank You,
				 Admin
				 $domainname";
		
			$headers .= 'From:  <'.'mymobilemanager.com'.'>' . "\r\n";
			mail($to, $subject, $message, $headers);
			
			$message="Success";
			$email="";
			$userName="";
			$firstName="";
			$lastName="";
			$userName="";
			$userType="";
			$company="";
			$password="";
			$repassword="";
		} else {
			echo mysql_error();
			echo $sql3;
		}		
	}//end of if($message=='')
	
	} else {$message="Password do not match";}

}

/*
`Userid` ,
`First name` ,
`Last name` ,
`Username` ,
`Email` ,
`Company` ,
`usertype` ,
`Logo` ,
`Apply Date` ,
`password`
*/



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registration Page</title>
<script src="javascript.js"></script>
<!--<script type="javascript" src="javascript.js" language="javascript"></script>-->

</head>

<body>
<center>
<?php echo $message; ?>
<form action="registration.php" method="post" onsubmit="return validation_registration()">
<table>
<caption>Account Form<br /><br /></caption>
	<tr>
		<td>First Name : </td>
		<td><input type="text" name="firstName" id="firstName" value="<?=$firstName?>"/></td>
	</tr>

	<tr>
		<td>Last Name : </td>
		<td><input type="text" name="lastName" id="lastName" value="<?=$lastName?>"/></td>
	</tr>

	<tr>
		<td>Username : </td>
		<td><input type="text" name="userName" id="userName" value="<?=$userName?>" onblur="CheckUsername(this.value);"/> <div id="usernameresult"></div> </td>
	</tr>
	

	<tr>
		<td>Password : *</td>
		<td><input type="password" name="password" id="password" value="<?=$password?>"/></td>
	</tr>

	<tr>
		<td>Retype Password : </td>
		<td><input type="password" name="repassword" id="repassword" value="<?=$repassword?>"/></td>
	</tr>
	

	<tr>
		<td>Membership : </td>
		<td><input type="text" name="userType" id="userType" value="<?=$userType?>" readonly=""/></td>
	</tr>

	<tr>
		<td>Email : </td>
		<td><input type="text" name="email" id="email" value="<?=$email?>"/></td>
	</tr>

	<tr>
		<td>Company : </td>
		<td><input type="text" name="company" id="company" value="<?=$company?>"/></td>
	</tr>
	
	<tr>
		<td colspan="2" align="right">
		<input type="submit" name="submit" value="Submit"/></td>
	</tr>

</table>
</form>
</center>
</body>
</html>
