<?php
	
	
	$qry = "SELECT * FROM mobilemanager_user WHERE parentAccount = $Userid";
	$searchText = "";
	if($_REQUEST['search_text']!=""){
		$searchText = $_REQUEST['search_text'];
		$qry .=" and Username like '$searchText%'";
	}
	//for pagination
	$starting=0;
	$recpage = 5; //number of records per page
	
	$obj = new pagination_class($qry,$starting,$recpage);		
	$result = $obj->result;

			
			?><form name="form1" action="userHome.php" method="POST">
			
			<table border="0" align="center" width="100%">
			<tr>
			  <TD colspan="2">
				Search <input type="text" name="search_text" value="<?php echo $searchText; ?>">
					<input type="submit" value="Search">
			  </TD> 
			</tr>
			<tr><TD colspan="2">
			
			<div id="page_contents">
				<table border="0" align="center" width="100%" cellpadding="5" cellspacing="5">
				<tr><TD width="5%"></TD><TD>Name</TD></tr>
				<? if(mysql_num_rows($result)!=0){
					$counter = $starting + 1;
					while($data = mysql_fetch_array($result)) {?>
						<tr>
						<TD><? echo $counter; ?></TD>
						<TD><a href="mobiHome.php?mobiId=<?=$data['Userid']?>"><?php echo $data['Username']; ?></a></TD>
                        
													
												 <? if ($data1['active'] == 1) { $published = 'Yes'; } else { $published = "no"; }?>            
												 <td width="10%"><a href="viewmypage.php?siteIdForPub=<?=$data['Userid']?>&active=<?= $data1['active']; ?>" onClick="return confirmPublish()"><?= $published; ?></a></td>
												 <td width="10%"><a href="aProcessor.php?userIdForDel=<?= $data['Userid']; ?>" onClick="return confirmDelete()">X</a>
												 </td>
						</tr><?
						$counter ++;
					} ?>
				
    </table>
    <table>
						
					<tr><TD colspan="2"><? echo $obj->anchors; ?></TD></tr>
					<tr><TD colspan="2"><? echo $obj->total; ?></TD></tr>
				<?}else{?>
					<tr><TD align="center" colspan="2">No Data Found</TD></tr>
				<?}?>
				</TD></tr>
				</table>
			</div>
			</TD></tr>
		</table></form>
			