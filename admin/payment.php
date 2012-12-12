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
	?>
	
	<?php include("toppart.php"); ?>
	
        
        <h1><?=$planname?></h1>
        <br />
        <h2><?= $desc; ?></h2>
        <h2>$<?=$totalprice?>/month</h2>
	  
	<?php include("downpart.php"); ?>
