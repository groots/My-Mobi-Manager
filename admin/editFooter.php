<?php
include("session_check.php");

	$pagetitle="Create a Mobile Webpage";
	$Userid=$_SESSION['ID'];
	$siteId = $_SESSION['mobiId'];
	
	if($_POST['Submit']){
		$footer = addslashes($_POST['PostArea']);
		$sql="Update mobilemanager_moSiteInfo set footer='$footer' where siteId='$siteId'";
		mysql_query($sql);	
		if ($returnHome=="true") {
				$successmessage="Add Footer Saved Successfully";	
				header("location: editFooter.php");
		} else {
			$errormessage=$errormessage . $returnFromSave;
		}
	}
	
	$sqlu="SELECT SiteName, footer FROM ".$projectName."moSiteInfo WHERE siteId=$siteId";
	$resultu=mysql_query($sqlu); 
	 
	$recordu=mysql_fetch_array($resultu);
	$userName=$recordu['SiteName'];
	$footer = $recordu['footer'];

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
	<center>

<form id="formSubmit"   action="editFooter.php" method="post" >

<textarea name="PostArea" cols="" rows="5" id="PostArea" class="area" onkeyup="CountlimitChars()"><?PHP echo $footer; ?></textarea>
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
	var editor = CKEDITOR.replace( 'PostArea' ,{
               
                    toolbar : [ ['Source','-','Cut','Copy','Paste','-','Undo','Redo','RemoveFormat','-','Link','Unlink','Anchor','-','Image','Table','HorizontalRule','SpecialChar'], '/', ['Format','Templates','Bold','Italic','Underline','-','Superscript','-',['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],'-','NumberedList','BulletedList','-','Outdent','Indent'] ],
                    width:'500px',height:'300px',
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

<span class="formmesssage"></span>
<div class="update-button"><input type="submit" name="Submit" value="Update Footer" id="Submit" /></div>
</form>

</center>	
 
<?php include("downpart.php"); ?>