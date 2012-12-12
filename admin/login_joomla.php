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
	$sql="SELECT Userid, userName, password, subscriptionId FROM ".$projectName."user WHERE Username ='$userName' AND password ='$password' AND active=1";
	$result=mysql_query($sql);  
	$record=mysql_fetch_array($result);
            
	if($password==$record['password'] && $userName==$record['userName']){		
		$_SESSION['password']=$record['password'];
		//$_SESSION['password']=$record['password'];
        $_SESSION['userName']=$record['userName'];
	   	$loggedinuserID=$record['Userid'];
	    $_SESSION['ID']=$record['Userid'];
	    $_SESSION['loggedinusertype']=$record['type'];
	   		
	// Start Authorize.net
	
	
	
	$sqlAuth="select Userid, totalLogins, subscriptionId, siteAccess, parentAccount, planidno from ".$projectName."user WHERE Userid='$loggedinuserID'";
	
	$resAuth=mysql_query($sqlAuth);
	$rowAuth=mysql_fetch_array($resAuth);
	$authSubId = $rowAuth['subscriptionId'];
	$siteString= $rowAuth["siteAccess"];
	$planid = $rowAuth["planidno"];
	$isParent = $rowAuth["parentAccount"];	
	$mySites=explode(",",$siteString);
	$siteSize = count($mySites);
	//print_r($mySites);
	//exit;
	//echo $siteSize;
		if ($authSubId != "")  {
			include("subscription_get_status.php");	
			if ($subscriptionId == 'Successful.'){
					$updateUser = "UPDATE mobilemanager_user SET totalLogins = $newTotal, timestamp = " . date('Y-m-d') . " WHERE Userid = $loggedinuserID"; 
				
				//mysql_query($updateuser) or die("error updating user information, please contact support");
			//echo "hello roots";
				if($siteSize > 1 || $hasParent == "" && $planid != 3 ){			
					header("location: userHome.php");
					exit;			
				} else {
					$_SESSION['mobiId'] = $mySites[0];
					header("location: mobiHome.php");
					exit;
				}
					
					
			} else {
				//$_SESSION['paymentFlag']=$countforpay;
				//header("location: ../payment.php");
				echo "Your Account is currently not active.  Please sign up for a new account or contact our support team if you believe you've received this message in error.";
				exit;
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Mobi Manager Login</title>
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
																	<script src="javascript.js"></script>
                                                                    
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
                                                                    <? } ?>
                                                                    
                                                                    
                                                                    
                                                                    <form action="login.php" method="post">
                                                                    <table align="center">
                                                                        <tr>
                                                                            <td>
                                                                               <table align="left" class="generaltable" style="font-size:16px; font-weight:500;">
                                                                                <tr ><td> UserName <br  /><br  /><input type="text" id="userName" name="userName" style="height: 40px; color: #036679; font-weight: bolder; font-size:14px; width: 250px; border: medium solid #036679;"></td></tr>
                                                                                <tr style="height:20px;"><td >&nbsp;</td></tr>
                                                                                <tr>
                                                                                	<td> Password <br  /><br  /><input type="password" id="password" name="password" style="height: 40px; width: 250px; border: medium solid #036679;">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                	<td><input type="submit" name="submit" id="submit" value="Log-in!" style="background: #036679; height: 30px; width: 150px;"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><a href="/forgotPass.php" >Forgot Password?</a></td>    
                                                                                </tr>
                                                                    </table>
                                                                    
                                                                            </td>
                                                                       </tr>
                                                                    </table>
                                                                    </form>
                                                                    
                                                                    </td></tr></table>



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
				<a href="https://fifthfloor.mymobimanager.com/login.php">Login</a> || <a href="myMobiContact.php">Contacts</a>
			</div>
		</div>
		<div class="column_1">
			<div class="indent">
				Hosting company &copy; 2007<br />
				<a href="index-5.html">Privacy Policy.</a>
			</div>
		</div>
		<div class="clear"></div>
	<!--footer end-->	
</div>
</div>
</body>
</html>