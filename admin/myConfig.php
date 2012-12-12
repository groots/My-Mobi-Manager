<?php
include("../dbcon.php");

if($Userid=$_SESSION['ID'])
{

$sql="select * from ".$projectName."user, ".$projectName."plansettings where planidno=planid and Userid='$Userid'";



$result=mysql_query($sql);
$row=mysql_fetch_array($result);


$userId=$row['Userid'];

//echo $userId;
$dateofregistration=$row['ApplyDate'];

}
/*
CREATE TABLE IF NOT EXISTS `mobilemanager_user` (
  `Userid` int(10) NOT NULL auto_increment,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Company` varchar(50) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `Logo` varchar(100) NOT NULL,
  `active` int(1) NOT NULL,
  `randnumber` varchar(10) NOT NULL,
  `ApplyDate` date NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY  (`Userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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


$firstName', '$lastName', '$userName', '$email', '$company', '$userType', '$randnumber', '', Now(), '$password'

*/
if($_POST['submit2'])
{


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
	
	$password=$_POST['password'];
	if($password=="")
	$message=$message."Password could not be empty.<br>";
	
	$repassword=$_POST['repassword'];
	if($repassword=="")
	$message=$message."Retype password could not be empty.<br>";


	$userIdAfterPost=$_POST['userId'];

//	$logo=$_POST['logo'];


//echo "LOgo : ".$_FILES['image']['name']."<br>";


 
 $imageName=rand (111111,999999).'.'.$_FILES['image']['name'];
 
 $newname="../logo/".$imageName; ///secureCode/secure
 
 copy($_FILES['image']['tmp_name'], $newname);
  
//echo $_FILES['image']['name'];
//exit;


//getting image sizes
list($width, $height) = getimagesize($newname);

if($_FILES['image']['name']==""){
} else {
$sqlEdit = "update ".$projectName."user set Logo='".$imageName."', logoWidth='".$width."', logoHeight='".$height"' ";

//echo "else loop: ".$sqlEdit;
}
//echo $sqlEdit;

$resultEdit=mysql_query($sqlEdit);
$message="<h4>Update successfully.</h4>";


$sql="select * from ".$projectName."user, ".$projectName."plansettings where planidno=planid and Userid='$userIdAfterPost'";

$result=mysql_query($sql);
$row=mysql_fetch_array($result);

echo mysql_error();
} else
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
		<td><input type="text" name="userType" id="userType" value="<?=$row['planname']?>" readonly=""/></td>
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
		<td>Logo : </td>
		<td><input type="file" name="image" id="image"/></td>
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
