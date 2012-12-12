<?php
include("session_check.php");

$pagetitle="Payment History";
$Userid=$_SESSION['ID'];

//echo "id: ".$Userid;

?>

<?php include("toppart.php");?>

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

<?php include("downpart.php");?>