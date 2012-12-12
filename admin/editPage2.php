<?php
	include("session_check.php");

	$pagetitle="Update Page";
	$pagetag = "If everyone is thinking alike, then somebody isn't thinking -George S. Patton";
	
	$Userid=$_SESSION['ID'];
	$siteId = $_SESSION['mobiId'];
	
	///////////////  INTEGRATIONS //////////////////////////
	
	
	$sql3="SELECT * FROM mobilemanager_google_analytics WHERE mobiSiteId = '$siteId'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	
	
	///////////// END INTEGRATIONS /////////////////////////
	
	
	$sqlu="SELECT SiteName FROM ".$projectName."moSiteInfo WHERE siteId=$siteId";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);
	
	if($_GET['idForEdit']){
		$id=$_GET['idForEdit'];
		$_SESSION['currentPageId'] = $id; 
		$sql="select * from ".$projectName."page where pageid='$id'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
	}
	if($_POST['editPage'] ){
		$id=$_POST['idForEdit'];
	
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
	
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		
		if ($errormessage==''){
			$returnFromEdit=editPage_save_form($Pagetitle,$siteId,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$flagEbrite,$ccFlag,$addStoreLocator,$isNav,$Pageorder,$projectName,$parentLink,$publishContent,$pageType);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$mChimpListID='';
					$flagEbrite='';
					$ccFlag='';
					$addStoreLocator='';
					$isNav='';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent ='';
					header("location: viewmypage.php");	
				} 
			} else
				$errormessage=$errormessage . $returnFromEdit;
		}  // END OF if($error-message=='')	 
	} elseif($_POST['cancelPage'])  { //END OF if($_POST['editPage'])
		header("location: viewmypage.php"); 
	} elseif($_POST['applyPage'])  { //END OF if($_POST['editPage'])
	
		$id=$_POST['idForEdit'];
	
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
	
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url cann't be empty<br>";
		
		if ($isNav != 1)
			$isNav =0;
		
		if ($errormessage==''){
			$returnFromEdit=editPage_save_form($Pagetitle,$siteId,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$flagEbrite,$ccFlag,$addStoreLocator,$isNav,$Pageorder,$projectName,$parentLink,$publishContent,$pageType);
			if ($returnFromEdit=="true"){
				$successmessage="Edit Successfully";
				if ($_POST['editPage']) {	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$mChimpListID='';
					$flagEbrite='';
					$ccFlag='';
					$addStoreLocator='';
					$isNav='';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent ='';
					header("location: editPage.php");	
				} 
			} else
				$errormessage=$errormessage . $returnFromEdit;
		}  // END OF if($error-message=='')	  
	}
 
?>

<script language="javascript" type="text/javascript">
	function makeurl () {
	
		var http = "http://";
		var userName = "<?=$recordu['SiteName']?>";
		var mmanager = ".<?=$domainname?>/?";
		var Pagetitle =  document.getElementById('Pagetitle').value;
		var title = Pagetitle.replace(/ /g,"_");
		var html = ".html";
		var url= http + userName + mmanager + title + html;
		
		document.getElementById('Seourl').value = url;
	}
	
	function addIdtofield(id, element) {
		//alert(id);    
		var mctextbox = document.getElementById(element);
		mctextbox.value = '';
    	mctextbox.value = mctextbox.value + id;
	}
</script>
	

<?php include("toppart.php"); ?>

			 <?PHP if($row3['fStackAPIKey'] != "") {  ?>
                    <!-- #dialog is the id of a DIV defined in the code below -->
                     
                    <div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialog" class="window">
                            <h2>Active Formstack Forms</h2> 
                            <table width="900px">
                            <tr>
                            <td width="150px" valign="top">
                             <?
                             
                             
                                            require_once '../formstack.php';
                                            $formstack = new Formstack($row3['fStackAPIKey']);
                                            $res = $formstack->forms();
                                            
                                            foreach($res['forms'] as $form) {
                                                $bx++;
												?>
                                                <h5><? echo $bx. $form['name'] ?><br /><a href="#" class="close" onclick="addIdtofield('<?= $form['id']; ?>', 'formStackId')"><?=$form['id'] ?></a></h5><? 
                                                if($bx == 10 || $bx == 20 || $bx == 30 || $bx == 40 || $bx == 50 || $bx == 60 ||$bx == 70 || $bx == 80 || $bx == 90){
                                                    echo "</td><td valign='top' width='150px'>";
                                                }
                                            }
                                            ?>
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                            <a href="#" class="close" style="color: #F5C36D;">Close Window</a>
                     
                        </div>
                     
                         
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                        <div id="mask"></div>
                    </div>
			<? } ?>                           
            		<div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialog1" class="window">
                            <h2>Page QR Code</h2> 
                            <table align="center">
                            <tr>
                            <td width="150px">                                          
                                <script type="text/javascript">
                                generateQRCODE("qr","250","<? echo $row['Seourl']; ?>");
                                </script>  
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                            Right click image to copy it to clipboard. <br />
                            <a href="#" class="close" style="color: #F5C36D;">Close Window</a>
                        </div>
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                        <div id="mask"></div>
                    </div>         

            		<div id="boxes" > 
                        <!-- #customize your modal window here --> 
                        <div id="dialog3" class="window">
                            <h2>Mailchimp Lists</h2> 
                            <table align="center">
                            <tr>
                            <td width="250px">             
                            
								<?php
                                /**
                                This Example shows how to pull the Members of a List using the MCAPI.php 
                                class and do some basic error checking.
                                **/
                                require_once 'inc/MCAPI.class.php';
                                require_once 'inc/config.inc.php'; //contains apikey
                                
                                
                                    $apikey = $row3['mChimpKey'];
                                
                                $api = new MCAPI($apikey);
                                
                                $retval = $api->lists();
                                
                                if ($api->errorCode){
                                    echo "Unable to load lists()!";
                                    echo "\n\tCode=".$api->errorCode;
                                    echo "\n\tMsg=".$api->errorMessage."\n";
                                } else {
                                    echo "<h3>Number of Active Lists:".$retval['total']."</h3>";
                                    //echo "Lists returned:".sizeof($retval['data'])."\n";
                                    foreach ($retval['data'] as $list){ 
                                        ?>
                                        <a href="#" class="close" onclick="addIdtofield('<?= $list['id']; ?>', 'mChimpListID')">
                                        <?
										echo $list['name']." - ". $list['id']."\n";
										?> 
                                        </a>
                                        <?
                                        //echo "Web_id = ".$list['web_id']."\n";
                                        //echo "\tSub = ".$list['stats']['member_count'];
                                        //echo "\tUnsub=".$list['stats']['unsubscribe_count'];
                                        //echo "\tCleaned=".$list['stats']['cleaned_count']."\n";
                                    }
                                }
                                
                                ?>
                            <!-- close button is defined as close class -->
                            </td>
                            </tr>
                            </table>
                            <p>
                            	<a href="#" class="close" style="color: #F5C36D;">Close Window</a>
                            </p> 
                        </div>
                        <!-- Do not remove div#mask, because you'll need it to fill the whole screen --> 
                        <div id="mask"></div>
                    </div>         
                     
                     
<form  action="editPage.php" method="post" onSubmit="return validateForm1()">

<table align="right" width="1000px">            
    <tr align="right">
    <td align="right"><input type="submit" name="editPage" class="formButton" value="Save"/> <input type="submit" name="applyPage" class="formButton" value="Apply"/> <input type="submit" name="cancelPage" class="formButton" value="Cancel"/>
    <input type="hidden" name="idForEdit" value="<?=$id?>"/>
    </td>
    
    </tr>
</table>

 <table width="100%" cellpadding="5" cellspacing="5" class="icontent">
	<tr>
    	<td width="50%" valign="top">
    
            <div>
                 <ul class="tabs">
                     <li><a href="#"><span>Page Info</span></a></li>
                     <li><a href="#"><span>Page Content</span></a></li>
                     <li><a href="#"><span>Additional Options</span></a></li>
                 </ul>
                 <div class="panes">
                     <div class="hide">
                     <table id="addNewPageTable" border="0" cellpadding="0" cellspacing="0" align="left" width="100px">
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
                                        <input type="text"  class="fieldStyle" name="Pagetitle" id="Pagetitle" value="<? echo $row['Pagetitle'];?>" onblur="makeurl()"/><br />
                                        This will also be the name of the link in your main navigation on your mobile website.
                                    </div></td>
                              </tr>
                                <tr>
                                    <td>
                                        <table cellpadding="15" cellspacing="5">
                                            <tr>
                                                <td><h3>Parent Item</h3>
                                                <div>
                                                 <SELECT NAME="parentLink" size="8" style="width: 200px; background: #FDDEA9;">
                                                    <OPTION VALUE="0">Choose a link</OPTION>        
                                                      <?php     
                                                      
                                                        $pLInk = $row['Parentlink'];
                                                        $sqlp="select * from ".$projectName."page WHERE mobiSiteId=$siteId";
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
                                                <td >
                                                    <h3>Page QR Code</h3>                                         
                                                    <script type="text/javascript">
                                                    generateQRCODE("qr","150","<? echo $row['Seourl']; ?>");
                                                    </script>
                                        <a href="#dialog1" name="modal" style="color: #106271;">Click for larger code</a> 
                                                </td>
                                            </tr>
                                        </table>
                                     </td>
                                </tr>
                      </table>
                     </div>
                     <div class="hide">
                                 <table>            	
                                  <tr>
                                <td>
                                    <h3>Page Content</h3>
                                <textarea name="content"><? echo $row['content']; ?> </textarea>
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
                                    width:'500px',height:'250px',
                  
        filebrowserBrowseUrl : '/ckeditor/ckfinder/ckfinder.html',
        filebrowserFlashBrowseUrl : '/ckeditor/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' 
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
                     </div>
                     <div class="hide">
                     
                            <table id="addNewPageTable" border="0" cellpadding="0" cellspacing="0" align="left"> 
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
                                
                                
                             if($row3['mChimpKey'] != "" ){	 
                             
                             ?>
                             <tr id="mailchimp">
                                <td height="30"><h3>Add Mailchimp List ID</h3>
                                    <div class="fieldExtraStyle">
                                        <input type="text"  class="fieldStyle" name="mChimpListID" id="mChimpListID" value="<? echo $row['mChimpListID'];?>" /><br />
                                        <a href="#dialog3" name="modal" style="color: #F5C36D;">View Available Mailchimp Lists</a>
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
                             
                              <?php
                                $sqlLocator = "SELECT * FROM mobilemanager_markers WHERE mobiSiteId = $siteId";
                                $resultLocator = mysql_query($sqlLocator);
                                $num_location_rows = mysql_num_rows($resultLocator);
                                //$locator = mysql_fetch_array($resultLocator);
                                if($num_location_rows > 1){	 
                             ?>
                             <tr id="constantContact">
                                <td height="30"><h3>Add Store Locator</h3>
                                    <div class="fieldExtraStyle" style="height: 20px;">
                                        <input type="checkbox" name="addStoreLocator" id="addStoreLocator" value="1" <? $checked = (!empty($row['addStoreLocator'])) ? 'checked="checked"' : ''; echo $checked; ?>  />
                                        Add a store locator to this page.
                                    </div>
                                </td>
                             </tr>
                             <?php
                                }
                             ?>
                             
                             <tr>
                                <td height="30"><h3>SEO url </h3>
                                    <div class="fieldExtraStyle">
                                        <input type="text"  class="fieldStyle" name="Seourl" id="Seourl" value="<? echo $row['Seourl'];?>" onblur="makeurl()" /><br />
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
                     </div>
                 </div>
			</div>
           <div style="clear:both;"></div> 
        </td> 
    </tr>
</table>
            
</form>

<script>
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>
<?php include("downpart.php"); ?>