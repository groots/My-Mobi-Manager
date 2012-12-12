<?php
	include("session_check.php");
	$pagetitle="Add Organization Locations";
	$pagetag = "Time to get Jiggy with it!";
	$Userid=$_SESSION['userName'];
	$siteId=$_SESSION['mobiId'];
	$projectName="mobilemanager_";
	if($_GET['idForDel']){
			unlink("/gbimages/" . $_GET['in']);
			$d_id = $_GET['idForDel'];
			$sqld="UPDATE ".$projectName."global_settings SET backgroundimage = NULL  where mobiSiteId='$d_id'";
			mysql_query($sqld);	
			$successmessage="Image deleted successfully";
	}

	if($_POST["submit"]) { 
		$act1 = $_POST['locActive1'];
		$name1 = $_POST['locName1'];
		$address1 = $_POST['locAdd1'];
		$phone1 = $_POST['phone1'];
		$act2 = $_POST['locActive2'];
		$name2 = $_POST['locName2'];
		$address2 = $_POST['locAdd2'];
		$phone2 = $_POST['phone2'];
		$act3 = $_POST['locActive3'];
		$name3 = $_POST['locName3'];
		$address3 = $_POST['locAdd3'];
		$phone3 = $_POST['phone3'];
		$act4 = $_POST['locActive4'];
		$name4 = $_POST['locName4'];
		$address4 = $_POST['locAdd4'];
		$phone4 = $_POST['phone4'];
		$act5 = $_POST['locActive5'];
		$name5 = $_POST['locName5'];
		$address5 = $_POST['locAdd5'];
		$phone5 = $_POST['phone5'];
		
		
		$i=1;
		while($i<=5)
  		{
			if($name1 != "" && $i == 1){
				$sql1= "INSERT INTO mobilemanager_markers (mobiSiteId, active, name, address, phone, lat, lng, purpose) VALUES ($siteId, $act1, '$name1', '$address1', '$phone1', '', '', 'sLocator')";
				mysql_query($sql1) or die("Location 1 had an error uploading");
			} else if ($name2 != "" && $i == 2){
				$sql2= "INSERT INTO mobilemanager_markers (mobiSiteId, active, name, address, phone, lat, lng, purpose) VALUES ($siteId, $act2, '$name2', '$address2', '$phone2' '', '', 'sLocator')";
				mysql_query($sql2) or die("Location 2 had an error uploading");
			} else if ($name3 != "" && $i == 3){
				$sql3= "INSERT INTO mobilemanager_markers (mobiSiteId, active, name, address, phone, lat, lng, purpose) VALUES ($siteId, $act3, '$name3', '$address3', '$phone3', '', '', 'sLocator')";
				mysql_query($sql3) or die("Location 3 had an error uploading");
			} else if ($name4 != "" && $i == 4){
				$sql4= "INSERT INTO mobilemanager_markers (mobiSiteId, active, name, address, phone, lat, lng, purpose) VALUES ($siteId, $act4, '$name4', '$address4', '$phone4', '', '', 'sLocator')";
				mysql_query($sql4) or die("Location 4 had an error uploading");
			} else if ($name5 != "" && $i == 5){
				$sql5= "INSERT INTO mobilemanager_markers (mobiSiteId, active, name, address, phone, lat, lng, purpose) VALUES ($siteId, $act5, '$name5', '$address5', '$phone5', '', '', 'sLocator')";
				mysql_query($sql5) or die("Location 5 had an error uploading");
			}
  			$i++;
  		}
		include("setLatandLong.php");
		//End of Page Transation
		header("location: allLocations.php");
	}
	


	include("toppart.php");
?>

<form name="form_global_settings" enctype="multipart/form-data" action="mobiLocations.php" method="post" >          
    
<table>
    <tr>
        <td>
            <table align="right" width="1000px" style="z-index: 1000;">            
                <tr align="right">
                <td align="right"><input type="submit" class="formButton" name="submit" id="submit" value="Save" /> <input type="submit" name="cancelPage" class="formButton" value="Cancel"/>
                <input type="hidden" name="idForEdit" value="<?=$siteId?>"/>
                </td>
                
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>    
        	<table cellspacing="10" cellpadding="10">
            	<tr>
                	<td valign="top">
                        <table cellpadding="5">
                            <tr>
                                <td colspan="2"><h3>Address 1</h3></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><input type="checkbox" checked name="locActive1" id="locActive1" value="1" /> This address will be active</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input type="text" name="locName1" id="locName1" /></td>
                            </tr>        
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="locAdd1" id="locAdd1" /></td>
                            </tr>               
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" name="phone1" id="phone1" /></td>
                            </tr> 
                            <tr><td colspan="2">&nbsp;</td></tr>    
                            <tr>
                                <td colspan="2"><h3>Address 2</h3></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><input type="checkbox" checked name="locActive2" id="locActive2" value="1" /> This address will be active</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input type="text" name="locName2" id="locName2" /></td>
                            </tr>        
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="locAdd2" id="locAdd2" /></td>
                            </tr>                
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" name="phone2" id="phone2" /></td>
                            </tr>    
                            <tr><td colspan="2">&nbsp;</td></tr>     
                              </table> 
                    </td>
                    <td valign="top">
                    	<table cellpadding="5">
                            <tr>
                                <td colspan="2"><h3>Address 3</h3></td>
                            </tr>
                            
                            <tr>
                            	<td colspan="2"><input type="checkbox" checked name="locActive3" id="locActive3" value="1" /> This address will be active</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input type="text" name="locName3" id="locName3" /></td>
                            </tr>        
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="locAdd3" id="locAdd3" /></td>
                            </tr>                   
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" name="phone3" id="phone3" /></td>
                            </tr>      
                            <tr><td colspan="2">&nbsp;</td></tr>    
                     
                     
                     
                            <tr>
                                <td colspan="2"><h3>Address 4</h3></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><input type="checkbox" checked name="locActive4" id="locActive4" value="1" /> This address will be active</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input type="text" name="locName4" id="locName4" /></td>
                            </tr>        
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="locAdd4" id="locAdd4" /></td>
                            </tr>                
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" name="phone4" id="phone4" /></td>
                            </tr>         
                            <tr><td colspan="2">&nbsp;</td></tr> 
                               </table> 
                    </td>
                    <td valign="top">
                    	<table cellpadding="5">
                            <tr>
                                <td colspan="2"><h3>Address 5</h3></td>
                            </tr>
                            <tr>
                            	<td colspan="2"><input type="checkbox" checked name="locActive5" id="locActive5" value="1" /> This address will be active</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input type="text" name="locName5" id="locName5" /></td>
                            </tr>        
                            <tr>
                                <td>Address</td>
                                <td><input type="text" name="locAdd5" id="locAdd5" /></td>
                            </tr>               
                            <tr>
                                <td>Phone</td>
                                <td><input type="text" name="phone5" id="phone5" /></td>
                            </tr>          
                            <tr><td colspan="2">&nbsp;</td></tr>       
                        </table>
                    </td>
                </tr>
            </table>    
            	
        </td>
    </tr>
</table>    
    </form>
    
<?php include("downpart.php")?>
