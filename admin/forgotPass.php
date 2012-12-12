<?php

//$_POST['email'] = 'squish@squishdesigns.com';
include("../dbcon.php");
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
	
	<div class="clear"></div>
	</div>
</div>
<!--header end-->
<div id="wrapper">
	<div class="main">
		<div class="indent">
			<!--content -->
				<div class="column" style="width: 900px; height: 500px;">
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

<center>
<?	
	if($_POST['sendPass']) {
		$email=$_POST['email'];
		$email=mysql_real_escape_string($email);
		$status = "OK";
		$msg="";
	//error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
	// You can supress the error message by un commenting the above line
		if (!stristr($email,"@") OR !stristr($email,".")) {
			$msg="Your email address is not correct<BR>";
			$status= "NOTOK";
		}
	
		echo "<br><br>";
		if($status=="OK"){ // validation passed now we will check the tables
			$query="SELECT * FROM mobilemanager_user WHERE mobilemanager_user.Email = '$email'";
			$st=mysql_query($query);
			$recs=mysql_num_rows($st);
			$row=mysql_fetch_object($st);
			$em=$row->Email;// email is stored to a variable
	
			if ($recs == 0) { // No records returned, so no email address in our table
			// let us show the error message
				echo "<center><font face='Verdana' size='2' color=red><b>No Password</b><br> Sorry Your address is not there in our database . You can signup and login to use our site. <BR><BR><a href='signup.php'> Sign UP </a> </center>";
				exit;
			}
	
	// formating the mail posting
	// headers here
			$headers4="support@mymobimanager.com"; // Change this address within quotes to your address
			$headers.="Reply-to: $headers4\n";
			$headers .= "From: $headers4\n";
			$headers .= "Errors-to: $headers4\n";
	//$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
	// for html mail un-comment the above line
	
	// mail funciton will return true if it is successful
			if(mail("$em","Your Request for login details","This is in response to your request for login details at My Mobi Manager \n \nUsername: $row->Username \n Password: $row->password \n\n Thank You \n \n siteadmin","$headers")){
				echo "<center><font face='Verdana' size='2' ><b>THANK YOU</b> <br>Your password is has been sent to your registered emil address. Please check your mail after some time. </center>";
			} else {// there is a system problem in sending mail
			echo " <center><font face='Verdana' size='2' color=red >There is some system problem in sending login details to your address. Please contact site-admin. <br><br><input type='button' value='Retry' onClick='history.go(-1)'></center></font>";
			}
		
		}
		else {// Validation failed so show the error message
		echo "<center><font face='Verdana' size='2' color=red >$msg <br><br><input type='button' value='Retry' onClick='history.go(-1)'></center></font>";
		}
	} else {
		?>

        <form method="post" action="forgotPass.php">
         Please type your email address below.
         <br />
         <input type="text" name="email" id="email" />
         <br />
         <input type="submit" value="Send Instructions" name="sendPass" id="sendPass" />
         </form>
        <?
	}
?>
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
