<?PHP

  // You can place PHP like this
    include("dbcon.php");
    $pagetitle = "Login to My Mobi Manager";
    $pagetag = "America is the most inventive country in the world because everybody has access to information -Tom Clancy";
    $_SESSION['userName']="";
    $_SESSION['password']="";
    $_SESSION['ID']="";
    $_SESSION['paymentFlag']="";

if($_POST['submit'])
{
    $username=$_POST['username'];
    $password =$_POST['password'];
    $sql="SELECT Userid, userName, password, subscriptionId FROM ".$projectName."user WHERE Username ='$userName' AND password ='$password' AND active=1";
    $result=mysql_query($sql);
    $record=mysql_fetch_array($result);
            
    if($password==$record['password'] && $userName==$record['userName']){
        $_SESSION['password']=$record['password'];
        //$_SESSION['password']=$record['password'];
        $_SESSION['userName']=$record['userName'];
     $loggedinuserID=$record['Userid'];
        $_SESSION['ID']=$record['Userid'];
        $_SESSION['loggedinusertype']=$record['type'];
    
    // Start Authorize.net

$sqlAuth="select Userid, totalLogins, subscriptionId, siteAccess, parentAccount, planidno from ".$projectName."user WHERE Userid='$loggedinuserID'";
    
    $resAuth=mysql_query($sqlAuth);
    $rowAuth=mysql_fetch_array($resAuth);
    $authSubId = $rowAuth['subscriptionId'];
    $siteString= $rowAuth["siteAccess"];
    $planid = $rowAuth["planidno"];
    $isParent = $rowAuth["parentAccount"];    
    $mySites=explode(",",$siteString);
    $siteSize = count($mySites);
    //print_r($mySites);
    //exit;
    //echo $siteSize;
        if ($authSubId != "")  {
            include("subscription_get_status.php");    
            if ($subscriptionId == 'Successful.'){
                    $updateUser = "UPDATE mobilemanager_user SET totalLogins = $newTotal, timestamp = " . date('Y-m-d') . " WHERE Userid = $loggedinuserID";
 

             if($siteSize > 1 || $hasParent == "" && $planid != 3 ){            
                    header("location: userHome.php");
                    exit;            
                } else {
                    $_SESSION['mobiId'] = $mySites[0];
                    header("location: mobiHome.php");
                    exit;
                }
                    
                    
            } else {
                //$_SESSION['paymentFlag']=$countforpay;
                //header("location: ../payment.php");
                echo "Your Account is currently not active.  Please sign up for a new account or contact our support team if you believe you've received this message in error.";
                exit;
            }
        } else {
            
                    $updateUser = "UPDATE user SET totalLogins = $newTotal, timestamp = " . date('Y-m-d') . " WHERE Userid = $loggedinuserID";                 
                    mysql_query($updateuser);
                    ob_end_clean();
					
				if($siteSize > 1 || $isParent == "" && $planid != 3 ){            
                    header("location: userHome.php");
                    exit;            
                } else {
                    $_SESSION['mobiId'] = $mySites[0];
                    header("location: mobiHome.php");
                    exit;
                }
                    header("location: userHome.php");
                    //echo "here";
                    exit;
        }
        
    } else {
        $errormessage=$errormessage . "Wrong Username or Password!";    
		header("location: http://mymobimanager.com/user-login?errormessage=1");
      }
}// end of if($_POST['submit'])

?>