<?php
include("session_check.php");

	$pagetitle="Edit a Mobile Homepage";
	$pagetag = "There's no place like home!";
	$Userid=$_SESSION['ID'];
	
	if($_POST['Submit']){
		$homeText = addslashes($_POST['PostArea']);
		$sql="Update mobilemanager_user set homePageText='$homeText' where Userid='$Userid'";
		mysql_query($sql);	
		if ($returnHome=="true") {
				$successmessage="Add Homepage Saved Successfully";	
				header("location: editHomepage.php");
		} else {
			$errormessage=$errormessage . $returnFromSave;
		}
	}
	
	$sqlu="SELECT userName, homePageText FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu); 
	 
	$recordu=mysql_fetch_array($resultu);
	$userName=$recordu['userName'];
	$homePage = $recordu['homePageText'];

?>

<?php include("toppart.php"); ?>
	<center>

<form id="formSubmit"   action="editHomepage.php" method="post" >
<textarea name="PostArea" cols="" rows="5" id="PostArea" class="area" onkeyup="CountlimitChars()"><?PHP echo $homePage; ?></textarea>
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
                    width:'500px',height:'300px'
                
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
<div class="update-button"><input type="submit" name="Submit" value="Update Homepage" id="Submit" /></div>
</form>

</center>	
<?php include("downpart.php"); ?>