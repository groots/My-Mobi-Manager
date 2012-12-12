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
        width: 100%;
        margin:0px;
        padding:0px;
-moz-box-shadow: 10px 10px 5px #3c3c3c;
-webkit-box-shadow: 10px 10px 5px #3c3c3c;
box-shadow: 10px 10px 5px #3c3c3c;
<? if($row['backgroundcolor']!="") {?>
		background: <?= $row['backgroundcolor']; ?>; /* for non-css3 browsers */

<? if($row['haveGradient']=="1") {?>
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?= $row['2ndbackgroundColor']; ?>-+-+', endColorstr='<?= $row['backgroundcolor']; ?>'); /* for IE */
background: -webkit-gradient(linear, left top, left bottom, from(<?= $row['2ndbackgroundColor']; ?>), to(<?= $row['backgroundcolor']; ?>)); /* for webkit browsers */
background: -moz-linear-gradient(top,  <?= $row['2ndbackgroundColor']; ?>,  <?= $row['backgroundcolor']; ?>); /* for firefox 3.6+ */
<? }

	} if($row['backgroundimage']!="") { ?>
		background:url(admin/gbimages/<? echo $row['backgroundimage']; ?>) <?= $row['backgroundcolor']; ?> ;
<? } ?>
	

<? if($row['font']!="") {?>
		font-family:"<? echo $row['font']; ?>"; 
<? } ?>
<? if($row['fontcolor']!="") {?>
		color: <? echo $row['fontcolor']; ?>; 
<? } ?>
}

a {
	text-shadow: 0 1px 1px rgba(0,0,0,.5);
}
	#styleTop {
    	
		width: 100%;
        max-width: 620px;
<? if($row['logobackgroundcolor']!="") {?>
		background: <? echo $row['logobackgroundcolor']; ?>; 
<? } ?>
    }
	#logo {
		text-align: center; 
        padding-top: 5px; 
        padding-bottom: 0px;
        margin: auto;
        
	}

    .nav a{ 
    
    }
    
    a.nav:link {color: <? echo $row['linktextcolor']; ?>; text-shadow: 0 1px 1px rgba(0,0,0,.9);}
    a.nav:visited {color: <? echo $row['linktextcolor']; ?>; text-shadow: 0 1px 1px rgba(0,0,0,.9);}
    a.nav:hover {color: <? echo $row['linktextcolor']; ?>; text-shadow: 0 1px 1px rgba(0,0,0,.9);}
    a.nav:active {color: <? echo $row['linktextcolor']; ?>;text-shadow: 0 1px 1px rgba(0,0,0,.9);}
    
    .m3link {
        width: auto;
        padding: 10px 0px 10px 0px;
        <? if($row['linkbgcolor']!="") {?>
        background-color:<? echo $row['linkbgcolor']; ?>;
        <? } ?>
        <? if($row['linktextcolor']!="") {?>
        color:<? echo $row['linktextcolor']; ?>;     
         <? } ?>
        margin: 0 auto;
        max-width: 620px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
        <? if($row['linkbordercolor']!="") {?>
        border-color:<? echo $row['linkbordercolor']; ?>;     
         <? } ?>
         
    }
    
    .m3link a {
		display:block;
        margin: 0px;
        padding: 0px;
        
    
    }
    
    <? if ($row['markerColor'] != ""){ ?>
	.rightMarker { 
    	position: relative;
    	float: right;
        width: 0; 
        height: 0px; 
        border-top: 12px solid transparent; 
        border-left: 25px solid <? echo $row['markerColor']; ?>; border-bottom: 12px solid transparent; 
        margin: -20px 25px 0px 0px;
    } 
    <? } ?>
    
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
        padding: 2px 12px; 
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
        padding-bottom: 10px;

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
    
    
    <? if ($Name == "squishdesigns"){
	?>
    #footer {
    	position: relative;
        bottom: 0px;
     background: rgb(167,207,223); /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover,  rgba(167,207,223,1) 0%, rgba(35,83,138,1) 100%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba(167,207,223,1)), color-stop(100%,rgba(35,83,138,1))); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  rgba(167,207,223,1) 0%,rgba(35,83,138,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  rgba(167,207,223,1) 0%,rgba(35,83,138,1) 100%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  rgba(167,207,223,1) 0%,rgba(35,83,138,1) 100%); /* IE10+ */
background: radial-gradient(center, ellipse cover,  rgba(167,207,223,1) 0%,rgba(35,83,138,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a7cfdf', endColorstr='#23538a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

        width: auto;
        color: <?= $row['footerFontColor']; ?>;
        text-align: center;
        max-width: 620px;
        margin: 0px 0px 0px 0px;
        padding: 2px 0px 0px 4px;
    }
    <?	
	} else {
		?>
    #footer {
    	position: relative;
        bottom: 0px;
        <? if ($row['footerColor']!= "") { ?>
    		background: <?= $row['footerColor']; ?>;
        <? } else { ?>
        	/* background: #3c3c3c; */
        <? } ?>        
        width: auto;
        color: <?= $row['footerFontColor']; ?>;
        text-align: center;
        max-width: 620px;
        margin: 0px 0px 0px 0px;
        padding: 2px 0px 0px 4px;
    }
    <? } ?>
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
   
   