<?php
include("dbcon.php");
$userName=$_GET['u'];
$Pagetitle=$_GET['p'];
$Seourl="http://".$userName.".".$domainname."/?".$Pagetitle; 

$query2="SELECT * FROM ".$projectName."page x, ".$projectName."user y    WHERE x.Userid=y.Userid and  y.Username='$userName'";
$result2=mysql_query($query2);

echo mysql_error();
$nume=mysql_num_rows($result2);
if($nume==0)
{
echo "This page doesn't exist";
exit();
}
$row=mysql_fetch_array($result2);
 $Userid=$row["Userid"];
  $pid=-1;
if ($Pagetitle=="")
{
$sql="SELECT * FROM ".$projectName."page WHERE  Userid=$Userid order by Pageorder ";
$result=mysql_query($sql); 
 $title="Home page of ".$userName;
 } 
 else
{
$sql="SELECT * FROM ".$projectName."page WHERE Seourl='$Seourl' ";
$result=mysql_query($sql); 
 $row=mysql_fetch_array($result);
  $pid=$row['Pageorder'];
  $title=$row['Pagetitle'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$title?></title>
</head>
<body>
<?
if ($Pagetitle=="")
{
while( $row=mysql_fetch_array($result))  {
echo '<a href='.$row['Seourl'].'>'.$row['Pagetitle'].'</a><br>';
}
}
else
{
 echo $row['content'];
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
	<?
	$sql="SELECT * FROM ".$projectName."page WHERE Pageorder < $pid and Userid=$Userid  order by Pageorder desc";
	 
$result=mysql_query($sql); 
 $row=mysql_fetch_array($result);
 if ($row["Seourl"]!="")  echo '<a href='.$row['Seourl'].'>Previous</a>';
	?>
	</td>
	<td align="center"><a href="http://<?=$userName?>.<?=$domainname?>">Home</a></td>
    <td align="right"><?
	$sql="SELECT * FROM ".$projectName."page WHERE Pageorder > $pid and Userid=$Userid  order by Pageorder asc";
 
$result=mysql_query($sql); 
 $row=mysql_fetch_array($result);
 if ($row["Seourl"]!="")  echo '<a href='.$row['Seourl'].'>Next</a>';
	?></td>
  </tr>
</table>


</body>
</html>

