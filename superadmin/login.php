<?php
include("../dbcon.php");

$_SESSION['username']="";
$_SESSION['password']="";


if($_POST['submit'])
{
$username=addslashes($_POST['username']);
$password=addslashes($_POST['password']);




$sql="SELECT * FROM ".$projectName."superadmin WHERE Username='$username' AND password='$password'";
$result=mysql_query($sql);
//$countUser=mysql_num_rows($result);


$record=mysql_fetch_array($result);




            
if($password==$record['password'] && $username==$record['Username'])
        
	{
	
	$_SESSION['password']=$record['password'];

    $_SESSION['username']=$record['Username'];

      header("location:home.php");
	}
	else
	{
  //echo "Wrong Username or Password";
	$message=$message . "Wrong Username or Password!";	

  	}

}//end of if($_POST['submit'])

/*
if($username=='admin' && $password=='123')
{
$message="login Successfully.";
{header('Location: home.php');}
}

else
{
echo "Username and password don't match!";
}



} // close if($_GET['submit'])

*/

?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Page</title>
</head>

<body>

<center>

<?php echo $message; ?>

<form action="login.php" method="post" >
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td height="33">User Name </td>
<td><input type="text" name="username"/></td>
</tr>

<tr>
<td height="33">Password </td>
<td><input type="password" name="password"/> </td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="submit" value="Submit"/></td>
</tr>
</table>

</form>

</center>

</body>
</html>
