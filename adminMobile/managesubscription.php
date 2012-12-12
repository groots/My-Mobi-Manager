<?php
	include("session_check.php");
	$pagetitle="Manage Subscription";
	$Userid=$_SESSION['ID'];
	
	
	$enc = md5(rand());
	$sql="SELECT * FROM mobilemanageruser_plan WHERE user_id = '$Userid'";
	$result=mysql_query($sql);
	$userplan_row=mysql_fetch_array($result);
	
	$sql="SELECT * FROM mobilemanager_setting LIMIT 1";
	$paypal_re=mysql_query($sql);
	$paypal_row=mysql_fetch_array($paypal_re);	
	$paypal_id = $paypal_row['value']; 
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
	if($_POST['submit']){
		$package = $_REQUEST['package'];	
		$query   = "SELECT * FROM mobilemanager_plansettings WHERE planid='$package'";
		$res     = mysql_query($query);
		$row     = mysql_fetch_array($res);
		$planname= $row['planname'];
		$amount  = $row['fee'];
		$desc	 = $row['Description'];
		require_once('paypal.class.php');  
		$enc 	 = $_REQUEST['enc']; 
		$userplan= $userplan_row['fee'];
		if($userplan<$amount)
			$amount = $amount - $userplan ;
		$query 	 = "INSERT INTO  mobilemanager_temp VALUES('','$package','$enc','$Userid')";
		mysql_query($query);

		$p = new paypal_class;             
		//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   
		$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
		// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$this_site	 = 'http://'.$_SERVER['HTTP_HOST']."/squishdev/admin/";
		$success_script = $this_site.'success.php?enc='.$enc;
		$cancel_script  = $this_site.'cancel.php?enc='.$enc;
		$p->add_field('business', $paypal_id);
		$p->add_field('return', $success_script);
		$p->add_field('currency_code','USD');
		$p->add_field('cancel_return', $cancel_script);
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('item_name', $planname);
		//$p->add_field('amount', $amount);
		$p->add_field('cmd', '_xclick-subscriptions');		
		$p->add_field('a3', $amount);		
		$p->add_field('no_shipping', '1');		
		$p->add_field('p3', '1');		
		$p->add_field('t3', 'M');				
		$p->add_field('src', '1');				
		$p->add_field('sra', '1');				
		//$p->dump_fields();
		$p->submit_paypal_post(); 	
	}

?>   

	<form action="" method="post">	
     
     <table width="100%" cellpadding="8" cellspacing="8">
     	<tr>
        	<td valign="top" width="50%">
            
                 <table border="0" cellpadding="5" cellspacing="5" align="left" width="100%">
                    <tr>
                        <td class="adminHeader" colspan="2"><h2>Package Detail</h2><?php if($userplan_row['planid']=="") echo("You are not subscribed yet"); else{ $qu = "SELECT * FROM mobilemanager_plansettings WHERE planid='".$userplan_row['planid']."'"; $r =mysql_fetch_array(mysql_query($qu)); echo("Current Selected Package: ".$r['planname']);} ?></td>
                    </tr>
                    <tr>
                        <td><strong>Select Package </strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                     
                        
                        	<input type="hidden" name="enc" value="<?php echo($enc);?>" />
                            <?php
							$query = "SELECT * FROM mobilemanager_plansettings";
							$res   = mysql_query($query);
							
							 ?>
                            <select id="package" name="package" class="fieldStyle">
                               <?php while($row = mysql_fetch_array($res)){?>
                                <option value="<?php echo($row['planid']);?>" <?php if($userplan_row['planid']==$row['planid']) echo("selected");?>><?php echo($row['planname']); ?> (<?php echo($row['fee']); ?>$)</option>
							   <?php } ?>
                            </select>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Subscribe"/></td></tr>
                 </table>
            
            </td>
          </tr>
     </table>
	 </form>

<?php
include("downpart.php");
?>