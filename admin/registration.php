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
	
	//exit;
//echo $responseText;			
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
	}
}

$title = "My Mobi Manager Signup";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Mobi Manager Registration</title>
<link href="mobiStyle.css" rel="stylesheet" type="text/css" />
<link href="mobiLayout.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body id="page_1" onLoad="MM_preloadImages('images/m_1_hov.gif','images/m_2_hov.gif','images/m_3_hov.gif','images/m_4_hov.gif','images/m_5_hov.gif')">
<div class="main">
	<!--header -->
	<div id="header">
		<div class="column">
			<a href="index.html"><img src="images/logo.png" alt="" border="0" /></a><br /> 
		</div>
		<div class="column_1">
			
			<div class="indent">
				<a href="http://www.facebook.com/pages/My-Mobi-Manager/#!/pages/My-Mobi-Manager/124497074251188?ref=search" target="_blank"><img src="images/facebook.png" alt="follow us on Facebook" /></a>   <a href="http://www.twitter.com/mymobimanager" target="_blank"><img src="images/twitter_logo_header.png" alt="follow us on Twitter" /></a>
			</div>
        </div>
		<div class="clear"></div>
	</div>
	<!--header end-->
</div>
<!--header -->
<div id="header_1">
	<div class="main">
	<div class="indent">
	<a href="http://mymobimanager.com/index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','images/m_1_hov.gif',1)"><img src="images/m_1.gif" alt=" " name="Image2" width="151" height="61" border="0" id="Image2" /></a><a href="http://mymobimanager.com/mobileFeatures.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','images/m_2_hov.gif',1)"><img src="images/m_2.gif" alt=" " name="Image3" width="113" height="61" border="0" id="Image3" /></a><img src="images/m_3_hov.gif" alt=" " width="114" height="61" border="0" id="Image4" /><a href="http://mymobimanager.com/mobileBlog.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','images/m_4_hov.gif',1)"><img src="images/m_4.gif" alt=" " name="Image5" width="112" height="61" border="0" id="Image5" /></a><a href="http://mymobimanager.com/myMobiContact.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','images/m_5_hov.gif',1)"><img src="images/m_5.gif" alt=" " name="Image6" width="169" height="61" border="0" id="Image6" /></a><br /> 
	</div>
	<div class="column">
		<div class="indent">
			<a href="#"><img src="images/banner.jpg" alt="" border="0" /></a><br /> 
		</div>
	</div>
	<div class="column_1">
		<div class="indent txt">
			<div class="h"><img src="images/2_h_1.gif" alt="" /></div>
			<strong>We love adding more features.</strong> To give your company as much power and flexibility to have the mobile webiste you want, we have a large list of features and we are dedicated to adding more options as well. We value integrating our system with already proven online tools, read below to learn more.<br />
			<div class="right"><br /></div> 
		</div>
	</div>
	<div class="clear"></div>
	</div>
</div>
<!--header end-->
<div id="wrapper">
	<div class="main">
		<div class="indent">
			<!--content -->
				<div class="column">
					<div class="indent t">
						<div class="h"><img src="images/signUpBanner.gif" alt="" /></div>
							<div class="side_left">
								<div class="side_right">
									<div class="side_top">
										<div class="side_bot">
											<div class="left_top">
												<div class="right_top">
													<div class="left_bot">
														<div class="right_bot">
															<div class="indent txt_2">
																<div class="block_3">
<?php

?>

<script src="javascript.js"></script>
<center>
<?php echo '<strong style="color: red;">' . $message . " " . $responseText . '</strong>'; ?>
<form action="registration.php" method="post" onSubmit="return validation_registration()" style="font-size:13px;">
    <table cellpadding="10" cellspacing="5" width="100%">
        <tr>
        <td style="padding-right: 20px;" width="100%"><h1>Contact Information</h1>
        <br />
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
        <br />
    <h1>Company Mobile Web Info</h1>
    <br />
    <table cellpadding="5" cellspacing="5">
    <tr>
        <td>* Username:  
        <br />
        	<input type="text" name="userName" id="userName" value="<?=$userName?>" onBlur="CheckUsername(this.value);"  class="formField" /> <div id="usernameresult"></div> </td>
    </tr>    
    <tr>
        <td>* Password: <br />
    <input type="password" name="password" id="password" value="<?=$password?>"  class="formField" /></td>
    </tr>
    <tr>
        <td>* Enter your password again:  <br />
    <input type="password" name="repassword" id="repassword" value="<?=$repassword?>"  class="formField" /></td>
    </tr>
    <? if ($planid == 3){ ?>
		
    <tr>
        <td>* Site name:  
        <br />
        	<input type="text" name="siteName" id="siteName" value="<?=$userName?>" onBlur="CheckSitename(this.value);"  class="formField" /> <div id="sitenameresult"></div> </td>
    </tr>
    <? } ?>
    
    </table>
    <hr />
    <table>
	<tr>
		<td>* Card Number:  <br />
        	<input type="text" name="cardNumber" id="cardNumber" value="<?=$cCard?>"  class="formField"/></td>
	</tr>
	<tr>
		<td>Expires On: <br />
        	<select class="formField2" id="card_expires_month" name="card_expires_month" style="font-size:14px;">
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
<select class="formField2" id="card_expires_year" name="card_expires_year" style="font-size:14px;">
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
<br />
	    <h1>Membership Details</h1>
        <br />
    <table cellpadding="5" cellspacing="5">
    <tr>
        <td>Membership: </td>
        <td><input disabled="disabled" type="text" name="userType" id="userType" value="<?=$userType?>" readonly="" class="formField" />
            <input type="hidden" name="userType" id="userType" value="<?=$userType?>" /></td>
    </tr>
	<tr>
		<td>If you have discount coupon <br /> then Enter coupon name: </td>
		<td><input type="text" name="couponname" id="couponname" value="<?=$couponname?>"  class="formField"/></td>
	</tr>
    </table>
    </td>
    </tr>
    <tr>
		<td colspan="2" align="center">
		<input type="hidden" name="planid" value="<?=$planid?>"/>
		<input type="submit" name="submit" value="Registration Complete!" class="formButton" /></td>
	</tr>
    <tr>
    	<td colspan="2" align="center">By creating an account, you're also opting to receive e-mail about Angie's List.  If you ever want us to stop sending you mobile marketing advice, you can unsubscribe (through a link at the bottom of each e-mail) at any time.
    </tr>
</table>
</form>

</center>
																</div>
															</div>
															<div class="right"><!--a href="#"><img src="images/more_1.jpg" alt="" border="0" /></a--><br /></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
		  <div class="column_1">
					<div class="t_1">
						<div class="side_top">
							<div class="left_top">
								<div class="right_top">
									<div class="left_bot">
										<div class="right_bot">
											<div class="indent">
												<img src="images/2_h_3.gif" alt="" /><br />
												<ul style="margin:4px 0 0 0;">
													<li><div><a href="#"><strong>One click call</strong></a></div></li>
													<li><div><a href="#"><strong>One click email</strong></a></div></li>
													<li><div><a href="#"><strong>Custom Site Branding</strong></a></div></li>
													<li><div><a href="#"><strong>Mailchimp Integration</strong></a></div></li>
													<li><div><a href="#"><strong>QR Code for every page</strong></a></div></li>
													<li><div><a href="#"><strong>Manage mobile using editor</strong></a></div></li>
													<li><div><a href="#"><strong>RSS feed Integration</strong></a></div></li>
													<li><div><a href="#"><strong>W3C Valid mobile Sites</strong></a></div></li>
													<li><div><a href="#"><strong>Integrate forms using Formstack</strong></a></div></li>
													<li><div><a href="#"><strong>Google Analytics Integration</strong></a></div></li>
												</ul>
                                                <br />
                                                <center>
                                            	<img width="200px" src="https://fifthfloor.mymobimanager.com/images/securedIcon.png" />
                                                <br />
                                                <br />
                                                <!-- (c) 2005, 2011. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="2da29ba7-6100-4c00-bdf2-8a49f04429a5";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payments</a> </div> 
                                                </center>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 
		  </div>
				<div class="clear"></div>
			<!--content end-->
		</div>
	</div>
</div>
<div id="footer">
	<div class="main">
	<!--footer -->
		<div class="column">
			<div class="indent">
				<a href="https://fifthfloor.mymobimanager.com/login.php">Login</a> || <a href="http://www.mymobimanager.com/myMobiContact.php">Contacts</a>
			</div>
		</div>
		<div class="column_1">
			<div class="indent">
				My Mobi Manager &copy; 2011<br />
				<!--a href="index-5.html">Privacy Policy.</a-->
			</div>
		</div>
		<div class="clear"></div>
	<!--footer end-->	
</div>
</div>
</body>
</html>