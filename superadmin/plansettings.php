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
 
 
$planName=addslashes($_POST['planName']);
if($planName=="")
$message="Plan name can not be empty.<br>";

$fee=addslashes($_POST['fee']);
if($fee=="")
$message="Fee can not be empty.<br>";

$pagesLimit=addslashes($_POST['pagesLimit']);
if($pagesLimit=="")
$message="Number of pages limit can not be empty.<br>";

if($message=="")
{
	$dayslimit = $_REQUEST['dayslimit'];

$sql="insert into ".$projectName."plansettings (planname, fee, pageslimit,dayslimit) values('$planName', '$fee','$pagesLimit','$dayslimit')";
 	
	if(mysql_query($sql))
	{
	$planName="";
	$fee="";
	$pagesLimit="";

	$message="Success";
	
	}
	
	else
	{
	echo mysql_error();
	echo $sql;
	}


}//end of if($message=="")


}//end of if($_POST['submit'])


if($_GET['planE'])
{
$planname=$_GET['planE'];


$record=mysql_fetch_array(mysql_query("select * from ".$projectName."plansettings where planname='$planname'"));

}

if($_POST['edit'])
{

$planEdit=$_POST['planEdit'];

$planName=addslashes($_POST['planName']);
if($planName=="")
$message="Plan name can not be empty.<br>";

$fee=addslashes($_POST['fee']);
if($fee=="")
$message="Fee can not be empty.<br>";

$pagesLimit=addslashes($_POST['pagesLimit']);
if($pagesLimit=="")
$message="Number of pages limit can not be empty.<br>";
$dayslimit = $_REQUEST['dayslimit'];

$sqlE="update ".$projectName."plansettings set planname='".$planName."', fee='".$fee."', pageslimit='".$pagesLimit."', dayslimit='".$dayslimit."' where planname='$planEdit' ";

//echo $sqlE;

mysql_query($sqlE);

	$planName="";
	$fee="";
	$pagesLimit="";


$message="Success";


} //end of if($_GET['planE'] && $_POST['edit'])



if($_GET['planX'])
{
$planname=$_GET['planX'];


//echo "planX : ".$_GET['planX']."<br>";

$sqlD="delete from ".$projectName."plansettings where planname='$planname'";
//echo $sqlD;
mysql_query($sqlD);



}




?>



<?php include("toppart.php");?>

<center>

<?php echo $message; ?>



<form action="../superadmin/plansettings.php" method="post">
<table border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">
<tr>
	<td bgcolor="#FFFFFF">Plan Name</td>
	<td bgcolor="#FFFFFF">
	<?php if($_GET['planE']){ ?>
	<input type="text" name="planName" id="planName" value="<?=$record['planname']?>"/><?php } else {?>
	<input type="text" name="planName" id="planName" value="<?=$record['planname']?>"/>
	<?php } ?>
	</td>
</tr>

<tr>
	<td bgcolor="#FFFFFF">Fee</td>
	<td bgcolor="#FFFFFF"><input type="text" name="fee" id="fee" value="<?=$record['fee']?>"/></td>
</tr>

<tr>
	<td bgcolor="#FFFFFF">No. of Pages Limit </td>
	<td bgcolor="#FFFFFF"><input type="text" name="pagesLimit" id="pagesLimit" value="<?=$record['pageslimit']?>"/></td>
</tr>
<tr>
  <td bgcolor="#FFFFFF">No. of Days</td>
  <td bgcolor="#FFFFFF"><input type="text" name="dayslimit" id="dayslimit" value="<?=$record['dayslimit']?>"/></td>
</tr>

<tr>
	<td colspan="2" align="right" bgcolor="#FFFFFF">
	<?php if($_GET['planE']){ ?>
	<input type="hidden" name="planEdit" id="planEdit" value="<?=$_GET['planE']?>"/>
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
$result=mysql_query("select * from ".$projectName."plansettings");


?>

<table border="0" cellpadding="2" cellspacing="1" bgcolor="#0000FF">
  <tr>
    <th bgcolor="#FFFFFF">Plan Name</th>
    <th bgcolor="#FFFFFF">Fee</th>
    <th bgcolor="#FFFFFF">No of Pages Limit</th>
    <th bgcolor="#FFFFFF">No of Days Limit</th>
    <th bgcolor="#FFFFFF">Edit</th>
    <th bgcolor="#FFFFFF">Delete</th>
  </tr>
<?php
while($row=mysql_fetch_array($result))
{
?>

  <tr>
    <td bgcolor="#FFFFFF"><?=$row['planname']?></td>
    <td bgcolor="#FFFFFF"><?=$row['fee']?></td>
    <td bgcolor="#FFFFFF"><?=$row['pageslimit']?></td>
    <td bgcolor="#FFFFFF"><?=$row['dayslimit']?></td>
    <td bgcolor="#FFFFFF"><a href="../superadmin/plansettings.php?planE=<?=$row['planname']?>">E</a></td>
    <td bgcolor="#FFFFFF"><a class="redDelete" href="../superadmin/plansettings.php?planX=<?=$row['planname']?>"> X </a></td>
  </tr>
 
<?php
 }
?>  

</table>





</center>
<?php include("downpart.php");?>