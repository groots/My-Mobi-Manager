<?php
	include("session_check.php");
	
	$_SESSION['userName'];
	
	$pagetitle="Create Mobile Content";
	$pagetag = "Good content creates great relationships!";
	$Userid=$_SESSION['ID'];
	
	
	///////////////  INTEGRATIONS //////////////////////////
	
	
	
	
	$sqlu="SELECT userName FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu); 
	 
	$recordu=mysql_fetch_array($resultu);
	$userName=$recordu['userName'];



	if($_POST['addNewPage']){
		if ($_POST['pageType'] == 'mobile') {
			$pageType = 0;
		} elseif ($_POST['pageType'] == 'coupon') {
			$pageType = 1;
		}
		$sql=" select pageslimit  FROM ".$projectName."plansettings p , ".$projectName."user u where u.Userid=$Userid and u.planidno =p.planid  and pageslimit -1 <  (select count(*) from ".$projectName."page where Userid=$Userid) ";
		
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		if($row['pageslimit']) 
		$errormessage=$errormessage . "You have exceeded your page limit.";
		if ($Pagetitle=='')
			$errormessage=$errormessage . "Page title can't be empty<br>";
			
		if ($Seourl=='')
			$errormessage=$errormessage . "SEO url can't be empty<br>";
					
		if ($errormessage==''){
			$Seourl = "http://" . $recordu['userName'] . ".mymobimanager.com/?" . $_POST['Pagetitle'] . ".html";
			$returnFromSave=addNewPage_save_form($Pagetitle,$Userid,$content,$Seourl,$creationdate,$Rsspath,$formStackId,$ccFlag,$isNav,$Pageorder,$projectName,$parentLink, $publishContent);
			if ($returnFromSave=="true") {
					$successmessage="Add New Page Saved Successfully";	
					$Pagetitle='';
					$content='';
					$Seourl='';
					$Rsspath='';
					$formStackId='';
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
	} elseif($_POST['cancelPage'])  { 
		header("location: viewmypage.php"); 
	}
	
	$sql3="SELECT * FROM mobilemanager_google_analytics  WHERE userId = '$Userid'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
?>
 
<?php include("toppart.php"); ?> 
<form  action="addNewPage.php" method="post" onSubmit="return validateForm1()">

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

<table  cellpadding="5" cellspacing="5">
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
                    width:'500px',height:'240px'
                
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
        
        <td valign="top">
			
<div id="pageOpts">  
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
                		<input type="radio" name="publishContent" id="publishContent" value="1" /> Publish <input type="radio" name="publishContent" id="draft" value="2" /> Draft <input type="radio" name="publishContent" id="unpublish" value="0" /> UnPublish  
                        <br /><br />
                        <? if ($isNav = "1") {
							$isNavCheck = "Checked='Checked'";	
						} else {
							$isNavCheck = "";	
						}
						?>
                        <input type="checkbox" name="isNav" id="isNav" value="1" <?= $isNavCheck; ?> /> Navigation or Sub Navigation
                	</div>
                </td>
              </tr>
              <tr>
                <td height="30">
                	<h3>Page Title</h3>
                	<div class="fieldExtraStyle">
                		<input type="text"  class="fieldStyle" name="Pagetitle" id="Pagetitle" value="<?=$Pagetitle?>" onblur="makeurl()"/> 
                	</div>
                </td>
              </tr>
                <tr>
                    <td><h3>Parent Item</h3>
                    <div>
                     <SELECT NAME="parentLink" size="8" style="width: 250px; background: #FDDEA9;">
                        <OPTION VALUE="0">Choose a link</OPTION>        
                          <?php             
                            $sql="select * from ".$projectName."page WHERE Userid=$Userid ";
                            $result=mysql_query($sql);
                            while($row=mysql_fetch_array($result)){  
                              echo "<OPTION VALUE='" . $row['pageid']. "'>" . $row['Pagetitle'] . "</OPTION>";
                            }
                            ?> 	          
                    </SELECT>
                    </div>
                    <input type="hidden" id="pageType" name="pageType" value="mobile" />
                    </td>
                </tr> 
             <tr>
                <td height="30">
                	<h3>Rss Path</h3>
                	<div class="fieldExtraStyle">	
                        <input type="text" class="fieldStyle" name="Rsspath" id="Rsspath" value="<?=$Rsspath?>" /> 
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
            <?PHP  }  ?>
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
             <tr style="display: none;">
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
        </td>
    	
    </tr>
</table>

<?php 
}
?>

<table>
  <tr>
    <td align="center"><input type="submit"  class="formButton" name="addNewPage"  value="Submit Content" /> <input type="submit" name="cancelPage" class="formButton" value="CANCEL"/></td>
    <!--td><input type="button"  class="forminput2" name="cancelPage"  value="Submit Page" /></td-->
  </tr>

</table>
</form>		

<?PHP include("downpart.php"); ?>