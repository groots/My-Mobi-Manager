<?php 
include("../dbcon.php");

$username=$_SESSION['username'];
$password=$_SESSION['password'];

//echo "user ".$username." pass : ".$password."<br>";


if(($username!="admin") && ($password!="123"))
{header('Location: login.php');}


if($_POST['submit'])
{
$mm=$_REQUEST["mon"];
$yy=$_REQUEST["yyyy"];


}



if( $mm=='' )
{
$mm=date("m");
$yy=date("Y");
}






/*
$sql="SELECT * FROM tbl_longleave JOIN tbl_emp ON tbl_longleave.username = tbl_emp.username WHERE tbl_longleave.status='Pending'";
*/

?>

<?php include("toppart.php");?>

<center>

<form action="paymenthistory.php" method="post">

 <select name=yyyy> 
<option value="2008"<? if($yy == "2008") echo "selected";?>>2008</option>
<option value="2009"<? if($yy == "2009") echo "selected";?>>2009</option>
<option value="2010"<? if($yy == "2010") echo "selected";?>>2010</option>
<option value="2011"<? if($yy == "2011") echo "selected";?>>2011</option>
<option value="2012"<? if($yy == "2012") echo "selected";?>>2012</option>
</select> 
<select name=mon> 
<? for ($i=1; $i<=12;$i++){ ?>
<!--//echo '<option value="'.$i.'" if($mm == "'.$i.'") echo "selected"; >'.$i.'</option>';-->

<option value="<?=$i?>"<? if($mm == $i) echo "selected";?>><? echo $i; ?></option>

<? } ?>

</select>
<input type="submit" name="submit" value="GO"/> 
</form>




<table border="0" cellpadding="2" cellspacing="1" bgcolor="#0000FF">
  <tr>
    <th bgcolor="#FFFFFF">Date</th>
    <th bgcolor="#FFFFFF">Username</th>
    <th bgcolor="#FFFFFF">Fullname</th>
    <th bgcolor="#FFFFFF">Payment Amount</th>
  </tr>
<?php

 for ($i=$stdate; $i<=31; $i++)
{

$dt=date("Y-m-d", mktime(0,0,0,$mm,$i,$yy));

//echo $dt."<br>";






$sql="select * from ".$projectName."paymenthistory join ".$projectName."user on ".$projectName."user.Userid=".$projectName."paymenthistory.Userid where paymentdate='$dt'" ;

//echo $sql;

$result=mysql_query($sql);




while($row=mysql_fetch_array($result))
{
?>

  <tr>
    <td bgcolor="#FFFFFF"><?=$row['paymentdate']?></td>
    <td bgcolor="#FFFFFF"><?=$row['Username']?></td>
    <td bgcolor="#FFFFFF"><? echo $row['Firstname']." ".$row['Lastname'];?></td>
    <td bgcolor="#FFFFFF"><?=$row['paymentamount']?></td>

  </tr>
 
<?php
 }
 
 }
 
 
?>  

</table>





</center>
<?php include("downpart.php");?>