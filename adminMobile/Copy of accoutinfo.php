<?php
include("session_check.php");


?>

<?php include("toppart.php"); ?>
	<h2>Account Information</h2>
	<p class="adminLinks"><a href="change_password.php">Change Password</a><p/>
	<p class="adminLinks"><a href="editaccoutinfo.php">Edit Account Information</a><p/>
	<p class="adminLinks"><a href="paymenthistory.php">Payment History</a><p/>		
    
    
    
    <!-- the tabs -->
<ul class="tabs">
	<li><a href="#"><h2 >Change Password</h2></a></li>
	<li><a href="#"><h2>Edit Account Information</h2></a></li>
	<li><a href="#"><h2>Payment History</h2></a></li>
</ul>

<!-- tab "panes" -->
<div class="panes">
	<div><table cellpadding="10" cellspacing="10">
<tr>
    <td>
    	<form action="change_password.php" method="post" onSubmit="return validate_pass()">	
	
	<table border="0" cellpadding="0" cellspacing="0" class="generaltable">
 

	 <tr>
	<td>New Password :</td>	 
	 <td><input type="password" name="newPassword" id="newPassword" /> </td>
	 </tr>
	 
	 <tr>
	<td>Retype New Password :</td>
	 <td><input type="password" name="retypePassword" id="retypePassword"/> </td>
	 </tr>
	 
	 <tr><td></td>
	 <td><input type="submit"name="submitPassword" id="submitPassword" value="Change Password"/> </td></tr>
	 </table>
	 
	 </form>

    
    
    </td>
</tr>
</table></div>

<div>
<!------------------------ EDIT ACCOUNT INFO ----------------------------------------->
<center>
<?php echo $message; ?>
<form action="editaccoutinfo.php" method="post" enctype="multipart/form-data" onsubmit="return validation_registration()">
<table>
<caption>Edit Registration Form<br /><br /></caption>
	<tr>
		<td>First Name : </td>
		<td><input type="text" name="firstName" id="firstName" value="<?=$row['Firstname']?>"/></td>
	</tr>
	<tr>
		<td>Last Name : </td>
		<td><input type="text" name="lastName" id="lastName" value="<?=$row['Lastname']?>"/></td>
	</tr>
	<tr>
		<td>Username : </td>
		<td><input type="text" name="userName" id="userName" value="<?=$row['Username']?>" readonly=""  /> <div id="usernameresult"></div> </td>
	</tr>
	<tr>
		<td>Password : *</td>
		<td><input type="password" name="password" id="password" value="<?=$row['password']?>"/></td>
	</tr>
	<tr>
		<td>Retype Password : </td>
		<td><input type="password" name="repassword" id="repassword" value="<?=$row['password']?>" /></td>
	</tr>
	<tr>
		<td>Membership : </td>
		<td><input type="text" name="userType" id="userType" disabled="disabled" value="<?=$row['planname']?>" readonly=""/><input type="hidden" name="userType" id="userType" value="<?=$row['planname']?>" readonly=""/></td>
	</tr>
	<tr>
		<td>Email : </td>
		<td><input type="text" name="email" id="email" value="<?=$row['Email']?>"/></td>
	</tr>
	<tr>
		<td>Company : </td>
		<td><input type="text" name="company" id="company" value="<?=$row['Company']?>"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<input type="hidden" name="userId" id="userId" value="<?=$userId?>"/>
		<input type="submit" name="submit2" value="Edit"/></td>
	</tr>

</table>
</form>
</center>

</div>
<div>
<!--------------------------- PAYMENT HISTORY ---------------------->
<center>

<form action="paymenthistory.php" method="post" >
<table id="paymenthistoryTable" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>Month</td>
<td>
<select name="month" id="month">
<?php
if(isset($_POST["month"])){
       $selected_month = $_POST["month"];
} else {
       $selected_month = date("n");
}
for($m=1;$m<=12;$m++){
        $month = date('F', mktime(0,0,0,$m));
  if($selected_month  == $m)
echo "<option value='$m' selected>$month</option>";
else
echo "<option value='$m'>$month</option>";
}
?>
</select>
</td>
<td>Year</td>
<td>
<select name="year" id="year">
<?PHP

if(isset($_POST["year"])){
       $year  = $_POST["year"];
} else {
       $year   = date("Y");
}

for($i=2010;$i>=2000;$i--)
{
if($year == $i)
echo "<option value='$i' selected>$i</option>";
else
echo "<option value='$i'>$i</option>";
}
?>
</select>
</td>
<td><input type="submit"  name="submit" id="submit" value="GO"/></td>
</tr>
</table><br/><br/>


<table id="paymenthistoryTable" border="1" cellpadding="0" cellspacing="0">
<tr>
  <th>Date</th><th>Name</th><th>Amount</th>
</tr>
<tr>

<?php

if($_POST['submit'])
{
$month=$_POST['month'];
$year=$_POST['year'];
 
$sql="SELECT Firstname,Lastname,paymentdate,DATE_FORMAT(paymentdate, '%d-%m-%Y'),SUM(paymentamount) as sumtotal FROM ".$projectName."paymenthistory  p,  ".$projectName."user u WHERE u.Userid=$Userid AND  p.userid=u.Userid and month(paymentdate)= '$month' AND year(paymentdate)='$year' group by paymentdate ";

$result = mysql_query($sql);
echo mysql_error();
$total=0;

while($row = mysql_fetch_array($result)){


$total=$total +  $row['sumtotal'] ;?>
<td align="left"><? echo $row["DATE_FORMAT(paymentdate, '%d-%m-%Y')"]; ?></td><td><? echo $row['Firstname']." ".$row['Lastname'];?></td>
 <td align="right"><? echo $row['sumtotal'];?></td>
 </tr>
<?
		}
?>

<tr><td  colspan="2" align="right">Total</td>
<td align="right">
<?
echo "$total"; ?></td></tr>
<?
}
else{
$month = date("m");

$sql="SELECT Firstname,Lastname,paymentdate,DATE_FORMAT(paymentdate, '%d-%m-%Y'),SUM(paymentamount) as sumtotal FROM ".$projectName."paymenthistory  p,  ".$projectName."user u WHERE u.Userid='$Userid' AND  p.userid=u.Userid and month(paymentdate)= '$month' AND year(paymentdate)='$year' group by paymentdate ";

$result = mysql_query($sql);
echo mysql_error();
$total=0;

while($row = mysql_fetch_array($result)){

$total=$total +  $row['sumtotal'] ;?>
<tr><td align="left"><? echo $row["DATE_FORMAT(paymentdate, '%d-%m-%Y')"]; ?></td><td><? echo $row['Firstname']." ".$row['Lastname'];?></td>
 <td align="right"><? echo $row['sumtotal'];?></td>
 </tr>
	<?
	}
?>
<tr><td  colspan="2" align="right">Total</td>
<td align="right"><?
echo "$total"; 
}
?>	  
</td></tr>
</table>


</div>

</div>
<hr width="100%"  />
<!-- This JavaScript snippet activates those tabs -->
<script>

// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>


<?php include("downpart.php"); ?>
