<?
error_reporting(5);

foreach($_POST as $key=>$value)
{
	$$key=addslashes(trim($value));
}
 
//////////////////////////////mizanStart///////////////////////////////////////////////////////

//function  addNewPage_save_form for save data to table contentmangsystem_page 

function addNewPage_save_form($Pagetitle,$siteId,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$ccFlag,$isNav,$Pageorder,$projectName, $parentLink, $publishContent)
{
$Userid=$_SESSION['ID'];
	$sql="insert into ".$projectName."page (Pagetitle,mobiSiteId,content,Seourl,creationdate,Rsspath,fStackFormId,mChimpListID,ccFlag,isNav,Pageorder,Parentlink, active) values('$Pagetitle','$siteId','$content','$Seourl',NOW(),'$Rsspath','$formStackId','$mChimpListID','$ccFlag','$isNav','$Pageorder','$parentLink','$publishContent')";

//echo "formid = " . $sql;
	if(mysql_query($sql))
		return "true";
	else
		return mysql_error();
}

// function  externalPage_del_form for delete data from table contentmangsystem_page 

function Page_del_form($projectName)
{
$id=$_GET['idForDel'];
$sql2="delete from ".$projectName."page where pageid='$id'";


	if(mysql_query($sql2))
		return "true";
	else
		return mysql_error();
}


function location_del_form($projectName)
{
$id=$_GET['idForDel'];
$sql2="delete from ".$projectName."markers where id='$id'";


	if(mysql_query($sql2))
		return "true";
	else
		return mysql_error();
}

// function  externalPage_del_form for delete data from table contentmangsystem_page 
function Page_pub_form($projectName, $active){
$id=$_GET['idForPub'];
$isActive = $_GET['active'];

if ($isActive ==1){
	$pub = 0;
} else {
	$pub = 1;
}
$sql2="Update ".$projectName."page SET active = $pub where pageid='$id'";


	if(mysql_query($sql2))
		return "true";
	else
		return mysql_error();
}


//editPage_save_form($pageName,$pageTitle,$pageContent,$pageType,$rank);

//function  editPage_save_form for edit data to table contentmangsystem_page 


function add_as_hq($projectName){
	$mobiId=$_GET['idForHQ'];
	$locationId = $_GET['locoId'];
	$isHQ = $_GET['isHQ'];
	
	$clearHQs="Update ".$projectName."markers SET isHQ = '' WHERE mobiSiteId='$mobiId'";
	if(mysql_query($clearHQs)){
		//return "true";
	}else
		return mysql_error();
	$addHQ = "UPDATE ".$projectName."markers SET isHQ = 1 WHERE id = $locationId";
	if(mysql_query($addHQ))
		return "true";
	else 
		return mysql_error();	
}

function editPage_save_form($Pagetitle,$siteId,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$fStackResponse,$mChimpListID,$mChimpResponse,$flagEbrite,$ccFlag,$ccResponse,$addStoreLocator,$haveUnqNavColor,$navColor,$isNav,$Pageorder,$parentLink,$publishContent)
{
$id=$_POST['idForEdit'];
$Userid=$_SESSION['ID'];
	$siteId = $_SESSION['mobiId'];
if ($haveUnqNavColor != 1) {
	$navColor = "";	
}

$sql="update mobilemanager_page set 	Pagetitle='$Pagetitle',mobiSiteId='$siteId',content='$content',Seourl='$Seourl',creationdate=NOW(),Rsspath='$Rsspath',fStackFormId='$formStackId',fStackResponse='$fStackResponse',mChimpListID ='$mChimpListID',mChimpResponse='$mChimpResponse',flagEbrite ='$flagEbrite',ccFlag='$ccFlag',ccResponse='$ccResponse',addStoreLocator='$addStoreLocator',unqNavColor ='$navColor', isNav = '$isNav',Pageorder='$Pageorder', Parentlink = '$parentLink', active = '$publishContent' where pageid='$id'";
	if(mysql_query($sql))
		return "true";
	else
		return mysql_error();
}



function newsite_save($siteName,$Userid,$active,$website,$ocPhone,$ocEmail,$publishContent)
{ 

	$code = md5(uniqid(rand(), true));
	$Userid=$_SESSION['ID'];
	$sql="insert into mobilemanager_moSiteInfo (Userid,siteName,mainWebSite,ocPhone,ocEmail,createdOn,createdBy,modifiedOn,modifiedBy,active, randomString) values('$Userid','$siteName','$website','$ocPhone','$ocEmail',NOW(),'$Userid',NOW(),'$Userid','$publishContent','$code')";
 	//echo $sql;
	mysql_query($sql);
	 
	 $sql2 = "SELECT siteAccess FROM mobilemanager_user WHERE Userid = $Userid";
	 $result = mysql_query($sql2);
	 while ($row = mysql_fetch_array($result))
	 {
		$siteAccessString = $row['siteAccess'];
	 }
 
	 $sql3 = "SELECT siteId FROM mobilemanager_moSiteInfo WHERE userId = $Userid AND randomString = '$code'";
	 $result2 = mysql_query($sql3);
	 while ($row2 = mysql_fetch_array($result2))
	 {
		$newSiteId = $row2['siteId'];
	 }
 
 
	 $siteAccessString .= ", " .$newSiteId;
	 //echo $siteAccessString;
	 $sql4 = "UPDATE mobilemanager_user SET siteAccess = '$siteAccessString' WHERE Userid = $Userid";
	 //echo $sql4;
	 
		if(mysql_query($sql4))
			return "true";
		else
			return mysql_error();
}


function newuser_save($userId, $firstName,$lastName, $userName, $email, $newSites, $password)
{ 
	//echo "hello world";
	//exit;
	$code = md5(uniqid(rand(), true));
	$Userid=$_SESSION['ID'];
	
	$sqlNewUser = 'INSERT INTO mobilemanager_user (Firstname, Lastname, Username, parentAccount, Email, Company, planidno, siteAccess, Logo, logoWidth, logoHeight, homePageText, Footer, active, randnumber, ApplyDate, password, bizEmail, bizPhone, bizWebsite, apiKey, totalLogins, lastLogin, randomString, subscriptionId) VALUES("' . $firstName . '", "' . $lastName . '", "' . $userName . '", "'. $userId . '", "' . $email . '", "", "", "' . $newSites . '", "", "", "", "", "", 1, "", "' . date() . '", "' . $password . '", "", "", "", "", 0, "", "", "")';
	
	//echo $sqlNewUser;
	
	mysql_query($sqlNewUser) or die ("Error creating new User");
	
	/*
	$sql="insert into mobilemanager_moSiteInfo (Userid,siteName,mainWebSite,ocPhone,ocEmail,createdOn,createdBy,modifiedOn,modifiedBy,active, randomString) values('$Userid','$siteName','$website','$ocPhone','$ocEmail',NOW(),'$Userid',NOW(),'$Userid','$publishContent','$code')";
 	//echo $sql;
	mysql_query($sql);
	 
	 $sql2 = "SELECT siteAccess FROM mobilemanager_user WHERE Userid = $Userid";
	 $result = mysql_query($sql2);
	 while ($row = mysql_fetch_array($result))
	 {
		$siteAccessString = $row['siteAccess'];
	 }
 
	 $sql3 = "SELECT siteId FROM mobilemanager_moSiteInfo WHERE userId = $Userid AND randomString = '$code'";
	 $result2 = mysql_query($sql3);
	 while ($row2 = mysql_fetch_array($result2))
	 {
		$newSiteId = $row2['siteId'];
	 }
 
 
	 $siteAccessString .= ", " .$newSiteId;
	 //echo $siteAccessString;
	 $sql4 = "UPDATE mobilemanager_user SET siteAccess = '$siteAccessString' WHERE Userid = $Userid";
	 //echo $sql4;
	 
		if(mysql_query($sql4))
			return "true";
		else
			return mysql_error();
*/
}

/*
$pageName=$_POST["pageName"];
$pageTitle=$_POST["pageTitle"];
$pageContent=$_POST["pageContent"];
$pageType=$_POST["pageType"];
$rank=$_POST["rank"];
*/
////////////////////////////endMizan/////////////////////////////////////////////////////

?>