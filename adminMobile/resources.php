<?php
include("session_check.php");
$Userid=$_SESSION['ID'];
$Userid=$_SESSION['ID'];




//echo "user id : ".$Userid;

$pagetitle="View List of Mobile Pages";
	
if($_GET['idForDel'])
{
	$id=$_GET['idForDel'];
	if ($errormessage=='')
		{
		$returnFromdel=Page_del_form($projectName);
		if ($returnFromdel=="true")
			{
			$successmessage="Delete Successfully";	
			
			}
		else
			$errormessage=$errormessage . $returnFromdel;
		}  // END OF if($errormessage=='')

}


$sql="select * from ".$projectName."page WHERE Userid=$Userid ORDER BY pageid, Parentlink";
$result=mysql_query($sql);



?>

<?php include("toppart.php"); ?>
  <div>
    <div>
      <div>

        <!--div class="badge">

          <a href="#recommended"><img src="images/badge-98percent.png" width="102" height="101" alt="98% Customer Recommended" /></a>

        </div-->

        <div style="padding: 0;">

          <table width="100%" cellpadding="10" cellspacing="10">

<tr>

<td valign="top" style="border: solid #036679 thick; background: #fff; width: 300px; height: 500px;">

<DIV class=tall>

<h1>My Mobi Manager Resources</h1>

<p>

<h2 align="left">Pick one of these Scripts to help your website detect your M<sup>3</sup> Website.

 	
   <h3> Please contact us if you have any problems with any of theses scripts.</h3>
    
</p>
 <a href="../resourcesX/detectmobilebrowser.php.txt" target="_blank">PHP</a>

 	<br /><br />

 <a href="../resourcesX/detectmobilebrowser.asp.txt" target="_blank">ASP Classic</a>

 	<br /><br />

<a href="../resourcesX/detectmobilebrowser.aspx.txt" target="_blank">ASP.NET</a>

 	<br /><br />

 	

 <a href="../resourcesX/detectmobilebrowser.cfm.txt" target="_blank">Coldfusion</a>

 	<br /><br />

 <a href="../resourcesX/detectmobilebrowser.cs.txt" target="_blank">CS</a>

 	<br /><br />



 <a href="../resourcesX/detectmobilebrowser.htaccess.txt" target="_blank">Apache</a>

 	<br /><br />

 <a href="../resourcesX/detectmobilebrowser.js.txt" target="_blank">Javascript</a>

<br /><br />

 <a href="../resourcesX/detectmobilebrowser.jsp.txt" target="_blank">JSP</a>

 	<br /><br />

 </h2>

</DIV>

</td>

</tr>

</table>



        </div>

      </div>

    </div>

  </div>

    

  <!--div class="container">

    <div class="logos">

      <div class="right">

        <h2>Every day the world&rsquo;s most respected brands, small businesses, non-profits, and entrepreneurs depend on M3 to make their mobile websites run smoothly.<br />Fun text here</h2>

      </div>

      <div class="left">

        <img src="/images/logos-more.png" width="400" height="100" alt="Our Customers" />

      </div>

    </div>

  </div-->

  <?PHP include("includes/footer.php"); ?>