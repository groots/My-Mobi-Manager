<?php
	include("session_check.php");

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
	
	$companyWeb = $_POST['companyWeb'];
	
	$ocEmail = $_POST['ocEmail'];
	$ocPhone = $_POST['ocPhone'];
	$mWebsite = $_POST['mainWebSite'];
	

	$userIdAfterPost=$_POST['userId'];

		$sqlEdit = "update ".$projectName."user set Firstname='".$firstName."', Lastname='".$lastName."', password='".$password."',Email='".$email."', Company='".$company."', bizWebsite='".$companyWeb."', ApplyDate=Now() where Userid = '".$userIdAfterPost."' and Username='".$userName."' ";
		
		mysql_query($sqlEdit) or die ("Update Could not be completed.  Error editting user");
		
		$sqlSiteEdit = "UPDATE " . $projectName . "moSiteInfo SET mainWebSite ='".$mWebsite."', ocPhone='".$ocPhone."', ocEmail='".$ocEmail."' WHERE siteId = " . $_SESSION['mobiId'];
		mysql_query($sqlSiteEdit) or die("Update could not be completed.  Error editting mobile website");
		
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
<?php 
	//print_r($_SESSION);
?>
<form action="editaccoutinfo.php" method="post" enctype="multipart/form-data" onsubmit="return validation_registration()">
<br />
<br />
<table cellpadding="10" cellspacing="10">
	<tr>
    	<td valign="top">
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
                    <td>Company Website : </td>
                    <td><input type="text" name="companyWeb" id="companyWeb" value="<?=$row['bizWebsite']?>"/></td>
                </tr>
            </table>        
        </td>
    	<? if($_SESSION['mobiId'] != ""){ 
			$getSiteInfo = "SELECT * FROM mobilemanager_moSiteInfo WHERE siteId = '" . $_SESSION['mobiId'] . "'";
			$resultSiteInfo = mysql_query($getSiteInfo);
			$siteInfo = mysql_fetch_array($resultSiteInfo); 
		?>
        <td valign="top">
			<table>
            <caption>Edit Site Info<br /><br /></caption>
                <tr>
                    <td>Site Extension : </td>
                    <td><input disabled="disabled" type="text" name="SiteName" id="SiteName" value="<?=$siteInfo['SiteName']?>"/>.mymobimanager.com</td>
                </tr>
                <tr>
                    <td>One Click Email : </td>
                    <td><input type="text" name="ocEmail" id="ocEmail" value="<?=$siteInfo['ocEmail']?>"/></td>
                </tr>
                <tr>
                    <td>One Click Call : </td>
                    <td><input type="text" name="ocPhone" id="ocPhone" value="<?=$siteInfo['ocPhone']?>"/></td>
                </tr>
                <tr>
                    <td>Linked Desktop Website : </td>
                    <td><input type="text" name="mainWebSite" id="mainWebSite" value="<?=$siteInfo['mainWebSite']?>"/></td>
                </tr>
            
            </table>        
        </td>
        <? } ?>
    </tr>
    
    <tr>
        <td colspan="2" align="center">
        <input type="hidden" name="userId" id="userId" value="<?=$userId?>"/>
        <input type="submit" name="submit2" class="formButton" value="Edit"/></td>
    </tr>
</table>
</form>
</center>

<?php include("downpart.php"); ?>
