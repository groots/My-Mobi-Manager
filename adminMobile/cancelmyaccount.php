<?php
include("session_check.php");


$pagetitle="Cancel My Account";
$Userid=$_SESSION['ID'];

if($_POST['cancelaccount'])
	{
$sql="delete from ".$projectName."user WHERE Userid=$Userid";
	
mysql_query($sql);
echo mysql_error();
	$successmessage="Deleted successfully";
	if($successmessage!='')
	header("location: login.php");	
	}  //END OF if($_POST['cancelaccount'])
?>

<script type="text/javascript">  
function confirmDelete()
{
    return confirm("Are you sure to cancel it?");
} 
</script> 




<?php include("toppart.php"); ?>
	<center>
<form  action="cancelmyaccount.php" method="post" >

<table id="cancelmyaccount" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td></td>
    <td><input type="submit"  class="forminput1" name="cancelaccount"  value="Cancel My Account" onClick="return confirmDelete()" /></td>
  </tr>
</table>

	
	

	
</form>		</center>	
<?php include("downpart.php"); ?>