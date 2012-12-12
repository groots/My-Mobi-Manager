<?php
$navigation = 2;
require_once 'formstack.php';
	$userName=$_GET['u'];
	$Pagetitle=$_GET['p'];
	$pageQuery = "SELECT * FROM".$projectName."page x WHERE x.Userid=y.Userid AND active = 1 and  y.Username='$userName'";
	
	$Seourl="http://".$userName.".".$domainname."/?".$Pagetitle; 
	$query2="SELECT * FROM ".$projectName."page x, ".$projectName."user y WHERE x.Userid=y.Userid and  y.Username='$userName'";
	$result2=mysql_query($query2);
	echo mysql_error(); 
		
	$nume=mysql_num_rows($result2);
	if($nume==0){
		echo "This page doesn't exist";
		exit();
	}
	$row=mysql_fetch_array($result2);
	$Userid=$row["Userid"];
	$pid=-1;
	 
	//echo $row['Pagetitle'];
	if ($Pagetitle==""){
		$sql="SELECT * FROM ".$projectName."page WHERE Userid=$Userid AND active = 1 AND  Parentlink = 0 order by Pageorder ";
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
	
	////////logo issue done by mizan////////////
	$logoOrcompany=mysql_fetch_array(mysql_query("select Company, Logo, logoWidth, logoHeight, bizEmail, bizPhone, bizWebsite, homePageText from ".$projectName."user where Username='$userName'"));
	$navStyle=mysql_fetch_array(mysql_query("select * from ".$projectName."global_settings x, ".$projectName."user y WHERE x.Userid=y.Userid and  y.Username='$userName'"));
	///////end of done by mizan/////////////////
	
	header("Keep-Alive: timeout=5, max=100");
	header('Expires: Mon, 26 Jul 2012 05:00:00 GMT'); 
	header('Pragma: private');
	//header('content-type: application/xhtml+xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$title?> Mobile Homepage</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml" />
<meta http-equiv="Cache-Control" content="max-age=600; no-transform" />

<?
	if ($cssFileName == "") {
		$cssFileName = 	'usercss4';
	} else {
		$cssFileName = "";	
	}
?>

<link type="text/css" media="screen" rel="stylesheet" href="<?= $cssFileName; ?>.php?u=<?=$userName?>" /> 
<?php 
	if($logoOrcompany['Logo']!=''){ 
		$src1="logo/".$logoOrcompany['Logo'];
		
		?><link rel="image_src" href="http://mymobimanager.com/<?PHP echo $src1; ?>" /> <? }

	$queryc="SELECT * FROM mobilemanager_google_analytics WHERE userId = '$Userid'";
	$resultc=mysql_query($queryc);
	$rowc=mysql_fetch_array($resultc);
	
	$fStackAPIKey = $rowc['fStackAPIKey'];	
	$clientLogin = $rowc['ccLogin'];
	$clientPassword = $rowc['ccPassword'];
	$dhp = $rowc['indexPageName'];
	$socialShare = $rowc['socialShare'];
	$displayFooter = $rowc['displayFooter'];	
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
<body>
<?PHP 
	if ($Userid == '00000') {
?>		
<div id="headerAd"  class="topAd">
 Header Ad
</div>
<?PHP
	}	
?>
               <?PHP 
	if ($logoOrcompany['bizWebsite'] != "" || $logoOrcompany['bizWebsite'] != NULL) {
?>
<a style="color: <?= $navStyle['searchBoxBG']; ?>;"  href="<?= $logoOrcompany['bizWebsite'] . $indexCode; ?>">Desktop Site</a> | 
<?PHP 
}
?>
 <a href="/" style="color: <?= $navStyle['searchBoxBG']; ?>;" target="_self">Home</a> | <a style="color: <?= $navStyle['searchBoxBG']; ?>;" href="tel:<?PHP echo $logoOrcompany['bizPhone']; ?>" class="nav" target="_self">Call</a> | <a style="color: <?= $navStyle['searchBoxBG']; ?>;" href="mailto:<?PHP echo $logoOrcompany['bizEmail']; ?>" class="nav" target="_self">Email</a>			
<div>
<div id="styleTop">
    <p id="logo"><?php if($logoOrcompany['Logo']!='')     { 
                               $src="logo/".$logoOrcompany['Logo'];
           ?> <img  src="<?=$src?>" alt="Logo" width="100%" />
                               <?php } else echo "<h1>".$logoOrcompany['Company']."</h1>";?>
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
		
	} else {
		while( $row=mysql_fetch_array($result))  {
			if ($pageid != $row['Parentlink'] && $home == "yes") {
				echo '<a class="nav m3link" accesskey="'.$ii.'" href="'.$row['Seourl'].'">'.$row['Pagetitle'].'</a>';
				$ii++;
			}
		}
	}
?>
	</div>
</div>
<?PHP 
	if($navigation == 1){
?>
    <div id="searchBox">
        <form action="page.php" method="get" id="searchBoxBG">
          <div>
          <input name="searchWord" id="searchWord" type="text" value=" " size="20" />
          <input type="hidden" value="<?PHP echo $userName; ?>" id="u" name="u" />
          <input type="hidden" value="<?PHP echo $Pagetitle; ?>" id="p" name="p" />
          <input type="submit" name="Search" value="Search" />
          </div>
        </form>
    </div>
<?PHP } ?>
    <div >
<?

$searchSubmit = $_GET['Search'];
$ii=0;
if ($Pagetitle=="" && $searchSubmit =="" ){
	if($logoOrcompany['homePageText'] != ""){
		echo  "<div class='mobileContentArea1'>" . $logoOrcompany['homePageText'] . "</div>";
	}
	if($navigation == 1) {
		while( $row=mysql_fetch_array($result))  {
			if ($pageid != $row['Parentlink'] && $home == "yes") {
				echo '<p class="m3link"><a class="nav" accesskey="'.$ii.'" href="'.$row['Seourl'].'">'.$row['Pagetitle'].'</a></p>';
				print("\n");
				$ii++;
			}
		}
	}
} else {
	$searchSubmit = $_GET['Search'];
	if(!$searchSubmit) {
		
		$content1 = $row['content'];
		$content = str_replace('&','&amp;',html_entity_decode($content1,ENT_NOQUOTES,'UTF-8')); ?>
		
				<div class="mobileContentArea1">hi
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
			if ($row['ccFlag'] == "1" ) {		
				include("ccForm.php");
			}
	} else {
		include("searchMobileSite.php");
	}
	?> 
        </div><?
}


	$sqly="SELECT * FROM ".$projectName."page WHERE Parentlink = $pageid AND active = 1 order by Pageorder desc";
	$resulty=mysql_query($sqly); 
	//$rowy=mysql_fetch_array($resulty);
 	while( $rowy=mysql_fetch_array($resulty))  {
		if ($pageid == $rowy['Parentlink'] && $Pagetitle!="") {
			echo '<p class="m3link"><a class="nav" accesskey="'.$ii.'" href="'.$rowy['Seourl'].'">'.$rowy['Pagetitle'].'</a></p>';
			print("\n");
		}
		$ii++;
	}
	//echo $pageid;
?>
<!--div  class="m3link"><a href="http://<? //$userName?>.<? //$domainname?>">Home</a></div-->

</div>
<?PHP 
	if ($Userid == '00000') {
?>		
<div id="footerAd"  class="bottomAd">
 Footer Ad
</div>
<?PHP
	}	
?>


		</div>
	</body>
</html>