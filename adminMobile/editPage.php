<?php
	include("session_check.php");

	$pagetitle="Update Page";
	$pagetag = "If everyone is thinking alike, then somebody isn't thinking -George S. Patton";
	
	$Userid=$_SESSION['ID'];
	
	///////////////  INTEGRATIONS //////////////////////////
	
	
	$sql3="SELECT * FROM mobilemanager_google_analytics WHERE userId = '$Userid'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	
	
	///////////// END INTEGRATIONS /////////////////////////
	
	
	$sqlu="SELECT userName FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);
	
	if($_GET['idForEdit']){
		$id=$_GET['idForEdit'];
		$sql="select * from ".$projectName."page where pageid='$id'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
	}
	if($_POST['editPage'] || $_POST['applyPage'] ){
		$id=$_POST['idForEdit'];
	
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
	
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		
		if ($errormessage==''){ 
			$Seourl = "http://" . $recordu['userName'] . ".mymobimanager.com/?" . $_POST['Pagetitle'] . ".html";
			$returnFromEdit=editPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$flagEbrite,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink,$publishContent,$pageType);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$flagEbrite='';
					$ccFlag='';
					$isNav='';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent ='';
					header("location: viewmypage.php");	
				} 
			} else
				$errormessage=$errormessage . $returnFromEdit;
		}  // END OF if($errormessage=='')	
	} elseif($_POST['cancelPage'])  { //END OF if($_POST['editPage'])
		header("location: viewmypage.php"); 
	}

?> 


<?php include("toppart.php"); ?> 
<form  action="editPage.php" method="post" onSubmit="return validateForm1()">


 <table width="100%" cellpadding="5" cellspacing="5">
	<tr>
    <td  valign="top">
        	<table>            	
                  <tr>
                <td>
                	<h3>Page Content</h3>
                <textarea name="content" cols="30" rows="7"><? echo $row['content']; ?> </textarea>
                <script type="text/javascript">

// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
{
	document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'value (line 32).' ) ;
}
else
{
	var editor = CKEDITOR.replace( 'content' ,{
                <?  $sql="SELECT usertype FROM ".$projectName."user WHERE Userid=$Userid";
                $result=mysql_query($sql); 
                 
                $record=mysql_fetch_array($result);
                 if($record['usertype']=='iPhone') {
                ?>
                    toolbar : 'iPhone', <? } ?>
                <?	 if($record['usertype']=='Both') 
                {
                ?>
                    toolbar : 'Both', <? } ?>
                    <?	 if($record['usertype']=='General Phone') 
                {
                ?>
                    toolbar : 'GeneralPhone', <? } ?>
                    width:'500px',height:'250px'
                
                 } 
                 );


	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	CKFinder.setupCKEditor( editor, '/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
}

		</script>
                
                </td> 
                </tr>
            </table>        
        </td>
        </tr>
        <tr>
    	<td width="50%" valign="top">  
                 <table id="addNewPageTable" border="0" cellpadding="0" cellspacing="0" align="left">
                          <tr height="15px">
                            <td align="left">
                                <h3>Publishing Options</h3>
                                <?
                                    if ($row['active'] == '1') {
                                        $activeCheck ="checked='checked'";
                                    } elseif($row['active'] == '2') {
                                        $draftCheck ="checked='checked'";
                                    } else {
                                        $notActiveCheck ="checked='checked'";
                                    }
                                
                                ?>
                                <div class="fieldExtraStyle">
                                    <input type="radio" name="publishContent" id="publishContent" value="1" <?= $activeCheck;?>  /> Publish <input type="radio" name="publishContent" id="draft" value="2" <?= $draftCheck;?> /> Save as Draft <input type="radio" name="publishContent" id="unpublish" value="0" <?= $notActiveCheck;?> /> UnPublish  
                                    <br /><br />
                                    <? if ($row['isNav'] == "1") {
                                        $isNavCheck = "Checked='Checked'";	
                                    } else {
                                        $isNavCheck = "";	
                                    }
                                    ?>
                                    <input type="checkbox" name="isNav" id="isNav" value="1" <?= $isNavCheck; ?> /> Will be used in Site Navigation or Sub Navigation
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td height="30">
                                <h3>Page Title</h3>
                                <div class="fieldExtraStyle">
                                    <input type="text"  class="fieldStyle" name="Pagetitle" id="Pagetitle" value="<? echo $row['Pagetitle'];?>" onBlur="makeurl()"/><br />
                                    This will also be the name of the link in your main navigation on your mobile website.
                                </div></td>
                          </tr>
                            <tr>
                                <td><h3>Parent Item</h3>
                                <div>
                                 <SELECT NAME="parentLink" size="8" style="width: 250px; background: #FDDEA9;">
                                    <OPTION VALUE="0">Choose a link</OPTION>        
                                      <?php     
                                      
                                        $pLInk = $row['Parentlink'];
                                        $sqlp="select * from ".$projectName."page WHERE Userid=$Userid ";
                                        $resultp=mysql_query($sqlp);
                                        while($rowp=mysql_fetch_array($resultp)){  
                                            if ($pLInk == $rowp['pageid']){
                                                $parentSelect = "selected='	selected'"; 	
                                            } else {
                                                $parentSelect = "";	
                                            }
                                            echo "<OPTION VALUE='" . $rowp['pageid'] . " " . $parentSelect . "'>" . $rowp['Pagetitle']. "</OPTION>";
                                        }
                                        ?> 	    
                                </SELECT>
                                </div>
                                <input type="hidden" id="pageType" name="pageType" value="mobile" />
                                </td>
                            </tr> 
                         <tr id="rssPath">
                            <td height="30"><h3>Rss Path</h3>
                                <div class="fieldExtraStyle">
                                    <input type="text"  class="fieldStyle" name="Rsspath"   id="Rsspath" value="<? echo $row['Rsspath'];?>" /><br />
                                    Add the link to an RSS Feed here (optional).
                                </div>
                            </td>
                         </tr>
                         
                         <?php
						 
						 if($row3['fStackAPIKey'] != "" ){	 
						 
                         ?>
                         <tr id="formStack">
                            <td height="30"><h3>Add Formstack Form</h3>
                                <div class="fieldExtraStyle">
                                    <input type="text"  class="fieldStyle" name="formStackId" id="formStackId" value="<? echo $row['fStackFormId'];?>" /><br />
                                    <a href="#dialog" name="modal" style="color: #F5C36D;">View Available Formstack Forms</a>
                                </div>
                                
                                
                            </td>
                         </tr>
                         <?php
                            }
							
                            if($row3['ebriteusr'] != "" ){	 
                         ?>
                         <tr id="formStack">
                            <td height="30"><h3>EventBrite Events</h3>
                                <div class="fieldExtraStyle" style="height: 20px;">
                                    <input type="checkbox" name="flagEbrite" id="flagEbrite" value="1" <? $eChecked = (!empty($row['flagEbrite'])) ? 'checked="checked"' : ''; echo $eChecked; ?> />Include your list of EventBrite Events 
                                </div>
                            </td>
                         </tr>
                         <?php
                            }
                            if($row3['ccLogin'] !="" && $row3['ccPassword'] != ""){	 
                         ?>
                         <tr id="constantContact">
                            <td height="30"><h3>Add Constant Contact</h3>
                                <div class="fieldExtraStyle" style="height: 20px;">
                                    <input type="checkbox" name="ccFlag" id="ccFlag" value="1" <? $checked = (!empty($row['ccFlag'])) ? 'checked="checked"' : ''; echo $checked; ?>  />
                                    Add the <a href="http://constantcontact.com" target="_blank">Constant Contact</a> form to this page.
                                </div>
                            </td>
                         </tr>
                         <?php
                            }
                         ?>
                         
                         <tr>
                            <td height="30"><h3>SEO url </h3>
                                <div class="fieldExtraStyle">
                                    <input type="text"  class="fieldStyle" name="Seourl" id="Seourl" value="<? echo $row['Seourl'];?>" onBlur="makeurl()" /><br />
                                    This is based on page title, but you can modify as you need.
                                </div>
                              </td>
                         </tr>
                           <!--tr>
                            <td height="30"><h3>Page Order</h3>
                                <div class="fieldExtraStyle">
                                    <input type="text"  class="fieldStyle" name="Pageorder" id="Pageorder" value="<? //echo $row['Pageorder'];?>"  />
                                </div>
                        </td>
                         </tr-->
                        
                        </table> 
        </td> 
    </tr>
</table>
<table align="center" width="100%">            
    <tr>
    <td align="center"><input type="submit" name="editPage" class="formButton" value="EDIT"/> <input type="submit" name="applyPage" class="formButton" value="APPLY"/> <input type="submit" name="cancelPage" class="formButton" value="CANCEL"/>
    <input type="hidden" name="idForEdit" value="<?=$id?>"/>
    </td>
    
    </tr>
</table>
            
</form>

<?php include("downpart.php"); ?>