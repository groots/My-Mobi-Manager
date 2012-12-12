<?php

include("session_check.php");
$pagetitle="Dashboard";
$pagetag = "Home Sweet Home!";
include('classes/pagination_class.php');
include('classes/pagination_class2.php');

$_SESSION['mobiId']="";
////////////////////////////////////////////////
	$sqlu="SELECT userName, siteAccess FROM ".$projectName."user x WHERE x.Userid=$Userid";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);
	
	// Clear temp table
	mysql_query("DELETE FROM tempUserData WHERE userId = $Userid");
	$siteString= $recordu["siteAccess"];
	$mySites=explode(",",$siteString);
	
	if($_GET['idForEdit']){
		$id=$_GET['idForEdit'];
		$_SESSION['currentPageId'] = $id; 
		$sql="select * from ".$projectName."page where pageid='$id'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
	}

if($_POST['createSite'] ){
		$id=$_POST['idForEdit'];
		if ($siteName=='')
			$errormessage=$errormessage . "Site name can't be empty<br>";
	
		if ($ocPhone=='')
			$errormessage=$errormessage . "Site phone number url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		if ($errormessage==''){
			$returnFromAddSite=newsite_save($siteName,$Userid,$active,$website,$ocPhone,$ocEmail,$publishContent);
			if ($returnFromAddSite== "true"){
				$successmessage="Edit Successfully";
				if ($_POST['createSite']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					header("location: userHome.php");	
				} 
			} else
				$errormessage=$errormessage . $returnNewSite;
			
		}  
	} elseif ($_POST['copySite'] == "Copy") {
		
		$newSiteName = $_POST['siteName'];		
		$stc = $_POST['siteToCopy'];
		
		$origSiteInfo = mysql_fetch_array(mysql_query("SELECT * FROM mobilemanager_moSiteInfo WHERE siteId = " . $stc));		
		$origSiteStyle = mysql_fetch_array(mysql_query("SELECT * FROM mobilemanager_global_settings WHERE mobiSiteId = " .  $stc));
		$origSiteAddOns = mysql_fetch_array(mysql_query("SELECT * FROM mobilemanager_google_analytics WHERE mobiSiteId = " . $stc));	
		
		//SiteName of site being copied
		$origSiteName = $origSiteInfo['SiteName'];
		
		$sql1 = "INSERT INTO mobilemanager_moSiteInfo (userId, SiteName, active, logo, logoHeight, logoWidth, mainWebSite, ocPhone, ocEmail, homepageText, footer, createdOn, CreatedBy, modifiedOn, ModifiedBy) VALUES ('" . $origSiteInfo['userId'] . "', '" . $newSiteName . "', '" . $origSiteInfo['active'] . "', '" . $origSiteInfo['logo'] . "', '" . $origSiteInfo['logoHeight'] . "', '" . $origSiteInfo['logoWidth'] . "', '" . $origSiteInfo['mainWebSite'] . "', '" . $origSiteInfo['ocPhone'] . "', '" . $origSiteInfo['ocEmail'] . "', '" . addslashes($origSiteInfo['homepageText']) . "', '" . addslashes($origSiteInfo['footer']) . "', '" . $origSiteInfo['createdOn'] . "', '" . $origSiteInfo['CreatedBy'] . "', '" . $origSiteInfo['modifiedOn'] . "', '" . $origSiteInfo['ModifiedBy'] . "')";
		
		mysql_query($sql1) or die("Error copying mobile website, please contact support");
		
		$getSiteId = mysql_fetch_array(mysql_query("SELECT siteId FROM mobilemanager_moSiteInfo WHERE SiteName = '$newSiteName'"));
		$newSiteId = $getSiteId['siteId'];
		
		$sql2 = "INSERT INTO mobilemanager_google_analytics (mobiSiteId, status, code, fStackAPIKey, ebriteapi, ebriteusr, ccLogin, ccPassword, mChimpKey, mChimpListID, socialShare, facebookId, twitterId, serverLanguage, indexPageName, includeSearch, displayFooter) VALUES('" . $newSiteId . "', '" . $origSiteAddOns['status'] . "', '', '" . $origSiteAddOns['fStackAPIKey'] . "', '" . $origSiteAddOns['ebriteapi'] . "', '" . $origSiteAddOns['ebriteusr'] . "', '" . $origSiteAddOns['ccLogin'] . "', '" . $origSiteAddOns['ccPassword'] . "', '" . $origSiteAddOns['mChimpKey'] . "', '" . $origSiteAddOns['mChimpListID'] . "', '" . $origSiteAddOns['socialShare'] . "', '" . $origSiteAddOns['facebookId'] . "', '" . $origSiteAddOns['twitterId'] . "', '" . $origSiteAddOns['serverLanguage'] . "', '" . $origSiteAddOns['indexPageName'] . "', " . $origSiteAddOns['includeSearch'] . ", " . $origSiteAddOns['displayFooter'] . ")";
		
		mysql_query($sql2) or die(mysql_error());
		
		$sql3 = "INSERT INTO mobilemanager_global_settings (mobiSiteId, layout, logobackgroundcolor, font, fontcolor, searchBoxBG, navStyle, haveGradient, backgroundcolor, 2ndbackgroundColor, backgroundimage, linkcolor, linktextcolor, linkbgcolor, linkbordercolor, contentBGcolor, contentLinkColor, footerColor, footerFontColor) VALUES('" . $newSiteId . "', '" . $origSiteStyle['layout'] . "', '" . $origSiteStyle['logobackgroundcolor'] . "', '" . $origSiteStyle['font'] . "', '" . $origSiteStyle['fontcolor'] . "', '" . $origSiteStyle['searchBoxBG'] . "', '" . $origSiteStyle['navStyle'] . "', '" . $origSiteStyle['haveGradient'] . "', '" . $origSiteStyle['backgroundcolor'] . "', '" . $origSiteStyle['2ndbackgroundColor'] . "', '" . $origSiteStyle['backgroundimage'] . "', '" . $origSiteStyle['linkcolor'] . "', '" . $origSiteStyle['linktextcolor'] . "', '" . $origSiteStyle['linkbgcolor'] . "', '" . $origSiteStyle['linkbordercolor'] . "', '" . $origSiteStyle['contentBGcolor'] . "', '" . $origSiteStyle['contentLinkColor'] . "', '" . $origSiteStyle['footerColor'] . "', '" . $origSiteStyle['footerFontColor'] . "')";
		
		mysql_query($sql3) or die(mysql_error());
		
						
		$origSitePages = mysql_query("SELECT * FROM mobilemanager_page WHERE mobiSiteId = " . $stc);
		while( $origSitePageRow=mysql_fetch_array($origSitePages))  {
			$newLink = 	str_replace($origSiteName, $newSiteName, $origSitePageRow['Seourl']);
			$sql4 = "INSERT INTO mobilemanager_page (Pagetitle, mobiSiteId, content, contentType, Seourl, creationdate, Rsspath, fStackFormId, flagEbrite, mChimpListID, ccFlag, isNav, Pageorder, Parentlink, active, lastestTweet) VALUES('" . $origSitePageRow['Pagetitle'] . "', " . $newSiteId . ", '" . addslashes($origSitePageRow['content']) . "', " . $origSitePageRow['contentType'] . ", '" . $newLink . "', '" . $origSitePageRow['creationdate'] . "', '" . $origSitePageRow['Rsspath'] . "', '" . $origSitePageRow['fStackFormId'] . "', " . $origSitePageRow['flagEbrite'] . ", '" . $origSitePageRow['mChimpListID'] . "', " . $origSitePageRow['ccFlag'] . ", " . $origSitePageRow['isNav'] . ", " . $origSitePageRow['Pageorder'] . ", " . $origSitePageRow['Parentlink'] . ", " . $origSitePageRow['active'] . ", " . $origSitePageRow['lastestTweet'] . ")";
			//echo $sql4 . "<br><br>";
			mysql_query($sql4) or die(mysql_error());
		}	
		
		$getSiteAccess = mysql_fetch_array(mysql_query("SELECT siteAccess FROM mobilemanager_user WHERE Userid = '$Userid'"));
		$newSiteAccess = $getSiteAccess['siteAccess'] . ", $newSiteId";
		$sql5 = "UPDATE mobilemanager_user SET siteAccess = '$newSiteAccess' WHERE Userid = '$Userid'";
		mysql_query($sql5) or die (mysql_error());
		
		$_POST['copySite'] = "";
		
		header("location: userHome.php");
		
	} elseif($_POST['cancelPage'])  { 
		header("location: userHome.php"); 
	} elseif($_POST['createUser'])  { 
		$accessArray=$_POST['siteAccess'];
		if ($accessArray){		
			$xp = 0;
			foreach ($accessArray as $aa){
				if($xp == 0) {
					$siteAccess = $aa;
				} else {
					$siteAccess .=  ", " . $aa;
				}
				$xp = $xp + 1;
			}
		}
		$email=$_POST['usrEmail'];
		if($email=="")
			$errormessage=$errormessage."Email could not be empty.<br>";
	
		$res=mysql_query("select Email from ".$projectName."user where Email='$email'");
		$countEmail=mysql_num_rows($res);
		if($countEmail==1) {
			$errormessage=$errormessage."This email address is already exist!";
		}
		
		$userName=$_POST['userName'];
		if($userName=="")
			$errormessage=$errormessage."User Name could not be empty.<br>";
		
		$rest=mysql_query("select Email from ".$projectName."user where Username='$userName'");
		$countName=mysql_num_rows($rest);
		
		if($countName==1) {
			$errormessage=$errormessage."This username is already exist!";
		}
		
		$firstName=$_POST['fName'];
		if($firstName=="")
			$errormessage=$errormessage."First Name could not be empty.<br>";
		
		$lastName=$_POST['lName'];
		if($lastName=="")
			$errormessage=$errormessage."Last Name could not be empty.<br>";
		
		if (!ctype_alnum($userName)) {
			// display error
			$errormessage=$errormessage."Username cannot contain special characters.<br>";	
		}  
		
		$password=$_POST['password'];
		if($password=="")
			$errormessage=$errormessage."Password cannot be empty.<br>";
		
		$repassword=$_POST['repassword'];
		if($repassword=="")
			$errormessage=$errormessage."Retype password cannot be empty.<br>";
		
		
				
		//echo $errormessage;
		if ($errormessage=='' && $password==$repassword){
			$userId = $_SESSION['ID'];
//exit;		
		$newSites =  implode(", ",$accessArray);
		$returnFromAdd=newuser_save($userId, $firstName,$lastName, $userName, $email, $newSites, $password);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					header("location: userHome.php");	
				} 
			} else
				$errormessage=$errormessage . $returnNewSite;
		}		
		//header("location: userHome.php"); 
	}  	  
	if($_GET['successmessage'] == 'sDelete'){
		$successmessage = "Site Successfully Deleted";
	} else if ($_GET['successmessage'] == 'uDelete'){
		$successmessage = "User Successfully Deleted";
	}
	include("toppart.php"); ?>
<script language="JavaScript" src="pagination.js"></script>
<script language="JavaScript" src="pagination2.js"></script>

<link rel="stylesheet" type="text/css" href="style.css" />
                    <div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialog" class="window">
                        
                        <form action="userHome.php" method="post" id="newSite">
                            <h2>Add a Mobile Website</h2> 
                            <table width="900px" align="center">
                            <tr>
                            <td width="150px" valign="top">
                         		<table>
                                	<tr>
                                    	<td>Site Name </td>
                                    	<td><input type="text"  class="fieldStyle" name="siteName" id="siteName" value="<? echo $row['fStackFormId'];?>" /></td>
                                        <td>This is the prefix used in the URL of the mobile site.  No spaces please!</td>
                                    </tr>	
                                	<tr>
                                    	<td>Active</td>
                                    	<td>
                                <?
                                    if ($row['active'] == '1') {
                                        $activeCheck ="checked='checked'";
                                    } elseif($row['active'] == '2') {
                                        $draftCheck ="checked='checked'";
                                    } else {
                                        $notActiveCheck ="checked='checked'";
                                    }
                                
                                ?>
                                <div class="fieldExtraStyle" style="height: 20px;">
                                    <input type="radio" name="publishContent" id="publishContent" value="1" <?= $activeCheck;?>  /> Publish <input type="radio" name="publishContent" id="unpublish" value="0" <?= $notActiveCheck;?> /> UnPublish  
                                    <br /><br />
                                    <? if ($row['isNav'] == "1") {
                                        $isNavCheck = "Checked='Checked'";	
                                    } else {
                                        $isNavCheck = "";	
                                    }
                                    ?>
                                </div>
                                
                                </td>
                                        <td>Publish and unpublish mobile sites.</td>
                                    </tr>	
                                	<tr>
                                    	<td>Website Link</td>
                                    	<td><input type="text"  class="fieldStyle" name="website" id="website" value="<? echo $row['fStackFormId'];?>" /></td>
                                        <td>Enter the URL of your "traditional" desktop website.</td>
                                    </tr>	
                                	<tr>
                                    	<td>Phone Number</td>
                                    	<td><input type="text"  class="fieldStyle" name="ocPhone" id="ocPhone" value="<? echo $row['fStackFormId'];?>" /></td>
                                        <td>This is the phone number we will use for "Click to Call" functionality.</td>
                                    </tr>	
                                	<tr>
                                    	<td>Email</td>
                                    	<td><input type="text"  class="fieldStyle" name="ocEmail" id="ocEmail" value="<? echo $row['fStackFormId'];?>" /></td>
                                        <td>This is the email address that users will send emails to for "Click to Email" functionality.</td>
                                    </tr>	
                                </table>
                         
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                        
                     
                     <input type="submit" name="createSite" class="formButton" value="Save"/>  <input type="submit" name="cancelPage" class="formButton close" value="Cancel"/>
                     
                     </form>
                        </div>
                         
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                      <div id="mask"></div>
    				</div>
                    
                    
                    <div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialogCopy" class="window">
                        
                        <form action="userHome.php" method="post" id="newSite">
                            <h2>Copy a Mobile Website</h2> 
                            <table width="900px" align="center">
                            <tr>
                            <td width="150px" valign="top">
                         		<table>
                                	<tr>
                                    	<td>New Site Name </td>
                                    	<td><input type="text"  class="fieldStyle" name="siteName" id="siteName" onBlur="CheckSitename(this.value);" value="<? echo $row['SiteName'];?>" /><div id="sitenameresult"></div></td>
                                        <td>This will be the name of your mobile site.  No spaces please!</td>
                                    </tr>	
                                    
                                    <tr>
                                    	<td>Sites Assigned</td>
                                        <td>
                                        
                                        <select name="siteToCopy" id="siteToCopy" size="4" style="width: 250px; border: medium solid #036679; background: #FDDEA9;" >
<?PHP
				foreach ($mySites as $i => $value) {
					$query  = "SELECT * FROM mobilemanager_moSiteInfo WHERE siteId = $mySites[$i]";
								$result = mysql_query($query);
								$s =0;
								$counter = mysql_num_rows($result);
								if ($counter != 0) {
									while($row = mysql_fetch_array($result, MYSQL_ASSOC))
										{
											$s++;
										?>
                                        	<option id="<?=$row['siteId']?>" value="<?=$row['siteId']?>" ><?php echo $row['SiteName']; ?></option>
												
									<?php } 
								} else { ?>
					 Details about adding your first mobile website
				<? }
				}?>
                
                                         </select>   
                </td>
                                    </tr>
                                
                                </table>
                         
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                        
                     
                     <input type="submit" name="copySite" class="formButton" value="Copy"/>  <input type="submit" name="cancelPage" class="formButton close" value="Cancel"/>
                     
                     </form>
                        </div>
                         
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                      <div id="mask"></div>
    				</div>
                    
                    
                    <div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialog3" class="window" style=" height: 500px;">
                        
                        <form action="userHome.php" method="post" id="newSite">
                            <h2>Add a New User</h2> 
                            <table width="900px" align="center">
                            <tr>
                            <td width="150px" valign="top">
                         		<table>
                                	<tr>
                                    	<td>First Name</td>
                                    	<td><input type="text"  class="fieldStyle" name="fName" id="fName" value="<? echo $row['Firstname'];?>" /></td>
                                    </tr>
                                	<tr>
                                    	<td>Last Name</td>
                                    	<td><input type="text"  class="fieldStyle" name="lName" id="lName" value="<? echo $row['Lastname'];?>" /></td>
                                    </tr>	
                                    <tr>
                                        <td>Username</td>
                                        <td><input type="text" name="userName" id="userName" value="<?=$userName?>" onblur="CheckUsername(this.value);"  class="fieldStyle" /> <div id="usernameresult"></div> </td>
                                    </tr>
                                	<tr>
                                    	<td>Active</td>
                                    	<td>
                                <?
                                    if ($row['active'] == '1') {
                                        $activeCheck ="checked='checked'";
                                    } elseif($row['active'] == '2') {
                                        $draftCheck ="checked='checked'";
                                    } else {
                                        $notActiveCheck ="checked='checked'";
                                    }
                                
                                ?>
                                <div class="fieldExtraStyle" style="height: 20px;">
                                    <input type="radio" name="publishContent" id="publishContent" value="1" <?= $activeCheck;?>  /> Publish <input type="radio" name="publishContent" id="unpublish" value="0" <?= $notActiveCheck;?> /> UnPublish  
                                    <br /><br />
                                    <? if ($row['isNav'] == "1") {
                                        $isNavCheck = "Checked='Checked'";	
                                    } else {
                                        $isNavCheck = "";	
                                    }
                                    ?>
                                </div>
                                
                                
                                
                                
                                </td>
                                    </tr>	
                                	<tr>
                                    	<td>Password</td>
                                    	<td><input type="password"  class="fieldStyle" name="password" id="password" value="<? echo $row['fStackFormId'];?>" /></td>
                                    </tr>		
                                	<tr>
                                    	<td>Re Enter</td>
                                    	<td><input type="password"  class="fieldStyle" name="repassword" id="repassword" value="<? echo $row['fStackFormId'];?>" /></td>
                                    </tr>		
                                	<tr>
                                    	<td>Email</td>
                                    	<td><input type="text"  class="fieldStyle" name="usrEmail" id="usrEmail" value="<? echo $row['fStackFormId'];?>" /></td>
                                    </tr>	
                                    <tr>
                                    	<td>Sites Assigned</td>
                                        <td>
                                        
                                        <select name="siteAccess[]" id="siteAccess" multiple size="4" style="width: 250px; border: medium solid #036679; background: #FDDEA9;" >
<?PHP
				foreach ($mySites as $i => $value) {
					$query  = "SELECT * FROM mobilemanager_moSiteInfo WHERE siteId = $mySites[$i]";
								$result = mysql_query($query);
								$s =0;
								$counter = mysql_num_rows($result);
								if ($counter != 0) {
									while($row = mysql_fetch_array($result, MYSQL_ASSOC))
										{
											$s++;
										?>
                                        	<option id="<?=$row['siteId']?>" value="<?=$row['siteId']?>" ><?php echo $row['SiteName']; ?></option>
												
									<?php } 
								} else { ?>
					 Details about adding your first mobile website
				<? }
				}?>
                
                                         </select>   
                </td>
                                    </tr>
                                </table>
                         
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                        <br />
                     
                     <input type="submit" name="createUser" class="formButton" value="Save"/>  <input type="submit" name="cancelPage" class="formButton close" value="Cancel"/>
                     
                     </form>
                        </div>
                         
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                      <div id="mask"></div>
    </div>




<div style="position: relative; top: 0px; float: right; width: 20%; background: #ccc; padding: 10px; height: 600px;">
	<table class="mobiletips">
    	<tr>
        	<td>
    			Mobile Tip 1
            </td>
        </tr>
    	<tr>
        	<td>
    			Know your brand. Be sure to pass color scheme of your desktop website to your mobile webiste.
            </td>
        </tr>        
    </table>
    <br />
    <br />
    
    <table class="mobiletips">
    	<tr>
        	<td>
    			Mobile Tip 2
            </td>
        </tr>
    	<tr>
        	<td>
    			Test your website everytime you make updates. It is very easy to add new elements to pages that will increase the size of the mobile web page making download times higher and most costly to data plans.
            </td>
        </tr>        
    </table>
    <br />
    <br />
    <table class="mobiletips">
    	<tr>
        	<td>
    			Mobile Tip 3
            </td>
        </tr>
    	<tr>
        	<td>
    			No Problem. Please feel free to email us at any tiem with any questions and we will do our best to get back to you as quickly as possible with an answer. Thank you for using My Mobi Manager.
            </td>
        </tr>        
    </table>
</div>
<Br />


<table cellpadding="20" cellspacing="20" style="margin-top: -20px;">
	<tr valign="top">
    	<td valign="top">
        	
            <h2 style="margin-bottom: -2px">Manage Sites</h2>
<a href="#dialog" name="modal" style="color: #F5C36D;">Add Website</a> | 
<a href="#dialogCopy" name="modal" style="color: #F5C36D;">Copy Website</a>
<div >
<?PHP


			if (isset($mySites)) {
				foreach ($mySites as $i => $value) {
					$query  = "SELECT * FROM mobilemanager_moSiteInfo WHERE siteId = $mySites[$i]";
					$result = mysql_query($query);
					while($row = mysql_fetch_array($result, MYSQL_ASSOC))
					{
						$tempQuery = "INSERT INTO tempUserData (userId, siteId, siteName) VALUES ('" . $Userid . "', '" . $row['siteId'] . "', '" . $row['SiteName'] . "')";
						mysql_query($tempQuery) or die("sorrry");
					} 
				}
			} 
	
			include("sitelist.php");
				 ?>
</div>
<br />
<a href="#dialog" name="modal" style="color: #F5C36D;">Add Website</a> | 
<a href="#dialogCopy" name="modal" style="color: #F5C36D;">Copy Website</a>
</div> 

        </td>
    	<td valign="top" style="border-left: medium solid #3c3c3c;">
        <h2 style="margin-bottom: -2px;">Manage Users</h2>
            <a href="#dialog3" name="modal" style="color: #F5C36D;">add new user</a>

<div >
                                                        <? include("userlist.php"); ?>

</div>
<br />
            <a href="#dialog3" name="modal" style="color: #F5C36D;">add new user</a>
</div> 
 
        </td>
    </tr>
</table>


                    
                    
                    
<?php include("downpart.php"); ?>

