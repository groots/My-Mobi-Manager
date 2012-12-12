<?php

	include("session_check.php");
	
	
	$pagetitle="Design Settings For Mobile Website";
	$pagetag = "Time to get Jiggy with it!";
	$Userid=$_SESSION['userName'];
	$siteId=$_SESSION['mobiId'];
	$projectName="mobilemanager_";
	if($_GET['idForDel']){
			unlink("/gbimages/" . $_GET['in']);
			$d_id = $_GET['idForDel'];
			$sqld="UPDATE ".$projectName."global_settings SET backgroundimage = NULL  where mobiSiteId='$d_id'";
			mysql_query($sqld);	
			$successmessage="Image deleted successfully";
		
	}
	
	if($_GET['logoForDel']){
					
		unlink("logo/" . $_GET['in']);
		$d_id = $_GET['logoForDel'];
		$sqld="UPDATE ".$projectName."moSiteInfo SET logo = NULL  where siteId='$d_id'";
		mysql_query($sqld);	
		$successmessage="Image deleted successfully";
	}

if($_POST["submit"]) { 
	$logoBgColor = addslashes($_POST['logobackgroundcolor']);
	$layout = $_POST['layout'];
	$font=addslashes($_POST['font']);
	$fontcolor=addslashes($_POST['fontcolor']);
	$backgroundcolor=addslashes($_POST['backgroundcolor']);
	$haveGradient=addslashes($_POST['haveGradient']);
	$secBackgroundColor=addslashes($_POST['secBackgroundColor']);
	$havecontentBg=addslashes($_POST['havecontentBg']);
	$haveContentGradient=addslashes($_POST['haveContentGradient']);
	$contentBGcolor=addslashes($_POST['contentBGcolor']);
	$secContentBgColor=addslashes($_POST['secContentBgColor']);
	$contentLinkColor=addslashes($_POST['contentLinkColor']);
	$linktextcolor=addslashes($_POST['linktextcolor']);
	$linkbgcolor=addslashes($_POST['linkbgcolor']);
	$linkbordercolor=addslashes($_POST['linkbordercolor']);
	$markerColor = addslashes($_POST['markerColor']);
	$searchBoxBG = addslashes($_POST['searchBoxBG']);
	$navStyle = addslashes($_POST['navStyle']);
	$removeFooterBg = addslashes($_POST['removeFooterBg']);
	$footer = addslashes($_POST['footerColor']);
	$footerFontColor = addslashes($_POST['footerFontColor']);
	$removeLogoBG = addslashes($_POST['removeLogoBG']);
	
	if($removeLogoBG == 1) {
		$logoBgColor="";
	}
		
	
	$queryc="SELECT SiteName FROM  ".$projectName."moSiteInfo WHERE siteId=$siteId";
	$resultc=mysql_query($queryc);
	$rowc=mysql_fetch_array($resultc);
	
///////////upload
	$image_name=$rowc['SiteName'].'.'.$_FILES['file']['name'];

    if (file_exists("https://fifthfloor.mymobimanager.com/gbimages/" . $image_name )){
     	$errormessage = $image_name . " already exists. ";
    } else {
		$newname="https://fifthfloor.mymobimanager.com/gbimages/".$image_name;
	//  	copy($_FILES['file']['tmp_name'], $newname);
		
		
		
		
		if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 20000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("gbimages/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "gbimages/" . $image_name);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }
		//move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
      //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
     }

////////////end
/////////// logo upload

	$logoName=rand (111111,999999).'.'.$_FILES['image']['name'];
	$newLogoName="../logo/".$logoName; ///secureCode/secure
	copy($_FILES['image']['tmp_name'], $newLogoName);
  
//getting image sizes
	list($width, $height) = getimagesize($newLogoName);
	
////////////end

	$sql3="select * from ".$projectName."global_settings where mobiSiteId ='$siteId'";
	$result3=mysql_query($sql3);
	$exist=mysql_fetch_array($result3);
	
	if ($havecontentBg == 1)
		$contentBGcolor = "";
	else 
		$contentBGcolor = $contentBGcolor;
		
	if ($removeFooterBg == 1) {
		$footer = "";
	} 
	
	if ($haveGradient == 1){
		$addGradient = $secBackgroundColor;
		$editGradient = $secBackgroundColor;
		$haveGradient = 1;
	} else {
		$addGradient = "";
		$editGradient = "";
		$haveGradient = "";
		
	}
	
	if($haveLinkMarker == 1) {
		$addMarkerColor = $markerColor;
	} else {
		$addMarkerColor = "";
	}
	if ($haveContentGradient == 1){
		$addContentGradient = $secContentBgColor;
		$editContentGradient = $secContentBgColor;
		$haveContentGradient = 1;
	} else {
		$addContentGradient = "";
		$editContentGradient = "";
		$haveContentGradient = "";
		
	}

if($exist['mobiSiteId'] != "") {
		if($_FILES['image']['name']=="" && $_FILES['file']['name']=="" )	{
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',2ndContentBgColor='".$secContentBgColor."',haveContentGradient='" . $haveContentGradient . "',contentLinkColor='".$contentLinkColor."',linktextcolor='".$linktextcolor."',linkbgcolor='".	$linkbgcolor."',linkbordercolor='".$linkbordercolor."',markerColor='".$markerColor."',footerColor='" . $footer .  "',footerFontColor='" . $footerFontColor .  "' WHERE mobiSiteId = '$siteId' ";
		} else if($_FILES['image']['name']=="" )	{
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',2ndContentBgColor='".$secContentBgColor."',haveContentGradient='" . $haveContentGradient . "',contentLinkColor='".$contentLinkColor."',backgroundimage='".$image_name."',linktextcolor='".$linktextcolor."',linkbgcolor='".	$linkbgcolor."',linkbordercolor='".$linkbordercolor."',markerColor='".$markerColor."',footerColor='" . $footer .  "',footerFontColor='" . $footerFontColor .  "' WHERE mobiSiteId = '$siteId' ";
		} else {
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',2ndContentBgColor='".$secContentBgColor."',haveContentGradient='" . $haveContentGradient . "',contentLinkColor='".$contentLinkColor."',backgroundimage='".$image_name."',linktextcolor='".$linktextcolor."',linkbgcolor='".$linkbgcolor."',linkbordercolor='".$linkbordercolor."',markerColor='".$markerColor."',footerColor='" . $footer . "',footerFontColor='" . $footerFontColor .  "' WHERE mobiSiteId = '$siteId' ";
			$sqlEdit = "update ".$projectName."moSiteInfo set logo='".$logoName."', logoWidth='".$width."', logoHeight='".$height."' WHERE siteId = '$siteId' ";
		}
		mysql_query($sqlUp);
		$resultEdit=mysql_query($sqlEdit);
		if($errormessage=='')
			$successmessage="Update Successfully";
	} else {
		$sql="INSERT INTO ".$projectName."global_settings (mobiSiteId,layout,logobackgroundcolor,font,fontcolor,haveGradient,backgroundcolor,2ndbackgroundColor,contentBGcolor,2ndContentBgColor,haveContentGradient,contentLinkColor,backgroundimage,linktextcolor,linkbgcolor,linkbordercolor,markerColor,footerColor,footerFontColor) values('$siteId','$layout','$logoBgColor','$font','$fontcolor','$haveGradient','$backgroundcolor','$addGradient','$contentBGcolor','$secContentBgColor','$haveContentGradient','$contentLinkColor','$image_name','$linktextcolor','$linkbgcolor','$linkbordercolor','$footer','$markerColor','$footerFontColor')";
		mysql_query($sql);	
		
		
	if($_FILES['image']['name']=="")	{
		//$sqlEdit = "update ".$projectName."user set homePageText='" . $homeText . "'  WHERE Userid = '$Userid' ";
	} else {
		$sqlEdit = "update ".$projectName."moSiteInfo set logo='".$logoName."', logoWidth='".$width."', logoHeight='".$height."' WHERE siteId = '$siteId' ";
	}
		$resultEdit=mysql_query($sqlEdit);
		$successmessage="Update Successfully";
} }

	$sql="select * from ".$projectName."global_settings where mobiSiteId='$siteId'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

//echo $row['backgroundimage'];  


//print_r($_POST);

?>




<style type="text/css">
	<!--
	body
	{
	<? if($row['backgroundcolor']!="") {?>
	background-color:<? echo $row['backgroundcolor']; ?>; 
	<? } if($row['backgroundimage']!="") { ?>
	background-image:url(admin/gbimages/<? echo $row['backgroundimage']; ?>);
	<? } ?>
	<? if($row['font']!="") {?>
	font:"<? echo $row['font']; ?>"; 
	<? } ?>
	<? if($row['fontcolor']!="") {?>
	color: <? echo $row['fontcolor']; ?>; 
	<? } ?>
	text-align: center;
	 
	}
	#m3link {
		width: 100%;
		padding: 10px 0px 10px 0px;
		<? if($row['linkbgcolor']!="") {?>
		background-color:<? echo $row['linkbgcolor']; ?>;
		<? } ?>
		<? if($row['linktextcolor']!="") {?>
		color:<? echo $row['linktextcolor']; ?>;     
		 <? } ?>
		margin: 2px;
		text-decoration: none;
		text-align: center;
		border-width: thin;
		border-style:solid;
		<? if($row['linkbordercolor']!="") {?>
		border-color:<? echo $row['linkbordercolor']; ?>;     
		 <? } ?>
	}
	#m3link2 {
		width: 100%;
		padding: 10px 0px 10px 0px;
		<? if($row['linkbgcolor']!="") {?>
		background-color:<? echo $row['linkbgcolor']; ?>;
		<? } ?>
		<? if($row['linktextcolor']!="") {?>
		color:<? echo $row['linktextcolor']; ?>;     
		 <? } ?>
		margin: 2px;
		text-decoration: none;
		text-align: center;
		border-width: thin;
		border-style:solid;
		<? if($row['linkbordercolor']!="") {?>
		border-color:<? echo $row['linkbordercolor']; ?>;     
		 <? } ?>
	}
	
	 #searchBoxBG1 {
        <? if($row['searchBoxBG']!="") {?>
        background:<? echo $row['searchBoxBG']; ?>;     
         <? } ?>
        padding: 10px;
        border-width: thin;
        border-style:solid;
        <? if($row['linkbordercolor']!="") {?>
        border-color:<? echo $row['linkbordercolor']; ?>;     
         <? } ?>
        margin-bottom: 10px;
		text-align: center; 
    }
	a:link {
	<? if($row['linkbgcolor']!="") {?>
	color:<? echo $row['linktextcolor']; ?>;
	 
	 <? } ?>
	 Text-decoration:none;
	 font-weight: bolder;
	 }
	 
	 
	a:visited {
	<? if($row['linktextcolor']!="") {?>
	color:<? echo $row['linktextcolor']; ?>;
	 
	 <? } ?>
	 Text-decoration:none;
	 font-weight: bolder;
	 }
	 
	.socialShare {
	}
	
	.fbShare {
		position: relative; 
		bottom: 8px;
	}
	
	.centerContent {
		width: 299px;
		margin:0 auto;
	}
	
	#Table_01 {
		position:relative;
		left:0px;
		top:0px;
		width:370px;
		height:716px;
	}
	
	#iphoneViewer_ {
		position:absolute;
		left:0px;
		top:0px;
		width:370px;
		height:143px;
	}
	
	#iphoneViewer002_ {
		position:absolute;
		left:0px;
		top:143px;
		width:24px;
		height:573px;
	}
	
	#iphoneViewer003 {
		position:absolute;
		left:24px;
		top:143px;
		width:320px;
		height:418px;
		background-color: <?PHP echo $row['backgroundcolor']; ?>;
	}
	
	#iphoneViewer004_ {
		position:absolute;
		left:344px;
		top:143px;
		width:26px;
		height:573px;
	}
	
	#iphoneViewer005_ {
		position:absolute;
		left:24px;
		top:561px;
		width:320px;
		height:155px;
	}
	
	-->
</style>

<!--script src="201a.js" type="text/javascript"></script-->
<script language="javascript">
<!-- assumes fcp202.html file is in same folder -->
var newwindow='';
function pickerPopup202(ifn,sam){ 
	var bl=screen.width/2-102; var bt=screen.height/2-104;
	page=" fcp202.html"+"?ifn="+escape(ifn)+"&sam="+escape(sam); 
	if(!newwindow.closed&&newwindow.location){ 
		newwindow.location.href=page;
	}else{ 
		newwindow=window.open(page,"CTRLWINDOW","help=no, status=no, toolbar=no, menubar=no, location=no,scrollbars=no, resizable=no, dependent=yes, width=250,height=250,left="+bl+",top="+bt+","); 
		if(!newwindow.opener)
			newwindow.opener=self;
	}; 
	if(window.focus){
		newwindow.focus()
	} 
	return false;
}
</script>
<script type="text/javascript">
function changeStyle( ID, styleType, v, secId ) 
{ 
	//alert(ID + "second id = " + secId);
     var obj = document.getElementById( ID ); 
     var obj2 = document.getElementById( secId ); 
     switch( styleType ) 
     { 
          case "backgroundColor": 
               obj.style.backgroundColor = v; 
			   obj2.style.backgroundColor= v; 
               break; 
          case "size": 
               obj.style.size = v; 
               break; 
          case "color": 
               obj.style.color= v; 
			   obj2.style.color= v;  
               break; 
          case "textColor": 
               obj.style.color= v; 
			   obj2.style.color= v;  
               break; 
          case "bordercolor": 
               obj.style.color= v; 
			   obj2.style.color= v;  
               break; 
     } 
}
</script>

<script type="text/javascript" src="scripts/jscolor/jscolor.js"></script>
<?php
	$logoOrcompany=mysql_fetch_array(mysql_query("select SiteName, logo, logoWidth, logoHeight from ".$projectName."moSiteInfo where siteId='$siteId'"));
	$userName = $logoOrcompany['SiteName'];
	include("toppart.php");
?>

<form name="form_global_settings" enctype="multipart/form-data" action="global_settings.php" method="post" >          
    
<table>
<tr>
<td>
    <table align="right" width="1000px" style="z-index: 1000;">            
        <tr align="right">
        <td align="right"><input type="submit" class="formButton" name="submit" id="submit" value="Save" /> <input type="submit" name="cancelPage" class="formButton" value="Cancel"/>
        <input type="hidden" name="idForEdit" value="<?=$siteId?>"/>
        </td>
        
        </tr>
    </table>
</td>
</tr>
<tr>
<td>
    
<div>
     <ul class="tabs">
         <li><a href="#choose-layout"><span>Layouts</span></a></li>
         <li><a href="#first-tab"><span>Layout Info</span></a></li>
         <li><a href="#second-tab"><span>Logo Info</span></a></li>
         <li><a href="#font-tab"><span>Fonts</span></a></li>
         <li><a href="#third-tab"><span>Navigation</span></a></li>
         <li><a href="#fourth-tab"><span>Footer</span></a></li>
     </ul>
     <div class="panes">
         <div class="hide">
         <table border="0" cellpadding="10" cellspacing="10">                
                <tr>
                    <td align="left">
                    
                    <?PHP
                    if ($row['layout'] == 0){
                        $laySelect1 = "checked='checked'";
                    } else if ($row['layout'] == 1){
                        $laySelect2 = "checked='checked'";
                    } else if ($row['layout'] == 2		){
                        $laySelect3 = "checked='checked'";
                    } else {
                        $laySelect4 = "checked='checked'";	
                    }
                    ?>
                        <table align="left" width="100%">
                        <tr>
                            <td align="center"><img src="/images/layout1.gif" alt="layout 1" /></td>
                            <td align="center"><img src="/images/layout2.gif" alt="layout 2" /></td>
                            <td align="center"><img src="/images/layout3.gif" alt="layout 3" /></td>
                            <td align="center"><img src="/images/layout1.gif" alt="layout 4" /></td>
                        </tr>
                        <tr>
                            <td align="center"><input type="radio" name="layout" value="0" <?php echo $laySelect1; ?> /> Layout 1</td>
                            <td align="center"><input type="radio" name="layout" value="1" <?php echo $laySelect2; ?> /> Layout 2</td>
                            <td align="center"><input type="radio" name="layout" value="2" <?php echo $laySelect3; ?> /> Layout 3</td>
                            <td align="center"><input type="radio" name="layout" value="4" <?php echo $laySelect4; ?> /> Layout 4</td>
                        </tr>
                        </table>
                </td>
                </tr>
                </table>
         </div>
         <div class="hide">
             <table border="0" cellpadding="10" cellspacing="10">                        
                <tr>
                    <td colspan="2" class=""><h3>Add a Background Image</h3> </td>
                </tr>
            <tr>
            <td>Background Image</td>
             <td><input type="file" id="file" name="file" ></td>
            </tr>
        
            <tr>
            <td><strong>Search Box Background</strong> <br /><small><i>example: #ffffff for white</i></small></td>
             <td><input class="fieldStyle color {hash:true,caps:false}" name="searchBoxBG" ID="searchBoxBG" value="<? echo $row['searchBoxBG']; ?>"></td>
            </tr>
         <tr>
            <td><strong>Background Color</strong> <br /><small><i>example: #3c3c3c for dark gray</i></small></td>	 
            <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="backgroundcolor" ID="backgroundcolor" value="<? echo $row['backgroundcolor']; ?>"></td>	 
         </tr>
         <?PHP if ($row['haveGradient'] == 1){
                    $checkGradient = 'checked="checked"';
         } ?>
         
         <tr>
            <td><input  type="checkbox" id="haveGradient" name="haveGradient" value="1" <?= $checkGradient; ?> /><strong> Use Gradient</strong> <br /><small><i>example: #3c3c3c for dark gray</i></small></td>	 
            <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="secBackgroundColor" ID="secBackgroundColor" value="<? echo $row['2ndbackgroundColor']; ?>"></td>	 
         </tr>
         
         <?PHP if ($row['contentBGcolor'] == ""){
                    $checkContentBg = 'checked="checked"';
         } ?>
         <tr>
            <td><strong>Content Background Color</strong> <br /><small><i>example: #3c3c3c for dark gray</i></small></td>	 
            <td><input type="checkbox" id="havecontentBg" name="havecontentBg" value="1" <?= $checkContentBg; ?> />No Content Background Color<br /><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="contentBGcolor" ID="contentBGcolor" value="<? echo $row['contentBGcolor']; ?>"></td>	 
         </tr>
          <?PHP if ($row['haveContentGradient'] == 1){
                    $checkContentGradient = 'checked="checked"';
         } ?>
         
         <tr>
            <td><input  type="checkbox" id="haveContentGradient" name="haveContentGradient" value="1" <?= $checkContentGradient; ?> /><strong> Use Content Gradient</strong> <br /><small><i>example: #3c3c3c for dark gray</i></small></td>	 
            <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="secContentBgColor" ID="secContentBgColor" value="<? echo $row['2ndContentBgColor']; ?>"></td>	 
         </tr>
            
         <? if ( $row['backgroundimage'] != ""){  ?>
         <tr>
        <td>
        <table>
            <tr>
                <td><img width="200" src="/gbimages/<?= $row['backgroundimage']; ?>"></td>
            </tr>
        </table>
    
        </td><td><a href="global_settings.php?idForDel=<?=$siteId?>&in=<?= $row['backgroundimage']; ?>" > Remove Image </a>  </td>
        </tr>	 
        <? } ?>
            
            </table>
         </div>
    
         <div class="hide">
         <table border="0" cellpadding="10" cellspacing="10">        
            <tr>
                <td colspan="2">
                    <h3>Logo:</h3>
                    <div class="fieldExtraStyle">            
                        <input type="file" name="image" id="image" class="fieldStyle"/> <br />
                        We suggest uploading logos under 200px wide.
                     </div>
                  </td>
            </tr>
            <?   if ( $logoOrcompany['logo'] != ""){ ?>
                <tr>
                    <td><img width="199" src="http://www.mymobimanager.com/logo/<?PHP echo $logoOrcompany['logo']; ?>"></td>
                    <td><a href="global_settings.php?logoForDel=<?=$siteId?>&in=<?PHP echo $logoOrcompany['logo']; ?>" > Remove Image </a>  </td>
                </tr>	 	
            <? } 
            if ($row['logobackgroundcolor'] == "") {
                    $checkLogoBG = 'checked="checked"';
            }
            ?>
             <tr>
            <td><strong>Logo Background Color <br /><small><i>example: #cccccc for light gray</i></small></strong></td>	 
            <td><input type="checkbox" name="removeLogoBG" id="removeLogoBG" value="1" <?= $checkLogoBG; ?> /> Remove Background Color<input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="logobackgroundcolor" ID="logobackgroundcolor" value="<? echo $row['logobackgroundcolor']; ?>"></td>	 
            </tr>
            </table>
         </div>
        <div class="hide">
            <table> 
             <tr>
                <td><strong>Font:</strong></td>	 
                <td><select name="font" id="font" class="fieldStyle">
                     <option value=""  <? if($row['font'] == "") echo "selected"; ?>></option>
                        <option value="Arial" <? if($row['font'] == "Arial") echo "selected"; ?>>Arial</option>
                        <option value="Courier" <? if($row['font'] == "Courier") echo "selected"; ?>>Courier</option>
                        <option value="Tahoma" <? if($row['font'] == "Tahoma") echo "selected"; ?>>Tahoma</option>
            <option value="Times New Roman" <? if($row['font'] == "Times New Roman") echo "selected"; ?>>Times New Roman</option>
            <option value="TSANS-SERIF" <? if($row['font'] == "TSANS-SERIF") echo "selected"; ?>>TSANS-SERIF</option>
            <option value="Comic Sans MS" <? if($row['font'] == "Comic Sans MS") echo "selected"; ?>>Comic Sans MS</option>
                        <option value="Lucida Sans" <? if($row['font'] == "Lucida Sans") echo "selected"; ?>>Lucida Sans</option>
                    </select></td>	 
            </tr>
            <tr>
            <td><strong>Font Color</strong> <br /><small><i>example: #000000 for black</i></small></td>
             <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="fontcolor" ID="fontcolor" value="<? echo $row['fontcolor']; ?>"></td>
            </tr>
            </table>
        </div>
         <div class="hide">
         <table border="0" cellpadding="10" cellspacing="10" class="generaltable">        
         <tr>
                <td colspan="2" class=""><h3>Choose your Mobile Navigation Style</h3></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                    <tr>
                    <?PHP 
                    
                    if ($row['navStyle'] == 1){
                            $selected1 = "checked";	
                    } elseif ($row['navStyle'] == 2) {
                        $selected2 = "checked='checked'";
                    } else { 
                            $selected1 = "checked='checked'";	
                    }
                    ?>
                        <td><input type="radio" name="navStyle" value="1" <?php echo $selected1; ?>   />
                        <td><img src="/images/icons/back_icon.png" /> <img src="/images/icons/home_icon.png" /> <img src="/images/icons/phone_icon.png" /></td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="navStyle" value="2" <?php echo $selected2; ?> />
                        <td>Back | Home |  Call Us | Email Us </td>
                    </tr>
                    </table>
            </td>
            </tr>
            
            <tr>
                    <?PHP 
                    
                    if ($row['markerColor'] != ""){
                        $mcSelected = "checked='checked'";
                    } else {
						$mcSelected = "";	
                    }
                    ?>
                <td><strong>Add Link Marker</strong> <br /><small><i>example: #cccccc for light gray</i></small></td>	 
                <td><input type="checkbox" id="haveLinkMarker" name="haveLinkMarker" value="1" <?= $mcSelected; ?> />Include Link Marker<br /><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="markerColor" ID="markerColor" value="<? echo $row['markerColor']; ?>"></td>	 
         	</tr> 
            <tr>
                <td><strong>Content Link Color</strong> <br /><small><i>example: #cccccc for light gray</i></small></td>	 
                <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="contentLinkColor" ID="contentLinkColor" value="<? echo $row['contentLinkColor']; ?>"></td>	 
         	</tr>    
        
         <tr>
            <td><strong>Navigation Text Color</strong> <br /><small><i>example: #cccccc for light gray</i></small></td>	 
            <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="linktextcolor" ID="linktextcolor" value="<? echo $row['linktextcolor']; ?>"></td>	 
         </tr>
            <tr>
            <td><strong>Navigation BG Color</strong> <br /><small><i>example: #820000 for scarlet</i></small></td>
             <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="linkbgcolor" ID="linkbgcolor" value="<? echo $row['linkbgcolor']; ?>"></td>
            </tr>
            
            
            
            <tr>
            <td><strong>Link Border Color</strong><br /><small><i>example: #0000ff for blue</i></small></td>
             <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="linkbordercolor" ID="linkbordercolor" value="<? echo $row['linkbordercolor']; ?>"></td>
            </tr>
            </table>
         </div>
    
         <div class="hide">
         Footer
         <table>
        <tr>
         <?PHP if ($row['footerColor'] == ""){
                    $checkFooterBg = 'checked="checked"';
         } ?>
            <td><strong>Footer Color</strong> <br /><small><i>example: #820000 for scarlet</i></small></td>
             <td><input type="checkbox" id="removeFooterBg" name="removeFooterBg" value="1" <?= $checkFooterBg; ?> />No Footer Background Color<br /><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="footerColor" ID="footerColor" value="<? echo $row['footerColor']; ?>"></td>
            </tr>
            <tr>
            <td><strong>Footer Font Color</strong> <br /><small><i>example: #820000 for scarlet</i></small></td>
             <td><input class="fieldStyle color {hash:true,caps:false}" type="text" size="9" name="footerFontColor" ID="footerFontColor" value="<? echo $row['footerFontColor']; ?>"></td>
            </tr>
             
         </table>
         </div>
		</div>
</td>
</td>
</tr>
</table>    
    </form>
<script>
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>
    
<?php include("downpart.php")?>
