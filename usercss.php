<?php
	header('Content-type: text/css'); 
	include("dbcon.php");
	$Name=$_GET['u'];
	$sql="select * from ".$projectName."global_settings x, ".$projectName."moSiteInfo y  WHERE x.mobiSiteId=y.siteId and  y.SiteName='$Name'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
	body {
<? if($row['backgroundimage']!="") { ?>
		background-image:url(admin/gbimages/<? echo $row['backgroundimage']; ?>);
<? } else if($row['backgroundcolor']!="") {?>
	background-color:<? echo $row['backgroundcolor']; ?>; 
<? }  ?>
<? if($row['font']!="") {?>
		font:"<? echo $row['font']; ?>"; 
<? } ?>
<? if($row['fontcolor']!="") {?>
		color: <? echo $row['fontcolor']; ?>; 
<? } ?>
	padding: 0px 15px 5px 0px; 
}





    .mobileContentArea1 {
    	background: #bafefe; 
        padding: 2px 8px; 
        width: auto; 
        border: #027f7f thin solid; 
        margin: 0px 7px;
    }

	#logo {
		text-align: center; 
	}
	.back {
    	font-size: 10px;
    }
    .nav a { 
    	font-size: 10px;
    }
    
    a.nav:link {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:visited {color: <? echo $row['linktextcolor']; ?>;}
    a.nav:hover {color: <? echo $row['linktextcolor']; ?>; }
    a.nav:active {color: <? echo $row['linktextcolor']; ?>;}

    .m3link {
        width: 90%;
        padding: 5px 0px 5px 10px;
        <? if($row['linkbgcolor']!="") {?>
        background-color:<? echo $row['linkbgcolor']; ?>;
        <? } ?>
        <? if($row['linktextcolor']!="") {?>
        color:<? echo $row['linktextcolor']; ?>;     
         <? } ?>
        margin: 1px;
        text-decoration: none;
        text-align: center;
        border-width: thin;
        border-style:solid;
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

    a:link {
    <? if($row['linkbgcolor']!="") {?>
    color:<? echo $row['searchBoxBG']; ?>;
     <? } ?>
     	Text-decoration:none;
     	font-weight: bolder;
        font-size: 7px;
     }	
     
     
    a:visited {
    <? if($row['linktextcolor']!="") {?>
    		color:<? echo $row['linktextcolor']; ?>;
     
     <? } ?>
     	Text-decoration:none;
     	font-weight: bolder;
     }
     
    .socialShare {
    }
    
    .fbShare {	
        position: relative; 
        bottom: 8px;
        text-align: center;        
        display: block;
        margin-right: auto;
        margin-left: auto;
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
    	background: #3c3c3c;
        width: auto;
        color: #fff;
        text-align: center;
    }
    
    .linked {
    	padding-bottom: 8px;
    }