<?php
include("../dbcon.php");
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
	  
	
	$sql="SELECT Userid, userName, password FROM ".$projectName."user WHERE userName ='$userName' AND password ='$password' AND active=1";
	$result=mysql_query($sql); 
 
	$record=mysql_fetch_array($result);



            
	if($password==$record['password'] && $userName==$record['userName'])
        
	{
	
		$_SESSION['password']=$record['password'];
		//$_SESSION['password']=$record['password'];
        $_SESSION['userName']=$record['userName'];
	   	$loggedinuserID=$record['Userid'];
		
	    $_SESSION['ID']=$record['Userid'];
		
	    $_SESSION['loggedinusertype']=$record['type'];
	   
//// code for check payment/////////////////

		//$totalprice=1;

   		$sql_type="SELECT Userid, planidno FROM ".$projectName."user WHERE Userid='$loggedinuserID' ";
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
   
   		//echo "total price : ".$totalprice;
      

////end of code for check payment///////////


/// CODE FOR BUG SOLVE BY MIZAN DATE - 31.05.10////////////

/*

   $sql_type="SELECT Userid, planidno FROM ".$projectName."user WHERE Userid='$userid'  ";
   $res_type=mysql_query($sql_type);
   $rowforBug=mysql_fetch_array($res_type);
   $planidforBug=$rowforBug['planidno'];


   $sql_amt="SELECT planname, fee, Description FROM ".$projectName."plansettings WHERE planid='$planidforBug' ";
   //echo $sql_amt;
   $resultforBug=mysql_query($sql_amt);
   $rowa=mysql_fetch_array($resultforBug);
   $planname=$rowa['planname'];
   $totalprice=$rowa['fee'];
   $desc = $rowa['Description'];     */
   
/////// discount calculation mizan/////////////

$sqlDC="select Userid, couponid, amount, useridr, couponidr from ".$projectName."user, ".$projectName."coupon, ".$projectName."couponrdm where Userid='$loggedinuserID' and useridr=Userid and couponid=couponidr";

//echo "<br>".$sqlDC."<br>";

$resDC=mysql_query($sqlDC);
$countDC=mysql_num_rows($resDC);
$rowDC=mysql_fetch_array($resDC);

$discount=$rowDC['amount'];

if($countDC>0)
{
$totalprice=$totalprice - $discount;
//	if($totalprice <= 0 )
}
////// end of discount calculation mizan////////   
///END OF CODE FOR BUG SOLVE BY MIZAN DATE - 31.05.10//////
		$today=date("m");

		$sqlpaycheck="select * from ".$projectName."paymenthistory where userid='$loggedinuserID' and month(paymentdate)='$today' and paymentamount!=''";
		//echo $sqlpaycheck;
		$respaycheck=mysql_query($sqlpaycheck);
		$countforpay=mysql_num_rows($respaycheck);
		//echo "<br> count is : ".$countforpay;


//mizxan, let me see your code me: this is the code of login page. 
//will it wiork? me : yea. but I want to check all conditions.
			if(($totalprice>0) && ($countforpay==0)) {
				$_SESSION['paymentFlag']=$countforpay;
				header("location: ../payment.php");
			} else {
				header("location: userHome.php");
			}

/*

			if(($totalprice==0) && ($countforpay==0))//for free
			{
			
			header("location: userHome.php");
			}
			elseif($countforpay==0)
			{
			$_SESSION['paymentFlag']=$countforpay;
			header("location: ../payment.php");
			}
			elseif(($countDC>0) && ($totalprice <= 0))
			{
			header("location: userHome.php");
			}
			
			else
			{
			header("location: userHome.php");
			}
   */
	}
	else // for if($password==$record['password'] && $userName==$record['userName'])
	{
  	//echo "Wrong Username or Password";
	$errormessage=$errormessage . "Wrong Username or Password!";	
  	}


}// end of if($_POST['submit']) 

$showLogin = 'fish';
?>

<?php include("toppart.php"); ?>

<style>
body { 
}
</style>
<table border="0" cellspacing="0" cellpadding="0">
<tr><td>&nbsp;<!--PIC--></td>
</tr>

<tr><td>
	<table  border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td valign="top" width="80%" align="left"> 


<? if ($successmessage!=""){?>
<table  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="40px"><img src="success.PNG" /></td>
    <td class="greenmessage" align="left" valign="middle"><?=$successmessage?></td>
  </tr>
</table>
<?}?>

<? if ($errormessage!=""){?>
<table  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="40px"><img src="error.PNG" /></td>
    <td class="redmessage" align="left" valign="middle"><?=$errormessage?></td>
  </tr>
</table>
<? } ?>



<form action="login.php" method="post">
<table align="center">
	<tr> 
        <td>
           <table align="left" > 
            <tr style="position: relative; padding-bottom: 30px;"><td>UserName <br  /><input type="text" id="userName" name="userName" style="height: 30px; color: #036679; font-weight: bolder; font-size:18px; width: 250px; border: medium solid #036679;"></td></tr>
            <tr><td>Password <br  /><input type="password" id="password" name="password" style="height: 30px; width: 250px; border: medium solid #036679;"></td></tr>
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