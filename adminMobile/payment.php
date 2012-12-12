<?php
include("session_check.php");
   $userid=$_SESSION['ID'];


   $sql_type="SELECT Userid,usertype FROM ".$projectName."user WHERE Userid='$userid'  ";
   $res_type=mysql_query($sql_type);
   $row=mysql_fetch_array($res_type);
   $type=$row['usertype'];


   $sql_amt="SELECT planname,fee FROM ".$projectName."plansettings WHERE planname='$type' ";
   //echo $sql_amt;
   $result=mysql_query($sql_amt);
   $rowa=mysql_fetch_array($result);
   $totalprice=$rowa['fee'];

   //$admin_licenses=107; 
     // $totalprice=426;
   
   $paypal="https://www.paypal.com/cgi-bin/webscr";
   $sandbox="https://www.sandbox.paypal.com/cgi-bin/webscr";
?>

<?php include("toppart.php"); ?>


   <h1><?=$type?></h1>
   <h2>$<?=$totalprice?>/month</h2>
  

<form action="<?=$paypal?>" method="post">

<input type="hidden" name="cmd" value="_xclick">

<input type="hidden" name="business" value="enggiqbal@gmail.com">

<input type="hidden" name="lc" value="US">

<input type="hidden" name="item_name" value="<?=$type?>">

<input type="hidden" name="item_number" value="<?=$admin_licenses?>">


<input type="hidden" name="amount" value="<?=$totalprice?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="products">

<input type="hidden" name="return" value="<?=$urlpaypal?>admin/payment.php">

<input type="hidden" id="" name="notify_url" value="<?=$urlpaypal?>admin/notifypayment.php?userid=<?=$userid?>">

<input type="hidden" name="cbt" value="Return to Site">
<input type="hidden" name="cancel_return" value="<?=$urlpaypal?>admin/payment.php">

<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<?php include("downpart.php"); ?>
