<?php

	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	if(isset($_GET['mobiId'])){
		$curMobiId = $_GET['mobiId'];
	} else {
		$curMobiId = $_SESSION['mobiId'];		
	}
	
	$currentPage = curPageURL();
	//     echo $currentPage;
	//exit;
	$live_site2 = "http://squishdev.com/mymobimanager/index.php";
	$live_site3 = "http://mymobimanager.com/admin/userHome.php";
	$live_site4 = "http://www.mymobimanager.com/";
	$live_site5 = "http://www.mymobimanager.com";
	$live_site6 = "http://www.mymobimanager.com/index.php";

	$sqlu="SELECT SiteName FROM ".$projectName."moSiteInfo WHERE siteId=" . $curMobiId;
	$resultu=mysql_query($sqlu);  
	$recordu=mysql_fetch_array($resultu);
	
	$_SESSION['iUsr'] = $recordu['SiteName'];
	
	$sqlp = "SELEECT Pagetitle, Seourl FROM mobilemanager_page WHERE moSiteId = ". $curMobiId;
	$resultp=mysql_query($sqlp);  
	$recordp=mysql_fetch_array($resultp);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!--script src="../javascript.js"></script>
<script src="../sorttable.js"></script>
<script src="../CalendarPopup.js"></script-->
<script src="/scripts/tag-cx-qrcode.js" type="text/javascript"></script>
<link href="/mycss.css" rel="stylesheet" />
<link rel="Stylesheet" href="/css2/css.css" type="text/css" media="screen" />
<link rel="Stylesheet" href="/css2/ui.tabs.css" type="text/css" media="screen" />
<link rel="Stylesheet" href="/css2/mcubed.css" type="text/css" media="screen" />
<title>Mobile Website Manager</title>

<script>
	function deleteAlert(name,id){
		var conBox = confirm("Are you sure you want to delete: " + name);
		if(conBox){
			location.href="<?=$_SERVER['PHP_SELF'];?>?id="+ id + "&mode=remove";
		}else{
			return;
		}
	}
</script>

<script type="text/javascript" src="/scripts/jquery-latest.pack.js"></script>
<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			
	
});

</script>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/scripts/jquery-ui-personalized-1.6rc6.js"></script>
<script type="text/javascript" src="/scripts/jquery-ui-1.7.1.custom.min.js"></script>
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
		
	$("#designed").tabs();					   
		
	});	
</script>   

				<?php
				$queryRX  = "SELECT * FROM mobilemanager_page WHERE mobiSiteId = '" . $curMobiId . "' ORDER BY Pageorder ASC";
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
	<link rel="stylesheet" type="text/css" href="/css/tabs.css" />
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
	
	<!--[if lt IE 8]>
		<style>
			html { overflow-x:hidden; }	
			#content ol, #content ul  {margin-left: 50px; }
		</style>
	<![endif]-->	
<script src="javascript.js"></script>
 

</head>

<body class="home2" onLoad="">
<div id="adminHeader">
	<table width="100%" align="center" style=" margin: 0 auto -4em;">
    	<tr>
        	<td>
          		<img src="/images/logo.png" style="margin-bottom: 20px;" width="260" border="0" />
          	</td>
        	<td valign="top" align="right">
  
		<?  

		if ($_SESSION['loggedIn'] == 'yes'){ ?> 
       		<a style="color: #fff;" href="logout.php">Logout <?= ucfirst($recordu['SiteName']); ?></a> 
		<? } else { ?> 
        <a style="color: #fff;" href="https://fifthfloor.mymobimanager.com/login.php">Sign in</a> <? } ?> |  <a style="color: #fff;" href="/contact.php">Help/Support</a></td>
        </tr>
    </table>

  <div class="header" style="position: relative; padding-left: 30px;">
    <div class="container">
    
       <div class="links">
       
		<?PHP 	if($live_site3 != $currentPage) { ?>
         
       
<? if ($curMobiId != "") { ?>       
        <!--a href="/">Homepage</a--> <a href="mobiHome.php">Dashboard</a>  | 
	<a href="global_settings.php">Appearance</a> |  
    <a href="viewmypage.php">Pages</a> |  

<?PHP 
	if ($Userid == '93') {
?>		
    <a href="viewmypage.php">Advertisements</a> |  
<?PHP
	}
?>	
	<a href="g_analyticstracking.php">Enhancements</a>	 |  
    <!--p class="adminLinks"><a href="addNewPage.php">Create a mobile webpage</a><p/ -->
<? } }?>
	<a href="allLocations.php">Locations</a>	 | 
	<a href="accountInfo.php">Account Info</a>	 |  
	<a href="#">Resources</a>	 
       
       
       
       
       
       </div> <div class="sign_links">
		
        </div>
    </div>
  </div>

  <div class="">
    <div class="">
      <div class="">
        <!--div class="badge">
          <a href="#recommended"><img src="images/badge-98percent.png" width="102" height="101" alt="98% Customer Recommended" /></a>
        </div-->
             

       </div>
     </div>
  </div>
  </div>

<div class="mwrapper" >
<table>
<tr>
	<td align="center" valign="top">
<br>
<br>
<br>

             <h2 align="left" style="margin-botton: -8px;"><?=$pagetitle?></h2>
<? if ($successmessage!=""){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #06F;">
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
    <td class="redmessage" align="left" valign="middle">
<?php echo '<strong>' . $errormessage . '</strong>'; ?></td>
  </tr>
</table>
<br>
<? } 

?>