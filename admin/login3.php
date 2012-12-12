<?php
	include("dbcon.php");
	$pagetitle = "Login to My Mobi Manager";
	$pagetag = "America is the most inventive country in the world because everybody has access to information -Tom Clancy";
	$_SESSION['userName']="";
	$_SESSION['password']="";
	$_SESSION['ID']="";
	$_SESSION['paymentFlag']="";

if($_POST['submit'])
{
	$username=$_POST['username'];
	$password =$_POST['password'];
	$sql="SELECT Userid, userName, password, subscriptionId FROM ".$projectName."user WHERE userName ='$userName' AND password ='$password' AND active=1";
	$result=mysql_query($sql);  
	$record=mysql_fetch_array($result);
            
	if($password==$record['password'] && $userName==$record['userName']){		
		$_SESSION['password']=$record['password'];
		//$_SESSION['password']=$record['password'];
        $_SESSION['userName']=$record['userName'];
	   	$loggedinuserID=$record['Userid'];
	    $_SESSION['ID']=$record['Userid'];
	    $_SESSION['loggedinusertype']=$record['type'];
	   
//// code for check payment/////////////////
   		//$sql_type="SELECT Userid, planidno FROM ".$projectName."user WHERE Userid='$loggedinuserID' ";
   		//$res_type=mysql_query($sql_type);
   		//$row=mysql_fetch_array($res_type);
   		//$planid=$row['planidno'];
   		//$sql_amt="SELECT planname, fee, Description FROM ".$projectName."plansettings WHERE planid='$planid' ";
   		//$result=mysql_query($sql_amt);
   		//$rowa=mysql_fetch_array($result);
   		//$planname=$rowa['planname'];
  		//$totalprice=$rowa['fee'];
		//$desc = $rowa['Description'];
		
/////// discount calculation mizan/////////////
/*
	$sqlDC="select Userid, couponid, amount, useridr, couponidr, totalLogins from ".$projectName."user, ".$projectName."coupon, ".$projectName."couponrdm where Userid='$loggedinuserID' and useridr=Userid and couponid=couponidr";
	
	//echo "<br>".$sqlDC."<br>";
	
	$resDC=mysql_query($sqlDC);
	$countDC=mysql_num_rows($resDC);
	$rowDC=mysql_fetch_array($resDC);	
	$discount=$rowDC['amount'];
	$totalLogins = $rowDC['totalLogins'];
	$newTotal = $totalLogins + 1;
	if($countDC>0)
	{
		$totalprice=$totalprice - $discount;
	}
////// end of discount calculation mizan////////   
*/
		/*$today = date("m");
		$sqlpaycheck="select * from ".$projectName."paymenthistory where userid='$loggedinuserID' and month(paymentdate)='$today' and paymentamount!=''";
		
		$respaycheck=mysql_query($sqlpaycheck);
		$countforpay=mysql_num_rows($respaycheck);
		*/
		
	// Start Authorize.net
	
	
	
	$sqlAuth="select Userid, totalLogins, subscriptionId from ".$projectName."user WHERE Userid='$loggedinuserID'";
	$resAuth=mysql_query($sqlAuth);
	$rowAuth=mysql_fetch_array($resAuth);
	$authSubId = $rowAuth['subscriptionId'];
			
		if ($authSubId != "")  {
			include("subscription_get_status.php");	
			if ($subscriptionId == 'Successful.'){
					$updateUser = "UPDATE user SET totalLogins = $newTotal, timestamp = " . date('Y-m-d') . " WHERE Userid = $loggedinuserID"; 
				
					mysql_query($updateuser);
				//echo "hello roots";
					header("location: userHome.php");
					exit;
			} else {
				//$_SESSION['paymentFlag']=$countforpay;
				//header("location: ../payment.php");
				echo "hello brooklyn";
			}
		} else {
			
					$updateUser = "UPDATE user SET totalLogins = $newTotal, timestamp = " . date('Y-m-d') . " WHERE Userid = $loggedinuserID"; 				
					mysql_query($updateuser);
					ob_end_clean();
					header("location: userHome.php");
					//echo "here";
					exit;
		}
		
	} else {
		$errormessage=$errormessage . "Wrong Username or Password!";	
  	}
}// end of if($_POST['submit']) 

$showLogin = 'fish';
?>

<?php include("toppart.php"); ?>

<style>
body {
	background: url(images/bg-login.jpg) #F79A35 no-repeat;	
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;<!--PIC--></td>
</tr>

<tr><td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="450px;"   >
		<tr>
			<td valign="top" width="80%" align="left">
			<h4><?=$pageTitle?></h4>


<? if ($errormessage!=""){?>
<table  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="40px"><img src="error.PNG" /></td>
    <td class="redmessage" align="left" valign="middle"><?=$errormessage?></td>
  </tr>
</table>
<?}?>



<form action="login.php" method="post">
<table align="center">
	<tr>
    	<td style="background: url(images/login-left.jpg) no-repeat; height:417px; width: 451px; position:relative; margin-top: 18px;">
        
        </td>
        <td>
           <table align="left" class="generaltable" style="background: url(images/login.png); height:417px; width: 341px;">
            <tr style="height:90px;"><td >&nbsp;</td></tr>
            <tr style="position: relative; padding-bottom: 40px;"><td>UserName <br  /><input type="text" id="userName" name="userName" style="height: 40px; color: #036679; font-weight: bolder; font-size:18px; width: 250px; border: medium solid #036679;"></td></tr>
            <tr><td>Password <br  /><input type="password" id="password" name="password" style="height: 40px; width: 250px; border: medium solid #036679;"></td></tr>
            <tr>
            	<td><a href="/admin/forgotPass.php" >Forgot Password?</a></td>    
            </tr>
            <tr><td><input type="submit" name="submit" id="submit" value="Log-in!" style="background: #036679; height: 30px; width: 150px;"></td></tr>
</table>

        </td>
   </tr>
</table>
</form>

</td></tr></table>

<?php
include("downpart.php");
?>