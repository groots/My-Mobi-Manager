<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--<link rel="stylesheet" href="css.css" type="text/css">
<script type="text/javascript" src="javascript.js"></script>
<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="./ckeditor/ckfinder/ckfinder.js"></script>-->
<title>Mobile Website Manager</title>
<style>
.redDelete
{
color:#FF0000
}

</style>

</head>

<body>

<center>

<table  border="1" cellspacing="0" cellpadding="0" width="100%" height="500px" >
<tr>
   <td align="left" bgcolor="#ffffff" valign="top" width="20%">	

	<a href="manageuser.php">Manage User</a><br/>

    <a href="superadminsetting.php">Setting</a><br/>

    <a href="plansettings.php">Plan Setting</a><br/>
	
	<a href="discountcoupon.php">Coupon Setting</a><br/>
		
	<a href="paymenthistory.php">Payment History</a><br/>
	
	<a href="logout.php">Logout</a><br/>

	</td>
    
	<td align="left" valign="top">
	
            <p class="heading"><?=$pagetitle?></p>

<?if ($successmessage!=""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40px"><img src="success.PNG" /></td>
    <td class="greenmessage" align="left" valign="middle"><?=$successmessage?></td>
  </tr>
</table>
<?}?>

<?if ($errormessage!=""){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40px"><img src="error.PNG" /></td>
    <td class="redmessage" align="left" valign="middle"><?=$errormessage?></td>
  </tr>
</table>
<?}?>