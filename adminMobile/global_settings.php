<?php

	include("session_check.php");
	$pagetitle="Design Settings For Mobile Website";
	$pagetag = "Time to get Jiggy with it!";
	$Userid=$_SESSION['ID'];
	$projectName="mobilemanager_";
	if($_GET['idForDel']){
			unlink("admin/gbimages/" . $_GET['in']);
			$d_id = $_GET['idForDel'];
			$sqld="UPDATE ".$projectName."global_settings SET backgroundimage = NULL  where Userid='$d_id'";
			mysql_query($sqld);	
			$successmessage="Image deleted successfully";
		
	}
	
	if($_GET['logoForDel']){
					
		unlink("logo/" . $_GET['in']);
		$d_id = $_GET['logoForDel'];
		$sqld="UPDATE ".$projectName."user SET Logo = NULL  where Userid='$d_id'";
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
	$contentBGcolor=addslashes($_POST['contentBGcolor']);
	$contentLinkColor=addslashes($_POST['contentLinkColor']);
	$linktextcolor=addslashes($_POST['linktextcolor']);
	$linkbgcolor=addslashes($_POST['linkbgcolor']);
	$linkbordercolor=addslashes($_POST['linkbordercolor']);
	$searchBoxBG = addslashes($_POST['searchBoxBG']);
	$navStyle = addslashes($_POST['navStyle']);
	$removeFooterBg = addslashes($_POST['removeFooterBg']);
	$footer = addslashes($_POST['footerColor']);
	$footerFontColor = addslashes($_POST['footerFontColor']);
	$removeLogoBG = addslashes($_POST['removeLogoBG']);
	if($removeLogoBG == 1) {
		$logoBgColor="";
	}
		
	
	$queryc="SELECT userName FROM  ".$projectName."user WHERE   Userid=$Userid";
	$resultc=mysql_query($queryc);
	$rowc=mysql_fetch_array($resultc);
	
///////////upload
	$image_name=$rowc['userName'].'.'.$_FILES['file']['name'];

    if (file_exists("gbimages/" . $image_name )){
     	$errormessage = $image_name . " already exists. ";
    } else {

	$newname="gbimages/".$image_name;
	  copy($_FILES['file']['tmp_name'], $newname);
     }

////////////end
/////////// logo upload

	$logoName=rand (111111,999999).'.'.$_FILES['image']['name'];
	$newLogoName="../logo/".$logoName; ///secureCode/secure
	copy($_FILES['image']['tmp_name'], $newLogoName);
  
//getting image sizes
	list($width, $height) = getimagesize($newLogoName);
	
////////////end

	$sql3="select * from ".$projectName."global_settings where Userid='$Userid'";
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
	





if($exist['Userid'] != "") {
		if($_FILES['image']['name']=="" && $_FILES['file']['name']=="" )	{
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',contentLinkColor='".$contentLinkColor."',linktextcolor='".$linktextcolor."',linkbgcolor='".	$linkbgcolor."',linkbordercolor='".$linkbordercolor."',footerColor='" . $footer .  "',footerFontColor='" . $footerFontColor .  "' WHERE Userid = '$Userid' ";
		} else if($_FILES['image']['name']=="" )	{
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',contentLinkColor='".$contentLinkColor."',backgroundimage='".$image_name."',linktextcolor='".$linktextcolor."',linkbgcolor='".	$linkbgcolor."',linkbordercolor='".$linkbordercolor."',footerColor='" . $footer .  "',footerFontColor='" . $footerFontColor .  "' WHERE Userid = '$Userid' ";
		} else {
			$sqlUp="UPDATE ".$projectName."global_settings SET layout = '" . $layout . "', logobackgroundcolor = '" . $logoBgColor . "', font ='".$font."',fontcolor='".$fontcolor."',searchBoxBG='".$searchBoxBG."',navStyle='".$navStyle."',haveGradient='" . $haveGradient . "',backgroundcolor='".$backgroundcolor."',2ndbackgroundColor='".$editGradient."',contentBGcolor='".$contentBGcolor."',contentLinkColor='".$contentLinkColor."',backgroundimage='".$image_name."',linktextcolor='".$linktextcolor."',linkbgcolor='".$linkbgcolor."',linkbordercolor='".$linkbordercolor."',footerColor='" . $footer . "',footerFontColor='" . $footerFontColor .  "' WHERE Userid = '$Userid' ";
			$sqlEdit = "update ".$projectName."user set Logo='".$logoName."', logoWidth='".$width."', logoHeight='".$height."' WHERE Userid = '$Userid' ";
		}
		mysql_query($sqlUp);
		$resultEdit=mysql_query($sqlEdit);
		if($errormessage=='')
			$successmessage="Update Successfully";
	} else {
		$sql="INSERT INTO ".$projectName."global_settings (Userid,layout,logobackgroundcolor,font,fontcolor,haveGradient,backgroundcolor,2ndbackgroundColor,contentBGcolor,contentLinkColor,backgroundimage,linktextcolor,linkbgcolor,linkbordercolor,footerColor,footerFontColor) values('$Userid','$layout','$logoBgColor','$font','$fontcolor','$haveGradient','$backgroundcolor','$addGradient','$contentBGcolor','$contentLinkColor','$image_name','$linktextcolor','$linkbgcolor','$linkbordercolor','$footer','$footerFontColor')";
		mysql_query($sql);	
		
		
	if($_FILES['image']['name']=="")	{
		//$sqlEdit = "update ".$projectName."user set homePageText='" . $homeText . "'  WHERE Userid = '$Userid' ";
	} else {
		$sqlEdit = "update ".$projectName."user set Logo='".$logoName."', logoWidth='".$width."', logoHeight='".$height."' WHERE Userid = '$Userid' ";
	}
		$resultEdit=mysql_query($sqlEdit);
		$successmessage="Update Successfully";
} }

	$sql="select * from ".$projectName."global_settings where Userid='$Userid'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

//echo $row['backgroundimage'];  

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

<script type="text/javascript" src="/scripts/jscolor/jscolor.js"></script>
<?php
	$logoOrcompany=mysql_fetch_array(mysql_query("select Username, Company, Logo, logoWidth, logoHeight from ".$projectName."user where Userid='$Userid'"));
	$userName = $logoOrcompany['Username'];
	include("toppart.php");
?>

<form name="form_global_settings" enctype="multipart/form-data" action="global_settings.php" method="post" >     

<div id="designed">
     <ul>
         <li><a href="#choose-layout"><span>Choose Layout</span></a></li>
         <li><a href="#first-tab"><span>General Layout</span></a></li>
         <li><a href="#second-tab"><span>Logo Information</span></a></li>
         <li><a href="#font-tab"><span>Font Style</span></a></li>
         <li><a href="#third-tab"><span>Navigation</span></a></li>
         <li><a href="#fourth-tab"><span>Footer</span></a></li>
     </ul>
	 <div id="choose-layout">
     <table border="0" cellpadding="10" cellspacing="10" class="generaltable">                
            <tr>
                <td align="left">
                
                <?PHP
                if ($row['layout'] == 0){
                    $laySelect1 = "checked='checked'";
                } else if ($row['layout'] == 1){
                    $laySelect2 = "checked='checked'";
                } else {
                    $laySelect3 = "checked='checked'";	
                }
                ?>
                    <table align="left" width="100%">
                    <tr>
                        <td align="center"><img src="/admin/images/layout1.gif" alt="layout 1" /></td>
                        <td align="center"><img src="/admin/images/layout2.gif" alt="layout 2" /></td>
                        <td align="center"><img src="/admin/images/layout3.gif" alt="layout 3" /></td>
                    </tr>
                    <tr>
                        <td align="center"><input type="radio" name="layout" value="0" <?php echo $laySelect1; ?> /> Layout 1</td>
                        <td align="center"><input type="radio" name="layout" value="1" <?php echo $laySelect2; ?> /> Layout 2</td>
                        <td align="center"><input type="radio" name="layout" value="2" <?php echo $laySelect3; ?> /> Layout 3</td>
                    </tr>
                    </table>
            </td>
            </tr>
            </table>
     </div>
	 <div id="first-tab">
         <table border="0" cellpadding="10" cellspacing="10" width="800px">                        
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
        
	 <? if ( $row['backgroundimage'] != ""){  ?>
     <tr>
	<td>
	<table>
    	<tr>
			<td><img width="200" src="/admin/gbimages/<?= $row['backgroundimage']; ?>"></td>
		</tr>
	</table>

	</td><td><a href="global_settings.php?idForDel=<?=$Userid?>&in=<?= $row['backgroundimage']; ?>" > Remove Image </a>  </td>
	</tr>	 
    <? } ?>
        
        </table>
	 </div>

	 <div id="second-tab">
	 <table border="0" cellpadding="10" cellspacing="10" class="generaltable">        
        <tr>
            <td colspan="2">
            	<h3>Logo:</h3>
                <div class="fieldExtraStyle">            
                    <input type="file" name="image" id="image" class="fieldStyle"/>
                 </div>
              </td>
        </tr>
        <?   if ( $logoOrcompany['Logo'] != ""){ ?>
            <tr>
                <td><img width="199" src="../logo/<?PHP echo $logoOrcompany['Logo']; ?>"></td>
                <td><a href="global_settings.php?logoForDel=<?=$Userid?>&in=<?PHP echo $logoOrcompany['Logo']; ?>" > Remove Image </a>  </td>
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
	<div id="font-tab">
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
	 <div id="third-tab">
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

	 <div id="fourth-tab">
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
    
         
    <div id="submitButton" style="position: relative; margin: auto;">
    <input type="submit" class="formButton" name="submit" id="submit" value="Save" />
    </div>
    </form>
    
<?php include("downpart.php")?>
