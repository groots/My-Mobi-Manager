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
    
    
    
    
    <div id="contentLeft">
     <table width="100%">
	 <tr bgcolor="#CCCCCC" > 
			    <th width="25%">List Page title</th>
				<th width="15%">Page Type</th>
				<th width="40%">Link</th>
				<th width="10%">Order <div style="font-size:10px;">(Click and Drag <br />to Change Order)</div></th>
				<th width="10%">Edit</th>
				<th width="10%">Delete</th>
	  </tr>
      </table>
			<ul>
				<?php
				$query  = "SELECT * FROM mobilemanager_page WHERE Userid = $Userid ORDER BY Pageorder ASC";
				$result = mysql_query($query);
				$s =0;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$s++;
				?>
					<li id="pagesArray_<?php echo $row['pageid']; ?>">
						<table>
                        	<tr>
								<td width="25%"><?php echo $s . ". " . $row['Pagetitle']; ?></td>
                                <td width="15%">Mobile Page	</td>
                
                                    <td width="40%"><a href="<?=$row['Seourl']?>"><?php echo $row['Seourl'];?></a>	</td>
                                
                                <td width="10%" align="center"><?=$row['Pageorder']?></td>		
                                <td width="10%"><a href="editPage.php?idForEdit=<?=$row['pageid']?>">Edit</a></td>		
                                            
                                 <td width="10%"><a href="viewmypage.php?idForDel=<?=$row['pageid']?>" onClick="return confirmDelete()">X</a>
                                 </td>
                            </tr>
                    	</table>
                    </li>
				<?php } ?>
			</ul>
		</div>
    
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#table-1").tableDnD();
});
</script>

</center>

<?php include("downpart.php"); ?>
