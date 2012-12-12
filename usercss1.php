<?php
	header('Content-type: text/css'); 
	include("dbcon.php");
	$Name=$_GET['u'];
	$sql="select * from ".$projectName."global_settings x, ".$projectName."moSiteInfo y  WHERE x.mobiSiteId=y.siteId and  y.SiteName='$Name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
	body {
        max-width: 800px;
        margin:0px;
        padding:0px;
        padding-top: 10px;
<?  if($row['backgroundcolor']!="") {?>


background: <?= $row['backgroundcolor']; ?>; /* for non-css3 browsers */

<? if($row['haveGradient']=="1") {?>
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?= $row['2ndbackgroundColor']; ?>-+-+', endColorstr='<?= $row['backgroundcolor']; ?>'); /* for IE */
background: -webkit-gradient(linear, left top, left bottom, from(<?= $row['2ndbackgroundColor']; ?>), to(<?= $row['backgroundcolor']; ?>)); /* for webkit browsers */
background: -moz-linear-gradient(top,  <?= $row['2ndbackgroundColor']; ?>,  <?= $row['backgroundcolor']; ?>); /* for firefox 3.6+ */

<? }} if($row['backgroundimage']!="") { ?>
		background-image:url(/admin/gbimages/<? echo $row['backgroundimage']; ?>);
<? } ?>
<? if($row['font']!="") {?>
		font:"<? echo $row['font']; ?>"; 
<? } ?>
<? if($row['fontcolor']!="") {?>
		color: <? echo $row['fontcolor']; ?>; 
<? } ?>
}
	#styleTop {
    	margin-bottom: 1px;
        clear: both;
        height: auto;
    	
<? if($row['logobackgroundcolor']!="") {?>
		background: <? echo $row['logobackgroundcolor']; ?>; 
<? } ?>
    }
	#logo {
    		padding-top: 13px;
        display: block;
        margin-right: auto;
        margin-left: auto;

	}
    
    #topNav{
    	text-align:center;
        bottom: 13px;
        display: block;
        margin-right: auto;
        margin-left: auto;
		list-style-type: none;
		float: right;	
		background-position: bottom left;
		margin: 0;
		padding: 6px 0 6px 0;
	}
    
    #topNav li{
		list-style-type: none;
		margin: 0;
		padding: 0;
		float: left;
		font-size: 16px;
		line-height: 15px;
		text-transform: uppercase;
		padding: 4px 0 4px 7px;
		margin-bottom: 6px;
        min-width: 100px;
	}
	#topNav li a{
		text-decoration: none;
		padding: 9px 11px 9px 14px;
		font-weight: bold;
	}
    #searchBox {
    	display: none;
    }

    .nav { 
    }
    
    a.nav:link {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:visited {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:hover {color: <? echo $row['linktextcolor']; ?>; }
    a.nav:active {color: <? echo $row['linktextcolor']; ?>;}

    .m3link {
        padding: 5px;
        <? if($row['linkbgcolor']!="") {?>
        background-color:<? echo $row['linkbgcolor']; ?>;
        <? } ?>
        <? if($row['linktextcolor']!="") {?>
        color:<? echo $row['linktextcolor']; ?>;     
         <? } ?>
        margin: 0px 1px 5px 1px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
        line-height: 2em;
        white-space: nowrap;
        <? if($row['linkbordercolor']!="") {?>
        border-color:<? echo $row['linkbordercolor']; ?>;     
         <? } ?>
-moz-border-radius: 1em 4em 1em 4em;
border-radius: 1em 4em 1em 4em;
    }
    
    #searchBoxBG {
        <? if($row['searchBoxBG']!="") {?>
        background:<? echo $row['searchBoxBG']; ?>;     
         <? } ?>
        padding: 10px;
        border-width: thin;
        border-style:solid;
        <? if($row['linkbordercolor']!="") {?>
        border-color:<? echo $row['linkbordercolor']; ?>;     
         <? } ?>
        margin-bottom: 10px;
		text-align: center; 
        clear: both;
-moz-border-radius: 1em 4em 1em 4em;
border-radius: 1em 4em 1em 4em;
    }

    .mobileContentArea1 {
    	background: <?= $row['contentBGcolor']; ?>; 
        padding: 2px 8px 2px 8px; 
        width: auto; 
        /*border: <? //echo $row['searchBoxBG']; ?> thin solid; */
        margin: 1px 7px 4px 7px;
        clear: both;
        
        
<? if($row['haveContentGradient']=="1") {?>
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?= $row['2ndContentBgColor']; ?>-+-+', endColorstr='<?= $row['contentBGcolor']; ?>'); /* for IE */
        background: -webkit-gradient(linear, left top, left bottom, from(<?= $row['2ndContentBgColor']; ?>), to(<?= $row['contentBGcolor']; ?>)); /* for webkit browsers */
        background: -moz-linear-gradient(top,  <?= $row['2ndContentBgColor']; ?>,  <?= $row['contentBGcolor']; ?>); /* for firefox 3.6+ */
<? } ?>


    -moz-border-radius: 4em 1em 4em 1em;
    border-radius: 4em 1em 2em 1em;
    }

   
    a:link {
    <? if($row['contentLinkColor']!="") {?>
    color:<? echo $row['contentLinkColor']; ?>;
     <? } ?>
     	Text-decoration:none;
     	font-weight: bolder;
     }	
     
     
    a:visited {
    <? if($row['contentLinkColor']!="") {?>
    		color:<? echo $row['contentLinkColor']; ?>;
     
     <? } ?>
     	Text-decoration:none;
     	font-weight: bolder;
     }
     
    .socialShareTop {
    	position: relative;
        float: right;
    	height: 10px;
        width: 60px;
        margin-top: -15px;
        padding-top: 0px;
        z-index: 50;
        
        
    }
    .socialShare {
    	position: relative;
    	height: 10px;
        width: 160px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        left: 8px;
        margin-top: 0px;
        padding-top: 10px;
        
        
    }
    
    .fbShareTop {
        position: relative; 
        text-align: center;
        margin-top: 0px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        float: left;
    }
    .fbShare {
        position: relative; 
        text-align: center;
        margin-top: -2px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        float: left;
    }
    
    twShareTop{
        position: relative; 
        top: 2px;
        text-align: center;
        margin-top: 0px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        float: right;
    }
    
    
    .twShare {
        position: relative; 
        padding: 0;
        margin-top: 0px;
        float: right;
        top: 0px;
        padding-right: 3px;
    }
    
    .customerCoupon {
        padding: 5px;
        border: thick dotted red;
        background: white;
        font-color: black;
    }
    .centerContent {
    	text-align: center;
    }
    
    .coupon {
        width: 250px;
        padding: 10px;
        text-align: center;
        border: 3px dashed #ccc; 
    }
    
    #footer {
        bottom: 10px;
    	background: <?= $row['footerColor']; ?>;
        width: 95%;
        color: <?= $row['footerFontColor']; ?>;
		line-height: 25px;
        margin: 0px;
        padding: 2px 0px 0px 20px;
        float: left;
    -moz-border-radius: 4em 1em 2em 0em;
    border-radius: 4em 1em 2em 0em;
    }
    
    .linked {
    	padding-bottom: 8px;
    }
    
    /*-------------- ADVERTISING ---------------
    ---------------------------------------------*/
    
   .topAd {
        width: 100%;
        padding: 10px 0px 10px 0px;
        <? if($row['topAdBgcolor']!="") {?>
        background-color:<? echo $row['topAdBgcolor']; ?>;
        <? } ?>
        <? if($row['topAdcolor']!="") {?>
        color:<? echo $row['topAdcolor']; ?>;     
         <? } ?>
        margin: 1px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
    }
    
   .bottomAd {
        width: 100%;
        padding: 10px 0px 10px 0px;
        <? if($row['bottomAdBgcolor']!="") {?>
        background-color:<? echo $row['bottomAdBgcolor']; ?>;
        <? } ?>
        <? if($row['bottomAdcolor']!="") {?>
        color:<? echo $row['bottomAdcolor']; ?>;     
         <? } ?>
        margin: 1px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
    }
   
   