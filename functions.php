<?
error_reporting(5);
foreach($_POST as $key=>$value)
{
	$$key=addslashes(trim($value));
}

//////////////////////////////mizanStart///////////////////////////////////////////////////////

//function  addNewPage_save_form for save data to table contentmangsystem_page 

function addNewPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$ccFlag,$isNav,$Pageorder,$projectName, $parentLink, $publishContent)
{
	$Userid=$_SESSION['ID'];
	$sql="insert into ".$projectName."page (Pagetitle,Userid,content,Seourl,creationdate,Rsspath,fStackFormId,mChimpListID,ccFlag,isNav,Pageorder,Parentlink, active) values('$Pagetitle','$Userid','$content','$Seourl',NOW(),'$Rsspath','$formStackId','$mChimpListID','$ccFlag','$isNav','$Pageorder','$parentLink','$publishContent')";

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
function editPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$flagEbrite,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink,$publishContent)
{
	$id=$_POST['idForEdit'];
	$Userid=$_SESSION['ID'];

	$sql="update ".$projectName."page set 	Pagetitle='$Pagetitle',Userid='$Userid',content='$content',Seourl='$Seourl',creationdate=NOW(),Rsspath='$Rsspath',fStackFormId='$formStackId',mChimpListID ='$mChimpListID',flagEbrite ='$flagEbrite',ccFlag='$ccFlag',isNav = '$isNav',Pageorder='$Pageorder', Parentlink = '$parentLink', active = '$publishContent' where pageid='$id'";
 
	if(mysql_query($sql))
		return "true";
	else
		return mysql_error();
}



function newsite_save($siteName,$Userid,$active,$website,$ocPhone,$ocEmail,$publishContent)
{ 
	echo "hello world";
	$Userid=$_SESSION['ID'];
	$sql="insert into ".$projectName."moSiteInfo (Userid,siteName,website,ocPhone,ocEmail,createdOn,createdBy,modifiedOn,modifiedBy,active) values('$Userid','$siteName','$website','$ocPhone','$ocEmail',NOW(),'$Userid',NOW(),'$Userid','$publishContent')";
 
	if(mysql_query($sql))
		return "true";
	else
		return mysql_error();
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