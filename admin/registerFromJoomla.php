<?PHP
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
			
				$sqlDC="select amount from ".$projectName."coupon where couponid=$couponid";
			
				
				$resDC=mysql_query($sqlDC);
				$countDC=mysql_num_rows($resDC);
				$rowDC=mysql_fetch_array($resDC);
				
				$discount=$rowDC['amount'];
				$totalprice=$totalprice - $discount;
			if ($totalprice > 0){
				// Start Authorize.net
				include("subscription_create.php");
				// End Authorize.net
			} else {
				$passThru = 1;	
			}
	
			if ($responseText == "Successful." || $passThru == 1) {
				$sqlin="INSERT INTO ".$projectName."user(Firstname, Lastname, Username, Email, Company, planidno, randnumber, Logo, ApplyDate, password, subscriptionId) VALUES('$firstName', '$lastName', '$userName', '$email', '$company', '$planid', '$randnumber', '', Now(), '$password', '$subscriptionId')";
			if(mysql_query($sqlin)){		
				if($planid == 3){ 	
					$sqlGetLast = "SELECT * FROM mobilemanager_user WHERE Username = '$userName'";	
					$lastInput=mysql_query($sqlGetLast);  
					$inputRecord=mysql_fetch_array($lastInput);
					$newSiteId = $inputRecord['subscriptionId'];
					$userId = $inputRecord['Userid'];
					$sqlCreateSite = "INSERT INTO ".$projectName."moSiteInfo (siteId, userId, SiteName, active) VALUES ($newSiteId, $userId, '" .$_POST['siteName'] . "', '1')";
					mysql_query($sqlCreateSite);
					mysql_query("UPDATE mobilemanager_user SET siteAccess = '$newSiteId' WHERE Username = '$userName'");
				} else {
					
				}
				
				//$randnumber=rand(111111, 999999);
				
				$to="$email";
				$subject="Thank you for registering at $domainname";
				$message="Hello $firstName $lastName,
						 Welcome and thank you using My Mobi Mobi.  Your one month trial begins today.  We will send you an email before your trial is over to let you know when your card will be charged.
						 <br>
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
			  	if (headers_sent()) {
					$_SESSION['success']= 'yes';
				}
					
		////end of code for check payment///////////
				if($totalprice <= 0) {
					?>
					<script type="text/javascript">
						window.location = "registrationdone.php"
					</script>
                    
                    <?
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
					
					<?
				}
			}		
					
			}
			
		}//end of if($message=='')
	
	} else {
		$message="Password do not match";
	}}
	echo $message;
?>