<?php
	include("session_check.php");
	$pagetitle="Dashboard";
	$pagetag = "Home Sweet Home!";
	$mobiId = $_GET['mobiId'];
	
	
	if(!isset($mobiId)){	
		$mobiId = $_SESSION['mobiId'];				
	}
	//if(!isset($_SESSION['mobiId']))
	if($_SESSION['mobiId'] == ""){
		$_SESSION['mobiId'] = $_GET['mobiId'];
	}

?>

<?php include("toppart.php"); ?>


<style type="text/css">
	<!--
	
	
	#Table_01 {
		width:370px;
		height:716px;
	}
	
	#iphoneViewer_ {
		position:absolute;
		left:0px;
		top:0px;
		width:370px;
		height:143px;
	}
	
	#iphoneViewer002_ {
		position:absolute;
		left:0px;
		top:143px;
		width:24px;
		height:573px;
	}
	
	#iphoneViewer003 {
		position:absolute;
		left:24px;
		top:143px;
		width:320px;
		height:418px;
		background-color: <?PHP echo $row['backgroundcolor']; ?>;
	}
	
	#iphoneViewer004_ {
		position:absolute;
		left:344px;
		top:143px;
		width:26px;
		height:573px;
	}
	
	#iphoneViewer005_ {
		position:absolute;
		left:24px;
		top:561px;
		width:320px;
		height:155px;
	}
	
	-->
</style>                                      
<div style="display: block ">
     <ul class="tabs">
         <li><a href="#first-tab"><span>Getting Started</span></a></li>
         <li><a href="#second-tab"><span>Helpful Info</span></a></li>
     </ul>
     <div class="panes">
         <div class="hide">
            <div>
         	<div style="width:100%;">
            	<div style="width: 60%; float: left;">
                <table cellpadding="3" cellspacing="3">
                    <tr>
                        <td valign="top"><img src="images/numberOne.png" width="70px" /></td>
                        <td valign="top"><h3><a href="global_settings.php">Create Your Brand!</a></h3>First things first, you need to add some style to your mobile website.  No one wants to come to your site, read great information and not know it's you, or worse yet, realize you have no style!			<br />
                        <p>
                            <a href="https://fifthfloor.mymobimanager.com/global_settings.php">Click here to get started </a>
                        </p>
                        
                        
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><img src="images/numberTwo.png"  width="70px" /></td>
                        <td valign="top"><h3><a href="viewmypage.php">Add Mobile Pages</a></h3>Now that we've had our appetizer, lets add some meat and potatoes.  Here we want to create the pages that go into the mobile website. Remember you can add pages under other pages by using the parent section.
                        <br />
                        <p>
                            <a href="https://fifthfloor.mymobimanager.com/viewmypage.php">Click here to add pages</a>
                        </p>
                        
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><img src="images/numberThree.png"  width="70px" /></td>
                        <td valign="top"><h3><a href="g_analyticstracking.php">Add Features</a></h3>What would all this hard (actually very easy) work be, if we didnt track it!  We use Google Analytics to track page usage.  It is free, and Google is really good at what they do. <a href="http://www.google.com/analytics" target="_blank">Get Analytics Now</a></td>
                    </tr>
                    <tr>
                        <td valign="top"><img src="images/numberFour.png"  width="70px" /></td>
                        <td valign="top"><h3>Add Mobile Dectection</h3>Now that your mobile site is created, we need to put it in front of your customers. Copy and Paste the code below into the head tag of your homepage: <br />
                        
                                        <a href="http://<?PHP echo $recordu['SiteName']; ?>.mymobimanager.com" name="modal" style="color: #106271;">View Your Site</a> <br /> Mobile Site URL: <strong style="color:#900;">http://<?PHP echo $recordu['SiteName']; ?>.mymobimanager.com</strong>
                        <p>
                            <div id="code" style="background: #fce1b3; border: solid thin #b37204; padding: 15px;">              
                            
                            <?PHP $sql_ga = "SELECT indexPageName, serverLanguage FROM mobilemanager_google_analytics WHERE mobiSiteId = ". $curMobiId;
							
									$result_ga=mysql_query($sql_ga);  
									$record_ga=mysql_fetch_array($result_ga); 
									
                                    if($record_ga['serverLanguage'] == 1) $sLan = ".php";
                                    if($record_ga['serverLanguage'] == 2) $sLan =  ".aspx";
                                    if($record_ga['serverLanguage'] == 3) $sLan =  ".asp"; 
                                    if($record_ga['serverLanguage'] == 4) $sLan =  ".jsp"; 
                                    if($record_ga['serverLanguage'] == 5) $sLan =  ".html";
                                    if($record_ga['serverLanguage'] == 6) $sLan =  ".htm";
									
									?>
                            &#60;&#115;&#99;&#114;&#105;&#112;&#116;&#62;&#32;&#118;&#97;&#114;&#32;&#109;&#121;&#109;&#111;&#98;&#105;&#117;&#115;&#101;&#114;&#110;&#97;&#109;&#101;&#32;
            &#61;&#32;&#34;<?PHP echo $recordu['SiteName']; ?>&#34;&#59;
             var ptls = "<?=$record_ga['indexPageName'] . $sLan; 			  ?>";
            &#32;&#60;&#47;&#115;&#99;&#114;&#105;&#112;&#116;&#62;&#32;
            &#13;&#10;&#60;&#115;&#99;&#114;&#105;&#112;&#116;&#32;&#116;&#121;&#112;&#101;&#61;&#34;&#116;&#101;&#120;&#116;&#47;&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#34;&#32;&#115;&#114;&#99;&#61;&#34;&#104;&#116;&#116;&#112;&#58;&#47;&#47;&#119;&#119;&#119;&#119;&#46;&#109;&#121;&#109;&#111;&#98;&#105;&#109;&#97;&#110;&#97;&#103;&#101;&#114;&#46;&#99;&#111;&#109;&#47;&#100;&#101;&#116;&#101;&#99;&#116;&#115;&#99;&#114;&#105;&#112;&#116;&#47;&#109;&#111;&#98;&#105;&#100;&#101;&#116;&#101;&#99;&#116;&#46;&#106;&#115;&#34;&#62;&#60;&#47;&#115;&#99;&#114;&#105;&#112;&#116;&#62;
            
                            </div>	
                        </p>                
                        </td>
                    </tr>
                </table>
                </div>
                <div style="width: 30%; float: right;">
                	<h3>Site Tools</h3>                    
						<script type="text/javascript">
                        generateQRCODE("qr","150","http://<?PHP echo $recordu['SiteName']; ?>.mymobimanager.com");
                        </script>
                </div>
               </div>
            </div> 
         </div>
         <div class="hide">
    <table cellpadding="10" cellspacing="10">
    <tr>
        <td valign="top"><h2>How to create mobile friendly content</h2>First things first, you need to add some style to your mobile website.  No one wants to come to your site, read great information and not know it's you, or worse yet, realize you have no style!</td>
    </tr>
    <tr>
        <td valign="top"><h2>Mobile SEO</h2>When it comes to mobile devices, things have changed with the web as we know it. Search Engine Optimization has new and unique challenges.  Mobi Thinking does a good job explaining things you should consider... <a href="http://mobithinking.com/sites/mobithinking.com/files/dotMobi_Mobile_SEO_Best%20Practices.pdf" target="_blank">Read More (PDF)</a></td>
    </tr>
    <tr>
        <td valign="top"><h2>Mobile Analytics - How to track and measure your users</h2>First things first, you need to add some style to your mobile website.  No one wants to come to your site, read great information and not know it's you, or worse yet, realize you have no style!</td>
    </tr>
    </table>     
         </div>
         
    </div>
        
</div>
<script>
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>           
<?php include("downpart.php"); ?>

