<?php
include("session_check.php");
$siteId = $_SESSION['mobiId'];
$Userid=$_SESSION['ID'];




//echo "user id : ".$Userid;

$pagetitle="Manage Mobile Pages";
$pagetag = "Anticipate the difficult by managing the easy -Lao Tzu";

	
if($_GET['idForDel'])
{
	$id=$_GET['idForDel'];
	if ($errormessage==''){
		$returnFromdel=location_del_form($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="Delete Successfully";	
			
			}
		else
			$errormessage=$errormessage . $returnFromdel;
		}  // END OF if($errormessage=='')

}
	
if($_GET['idForHQ'])
{
	$id=$_GET['idForHQ'];
	if ($errormessage==''){
		$returnFromdel=add_as_hq($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="HQ Set Successfully";	
			
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

$sql="select * from ".$projectName."markers WHERE mobiSiteId = $siteId ORDER BY id";
$result=mysql_query($sql);

?>

<?php include("toppart.php"); ?>

<center>
    <table align="right">
    	<tr height="10px" align="right">
            <td><a class="formButton" href="mobiLocations.php">Add Locations</a></td>
        </tr>
     </table> <!--a style="color:#fff; background: #036679; padding:10px; text-decoration: none;" href="addNewPage.php?pagetype=Coupon">Create Coupon</a-->	
    
    <div id="contentLeft">
     <table width="100%" style="background: URL(images/columnHeaderBg.gif) repeat-x; color: #fff;">
	 <tr> 
			    <th width="15%">Name</th>
				<th width="15%">Page Type</th>
				<th width="8%">Edit</th>
				<th width="8%">Published</th>
				<th width="8%">Delete</th>
	  </tr>
      </table>
			<ul>
				<?php
				
				// how many rows to show per page
				$rowsPerPage = 5;
				
				// by default we show first page
				$pageNum = 1;
				
				// if $_GET['page'] defined, use it as page number
				if(isset($_GET['page']))
				{
					$pageNum = $_GET['page'];
				}
				
				// counting the offset
				$offset = ($pageNum - 1) * $rowsPerPage;
				
				$query  = "SELECT * FROM mobilemanager_markers WHERE mobiSiteId = $siteId ORDER BY id ASC LIMIT $offset, $rowsPerPage";
				$result = mysql_query($query);
				$s =0;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$s++;
				?>
					<li id="pagesArray_<?php echo $row['mobiSiteId']; ?>" style="position: relative; left: -30px;">
						<table width="100%" cellpadding="5" cellspacing="5">
                        	<tr>
								<td width="20%"><a href="mobiLocations.php?idForHQ=<?=$row['mobiSiteId']?>"><?php echo $s . ". " . $row['name']; ?></a></td>
                                <td width="10%"><a href="allLocations.php?idForHQ=<?=$row['mobiSiteId']?>&locoId=<?= $row['id'] ?>&hq=<?= $row['isHQ'] ?>"><?php if ($row['isHQ'] == 1){ ?>HQ <?PHP } else { ?>Standard Location<? } ?></a></td>
                
                                <td width="30%"><a href="mobiLocations.php?idForEdit=<?=$row['mobiSiteId']?>"><?= $row['address']; ?></a></td>		
                                 <? if ($row['active'] == 1) { $published = 'Yes'; } else { $published = "no"; }?>            
                                 <td width="10%"><a href="allLocations.php?idForPub=<?=$row['mobiSiteId']?>&active=<?= $row['active']; ?>" onClick="return confirmPublish()"><?= $published; ?></a>
                                 <td width="10%"><a href="allLocations.php?idForDel=<?=$row['id']?>" onClick="return confirmDelete()">X</a>
                                 </td>
                            </tr>
                    	</table>
                    </li>
				<?php } 
				
				// how many rows we have in database
$query   = "SELECT COUNT(mobiSiteId) AS numrows FROM mobilemanager_markers WHERE mobiSiteId = $siteId";
$result  = mysql_query($query) or die('Error, query failed');
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

// print the link to access each page
$self = $_SERVER['PHP_SELF'];
$nav  = '';

for($page = 1; $page <= $maxPage; $page++)
{
   if ($page == $pageNum)
   {
      $nav .= " $page "; // no need to create a link to current page
   }
   else
   {
      $nav .= " <a href=\"$self?page=$page\">$page</a> ";
   }
}
// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
   $page  = $pageNum - 1;
   $prev  = " <a href=\"$self?page=$page\">[Prev]</a> ";

   $first = " <a href=\"$self?page=1\">[First Page]</a> ";
}
else
{
   $prev  = '&nbsp;'; // we're on page one, don't print previous link
   $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
   $page = $pageNum + 1;
   $next = " <a href=\"$self?page=$page\">[Next]</a> ";

   $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
}
else
{
   $next = '&nbsp;'; // we're on the last page, don't print next link
   $last = '&nbsp;'; // nor the last page link
}

// print the navigation link
echo $first . $prev . $nav . $next . $last; 
	
				?>
			</ul>
		</div>
</center>

<?php include("downpart.php"); ?>
