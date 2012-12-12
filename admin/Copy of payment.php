<?php
	include("dbcon.php");
	include("includes/header.php");

	$userid=$_SESSION['ID'];
	$userName=$_SESSION['userName'];
	echo "username - " . $userid;
	$paymentFlag=$_SESSION['paymentFlag'];
	//echo "session pay flag : ".$_SESSION['paymentFlag']."<br>";
	if($paymentFlag==0)
		echo "Please give your payment for login for this month."; 
	else
		echo "Registration successful, please check your email to active your site.";
	if($userid=="")
	{
		include("./admin/session_check.php");
	}


   $sql_type="SELECT Userid, planidno FROM ".$projectName."user WHERE Userid='$userid'  ";
   $res_type=mysql_query($sql_type);
   $row=mysql_fetch_array($res_type);
   $planid=$row['planidno'];


   $sql_amt="SELECT planname, fee, Description FROM ".$projectName."plansettings WHERE planid='$planid' ";
   //echo $sql_amt;
   $result=mysql_query($sql_amt);
   $rowa=mysql_fetch_array($result);
   $planname=$rowa['planname'];
   $totalprice=$rowa['fee'];
   $desc = $rowa['Description'];
   
/////// discount calculation mizan/////////////

	$sqlDC="select Userid, couponid, amount, useridr, couponidr from ".$projectName."user, ".$projectName."coupon, ".$projectName."couponrdm where Userid='$userid' and useridr=Userid and couponid=couponidr";

	//echo "<br>".$sqlDC."<br>";
	
	$resDC=mysql_query($sqlDC);
	$countDC=mysql_num_rows($resDC);
	$rowDC=mysql_fetch_array($resDC);
	
	$discount=$rowDC['amount'];
	
	if($countDC>0)
	{
	$totalprice=$totalprice - $discount;
		if($totalprice <= 0 )
		{
			?>
			<script type="text/javascript">
			window.location = "registrationdone.php"
			</script>
			<?
		}
	}
	
	////// end of discount calculation mizan////////   
	   
	
	   //$admin_licenses=107; 
		 // $totalprice=426;
	$sql_email="SELECT value FROM ".$projectName."setting";
	$res_email=mysql_query($sql_email);
	$rowemail=mysql_fetch_array($res_email);
	$email=$rowemail['value'];
	// $email=  "enggiq_1272170141_biz@gmail.com";
	   $paypal="https://www.paypal.com/cgi-bin/webscr";
	   $sandbox="https://www.sandbox.paypal.com/cgi-bin/webscr";
	?>
	
	<?php include("toppart.php"); ?>
	
	
	   <h1><?=$planname?></h1>
	   <br />
	   <h2><?= $desc; ?></h2>
	   <h2>$<?=$totalprice?>/month</h2>
	  
	<form name="_xclick" action="<?=$paypal?>" method="post">
	<input type="hidden" name="item_name" value="<?=$planname?>">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="<?=$email?>">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="no_shipping" value="1">
	<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	<input type="hidden" name="a3" value="<?=$totalprice?>">
	<input type="hidden" name="return" value="<?='http://'.$domainname.'/thankyou.php'?>"/>
	<input type="hidden" id="" name="notify_url" value="<?='http://www.'.$domainname.'/notifypayment.php'?>?userid=<?=$userid?>"/>
	<input type="hidden" name="cancel_return" value="<?='http://'.$domainname.'/payment.php'?>"/>
	
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="sra" value="1">
	</form>
	
	<!--
	<form action="<?=$paypal?>" method="post">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?=$email?>">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="item_name" value="<?=$type?>">
	<input type="hidden" name="amount" value="<?=$totalprice?>">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="button_subtype" value="products">
	<input type="hidden" name="return" value="<?='http://'.$domainname.'/thankyou.php'?>"/>
	<input type="hidden" id="" name="notify_url" value="<?='http://'.$domainname.'/notifypayment.php'?>?userid=<?=$userid?>"/>
	<input type="hidden" name="cancel_return" value="<?='http://'.$domainname.'/payment.php'?>"/>
	
	<input type="hidden" name="cbt" value="Return to Site">
	<input type="hidden" name="cancel_return" value="<?='http://'.$domainname.'/payment.php'?>"/>
	<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	-->

<?php include("downpart.php"); ?>
