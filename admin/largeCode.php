<?php
	include("session_check.php");

	$pagetitle="Update Page";
	$pagetag = "If everyone is thinking alike, then somebody isn't thinking -George S. Patton";
	
	$Userid=$_SESSION['ID'];
	
	///////////////  INTEGRATIONS //////////////////////////
	
	
	$sql3="SELECT * FROM mobilemanager_google_analytics WHERE userId = '$Userid'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	
	
	///////////// END INTEGRATIONS /////////////////////////
	
	
	$sqlu="SELECT userName FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);
	
	if($_GET['idForEdit']){
		$id=$_GET['idForEdit'];
		$_SESSION['currentPageId'] = $id; 
		$sql="select * from ".$projectName."page where pageid='$id'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
	}
	if($_POST['editPage'] ){
		$id=$_POST['idForEdit'];
	
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
	
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		
		if ($errormessage==''){
			$returnFromEdit=editPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$flagEbrite,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink,$publishContent,$pageType);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$flagEbrite='';
					$ccFlag='';
					$isNav='';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent ='';
					header("location: viewmypage.php");	
				} 
			} else
				$errormessage=$errormessage . $returnFromEdit;
		}  // END OF if($error-message=='')	 
	} elseif($_POST['cancelPage'])  { //END OF if($_POST['editPage'])
		header("location: viewmypage.php"); 
	} elseif($_POST['applyPage'])  { //END OF if($_POST['editPage'])
	
		$id=$_POST['idForEdit'];
	
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
	
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		
		if ($errormessage==''){
			$returnFromEdit=editPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$flagEbrite,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink,$publishContent,$pageType);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$flagEbrite='';
					$ccFlag='';
					$isNav='';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent ='';
					header("location: editPage.php");	
				} 
			} else
				$errormessage=$errormessage . $returnFromEdit;
		}  // END OF if($error-message=='')	  
	}
 session_start();



	$sqlu="SELECT userName FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);

$sqlp = "SELEECT Pagetitle, Seourl FROM mobilemanager_page WHERE Userid = $Userid";
	$resultp=mysql_query($sqlp);  
	$recordp=mysql_fetch_array($resultp);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css.css" type="text/css">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckfinder/ckfinder.js"></script>

<script src="../javascript.js"></script>
<script src="../sorttable.js"></script>
<script src="../CalendarPopup.js"></script>
<script src="http://www.tag.cx/qr-codes/tag-cx-qrcode.js" type="text/javascript"></script>
<link href="../mycss.css" rel="stylesheet" />
<link rel="Stylesheet" href="../css/css.css" type="text/css" media="screen" />
<link rel="Stylesheet" href="../css/ui.tabs.css" type="text/css" media="screen" />
<link rel="Stylesheet" href="../css/mcubed.css" type="text/css" media="screen" />
<title>Mobile Website Manager</title> 

</head> 
<body>
                                	<table cellpadding="15" cellspacing="5">
                                    	<tr>
                                   
                                            <td >
	                                            <h3>Page QR Code</h3>                                         
												<script type="text/javascript">
                                                generateQRCODE("qr","250","<? echo $row['Seourl']; ?>");
                                                </script>                                             </td>
                                        </tr>
                                    </table>
                                  
</body>
</html>