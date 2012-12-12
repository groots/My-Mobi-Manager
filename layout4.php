<?php
	include("isMobileCheck.php");
	$navigation = 1;
	require_once 'formstack.php';
	$userName=$_GET['u'];
	$Pagetitle=$_GET['p'];
	
	$pageQuery = "SELECT * FROM".$projectName."page x, moSiteInfo y WHERE x.mobiSiteId=y.siteId AND x.active = 1 and  y.SiteName='$userName'";
	
	$Seourl="http://".$userName.".".$domainname."/?".$Pagetitle; 
	$query2="SELECT * FROM ".$projectName."page x, ".$projectName."moSiteInfo y WHERE x.mobiSiteId=y.siteId and  y.SiteName='$userName'";
	$result2=mysql_query($query2);
	echo mysql_error(); 
		
	$nume=mysql_num_rows($result2);
	if($nume==0){
		//echo "This page doesn't exist";
		//exit();
	}
	$row=mysql_fetch_array($result2);
	$Userid=$row["Userid"];
	$siteId=$row["siteId"];
	$pid=-1;
	 
	//echo $row['Pagetitle'];
	if ($Pagetitle==""){
		$sql="SELECT * FROM ".$projectName."page WHERE mobiSiteId=$siteId AND active = 1 AND  Parentlink = 0 order by Pageorder ";
		$result=mysql_query($sql); 
		$title=$userName;
		$home = "yes";
	} else {
		$sql="SELECT * FROM ".$projectName."page WHERE Seourl='$Seourl' AND active = 1 ";
		$result=mysql_query($sql); 
		$row=mysql_fetch_array($result);
		$pid=$row['Pageorder']; 
		$title=$row['Pagetitle'];
		$pageid = $row['pageid'];
	//	echo $pageid;
	}
	
	
	$locations=mysql_fetch_array(mysql_query("SELECT * FROM ".$projectName."markers where mobiSiteId='$siteId' AND isHQ = 1"));
	
	$lonLatTest = "$locations[lat], $locations[lng]";
	$locationTitle = "$locations[name]: $locations[address]";
	
	////////logo issue done by mizan////////////
	$logoOrcompany=mysql_fetch_array(mysql_query("select SiteName, logo, logoWidth, logoHeight, ocEmail, ocPhone, mainWebsite, homepageText, footer from ".$projectName."moSiteInfo where SiteName='$userName'"));
	$navStyle=mysql_fetch_array(mysql_query("select * from ".$projectName."global_settings x, ".$projectName."moSiteInfo y WHERE x.mobiSiteId=y.siteId and  y.SiteName='$userName'"));
	///////end of done by mizan/////////////////
	#

    //header("Content-Type: application/xhtml+xml"); 
	header("Keep-Alive: timeout=5, max=100");
	header('Expires: Mon, 26 Jul 2012 05:00:00 GMT'); 
	header('Pragma: private');
	//header('content-type: application/xhtml+xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$title?> Mobile Homepage</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml" />
<meta http-equiv="Cache-Control" content="max-age=600" />
<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<?
	if($row['addStoreLocator'] == "1") {
?>
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;

    function load() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(<?= $lonLatTest; ?>),
        zoom: 14,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
      });
      infoWindow = new google.maps.InfoWindow();

      locationSelect = document.getElementById("locationSelect");
      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
      };
   }

   function searchLocations() {
     var address = document.getElementById("addressInput").value;
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
        searchLocationsNear(results[0].geometry.location);
       } else {
         alert(address + ' not found');
       }
     });
   }

   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;

     locationSelect.innerHTML = "";
     var option = document.createElement("option");
     option.value = "none";
     option.innerHTML = "See all results:";
     locationSelect.appendChild(option);
   }

   function searchLocationsNear(center) {
     clearLocations(); 

     var radius = document.getElementById('radiusSelect').value;
	 var siteId = document.getElementById('siteId').value;
     var searchUrl = 'phpsqlsearch_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&siteId=' + siteId;
     downloadUrl(searchUrl, function(data) {
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

         createOption(name, distance, i);
         createMarker(latlng, name, address);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }

    function createMarker(latlng, name, address) {
      var html = "<b>" + name + "</b> <br/>" + address;
      var marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
      markers.push(marker);
    }

    function createOption(name, distance, num) {
      var option = document.createElement("option");
      option.value = num;
      option.innerHTML = name + "(" + distance.toFixed(1) + ")";
      locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}

    //]]>
  </script>
<?		
	}
	if ($cssFileName == "") {
		$cssFileName = 	'usercss4';
	} else {
		$cssFileName = "";	
	}
?>

<link type="text/css" media="screen" rel="stylesheet" href="http://mymobimanager.com/<?= $cssFileName; ?>.php?u=<?=$userName?>" /> 
<?php 
	if($logoOrcompany['logo']!=''){ 
		$src1="logo/".$logoOrcompany['logo'];
		
		?><link rel="image_src" href="http://mymobimanager.com/<?PHP echo $src1; ?>" /> <? }

	$queryc="SELECT * FROM mobilemanager_google_analytics WHERE mobiSiteId = '$siteId'";
	$resultc=mysql_query($queryc);
	$rowc=mysql_fetch_array($resultc);
	
	$fStackAPIKey = $rowc['fStackAPIKey'];	
	$mcAPIKey = $rowc['mChimpKey'];
	$eBriteUsr = $rowc['ebriteusr'];
	$clientLogin = $rowc['ccLogin'];
	$clientPassword = $rowc['ccPassword'];
	$dhp = $rowc['indexPageName'];
	$socialShare = $rowc['socialShare'];
	$displayFooter = $rowc['displayFooter'];
	$displaySearch = $rowc['includeSearch'];	
	
	//echo $siteId;
	if ($dhp == "" || $dhp == "NULL") {
		$dhp = "index";
	} 
	$csL = $rowc['serverLanguage'];
		
		 if ($csL == 1 || $csL == "") {
			$indexCode = "/$dhp.php?mobileWeb=no";	
		} elseif ($csL == 2) {
			$indexCode = "/$dhp.aspx?mobileWeb=no";
		} elseif ($csL == 3) {
			$indexCode = "/$dhp.asp?mobileWeb=no";
		} elseif ($csL == 4) {
			$indexCode = "/$dhp.jsp?mobileWeb=no";
		} elseif ($csL == 5) {
			$indexCode = "/$dhp.html?mobileWeb=no";
		} elseif ($csL == 6) {
			$indexCode = "/$dhp.htm?mobileWeb=no";
		}
//---------------------------Google Analytics --------------------------------------//
	echo $rowc['code'];
?>
</head>
<body <? if($row['addStoreLocator'] == "1"){ echo ' style="margin:0px; padding:0px;" onLoad="load()"'; } ?>>
<?PHP 
	if ($Userid == '0000') {
?>		
<div id="headerAd"  class="topAd">
 Header Ad
</div>
<?PHP
	}	
?>

<div>
<div id="styleTop">
    <p id="logo"><?php if($logoOrcompany['logo']!='')     { 
                               $src="logo/".$logoOrcompany['logo'];
           ?> <img  src="/<?=$src?>" alt="Logo" height="<?PHP echo $logoOrcompany['logoHeight'] ?>" width="<?PHP echo $logoOrcompany['logoWidth'] ?>" />
                               <?php } else echo "<h1>".$logoOrcompany['SiteName']."</h1>";?>
    </p>
    </div>
<?PHP 
if ($socialShare == '1') {
?>	
<p class="socialShare">
    <strong class="fbShare">
    <a name="fb_share" type="button" href="http://www.facebook.com/sharer.php">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript">
	</script>
    </strong>
    <strong class="twShare">    
		<script type="text/javascript">
            tweetmeme_style = 'compact';
        </script>
        <script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
    </strong>
</p>
<? } ?>
    <div class="centerContent">
    <div id="navBar">
    <?PHP 
	if($navigation == 1){
		if($navStyle['navStyle'] == 2) {
	?>
                <a href="#" onclick="history.go(-1);return false;" style="color: <?= $navStyle['searchBoxBG']; ?>;" target="_self">Back</a> | <a href="/" style="color: <?= $navStyle['searchBoxBG']; ?>;" target="_self">Home</a> | <? if ($isFromMobile =="yes"){ ?> <a style="color: <?= $navStyle['searchBoxBG']; ?>;" href="tel:<?PHP echo $logoOrcompany['ocPhone']; ?>" class="nav" target="_self">Call</a> | <? } ?> <a style="color: <?= $navStyle['searchBoxBG']; ?>;" href="mailto:<?PHP echo $logoOrcompany['ocEmail']; ?>" class="nav" target="_self">Email</a>			
    <?PHP    
        } else {
	?>
               <p> <a href="#" onclick="history.go(-1);return false;" class="back" target="_self"><img src="/images/icons/back_icon.png" alt="backImage" width="35" height="35" /></a> <a href="/" target="_self"><img src="/images/icons/home_icon.png"  alt="homeImage" width="35" height="35" /></a><? if ($isFromMobile =="yes"){ ?> <a href="tel:<?PHP echo $logoOrcompany['ocPhone']; ?>" target="_self"><img src="/images/icons/phone_icon.png"  alt="phoneImage" width="35" height="35" /></a> <? } ?> <a href="mailto:<?PHP echo $logoOrcompany['ocEmail']; ?>" target="_self"><img src="/images/icons/mail_icon.png"  alt="mailImage" width="35" height="35" /></a></p>
<?PHP
		}
	} else {
		while( $row=mysql_fetch_array($result))  {
			if ($pageid != $row['Parentlink'] && $home == "yes") {
				echo '<a class="nav" accesskey="'.$ii.'" href="'.$row['Seourl'].'">'.$row['Pagetitle'].'</a> ||';
				$ii++;
			}
		}
	}
?>
	</div>
</div>
<?PHP 
	if($displaySearch == 1){
		include("searchengine/form.php");
	} ?>
    <div >
<?

$searchSubmit = $_GET['isSearch'];
$ii=0;
if ($Pagetitle=="" && $searchSubmit =="" ){
	if($navigation == 1) {
		while( $row=mysql_fetch_array($result))  {
			if ($pageid != $row['Parentlink'] && $home == "yes" && $row['isNav'] != 0) {
				echo '<p class="m3link"><a class="nav" accesskey="'.$ii.'" href="'.$row['Seourl'].'">'.$row['Pagetitle'].'</a></p>';
				print("\n");
				$ii++;
			}
		}
	}
	if($logoOrcompany['homepageText'] != ""){
		echo  "<div class='mobileContentArea1'>" . str_replace("/user_files/","/admin/user_files/", $logoOrcompany['homepageText']) . "</div>";
	}

} else {
	$searchSubmit = $_GET['Search'];
	$isSearch = $_GET['isSearch'];
	//echo "<h1>" . $isSearch . "</h1>";
	if(!$isSearch) {
	$sqly="SELECT * FROM ".$projectName."page WHERE Parentlink = $pageid AND active = 1 order by Pageorder desc";
	$resulty=mysql_query($sqly); 
	//$rowy=mysql_fetch_array($resulty);
 	while( $rowy=mysql_fetch_array($resulty))  {
		if ($pageid == $rowy['Parentlink'] && $Pagetitle!="" && $rowy['isNav'] != 0) {
			echo '<p class="m3link"><a class="nav" accesskey="'.$ii.'" href="'.$rowy['Seourl'].'">'.$rowy['Pagetitle'].'</a></p>';
			print("\n");
		}
		$ii++;
	}	
		$content1 = $row['content'];
		$content = str_replace('&','&amp;',html_entity_decode($content1,ENT_NOQUOTES,'UTF-8')); ?>
		
				<div class="mobileContentArea1">
                <?= $content; ?>

		
		<?php
		$url=$row['Rsspath'];
	if ($url!=""){
			$rss=new rssFeed($url);
	   	if($rss->error){
		  print "<h1>Error:</h1>\n<p><strong>$rss->error</strong></p>";
	   	} else{
			
		  $rss->parse();
		  $rss->showHeading("h1");
			if($rss->link){
				print "<p>Provided courtesy of:</p>";
				$rss->showLink();}
				$rss->showDescription();
				$rss->showStories();
			} 
		}
		if ($row['fStackFormId'] != "0" && $_REQUEST['submit'] != 'Save') {
			include("formstackForm.php");
		} else if ($_REQUEST['submit'] == 'Save') {
    
			// Get form info
			$form = FormStack::request($api_key, 'form', array( 'id' => $form_id ));
			// Iterate over each field to look for submitted data
			$submit = array( 'id' => $form_id );
			foreach ($form['fields'] as $field) {
				$var = 'field_'.$field['id'];
				if (!empty($_POST[$var]))
					$submit[$var] = $_POST[$var];
			}
			// Submit the new entry
			$submission = Formstack::request($api_key, 'submit', $submit);
			// Display the new submission
			print "<p>Form Submitted. Confirmation ID{$submission['id']}</p>";
		}
		
		if($row['mChimpListID'] != "" || $row['mChimpListID'] != NULL ){	
			if ($_REQUEST['mailchimp_sub'] == 'Subscribe') {		
				include("inc/mcapi_listSubscribe.php");
			} else {
				?>
				Subcribe to Our Newsletter
				<form method="post" action="<?= $Seourl; ?>">
                    <input type="hidden" name="mc_key" value="<?= $mcAPIKey; ?>" />
                    <input type="hidden" name="list_id" value="<?= $row['mChimpListID']; ?>" />
                    <input type="Textbox" name="mcemail" id="mcemail" />
                    <input type="submit" value="Subscribe" name="mailchimp_sub" id="mailchimp_sub">
                </form>
				<?
			}
		}
		
		if ($row['ccFlag'] == "1" ) {		
			include("ccForm.php");
		}
			
		if ($row['addStoreLocator'] == "1" ) {		
			include("searchMap.php");
		}
			
		if($row['flagEbrite'] == "1") { 
			$urlEbrite = 'https://www.eventbrite.com/xml/user_list_events?app_key=ODE5MDljNjUzYjFm&user=' . $eBriteUsr; 
			$xmlData = simplexml_load_file($urlEbrite);
			echo "<h2>Events provided by EventBrite!</h2>";
			foreach ($xmlData as $events) {
				$g++;
				echo "<h4>$g. $events->title</h4>"; 
				echo "<div>$events->description
						Capacity: $events->capacity 
						<br />
						Start Date: ". date('d-m-Y', strtotime($events->start_date)) . 
						"<br />
						End Date: ". date('d-m-Y', strtotime($events->end_date)) . 
						"	</div>";
				echo "<strong>Location: </strong>" . $events->venue->name;
			}
		}
			
	} else { ?>
    
				<div class="mobileContentArea1">
             <?
		include("searchengine/process.php");
	}
	?> 
        </div><?
}


	
	//echo $pageid;
?>
<!--div  class="m3link"><a href="http://<? //$userName?>.<? //$domainname?>">Home</a></div-->
<?PHP 

	if ($logoOrcompany['mainWebsite'] != "" || $logoOrcompany['mainWebsite'] != NULL) {
?>
<div  class="m3link"><a class="nav" href="<?= $logoOrcompany['mainWebsite'] . $indexCode; ?>">Desktop Site</a></div>
<!-- /index.php?mobileWeb=no-->

<?PHP 
}
?>

</div>
<?PHP 
	if ($Userid == '0000') {
?>		
<div id="footerAd"  class="bottomAd">
 Footer Ad
</div>
<?PHP
	}	
?>


<?PHP 
if ($displayFooter == "1" || $logoOrcompany['footer'] != ""){
?>
    <div id="footer">
		<?PHP  if ($logoOrcompany['footer'] != ""){ ?>
			<div>
            	<?= str_replace("/user_files/","/admin/user_files/", $logoOrcompany['footer']); ?>	
			</div>	
				 
		<?PHP }
		
		
		
		
		
		
            if ($displayFooter == "1") { ?>
        	<div>
            	Powered by <a  accesskey="1000" href="http://www.mymobimanager.com">My Mobi Manager</a>
            </div>
        	<?PHP } ?>


    </div>


<?PHP } ?>

		</div>
	</body>
</html>