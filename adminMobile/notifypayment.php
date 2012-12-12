<?php
include("session_check.php");
//$userid=$_SESSION['ID'];
$userid=$_GET['userid'];
$payment_amount = $_POST['mc_gross'];
$sqlpaypal="INSERT INTO ".$projectName."paymenthistory(userid,paymentamount,paymentdate) VALUES('$userid','$payment_amount',NOW())";
mysql_query($sqlpaypal);

 
 //mysql_query("insert into test(testtime,sqlstring) values(NOW(),'In Notify Payment')");
 //mysql_query("insert into testpaypal values('0sdfsdf')");
//$url = 'https://www.paypal.com/cgi-bin/webscr';
$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$postdata = '';
foreach($_POST as $i => $v) 
	{
	$postdata .= $i.'='.urlencode($v).'&amp;';
	}
$postdata .= 'cmd=_notify-validate';

$web = parse_url($url);
if ($web['scheme'] == 'https')
	{
	$web['port'] = 443;
	$ssl = 'ssl://';
	}
  else {
	$web['port'] = 80;
	$ssl = '';
	}
$fp = @fsockopen($ssl.$web['host'], $web['port'], $errnum, $errstr, 30);
 
if (!$fp) 
	{
	echo $errnum.': '.$errstr;
	} 
	else {
	fputs($fp, "POST ".$web['path']." HTTP/1.1\r\n");
	fputs($fp, "Host: ".$web['host']."\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $postdata . "\r\n\r\n");

	while(!feof($fp))
		{
		$info[] = @fgets($fp, 1024);
		}
	fclose($fp);
	$info = implode(',', $info);
	$item_number = $_POST['item_number'];
	$payment_status=$_POST['payment_status'];	
	$amount = $_POST['amount'];
	if (eregi('VERIFIED', $info)) 
		{
/////////////////$sql="select * from licenseprice  where description='license' ";
//////////////////////////$result=mysql_query($sql);
////////////////////////////$row=mysql_fetch_array($result);
/////////////////////////////////////////$totalprice=$row["price"];
		// yes valid, f.e. change payment status
		////////////////if($amount==$totalprice)
		/////////////////////////////////mysql_query("update playerlicense set status='active' where id=$item_number ");
		} 
	//   else 
	//   	{
		// invalid, log error or something
		//}



if($_POST["cmd"]!='_notify-validate')
   {
    // read the post from PayPal system and add 'cmd'
   $req = 'cmd=_notify-validate';

   foreach ($_POST as $key => $value) 
        {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
		}

   // post back to PayPal system to validate
   $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
   $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
   $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

   $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
   //$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
   }

// assign posted variables to local variables

//$userid = $_POST['userid'];

$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];

$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];






if (!$fp) 
   {
   // HTTP ERROR
   } 
  else 
    {
    fputs ($fp, $header . $req);
    while (!feof($fp)) 
	      {
          $res = fgets ($fp, 1024);
          if (strcmp ($res, "VERIFIED") == 0) 
             {  ///////////////*****************************************88888------------
             //mysql_query("insert into test(testtime, sqlstring)  values(NOW(),' it is ok 2')  ");
             $licenses=split("[,]",$item_number); 
             $adminid=$licenses[0];
             $duration=$licenses[1];
             if($duration==0) $duration=" 1 MONTH ";
               else if($duration==1) $duration=" 3 MONTH ";
                 else if($duration==2) $duration=" 6 MONTH ";
                   else if($duration==3) $duration=" 1 YEAR ";
             for($i=2;$i<count($licenses);$i++)
                { $licensenumber=$licenses[$i];
				$result=mysql_query("select status from playerlicense  where licensenumber='$licensenumber' and adminid='$adminid'  ");
				$row=mysql_fetch_array($result);
				$licensestatus=$row["status"];
				if($licensestatus=='active')
                   {   $sql="update playerlicense set enddate=DATE_ADD(enddate, INTERVAL ". $duration ." ) , status='active'  where licensenumber='$licensenumber' and adminid='$adminid'  "  ;
				   }
				   else
				      {
					  $result=mysql_query("select timezone from users where userid='$adminid'   ");
					  $row=mysql_fetch_array($result);
  					  $timeZoneDiff=$row["timezone"]+7;
					  $timeZoneDiffStr=$timeZoneDiff.':0:0';
					   $sql="update playerlicense set startdate=ADDTIME( NOW() , '$timeZoneDiffStr' ),enddate=DATE_ADD(ADDTIME( NOW() , '$timeZoneDiffStr' ), INTERVAL ". $duration ." ) , status='active'  where licensenumber='$licensenumber' and adminid='$adminid'  "  ;
					  }
                mysql_query($sql);
				//$sql=addslashes($sql);
                //mysql_query("insert into test(testtime, sqlstring)  values(NOW(),'$sql')  ");
                }
              }
          // check the payment_status is Completed
          // check that txn_id has not been previously processed
          // check that receiver_email is your Primary PayPal email
          // check that payment_amount/payment_currency are correct
          // process payment
          //}
          else if (strcmp ($res, "INVALID") == 0) 
		  	 {
			 // log for manual investigation
			 }
 		 }
   fclose ($fp);
   }
}