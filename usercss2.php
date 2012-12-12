<?php
	header('Content-type: text/css'); 
	include("dbcon.php");
	$Name=$_GET['u'];
	$sql="select * from ".$projectName."global_settings x, ".$projectName."moSiteInfo y  WHERE x.mobiSiteId=y.siteId and  y.SiteName='$Name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
	body {
        max-width: 620px;
        margin:0px;
        padding:0px;
<? if($row['backgroundcolor']!="") {?>
background: <?= $row['backgroundcolor']; ?>; /* for non-css3 browsers */

<? if($row['haveGradient']=="1") {?>
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?= $row['2ndbackgroundColor']; ?>-+-+', endColorstr='<?= $row['backgroundcolor']; ?>'); /* for IE */
background: -webkit-gradient(linear, left top, left bottom, from(<?= $row['2ndbackgroundColor']; ?>), to(<?= $row['backgroundcolor']; ?>)); /* for webkit browsers */
background: -moz-linear-gradient(top,  <?= $row['2ndbackgroundColor']; ?>,  <?= $row['backgroundcolor']; ?>); /* for firefox 3.6+ */

<? }} if($row['backgroundimage']!="") { ?>
		background-image:url(admin/gbimages/<? echo $row['backgroundimage']; ?>);
<? } ?>
<? if($row['font']!="") {?>
		font:"<? echo $row['font']; ?>"; 
<? } ?>
<? if($row['fontcolor']!="") {?>
		color: <? echo $row['fontcolor']; ?>; 
<? } ?>
}
	#styleTop {
    	
		width: 100%;
<? if($row['logobackgroundcolor']!="") {?>
		background: <? echo $row['logobackgroundcolor']; ?>; 
        margin: 0 auto;
<? } ?>
    }
	#logo {
    		padding-top: 13px;
		max-width: 100%;
		height: auto;
		display: block;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 13px;;
	}
    
    #topNav{
    	text-align:center;
    	position: relative;
        bottom: 13px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        width: 100%;

		list-style-type: none;
		float: right;	
		background-position: bottom left;
		background-repeat: no-repeat;
		margin: 0;
		padding: 6px 0 6px 0;
        background: <? echo $row['logobackgroundcolor']; ?>;
	}
    
    #topNav li{
		list-style-type: none;
		margin: 0;
		padding: 0;
		float: left;
		font-size: 11px;
		line-height: 10px;
		text-transform: uppercase;
		padding: 4px 0 4px 7px;
		margin-bottom: 6px;
	}
	#topNav li a{
		text-decoration: none;
		padding: 7px;
		font-weight: bold;
        font-size: 18px;
	}
	#topNav li a:hover{
		/*color:#cccccc;*/


    }
    #searchBox {
    	display: none;
    }

    .nav { 
    text-align: center;
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
    }

    .mobileContentArea1 {
    	background: <?= $row['contentBGcolor']; ?>; 
        padding: 2px 8px 8px 8px; 
        width: auto; 
        /*border: <? //echo $row['searchBoxBG']; ?> thin solid; */
        max-width: 600px;
        margin: 0px; 
        
        
		<? if($row['haveContentGradient']=="1") {?>
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?= $row['2ndContentBgColor']; ?>-+-+', endColorstr='<?= $row['contentBGcolor']; ?>'); /* for IE */
                background: -webkit-gradient(linear, left top, left bottom, from(<?= $row['2ndContentBgColor']; ?>), to(<?= $row['contentBGcolor']; ?>)); /* for webkit browsers */
                background: -moz-linear-gradient(top,  <?= $row['2ndContentBgColor']; ?>,  <?= $row['contentBGcolor']; ?>); /* for firefox 3.6+ */
        <? } ?>


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
     
     #tweet ul {list-style-type:none;}
     
    .socialShare {
    	position: relative;
        float: right;
    	height: 10px;
        width: 60px;
        margin-top: 0px;
        padding-top: 0px;
        z-index: 50;
        
        
    }
    
    .fbShare {
        position: relative; 
        margin-top: 0px;
        top: -5px;
        float: right;
    }
    .twShare {
        position: relative; 
        padding: 0;
        margin-top: 0px;
        float: right;
        top: -5px;
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
    	position: relative;
        bottom: 10px;
    	background: <?= $row['footerColor']; ?>;
        width: auto;
        color: <?= $row['footerFontColor']; ?>;
        text-align: center;
        max-width: 620px;
        margin: 0px;
        padding: 2px 0px 0px 0px;
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
   
   