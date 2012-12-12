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

<? }
	} if($row['backgroundimage']!="") { ?>
		background-image:url(admin/gbimages/<? echo $row['backgroundimage']; ?>);
<? }
//else { ?>
	/*background: #cccccc;*/ <?
//}
?>

<? if($row['font']!="") {?>
		font-family:"<? echo $row['font']; ?>"; 
<? } ?>
<? if($row['fontcolor']!="") {?>
		color: <? echo $row['fontcolor']; ?>; 
<? } ?>
}
	#styleTop {
    	
		width: auto;
        max-width: 620px;
<? if($row['logobackgroundcolor']!="") {?>
		background: <? echo $row['logobackgroundcolor']; ?>; 
<? } ?>
    }
	#logo {
		text-align: center; 
        padding-top: 5px; 
        padding-bottom: 0px;
	}

    .nav { 
    }
    
    a.nav:link {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:visited {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:hover {color: <? echo $row['linktextcolor']; ?>; }
    a.nav:active {color: <? echo $row['linktextcolor']; ?>;}

    .m3link {
        width: auto;
        padding: 10px 0px 10px 0px;
        <? if($row['linkbgcolor']!="") {?>
        background-color:<? echo $row['linkbgcolor']; ?>;
        <? } ?>
        <? if($row['linktextcolor']!="") {?>
        color:<? echo $row['linktextcolor']; ?>;     
         <? } ?>
        margin: 1px;
        max-width: 620px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
        <? if($row['linkbordercolor']!="") {?>
        border-color:<? echo $row['linkbordercolor']; ?>;     
         <? } ?>
    }
    
    #searchform {
        margin-left: auto;
        margin-right: auto;

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
        max-width: 620px;
        margin-left: auto;
        margin-right: auto;
    }

    .mobileContentArea1 {
    	background: <?= $row['contentBGcolor']; ?>; 
        padding: 2px 8px; 
        width: auto; 
        /*border: <? //echo $row['searchBoxBG']; ?> thin solid; */
        margin: 0px;
        max-width: 620px;
        
        
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
     
    .socialShare {
    	position: relative;
    	height: 10px;
        width: 160px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        left: 8px;
        margin-top: 0px;
        padding-top: 0px;
        max-width: 620px;
        
        
    }
    
    .fbShare {
        position: relative; 
        text-align: center;
        margin-top: 0px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        float: left;
    }
    .twShare {
        position: relative; 
        top: 2px;
        text-align: center;
        margin-top: 0px;
        display: block;
        margin-right: auto;
        margin-left: auto;
        float: right;
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
        bottom: 0px;
        <? if ($row['footerColor']!= "") { ?>
    		background: <?= $row['footerColor']; ?>;
        <? } else { ?>
        	background: #3c3c3c;
        <? } ?>        
        width: auto;
        color: <?= $row['footerFontColor']; ?>;
        text-align: center;
        max-width: 620px;
        margin: 0px 0px 0px 0px;
        padding: 2px 0px 0px 4px;
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
   
   