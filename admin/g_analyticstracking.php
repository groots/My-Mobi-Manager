<?php
	include("session_check.php");
	$pagetitle="System Configuration";
	$Userid=$_SESSION['ID'];
	$siteId = $_SESSION['mobiId'];
	$pagetag = "Guess what?! I got a fever, and the only prescription...is more <a href='http://en.wikipedia.org/wiki/More_cowbell' target='_blank'>cowbell!!</a> - Bruce Dickinson";
	
	if($_POST['submit']){

		$status=addslashes($_POST['status']);
		$code=addslashes($_POST['code']);
		$sql3="SELECT * FROM mobilemanager_google_analytics WHERE mobiSiteId = '$siteId'";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
	
		$dhp = $_POST['dhp'];
		$csL = $_POST['extension'];
		$flagChimp = $_POST['flagChimp'];
		$apiKey = $_POST['apiKey'];
		$listId = $_POST['listId'];
		$fStack = $_POST['FSapiKey'];
		$ccLogin = $_POST['ccLogin'];
		$ccPassword = $_POST['ccPassword'];
		$mChimpKey = $_POST['mChimpKey'];
		$mChimpListID = $_POST['mChimpListID'];
		$ebriteapi = $_POST['eBriteApi'];
		$ebriteusr = $_POST['eBriteUsr']; 
		$socialShare = $_POST['socialShare'];
		$displayFooter = $_POST['displayFooter'];
		$displaySearch = $_POST['displaySearch'];
		$facebookId = $_POST['facebookId'];
		$twitterId = $_POST['twitterId'];
		if($chkCustomTitle == 1){
			$cusSiteName = $_POST['newSiteTitle'];
		} else {
			$cusSiteName = "";	
		}
		//Mailchimp integration
		
		//Google Analytics
		if($row3['mobiSiteId'] != "") {
			$sqlUp="UPDATE ".$projectName."google_analytics SET status ='".$status."',code='".$code."',fStackAPIKey='".$fStack."',ebriteusr='". $ebriteusr . "',ccLogin='" . $ccLogin ."' ,ccPassword='" . $ccPassword ."' ,mChimpKey='" . $mChimpKey ."' ,socialShare='" . $socialShare ."' ,facebookId ='".$facebookId."',twitterId ='".$twitterId."',serverLanguage ='".$csL."',indexPageName='".$dhp."',displayFooter='".$displayFooter."',includeSearch='".$displaySearch."',customSiteTitle='".$cusSiteName."' WHERE mobiSiteId = '$siteId' ";

//echo $sqlUp; 
//exit;
			mysql_query($sqlUp);		
			$successmessage="Update Successfully";
		} else {
			$sql="INSERT INTO ".$projectName."google_analytics (mobiSiteId,status,ebriteusr,code,fStackAPIKey,ccLogin,ccPassword,mChimpKey,socialShare,facebookId, twitterId, serverLanguage,indexPageName,displayFooter,includeSearch,customSiteTitle) values('$siteId','$status','$ebriteusr','$code','$fStack','$ccLogin','$ccPassword','$mChimpKey','$socialShare','$facebookId','$twitterId','$csL','$dhp','$displayFooter','$displaySearch','$cusSiteName')";
			
			mysql_query($sql);			
		}
	
	}
		
	$sql="SELECT * FROM mobilemanager_google_analytics WHERE mobiSiteId = '$siteId' ";
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
     
     
<table align="right" width="1000px" style="z-index:100000; position: relative;">            
    <tr align="right">
    <td align="right"><input type="submit" name="submit" id="submit" class="formButton" value="Save"/> <input type="submit" name="applyPage" class="formButton" value="Apply"/> <input type="submit" name="cancelPage" class="formButton" value="Cancel"/>
    <input type="hidden" name="idForEdit" value="<?=$id?>"/>
    </td>
    
    </tr>
</table>
<br />
<br />
<br />
<div style="display: block ">
     <ul class="tabs">
         <li><a href="#first-tab"><span>Analytics</span></a></li>
         <li><a href="#second-tab"><span>Email Marketing</span></a></li>
         <li><a href="#third-tab"><span>Social</span></a></li>
         <li><a href="#fourth-tab"><span>Forms and Events</span></a></li>
         <li><a href="#fifth-tab"><span>Advanced</span></a></li>
     </ul>
     <div class="panes">
         <div class="hide">
            <table>
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
                            <td><textarea name="code" cols="50" rows="12"><? echo $row['code']; ?> </textarea></td>
                        </tr>
                         <tr>
                            <td colspan="2" align="center"><a href="javascript:openURL('signupGoggleAnalytics.php')">Google Analytics SignUp Process</a></td></tr>
            
            </table>
         </div>
         
         <div class="hide">
            <table>
                <tr>
                    <td colspan="2"><h2>Mailchimp Information (BETA)</h2></td>
                </tr>
                <!--tr>
                    <td><input type="checkbox" name="flagChimp" id="flagChimp" /> Use Mailchimp</td>
                </tr-->
                <tr>
                    <td colspan="2"><strong>API Key</strong></td>
                </tr>
                <tr>
                    <td><input type="text" name="mChimpKey" id="mChimpKey" value="<? echo $row['mChimpKey']; ?>" class="fieldStyle" />
                    <br /> <a href="https://admin.mailchimp.com/account/api-key-popup" target="_blank">Find your Mailchimp API KEY</a></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                
                  <tr>
                    <td class="adminHeader" colspan="2"><h2>Constant Contact Information</h2></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="flagChimp" id="flagChimp" /> Use Constant Contact</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Login Id</strong></td>
                </tr>
                <tr>
                    <td><input type="text" name="ccLogin" id="ccLogin" value="<? echo $row['ccLogin']; ?>" class="fieldStyle" /></td>
                </tr>
                <tr>
                    <td><strong>Password</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="ccPassword" id="ccPassword" value="<? echo $row['ccPassword']; ?>" class="fieldStyle" />
                    </td>
                </tr>             
                
            </table>
         </div>
         <div class="hide">
            <table>
                <tr>
                <td colspan="2"><strong>Allow Facebook and Twitter Sharing</strong></td>
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
            
            </table>
         </div>
         
         <div class="hide">
            <table>    
            <tr>
                <td class="adminHeader" colspan="2"><h2>Formstack Information</h2></td>
            </tr>
            <tr>
                <td colspan="2"><strong>API Key</strong></td>
            </tr>
            <tr>
                <td><input type="text" name="FSapiKey" id="FSapiKey" value="<? echo $row['fStackAPIKey']; ?>" class="fieldStyle" /></td>
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
            </table>
         </div>
         <div  class="hide">
            <table>
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
                            <td colspan="2"><strong>Display Search</strong></td>
                        </tr>
                        
                        <?PHP 
                        if ($displaySearch =="" || $displaySearch == "1"){
                            $dsChecked = 'checked="checked"';
                        } else {
                            $dsUnChecked = 'checked="checked"';
                        }
                        ?>
                        <tr>
                            <td><input type="radio" name="displaySearch" id="displaySearch" value="1" <?= $dsChecked; ?> />Yes <input type="radio" name="displaySearch" id="displaySearch" value="0" <?= $dsUnChecked; ?>  />No </td>
                        </tr>
        
                        <?PHP 
                            if ($row['customSiteTitle'] =="" ){
                                $csChecked = '';
                            } else {
                                $csChecked = 'checked="checked"';
                            }
                        ?>
                        <tr>
                            <td colspan="2"><strong>Display Custom Site Title</strong></td>
                        </tr>
    
                        <tr>
                            <td><input type="checkbox" name="chkCustomTitle" id="chkCustomTitle" value="1" <?= $csChecked; ?> />
                            <input type="text" id="newSiteTitle" name="newSiteTitle" value="<?= $row['customSiteTitle']; ?>" /></td>
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
         </div> 
    </div>     
</div>        
	 </form>
<script>
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>

<?php
include("downpart.php");
?>