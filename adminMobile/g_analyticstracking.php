<?php
	include("session_check.php");
	$pagetitle="System Configuration";
	$Userid=$_SESSION['ID'];
	$pagetag = "Guess what?! I got a fever, and the only prescription...is more <a href='http://en.wikipedia.org/wiki/More_cowbell' target='_blank'>cowbell!!</a> - Bruce Dickinson";
	
	if($_POST['submit']){
	
		$status=addslashes($_POST['status']);
		$code=addslashes($_POST['code']);
		$sql3="SELECT * FROM mobilemanager_google_analytics WHERE Userid = '$Userid'";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
	
		$dhp = $_POST['dhp'];
		$csL = $_POST['extension'];
		$flagChimp = $_POST['flagChimp'];
		$apiKey = $_POST['apiKey'];
		$listId = $_POST['listId'];
		$fStack = $_POST['FSapiKey'];
		$ebriteapi = $_POST['eBriteApi'];
		$ebriteusr = $_POST['eBriteUsr']; 
		$socialShare = $_POST['socialShare'];
		$displayFooter = $_POST['displayFooter'];
		$facebookId = $_POST['facebookId'];
		$twitterId = $_POST['twitterId'];
		//Mailchimp integration
		
		/*
		$resultMC = mysql_query("SELECT * FROM mobilemanager_mailchimp WHERE userId = '$Userid'");
		$rowMC = mysql_fetch_array($resultMC);
		if ($rowMC['id'] == "" && $flagChimp != "") {	
			//update Server configuration
			$sql="INSERT INTO ".$projectName."mailchimp (Userid,apiKey,listId) values('$Userid','$apiKey','$listId')";
			
			//echo $flagChimp . " api = " . $apiKey . " list id = " . $listId . " id = " . $Userid; exit;
			mysql_query($sql);	
		} else {	
			$sqlUp1="UPDATE ".$projectName."mailchimp SET apiKey ='".$apiKey."',listId ='".$listId."' WHERE userId = '$Userid' ";
			
			mysql_query($sqlUp1);
		}
		*/ 
		//Google Analytics
		if($row3['Userid'] != "") {
			$sqlUp="UPDATE ".$projectName."google_analytics SET status ='".$status."',code='".$code."',fStackAPIKey='".$fStack."',ebriteapi='".$ebriteapi."',ebriteusr='". $ebriteusr . "',socialShare='" . $socialShare ."' ,facebookId ='".$facebookId."',twitterId ='".$twitterId."',serverLanguage ='".$csL."',indexPageName='".$dhp."',displayFooter='".$displayFooter."' WHERE Userid = '$Userid' ";
			mysql_query($sqlUp);		
			$successmessage="Update Successfully";
		} else {
			$sql="INSERT INTO ".$projectName."google_analytics (Userid,status,ebriteapi,ebriteusr,code,fStackAPIKey,socialShare,facebookId, twitterId, serverLanguage,indexPageName,displayFooter) values('$Userid','$status','$ebriteapi','$ebriteusr','$code','$fStack','$socialShare','$facebookId','$twitterId','$csL','$dhp','$displayFooter')";
			mysql_query($sql);			
		}
	
	}
		
	$sql="SELECT * FROM mobilemanager_google_analytics WHERE userId = '$Userid' ";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
?> 

<script type="text/javascript">  
	function openURL(sURL) {
		window.open(sURL);
	}
</script> 

<?php
include("toppart.php");
?>

	<form action="g_analyticstracking.php" method="post">	
     
     <table width="100%" cellpadding="8" cellspacing="8">
     	<tr>
        	<td valign="top" width="50%">
            
                 <table border="0" cellpadding="5" cellspacing="5" align="left" width="100%">
                    <tr>
                        <td class="adminHeader" colspan="2"><h2>Server Language Information</h2></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Homepage File Name</strong></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="dhp" id="dhp" value="<? echo $row['indexPageName']; ?>" class="fieldStyle" /></td>
                    </tr>
                    <tr>
                        <td><strong>Server Language</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <select id="extension" name="extension" class="fieldStyle">
                                <option value="1" <? if($row['serverLanguage'] == 1) echo "selected"; ?>>PHP</option>
                                <option value="2" <? if($row['serverLanguage'] == 2) echo "selected"; ?>>ASPX</option>
                                <option value="3" <? if($row['serverLanguage'] == 3) echo "selected"; ?>>ASP</option>
                                <option value="4" <? if($row['serverLanguage'] == 4) echo "selected"; ?>>JSP</option>
                                <option value="5" <? if($row['serverLanguage'] == 5) echo "selected"; ?>>HTML</option>
                                <option value="6" <? if($row['serverLanguage'] == 6) echo "selected"; ?>>HTM</option>
                            </select>
                        </td>
                    </tr>
                    
          <tr>
            <td class="adminHeader" colspan="2"><h2>Eventbrite Information</h2></td>
        </tr>
        
        <tr>
            <td colspan="2"><strong>EventBrite Email</strong></td>
        </tr>
        <tr>
            <td>
                <input type="text" name="eBriteUsr" id="eBriteUsr" value="<? echo $row['ebriteusr']; ?>" class="fieldStyle" /></td>
        </tr>
        <tr>
            <td><strong>API KEY</strong></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="text" name="eBriteApi" id="eBriteApi" value="<? echo $row['ebriteapi']; ?>" class="fieldStyle" />
            </td>
        </tr>
        
                    <tr>
                        <td colspan="2" align="left" class="adminHeader"><h2>Google Analytics</h2></td>
                    </tr>
                    <tr>
                        <td>
                         <select name="status" id="status" class="fieldStyle">
                            <option value=""  <? if($row['status'] == "") echo "selected"; ?>></option>
                            <option value="enable" <? if($row['status'] == "enable") echo "selected"; ?>>Enable</option>
                            <option value="disable" <? if($row['status'] == "disable") echo "selected"; ?>>Disable</option>
                         </select> 
                        </td>	 
                    </tr>
                    <tr>
                        <td><textarea name="code" cols="50" rows="20"><? echo $row['code']; ?> </textarea></td>
                    </tr>
                     <tr>
                        <td colspan="2" align="center"><a href="javascript:openURL('signupGoggleAnalytics.php')">Google Analytics SignUp Process</a><input type="submit" name="submit" id="submit" value="Save"/></td></tr>
                 </table>
            
            </td>
        	
            <td valign="top" width="50%">
            
            
            
            
      <table border="0" cellpadding="5" cellspacing="5" align="left" width="100%">
  
        <tr>
            <td class="adminHeader" colspan="2"><h2>Social Media Share</h2></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Allow Facebook and Twiiter Sharing</strong></td>
        </tr>
        
        <?PHP 
		$socialShare = $row['socialShare'];
		if ($socialShare =="" || $socialShare == "1"){
			$sChecked = 'checked="checked"';
		} else {
			$sUnChecked = 'checked="checked"';
		}
		?>
        <tr>
            <td><input type="radio" name="socialShare" id="socialShare" value="1" <?= $sChecked; ?> />Yes <input type="radio" name="socialShare" id="socialShare" value="0" <?= $sUnChecked; ?>  />No 
            
            <p>Facebook Id <input type="textbox" name="facebookId" id="facebookId" value="<?= $row['facebookId']; ?>" /></p>
            <p>Twitter Id <input type="textbox" name="twitterId" id="twitterId" value="<?= $row['twitterId']; ?>" /></p>
            
            </td>
        </tr>
  
  
  
        <tr>
            <td class="adminHeader" colspan="2"><h2>Formstack Information</h2></td>
        </tr>
        <tr>
            <td colspan="2"><strong>API Key</strong></td>
        </tr>
        <tr>
            <td><input type="text" name="FSapiKey" id="FSapiKey" value="<? echo $row['fStackAPIKey']; ?>" class="fieldStyle" /></td>
        </tr>
        <!--tr>
            <td class="adminHeader" colspan="2"><h2>Mailchimp Information</h2></td>
        </tr>
        <tr>
            <td><input type="radio" name="flagChimp" id="flagChimp" /> Use Mailchimp</td>
        </tr>
        <tr>
            <td colspan="2"><strong>API Key</strong></td>
        </tr>
        <tr>
            <td><input type="text" name="apiKey" id="apiKey" value="<? //echo $row['apiKey']; ?>" class="fieldStyle" /></td>
        </tr>
        <tr>
            <td><strong>List Id</strong></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="text" name="listId" id="listId" value="<? //echo $row['listId']; ?>" class="fieldStyle" />
            </td>
        </tr-->
        <tr>
        	<td>&nbsp;</td>
        </tr>
        
          <tr>
            <td class="adminHeader" colspan="2"><h2>Constant Contact Information</h2></td>
        </tr>
        <tr>
            <td><input type="radio" name="flagChimp" id="flagChimp" /> Use Constant Contact</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Login Id</strong></td>
        </tr>
        <tr>
            <td><input type="text" name="apiKey" id="apiKey" value="<? echo $row['ccLogin']; ?>" class="fieldStyle" /></td>
        </tr>
        <tr>
            <td><strong>Password</strong></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="text" name="listId" id="listId" value="<? echo $row['ccPassword']; ?>" class="fieldStyle" />
            </td>
        </tr>
        
        
        
        
        <tr>
            <td class="adminHeader" colspan="2"><h2>General Settings</h2></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Display My Mobi Manager Footer</strong></td>
        </tr>
        
        <?PHP 
		if ($displayFooter =="" || $displayFooter == "1"){
			$dfChecked = 'checked="checked"';
		} else {
			$dfUnChecked = 'checked="checked"';
		}
		?>
        <tr>
            <td><input type="radio" name="displayFooter" id="displayFooter" value="1" <?= $dfChecked; ?> />Yes <input type="radio" name="displayFooter" id="displayFooter" value="0" <?= $dfUnChecked; ?>  />No </td>
        </tr>
  
  
	 </table>
            
            
            </td>
        </tr>
     </table>
	 </form>

<?php
include("downpart.php");
?>