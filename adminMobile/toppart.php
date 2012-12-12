<?php
session_start();



	$sqlu="SELECT userName FROM ".$projectName."user WHERE Userid=$Userid";
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);

$sqlp = "SELEECT Pagetitle, Seourl FROM mobilemanager_page WHERE Userid = $Userid";
	$resultp=mysql_query($sqlp);  
	$recordp=mysql_fetch_array($resultp);
?> 
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css.css" type="text/css">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckfinder/ckfinder.js"></script>

<script src="../javascript.js"></script>
<script src="../sorttable.js"></script>
<script src="../CalendarPopup.js"></script>
<link href="../mycss.css" rel="stylesheet" />
<link rel="Stylesheet" href="../css/css.css" type="text/css" media="screen" />
<link rel="Stylesheet" href="../css/ui.tabs.css" type="text/css" media="screen" />
<title>Mobile Website Manager</title>
	<link rel="stylesheet" type="text/css" href="../css/tabs.css" />
	<!-- tab pane styling -->
	<style>
	
#contentWrap {
	width: 100%;
	margin: 0 auto;
	height: auto;
	overflow: hidden;
	color: #fff;
}
#contentLeft {
	width: 100%;
	float: left;
}
#contentLeft li {
	width: 100%;
	list-style: none;
	margin: 0 0 4px 0;
	padding: 10px;
	background-color:#71A8B2;
	border: #CCCCCC solid 1px;
	color:#fff;
}

#contentLeft a {
	color: #fff;	
}

	</style>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
 

<script type="text/javascript" src="../scripts/jquery-ui-personalized-1.6rc6.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.7.1.custom.min.js"></script>
<script>
$(document).ready(function() {
	$("#designed").tabs();			
	$("#designed1").tabs();			
	$("#designed2").tabs();					   
});
</script>


 <script type="text/javascript">
	$(document).ready(function(){ 
							   
		$(function() {
			$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
				var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
				$.post("updateDB.php", order, function(theResponse){
					$("#contentRight").html(theResponse);
				}); 															 
			}								  
			});
		});
		
	$("#example").tabs();					   
		
	});	
</script>   

				<?php
				$queryRX  = "SELECT * FROM mobilemanager_page WHERE Userid = $Userid ORDER BY Pageorder ASC";
				$resultRX = mysql_query($queryRX);
				$sRX =0;
				$pageDD = "[";
				while($rowRX = mysql_fetch_array($resultRX, MYSQL_ASSOC))
				{
					$sRX++;
                    $pageDD .= '["' . $rowRX['Pagetitle']. '", "' . $rowRX['Seourl'] . '"],';
				} 
				$pageDD = substr($pageDD,'',-1);
				$pageDD .= "]";
				?> 

<script type="text/javascript" src="/path/to/tinyMCE_linklist.js"></script>
       <script type="text/javascript"> 
        //<![CDATA[

// When opening a dialog, its "definition" is created for it, for
// each editor instance. The "dialogDefinition" event is then
// fired. We should use this event to make customizations to the
// definition of existing dialogs.
CKEDITOR.on( 'dialogDefinition', function( ev )
        {
                // Take the dialog name and its definition from the event
                // data.
                var dialogName = ev.data.name;
                var dialogDefinition = ev.data.definition;

                // Check if the definition is from the dialog we're
                // interested on (the "Link" dialog).
                if ( dialogName == 'link' )
                {
                        // Get a reference to the "Link Info" tab.
                        var infoTab = dialogDefinition.getContents( 'info' );

                        // Remove the "Link Type" combo 
                         infoTab.remove( 'linkType' );

                        // Set the default value for the URL field.
                        var urlField = infoTab.get( 'url' );
                        urlField['default'] = 'www.example.com';

                        // Add a dropdown select/combo to the "info" tab.
                        infoTab.add( {
                                        id : 'customLinks',
                                        type : 'select',
                                        label : 'Custom Links',
                                        'default':'',
                                        items:<?= $pageDD; ?>,
                                        onChange:function(){var d = CKEDITOR.dialog.getCurrent();d.setValueOf("info", "url", this.getValue());} 
                        });

                        // Rewrite the 'onFocus' handler to always focus 'url' field.
                        dialogDefinition.onFocus = function()
                        {
                                var urlField = this.getContentElement( 'info', 'url' );
                                urlField.select();
                        };
                }
        });

        //]]>
        </script> 

	<!-- tab styling -->

	
	<!--[if lt IE 8]>
		<style>
			html { overflow-x:hidden; }
			#content ol, #content ul  {margin-left: 50px; }
		</style>
	<![endif]-->	
 
 
</head>
 
<body class="home2" onLoad=""> 
  <div class="header" style="position: relative;" >
    

<table align="center"  border="0" cellspacing="10" cellpadding="10"   >
<tr>

<?PHP  if($showLogin != 'fish'){ ?>  
 
  
<?PHP } ?>  
	<td align="center" valign="top">
          <img src="../images/logo.png"  width="200" border="0"  />
	

 <? if ($successmessage!=""){ ?>
<table   border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40px"><img src="success.PNG" /></td>
    <td class="greenmessage" align="left" valign="middle"><?=$successmessage?></td>
  </tr>
</table>
<? } ?>

<? if ($errormessage!=""){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40px"><img src="error.PNG" /></td>
    <td class="redmessage" align="left" valign="middle"><?=$errormessage?></td>
  </tr>
</table>
<? } 

?>