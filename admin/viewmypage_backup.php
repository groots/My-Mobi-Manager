<?php
include("session_check.php");
$Userid=$_SESSION['ID'];
$Userid=$_SESSION['ID'];




//echo "user id : ".$Userid;

$pagetitle="View List of Mobile Pages";
	
if($_GET['idForDel'])
{
	$id=$_GET['idForDel'];
	if ($errormessage=='')
		{
		$returnFromdel=Page_del_form($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="Delete Successfully";	
			
			}
		else
			$errormessage=$errormessage . $returnFromdel;
		}  // END OF if($errormessage=='')

}


$sql="select * from ".$projectName."page WHERE Userid=$Userid ORDER BY pageid, Parentlink";
$result=mysql_query($sql);



?>

<?php include("toppart.php"); ?>

<center>
    <p align="right" ><!--a style="color:#fff; background: #036679; padding:10px; text-decoration: none;" href="editHomepage.php">Edit Homepage</a--> <a style="color:#fff; background: #036679; padding:10px; text-decoration: none;" href="addNewPage.php?pagetype=Mobile">Add a page</a> <!--a style="color:#fff; background: #036679; padding:10px; text-decoration: none;" href="addNewPage.php?pagetype=Coupon">Create Coupon</a--><p/>	
	<table id="table-1" border="0" cellpadding="10" cellspacing="10" width="100%" style="background: #F5C36D;">
	 <tr bgcolor="#CCCCCC" > 
			    <th>List Page title</th>
				<th>Page Type</th>
				<th>Link</th>
				<th>Order <div style="font-size:10px;">(Click and Drag <br />to Change Order)</div></th>
				<th>Edit</th>
				<th>Delete</th>
	  </tr>
	          <?php     
                while($row=mysql_fetch_array($result))
				{  
				  $i++;
			
				  ?>
				<tr>
				<td id="<? echo $i; ?>"><?php 
				
				
				if ($row['Parentlink'] != 0){ 
					echo " ->";
				}
				
				echo $row['Pagetitle'];?>	</td>
				<td>Mobile Page	</td>

					<td><a href="<?=$row['Seourl']?>"><?php echo $row['Seourl'];?></a>	</td>
				
				<td align="center"><?=$row['Pageorder']?></td>		
				<td><a href="editPage.php?idForEdit=<?=$row['pageid']?>">Edit</a></td>		
							
                 <td><a href="viewmypage.php?idForDel=<?=$row['pageid']?>" onClick="return confirmDelete()">X</a>
				 </td>
	  </tr>
				    <?php                 
				  
				  }
                ?> 	  
		
	
				
	</table>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#table-1").tableDnD();
});
</script>

</center>

<?php include("downpart.php"); ?>
