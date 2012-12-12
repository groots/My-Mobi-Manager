<?php
include("session_check.php");
$Userid=$_SESSION['ID'];
//$Userid=$_SESSION['ID'];




//echo "user id : ".$Userid;

$pagetitle="Manage Mobile Pages";
$pagetag = "Anticipate the difficult by managing the easy -Lao Tzu";
	
if($_GET['idForDel'])
{
	$id=$_GET['idForDel'];
	if ($errormessage==''){
		$returnFromdel=Page_del_form($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="Delete Successfully";	
			
			}
		else
			$errormessage=$errormessage . $returnFromdel;
		}  // END OF if($errormessage=='')

}

if($_GET['idForPub'])
{
	$id=$_GET['idForPub'];
	if ($errormessage=='')
		{
		$returnFromdel=Page_pub_form($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="Publish Successfully";	
			
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
    <table>
    	<tr height="10px">
            <td><a style="color:#fff; background: #036679; padding:5px; text-decoration: none;" href="editHomepage.php">Homepage</a></td>
            <td><a style="color:#fff; background: #036679; padding:5px; text-decoration: none;" href="editFooter.php">Footer</a></td>
            <td><a style="color:#fff; background: #036679; padding:5px; text-decoration: none;" href="addNewPage.php?pagetype=Mobile">Add Page</a></td>
        </tr>
     </table> <!--a style="color:#fff; background: #036679; padding:10px; text-decoration: none;" href="addNewPage.php?pagetype=Coupon">Create Coupon</a-->	
    
    <div id="contentLeft">
     <table width="100%" style="background: URL(images/columnHeaderBg.gif) repeat-x; color: #fff;">
	 <tr> 
			    <th width="15%">Title</th>   
				<th width="8%">Edit</th>
				<th width="8%">Live</th>
				<th width="8%">Delete</th>
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
					<li id="pagesArray_<?php echo $row['pageid']; ?>" style="position: relative; left: -30px;">
						<table width="100%">
                        	<tr>
								<td width="15%"><a href="editPage.php?idForEdit=<?=$row['pageid']?>"><?php echo $row['Pageorder'] . " " . $row['Pagetitle']; ?></a></td> 		
                                <td width="10%"><a href="editPage.php?idForEdit=<?=$row['pageid']?>">Edit</a></td>		
                                 <? if ($row['active'] == 1) { $published = 'Yes'; } else { $published = "no"; }?>            
                                 <td width="10%"><a href="viewmypage.php?idForPub=<?=$row['pageid']?>&active=<?= $row['active']; ?>" onClick="return confirmPublish()"><?= $published; ?></a>
                                 <td width="10%"><a href="viewmypage.php?idForDel=<?=$row['pageid']?>" onClick="return confirmDelete()">X</a>
                                 </td>
                            </tr>
                    	</table>
                    </li>
				<?php } ?>
			</ul>
		</div>
</center>

<?php include("downpart.php"); ?>
