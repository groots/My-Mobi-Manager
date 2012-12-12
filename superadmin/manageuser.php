<?php
include("../dbcon.php");

$username=$_SESSION['username'];
$password=$_SESSION['password'];

//echo "user ".$username." pass : ".$password."<br>";


if(($username!="admin") && ($password!="123"))
{header('Location: login.php');}



if($_GET['active']==1  && $_GET['user'])
{
$user=$_GET['user'];
$active=$_GET['active'];


	$inactive=0;
	
	$sqlforAct="update ".$projectName."user set active='".$inactive."' where active='$active' and Username='$user' ";
	
	//echo $sqlforAct;
	
	mysql_query($sqlforAct);
	
}//end of if($_GET['active']==1  && $_GET['user'])
	
if($_GET['active']==0  && $_GET['user'])
{
$user=$_GET['user'];
$active=$_GET['active'];

	$activeOne=1;
	
	$sqlforInAct="update ".$projectName."user set active='".$activeOne."' where active='$active' and Username='$user' ";
	
	//echo $sqlforInAct;
	
	mysql_query($sqlforInAct);

}//end of if($_GET['active']==0  && $_GET['user'])



$sqlS="select * from ".$projectName."user, ".$projectName."plansettings where planid=planidno";
//echo $sqlS;
$result=mysql_query($sqlS);


?>

<?php include("toppart.php");?>

<center>

<table border="0" cellpadding="2" cellspacing="1" bgcolor="#0000FF">
  <tr>
    <th bgcolor="#FFFFFF">Logo</th>
    <th bgcolor="#FFFFFF">Username</th>
    <th bgcolor="#FFFFFF">Fullname</th>
    <th bgcolor="#FFFFFF">Membership</th>
	<th bgcolor="#FFFFFF">Site</th>
    <th bgcolor="#FFFFFF">Block</th>
  </tr>
<?php
while($row=mysql_fetch_array($result))
{
?>

  <tr>
    <td bgcolor="#FFFFFF">

		<?
		if ($row['Logo']=='')
		{ 
		$src="../logo/blank.png";
		}
		
		else
		{
		$src="../logo/".$row['Logo'];
		}
		
		?>
		
		<img  src="<?=$src?>" width="20px" height="20px" alt="Logo" >

	
	
	</td>
    <td bgcolor="#FFFFFF"><?=$row['Username']?></td>
    <td bgcolor="#FFFFFF"><? echo $row['Firstname']." ".$row['Lastname'];?></td>
    <td bgcolor="#FFFFFF"><?=$row['planname']?></td>
	<td bgcolor="#FFFFFF">
	<a target="_blank" href="<?='http://'.$row['Username'].'.'.$domainname?>"><?='http://'.$row['Username'].'.'.$domainname?></a>
	</td>
    <td bgcolor="#FFFFFF"><a href="../superadmin/manageuser.php?active=<?=$row['active']?>&user=<?=$row['Username']?>">
	<?php if($row['active']==1) { ?>
	
	Lock/<span style="color:#009933">Unlock</span></a>
	
	<?php } else { ?>
	
	<span style="color:#CC0000">Lock</span>/Unlock
	
	<?php } ?>
	
	</td>
	
  </tr>
 
<?php
 }
?>  

</table>





</center>
<?php include("downpart.php");?>