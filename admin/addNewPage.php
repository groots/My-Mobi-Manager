<?php
	include("session_check.php");
	
	$_SESSION['userName'];
	
	
	$pagetitle="Create Mobile Content";
	$pagetag = "Good content creates great relationships!";
	$Userid=$_SESSION['ID'];
	$siteId = $_SESSION['mobiId'];
	
	///////////////  INTEGRATIONS //////////////////////////
	
	
	
	
	$sqlu="SELECT SiteName FROM ".$projectName."moSiteInfo WHERE siteId=$siteId";
	$resultu=mysql_query($sqlu); 
	 
	$recordu=mysql_fetch_array($resultu);
	$userName=$recordu['SiteName'];


	if($_POST['addNewPage']){
		if ($_POST['pageType'] == 'mobile') {
			$pageType = 0;
		} elseif ($_POST['pageType'] == 'coupon') {
			$pageType = 1;
		}
		$sql=" select pageslimit  FROM ".$projectName."plansettings p , ".$projectName."user u where u.Userid=$Userid and u.planidno =p.planid  and pageslimit -1 <  (select count(*) from ".$projectName."page where Userid=$Userid) ";
		
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		//if($row['pageslimit']) 
		//$errormessage=$errormessage . "You have exceeded your page limit.";
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
			
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url can't be empty<br>";
					
		if ($errormessage==''){
			$returnFromSave=addNewPage_save_form($Pagetitle,$siteId,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$mChimpListID,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink, $publishContent);
			if ($returnFromSave=="true") {
					$successmessage="Add New Page Saved Successfully";	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
					$mChimpListID = '';
					$ccFlag ='';
					$isNav = '';
					$Pageorder='';
					$parentLink='';
					$pageType='';
					$publishContent='';
					header("location: viewmypage.php");
			} else
				$errormessage=$errormessage . $returnFromSave;
		}  // END OF if($errormessage=='')
	
	} elseif($_POST['cancelPage'])  { //END OF if($_POST['addNewPage'])
		header("location: viewmypage.php"); 
	}
	
	$sql3="SELECT * FROM mobilemanager_google_analytics  WHERE mobiSiteId = '$siteId'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
?>

<script language="javascript" type="text/javascript">
function makeurl () 
{

var http = "http://";
var userName = "<?= $userName; ?>";
var str = ".";
var mmanager = "<?=$domainname?>";
var str1 = "/?";
var Pagetitle =  document.getElementById('Pagetitle').value;
var title = Pagetitle.replace(/ /g,"_");
var html = ".html";
var url= http + userName + str + mmanager + str1 + title + html;

document.getElementById('Seourl').value = url;
}

$(document).ready(function () {
  //id is the ID for the DIV you want to display it as modal window
  launchWindow(id);
});
</script>


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
<div id="boxes">

    <div id="dialog" class="window">
    <h2>Active Formstack Forms</h2> 
        <table width="900px">
        <tr>
        <td width="150px" valign='top'>
         <?
		 
		 
						require_once '../formstack.php';
			 			$formstack = new Formstack($row3['fStackAPIKey']);
						$res = $formstack->forms();
						
						foreach($res['forms'] as $form) {
							$bx++;
							print " <h5>$bx. {$form['name']}<br /><a href='alert('Hello world'>{$form['id']}</a></h5>";
							if($bx == 10 || $bx == 20 || $bx == 30 || $bx == 40 || $bx == 50 || $bx == 60 ||$bx == 70 || $bx == 80 || $bx == 90){
								echo "</td><td valign='top' width='150px'>";
							}
						}
						?>
        <!-- close button is defined as close class -->
        </td>
        </tr>
        </table>
    <a href="#"class="close"/>Close it</a>
    </div> 
<!-- Mask to cover the whole screen -->
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
                                
                                
                                    $apikey = 'cfd4263fd6fb922950c74d2e778ce56b-us1';
                                
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

<form  action="addNewPage.php" method="post" onSubmit="return validateForm1()">


<table>
  <tr>
    <td align="center"><input type="submit"  class="formButton" name="addNewPage"  value="Submit Content" /> <input type="submit" name="cancelPage" class="formButton" value="CANCEL"/></td>
    <!--td><input type="button"  class="forminput2" name="cancelPage"  value="Submit Page" /></td-->
  </tr>

</table>
<?PHP 
$pageAction = $_GET['pagetype'];

	if ($pageAction == 'Coupon') {
?>
<table>
	<tr>
    	<td>
                <table>
                <tr>
                    <td>Coupon Title</td>
                    <td><input class="fieldStyle" type="text" name="cTitle" id="cTitle" /></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Coupon Discount</td>
                    <td><input class="fieldStyle" type="text" name="discount" id="discount" /></td>
                </tr>
                <tr>
                    <td>Coupon Description</td>
                    <td><input class="fieldStyle" type="text" name="cDesc" id="cDesc" /></td>
                </tr>
                <tr>
                    <td>SEO URL</td>
    				<td><input class="fieldStyle" type="text" class="forminput" name="Seourl" id="Seourl" value="<?=$Seourl?>" onblur="makeurl()" /></td>
                </tr>
            </table>
    	</td>
    	<td>
                <table class="coupon">
                <tr>
                    <td><font size="-4">"Coupon Discount</font> <h1>30% off</h1></td>
                </tr>
                <tr>
                    <td>Coupon Description</td>
                </tr>
            </table>
        		<input type="hidden" name="pageType" id="pageType" value="coupon" />
        </td>
    </tr>
</table>
	

<?PHP
	
	
} else {
	
	
?>	

<table width="100%" cellpadding="5" cellspacing="5" class="icontent">
	<tr>
    	<td width="40%" valign="top">
			
<div>
     <ul class="tabs">
         <li><a href="#"><span>Page Info</span></a></li>
         <li><a href="#"><span>Page Content</span></a></li>
         <li><a href="#"><span>Additional Options</span></a></li>
     </ul>
     <div class="panes">
         <div class="hide">
         <table id="addNewPageTable" border="0" cellpadding="0" cellspacing="0" align="left">
                  <tr height="15px">
                    <td align="left">
                        <h3>Publishing Options</h3>
                        <?
                            if ($publishContent == '1') {
                                $activeCheck ="checked='checked'";
                            } elseif($publishContent == '2') {
                                $draftCheck ="checked='checked'";
                            } else {
                                $activeCheck ="";
                            }
                        
                        ?>
                        <div class="fieldExtraStyle">
                            <input type="radio" name="publishContent" id="publishContent" value="1" /> Publish <input type="radio" name="publishContent" id="draft" value="2" /> Save as Draft <input type="radio" name="publishContent" id="unpublish" value="0" /> UnPublish  
                            <br /><br />
                            <? if ($isNav = "1") {
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
                            <input type="text"  class="fieldStyle" name="Pagetitle" id="Pagetitle" value="<?=$Pagetitle?>" onblur="makeurl()"/><br />
                            This will also be the name of the link in your main navigation.
                        </div>
                    </td>
                  </tr>
                    <tr>
                        <td><h3>Parent Item</h3>
                        <div>
                         <SELECT NAME="parentLink" size="8" style="width: 250px; background: #FDDEA9;">
                            <OPTION VALUE="0">Choose a link</OPTION>        
                              <?php             
                                $sql="select * from ".$projectName."page WHERE mobiSiteId = $siteId";
                                $result=mysql_query($sql);
                                while($row=mysql_fetch_array($result)){  
                                  echo "<OPTION VALUE='" . $row['pageid']. "'>" . $row['Pagetitle'] . "</OPTION>";
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
                        width:'500px',height:'240px',
                        filebrowserBrowseUrl : '../ckeditor/ckfinder/ckfinder.html',
                        filebrowserFlashBrowseUrl : '../ckeditor/ckfinder/ckfinder.html?type=Flash',
                        filebrowserUploadUrl : '../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                        filebrowserImageUploadUrl : '../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                        filebrowserFlashUploadUrl : '../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                    
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
                 
                 <tr>
                    <td height="30">
                        <h3>Rss Path</h3>
                        <div class="fieldExtraStyle">	
                            <input type="text" class="fieldStyle" name="Rsspath" id="Rsspath" value="<?=$Rsspath?>" /> <br />
                            Add the link to an RSS Feed here (optional).
                        </div>
                     </td>
                 </tr>
                 <?PHP if($row3['fStackAPIKey'] != "") {  ?>
                 <tr id="rssPath">
                    <td height="30"><h3>Add Formstack Form</h3>
                        <div class="fieldExtraStyle">
                            <input type="text"  class="fieldStyle" name="formStackId" id="formStackId" value="<? echo $row['formstackId'];?>" /><br />
                            <a href="#dialog" name="modal">View Available Formstack Forms</a> 
                        </div>
                     
                    </td>
                 </tr>
                <?PHP  }  
                
                        if($row3['mChimpListID'] != "") {  ?>
                 <tr id="rssPath">
                    <td height="30"><h3>Add MailChimp List ID</h3>
                        <div class="fieldExtraStyle">
                            <input type="text"  class="fieldStyle" name="mChimpListID" id="mChimpListID" value="<? echo $row['mChimpListID'];?>" /><br />
                            <a href="#dialog3" name="modal">View Available MailChimp Lists</a> 
                        </div>
                     
                    </td>
                 </tr>
                <?PHP  } 
                
                ?>
                 <?php
                    if($row3['ccLogin'] !="" && $row3['ccPassword'] != ""){	 
                 ?>
                 <tr id="constantContact">
                    <td height="30"><h3>Add Constant Contact</h3>
                        <div class="fieldExtraStyle">
                            <input type="checkbox" name="ccFlag" id="ccFlag" value="1" <? $checked = (!empty($row['ccFlag'])) ? 'checked' : ''; echo $checked; ?>  />
                            Add the <a href="http://constantcontact.com" target="_blank">Constant Contact</a> form to this page.
                        </div>
                    </td>
                 </tr>
                 <?php
                    }
                 ?>
                 <tr > 
                    <td height="30">
                        <h3>SEO url</h3>
                        <div class="fieldExtraStyle">
                            <input type="text" class="fieldStyle" name="Seourl" id="Seourl" value="<?=$Seourl?>" onblur="makeurl()" /> <br />
                            This is based on page title, but you can modify as you need.
                        </div>
                    </td>
                 </tr>
                  <tr>
                    <td height="30">
                        <h3>Page Order</h3>
                        <div class="fieldExtraStyle">
                            <input type="text" class="fieldStyle" name="Pageorder" id="Pageorder" value="<?=$Pageorder?>"  />
                        </div>
                    </td>
                 </tr>
                    </table>
            
            </div>
         </div>      
         </div>  	
        </td>
    </tr>
</table>

<?php 
}
?>
</form>		

<script>
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>
<?PHP include("downpart.php"); ?>