<?php
include("../dbcon.php");


$username=$_SESSION['username'];
$password=$_SESSION['password'];

//echo "user ".$username." pass : ".$password."<br>";


if(($username!="admin") && ($password!="123"))
{header('Location: login.php');}



if($_POST['submit'])
{
//$message="Submit will not work now due to technical problem. ";
 
 
$couponName=$_POST['couponName'];
if($couponName=="")
$message="Coupon name can not be empty.<br>";

$amount=$_POST['amount'];
if($amount=="")
$message="Amount can not be empty.<br>";


if($message=="")
{

$sql="insert into ".$projectName."coupon (couponname, amount) values('$couponName', '$amount')";
 	
	if(mysql_query($sql))
	{
	$couponName="";
	$amount="";


	$message="Success";
	
	}
	
	else
	{
	echo mysql_error();
	echo $sql;
	}


}//end of if($message=="")


}//end of if($_POST['submit'])


if($_GET['couponE'])
{
$couponid=$_GET['couponE'];


$record=mysql_fetch_array(mysql_query("select * from ".$projectName."coupon where couponid='$couponid'"));

}

if($_POST['edit'])
{

$couponEdit=$_POST['couponEdit'];

$couponName=$_POST['couponName'];
if($couponName=="")
$message="Coupon name can not be empty.<br>";

$amount=$_POST['amount'];
if($amount=="")
$message="Fee can not be empty.<br>";


$sqlE="update ".$projectName."coupon set couponname='".$couponName."', amount='".$amount."' where couponid='$couponEdit' ";

//echo $sqlE;

mysql_query($sqlE);

	$planName="";
	$fee="";
	$pagesLimit="";


$message="Success";


} //end of if($_GET['planE'] && $_POST['edit'])



if($_GET['couponX'])
{
$couponid=$_GET['couponX'];


//echo "planX : ".$_GET['planX']."<br>";

$sqlD="delete from ".$projectName."coupon where couponid='$couponid'";
//echo $sqlD;
mysql_query($sqlD);

$message="Delete successfully";

}




?>



<?php include("toppart.php");?>

<center>

<?php echo $message; ?>



<form action="../superadmin/discountcoupon.php" method="post">
<table border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">
<tr>
	<td bgcolor="#FFFFFF">Coupon Name</td>
	<td bgcolor="#FFFFFF">
	<?php if($_GET['couponE']){ ?>
	<input type="text" name="couponName" id="couponName" value="<?=$record['couponname']?>"/><?php } else {?>
	<input type="text" name="couponName" id="couponName" value="<?=$record['couponname']?>"/>
	<?php } ?>
	</td>
</tr>

<tr>
	<td bgcolor="#FFFFFF">Active</td>
	<td bgcolor="#FFFFFF"><input type="text" name="active" id="active" value="<?=$record['active']?>"/></td>
</tr>

<tr>
	<td bgcolor="#FFFFFF">Amount</td>
	<td bgcolor="#FFFFFF"><input type="text" name="amount" id="amount" value="<?=$record['amount']?>"/></td>
</tr>


<tr>
	<td bgcolor="#FFFFFF">Expires</td>
	<td bgcolor="#FFFFFF"><input type="text" name="expires" id="expires" value="<?=$record['expires']?>"/></td>
</tr>

<tr>
	<td colspan="2" align="right" bgcolor="#FFFFFF">
	<?php if($_GET['couponE']){ ?>
	<input type="hidden" name="couponEdit" id="couponEdit" value="<?=$_GET['couponE']?>"/>
	<input type="submit" name="edit" value="Edit"/>
	<?php } else { ?>	
	<input type="submit" name="submit" value="Submit"/>	
	<?php } ?>	
	</td>
</tr>
</table>
</form>

<br /> <br /> <br />

<?php 
$result=mysql_query("select * from ".$projectName."coupon");


?>

<table border="0" cellpadding="2" cellspacing="1" bgcolor="#0000FF">
  <tr>
    <th bgcolor="#FFFFFF">Coupon Name</th>
    <th bgcolor="#FFFFFF">Amount</th>
    <th bgcolor="#FFFFFF">Edit</th>
    <th bgcolor="#FFFFFF">Delete</th>
  </tr>
<?php
while($row=mysql_fetch_array($result))
{
?>

  <tr>
    <td bgcolor="#FFFFFF"><?=$row['couponname']?></td>
    <td bgcolor="#FFFFFF"><?=$row['amount']?></td>
    <td bgcolor="#FFFFFF"><a href="../superadmin/discountcoupon.php?couponE=<?=$row['couponid']?>">E</a></td>
    <td bgcolor="#FFFFFF"><a class="redDelete" href="../superadmin/discountcoupon.php?couponX=<?=$row['couponid']?>">X</a></td>
  </tr>
 
<?php
 }
?>  

</table>





</center>
<?php include("downpart.php");?>