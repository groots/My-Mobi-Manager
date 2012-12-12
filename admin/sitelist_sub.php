<?php
	include("dbcon.php");
	include('classes/pagination_class2.php');
	$Userid = $_SESSION['ID'];
	
	$qry1 = "SELECT * FROM tempUserData WHERE userId = $Userid";
	$searchText1 = "";
	if($_REQUEST['search_text1']!=""){
		$searchText1 = $_REQUEST['search_text1'];
		$qry1 .=" and Username like '$searchText1%'";
	}

	//for pagination
	if(isset($_GET['starting1'])&& !isset($_REQUEST['submit'])){
		$starting1=$_GET['starting1'];
	}else{
		$starting1=0;
	}
	$recpage1 = 5;//number of records per page
		
	$obj1 = new pagination_class2($qry1,$starting1,$recpage1);		
	$result1 = $obj1->result;
?>
    <table border="0" align="center" width="100%" cellpadding="5" cellspacing="5">
    <tr><TD width="5%"></TD><TD>Name</TD></tr>
    <? if(mysql_num_rows($result1)!=0){
        $counter1 = $starting1 + 1;
        while($data1 = mysql_fetch_array($result1)) {?>
            <tr>
            <TD><? echo $counter1; ?></TD>
            <TD><a href="mobiHome.php?mobiId=<?=$data1['siteid']?>"><?php echo $data1['siteName']; ?></a></TD>
			<? if ($data1['active'] == 1) { $published = 'Yes'; } else { $published = "no"; }?>            
                 <td width="10%"><a href="viewmypage.php?idForPub=<?=$data1['siteid']?>&active=<?= $data1['active']; ?>" onClick="return confirmPublish()"><?= $published; ?></a></td>
                 <td width="10%"><a href="aProcessor.php?idForDel=<?=$data1['siteid']?>&userIdToUpdate=<?= $Userid; ?>" onClick="return confirmDelete()">X</a>
                 </td>
            </tr><?
            $counter ++;
        } ?>
    </table>
    <table>
            
        <tr><TD colspan="2"><? echo $obj1->anchors; ?></TD colspan="2"></tr>
        <tr><TD colspan="2"><? echo $obj1->total; ?></TD></tr>
    <? }else{ ?>
        <tr><TD align="center" colspan="2">No Data Found</TD></tr>
    <? } ?>
    </TD></tr>
    </table>