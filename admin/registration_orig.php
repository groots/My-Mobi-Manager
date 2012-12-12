<?php
include("dbcon.php");
error_reporting(5);
$message='';
$userType=$_GET['plan'];
$planid=$_GET['id'];


$couponname = (!empty($_GET['special'])) ? $_GET['special'] : "";
if($_POST['submit']) {	

	$email=$_POST['email'];
	if($email=="")
		$message=$message."Email could not be empty.<br>";
	$res=mysql_query("select Email from ".$projectName."user where Email='$email'");
	$countEmail=mysql_num_rows($res);
	if($countEmail==1) {
		$message=$message."This email address is already exist!";
	}
	$userName=$_POST['userName'];
	
	if($userName=="")
	$message=$message."User Name could not be empty.<br>";
	$rest=mysql_query("select Email from ".$projectName."user where Username='$userName'");
	$countName=mysql_num_rows($rest);
	
	if($countName==1) {
	$message=$message."This username is already exist!";
	}
	$firstName=$_POST['firstName'];
	if($firstName=="")
		$message=$message."First Name could not be empty.<br>";
	
	$lastName=$_POST['lastName'];
	if($lastName=="")
		$message=$message."Last Name could not be empty.<br>";
	$userType=$_POST['userType'];
	if($userType=="")
		$message=$message."User Type could not be empty.<br>";
	$planid=$_POST['planid'];
	if($planid=="")
		$message=$message."Plan id could not be empty.<br>";
	
	$resM=mysql_query("select planname from ".$projectName."plansettings where planname='$userType'");
	$checkuserType=mysql_num_rows($resM);
	if($checkuserType!=1) {
		$message=$message."This Membership type is not valid!<br>Please SIGNUP again.";
	}
	
	if (!ctype_alnum($userName)) {
  		// display error
		$message=$message."Username cannot contain special characters.<br>";	
	}  
	
	$company=$_POST['company'];
	if($company=="")
		$message=$message."Unique Web Id cannot be empty.<br>";
	
	$password=$_POST['password'];
	if($password=="")
		$message=$message."Password cannot be empty.<br>";
	
	$repassword=$_POST['repassword'];
	if($repassword=="")
		$message=$message."Retype password cannot be empty.<br>";
		
	$cCard=$_POST['cardNumber'];
	if($cCard=="")
		$message=$message."Card Number cannot be empty.<br>";
	
	$year = $_POST['card_expires_year'];
	$month = $_POST['card_expires_month'];
	
	$expr_date = $year . "-" . $month;
	
/*	
	$cWebsite=$_POST['cWebsite'];
	$cWebsite = strtolower($cWebsite);	
	//echo $website;
	if(!stristr($cWebsite,'http://')){
				$message=$message."Company Website must start with: http://<br>";
			
	}
	*/
/////// for discount coupon//////////
	
	$couponname=$_POST['couponname'];	
	
	$sqlforid="select * from ".$projectName."coupon where couponname='$couponname'";

	$resforid=mysql_query($sqlforid);
	$recordforid=mysql_fetch_array($resforid);
	$couponselect=mysql_num_rows($resforid);

	if($couponname!="" && $couponselect==0) {	
		$message=$message."Your coupon code is not valid!<br>";
	}
	
	$couponid=$recordforid['couponid'];
	$couponCount = $recordforid['count'];
/////// end of discount coupon//////////		
		if($password==$repassword){
			if($message==''){
				$randnumber=rand(111111, 999999);			
	
			   $sql_amt="SELECT planname, fee, Description FROM ".$projectName."plansettings WHERE planid='$planid' ";
			
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
				$totalprice=$totalprice - $discount;
				
			// Start Authorize.net
			include("subscription_create.php");
			// End Authorize.net
			
			
			if ($responseText == "Successful.") {
				$sqlin="INSERT INTO ".$projectName."user(Firstname, Lastname, Username, Email, Company, planidno, randnumber, Logo, ApplyDate, password, subscriptionId) VALUES('$firstName', '$lastName', '$userName', '$email', '$company', '$planid', '$randnumber', '', Now(), '$password', '$subscriptionId')";
			if(mysql_query($sqlin)){		
				
				//$randnumber=rand(111111, 999999);
				//  what is this? work need 1 sec but , I shall have to tell several time , right ? 
				$to="$email";
				$subject="Thank you for registering at $domainname";
				$message="Hello $firstName $lastName,
						 Welcome and thank you using My Mobi Mobi.  
						 To activate your account please click following link
						 http://$domainname/activation.php?u=$userName&randN=$randnumber
						 
						 If you have already activated your account, you can login at  http://$userName.$domainname/admin/login.php and create/manage your mobile pages. 
						
						If you have any questions, please contact us and fe 
						
						 Thank You,
						 George Roots
						 http://www.mymobimanager.com";		
				$headers .= 'From:  <support@mymobimanager.com>' . "\r\n";
				mail($to, $subject, $message, $headers);
				$userId=mysql_insert_id();
				
				$todays_date = date("Y-m-d"); 
				if($couponid>0){
					mysql_query("INSERT INTO ".$projectName."couponrdm(useridr, couponidr, dateUsed) VALUES('$userId','$couponid', '$todays_date')");
					$couponCount = $couponCount + 1;
					mysql_query("UPDATE ".$projectName."coupon SET count = $couponCount WHERE couponid = $couponid");
				}
			
		//// code for check payment/////////////////
				$totalprice=1;
				$sql_type="SELECT Userid, planidno FROM ".$projectName."user WHERE Userid='$userId'  ";
				$res_type=mysql_query($sql_type);
				$row=mysql_fetch_array($res_type);
				$planid=$row['planidno'];
			
				$sql_amt="SELECT planname, fee FROM ".$projectName."plansettings WHERE planid='$planid' ";
		
				$result=mysql_query($sql_amt);
				$rowa=mysql_fetch_array($result);
				$planname=$rowa['planname'];
				$totalprice=$rowa['fee'];
			  
		////end of code for check payment///////////
				if($totalprice <= 0) {
					header('Location: registrationdone.php');
				} else {
					$_SESSION['ID']=$userId;		
					header('Location: payment.php');
				}		
				
				$message="Registration successful, please check your email to activate your site.";		
				$email="";
				$userName="";
				$firstName="";
				$lastName="";
				$userName="";
				$userType="";
				$company="";
				$password="";
				$repassword="";
				$couponname="";
			
			} else {
				echo mysql_error();
				echo $sql3;
			}		
				
			if($countDC>0)
			{
				if($totalprice <= 0 )
				{
					?>
					<script type="text/javascript">
					window.location = "registrationdone.php"
					</script>
					<?
				}
			}		
					
			}
		
			
		}//end of if($message=='')
	
	} else {
		$message="Password do not match";
	}
}

$title = "My Mobi Manager Signup";
include("includes/header.php");
?>

<script src="javascript.js"></script>
<center>
<table>
	<tr>
    	<td><table width="100%" cellpadding="10" cellspacing="10">
        <tr>
            <td valign="middle" align="right">
              <img src="https://fifthfloor.mymobimanager.com/images/logo.png" style="margin-bottom: 20px;" width="350" border="0" /></td>
            <td valign="middle" align="left"><img src="https://fifthfloor.mymobimanager.com/images/securedIcon.png" /></td>
        </tr>
    </table>
<?php echo '<strong style="color: red;">' . $message . '</strong>'; ?>
<form action="registration.php" method="post" onsubmit="return validation_registration()">
    <table cellpadding="10" cellspacing="10" width="75%" border="2">
        <tr>
        <td style="border-right: medium #ccc solid; padding-right: 20px;" width="40%"><h4>Contact Information</h4>
            <table cellpadding="5" cellspacing="5">        
            <tr>
                <td>* First Name:  <br />
        			<input type="text" name="firstName" id="firstName" value="<?=$firstName?>" class="formField" /></td>
            </tr>
         
            <tr>
                <td>* Last Name:  <br />
        		<input type="text" name="lastName" id="lastName" value="<?=$lastName?>"  class="formField" /></td>
            </tr>
            <tr>
                <td>* Email:  <br />
                    <input type="text" name="email" id="email" value="<?=$email?>"  class="formField"/></td>
            </tr>
            <tr>
                <td>Company: <br />
                    <input type="text" name="company" id="company" value="<?=$company?>"  class="formField" /></td>
            </tr>        
        </table>
        <hr />
    <h4>Company Mobile Web Info</h4>
    <table cellpadding="5" cellspacing="5">
    <tr>
        <td>* Username:  
        <br />
        	<input type="text" name="userName" id="userName" value="<?=$userName?>" onblur="CheckUsername(this.value);"  class="formField" /> <div id="usernameresult"></div> </td>
    </tr>
            <tr>
                <td>* Password: <br />
        	<input type="password" name="password" id="password" value="<?=$password?>"  class="formField" /></td>
            </tr>
            <tr>
                <td>* Enter your password again:  <br />
        	<input type="password" name="repassword" id="repassword" value="<?=$repassword?>"  class="formField" /></td>
            </tr>
            </table>
            <hr />
            <table>
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
</table>
</td>
<tr>
	<td colspan="2">
<hr width="95%" align="left" />
	    <h2>Membership Details</h2></td>
</tr>
    <tr>
        <td>Membership: </td>
        <td><input disabled="disabled" type="text" name="userType" id="userType" value="<?=$userType?>" readonly="" class="formField" />
            <input type="hidden" name="userType" id="userType" value="<?=$userType?>" /></td>
    </tr>
	<tr>
		<td>If you have discount coupon <br /> then Enter coupon name: </td>
		<td><input type="text" name="couponname" id="couponname" value="<?=$couponname?>"  class="formField"/></td>
	</tr>
    <tr>
		<td colspan="2" align="center">
		<input type="hidden" name="planid" value="<?=$planid?>"/>
		<input type="submit" name="submit" value="Registration Complete!" class="formButton" /></td>
	</tr>
</table>
</form></td>
    	<td><!-- (c) 2005, 2011. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="2da29ba7-6100-4c00-bdf2-8a49f04429a5";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payments</a> </div> </td>
    </tr>
</table>
    

</center>

<?PHP 
	include("includes/footer.php");
?>
