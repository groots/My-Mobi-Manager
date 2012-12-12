<?php
	include("session_check.php");
	$pagetitle="Manage Subscription";
	$Userid=$_SESSION['ID'];
	
	
	$enc = md5(rand());
	$sql="SELECT * FROM mobilemanageruser_plan WHERE user_id = '$Userid'";
	$result=mysql_query($sql);
	$userplan_row=mysql_fetch_array($result);


	if($_POST['Submit'] == 'Update Subscription'){
		$package = $_REQUEST['package'];	
		$query   = "SELECT * FROM mobilemanager_plansettings WHERE planid='$package'";
		$res     = mysql_query($query);
		$row     = mysql_fetch_array($res);
		$planname= $row['planname'];
		$amount  = $row['fee'];
		$desc	 = $row['Description'];
		
		//$userplan= $userplan_row['fee'];
		//if($userplan<$amount)
			//$amount = $amount - $userplan ;
		
		include("subscription_update.php");
		
		$query 	 = "INSERT INTO  mobilemanager_temp VALUES('','$package','$enc','$Userid')";
		mysql_query($query);
		
		$updateUser = "UPDATE mobilemanager_user SET planidno = " . $_POST['planId'] . " WHERE Userid = '$Userid'";
		mysql_query($updateUser);
		header ("location: accountInfo.php");	

	} else if($_POST['submit'] == 'End Subscription') {
		include("subscription_cancel.php");
	} else if ($_POST['submit'] == ''){
		
	}
?> 

<script type="text/javascript">  
	function openURL(sURL) {
		window.open(sURL);
	}
</script> 

<?php
include("toppart.php");
?>

<?php


	$userQuery = "SELECT * FROM mobilemanager_user WHERE Userid = $Userid";
	$runQuery = mysql_query($userQuery);
	$storeData = mysql_fetch_array($runQuery);
	
	$fName = $storeData['Firstname'];
	$lName = $storeData['Lastname'];
	$subId = $storeData['subscriptionId'];
	$planId = $storeData['planidno'];
	
?>   

     <div id="boxes" > 
        <!-- #customize your modal window here --> 
        <div id="dialog1" class="window">
			<form action="managesubscription.php" method="post">        
                <table cellpadding="10" cellspacing="10">
                	<tr>
                    	<td>
                        
                            <h2>Cancel Subscription</h2>
                            Click the button below to cancel your account.  Your account will stay active until the end of your monthly cycle and you will not be charged again.  Be aware that if you choose to cancel your account, you may lose all data associated with your account.
                         </td>
                    </tr>     
                </table>
     			<input type="hidden" name="subId" value="<?= $subId; ?>" />
                <input type="submit" class="formButton" name="Submit" id="Submit" value="End Subscription" /> <input type="submit" class="formButton close" value="Cancel" />
		</form>
        </div>
         
        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
        <div id="mask"></div>
    </div>
	<form action="managesubscription.php" method="post">	
     
     <table width="100%" cellpadding="8" cellspacing="8">
     	<tr>
        	<td valign="top" width="50%">
                     
                        
                        	<input type="hidden" name="enc" value="<?php echo($enc);?>" />
                            <?php
							$query = "SELECT * FROM mobilemanager_plansettings";
							$res   = mysql_query($query);
							
							 ?>
                            <select id="package" name="package" class="fieldStyle">
                               <?php while($row = mysql_fetch_array($res)){
								   if ($row['planid'] == $planId) {
										$selected = 'selected="selected"';   
								   } else {
										$selected = '';   
								   }
								   
								   ?>
                                <option <?= $selected; ?> value="<?php echo($row['planid']);?>" <?php if($userplan_row['planid']==$row['planid']) echo("selected");?>><?php echo($row['planname']); ?> (<?php echo($row['fee']); ?>$)</option>
							   <?php } ?>
                            </select>
            </td>
          </tr>
          <tr>
            <td>* Card Number:  <br />
                <input type="text" name="cardNumber" id="cardNumber" value="<?=$cCard?>"  class="formField"/></td>
        </tr>
        <tr>
            <td>Expires On: <br />
                <select class="formField2" id="card_expires_month" name="card_expires_month">
    <option value="01">1 - January</option>
    <option value="02">2 - February</option>
    <option value="03">3 - March</option>
    <option value="04">4 - April</option>
    <option value="05">5 - May</option>
    <option selected="selected" value="06">6 - June</option>
    <option value="07">7 - July</option>
    <option value="08">8 - August</option>
    
    <option value="09">9 - September</option>
    <option value="10">10 - October</option>
    <option value="11">11 - November</option>
    <option value="12">12 - December</option>
    </select>
    <select class="formField2" id="card_expires_year" name="card_expires_year">
    <option selected="selected" value="2011">2011</option>
    <option value="2012">2012</option>
    <option value="2013">2013</option>
    <option value="2014">2014</option>
    
    <option value="2015">2015</option>
    <option value="2016">2016</option>
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
    <option value="2020">2020</option>
    <option value="2021">2021</option>
    <option value="2022">2022</option>
    <option value="2023">2023</option>
    
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
    </select></td>
        </tr>
        <tr>
        <td>
     <input type="hidden" name="fName" value="<?= $fName; ?>" />
     <input type="hidden" name="lName" value="<?= $lName; ?>" />
     <input type="hidden" name="planId" value="<?= $planId; ?>" />
     <input type="hidden" name="subId" value="<?= $subId; ?>" />
        		<input type="submit" class="formButton" value="Update Subscription" name="Submit" id="Submit" />
        </td>
        </tr>
     </table>
     <input type="hidden" name="fName" value="<?= $fName; ?>" />
     <input type="hidden" name="lName" value="<?= $lName; ?>" />
     <input type="hidden" name="planId" value="<?= $planId; ?>" />
     <input type="hidden" name="subId" value="<?= $subId; ?>" />
	 </form>
     
     <table>
     	<tr>
        	<td>
            </td>
        </tr>
     	<tr>
        	<td>
				<a href="#dialog1" name="modal" style="color: #F5C36D;">Cancel Your Subscription</a>                    
			</td>
        </tr>
    </table>

<?php
include("downpart.php");
?>