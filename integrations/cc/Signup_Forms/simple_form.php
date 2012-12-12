<?php
header('Content-Type: text/html; charset=UTF-8');

$clientLogin = 'mymobimanager';
$clientPassword = '1.Squish.com';

include_once('cc_class.php');
$ccContactOBJ = new CC_Contact();

		
$ccListOBJ = new CC_List(); 
//if we have post fields means that the form have been submitted.
	
	if (!empty($_POST)) {
		///
		///
		$postFields = array();
		$postFields["email_address"] = $_POST["email_address"];
		$postFields["first_name"] = $_POST["first_name"];
		$postFields["last_name"] = $_POST["last_name"];
		$postFields["middle_name"] = $_POST["middle_name"];
		$postFields["home_number"] = $_POST["home_num"];
		$postFields["address_line_1"] = $_POST["adr_1"];
		$postFields["address_line_2"] = $_POST["adr_2"];
		$postFields["address_line_3"] = $_POST["adr_3"];
		$postFields["city_name"] = $_POST["city"];
		$postFields["state_code"] = $_POST["state"];
		// The Code is looking for a State Code For Example TX instead of Texas
		$postFields["state_name"] = $_POST["state_name"];
		$postFields["country_code"] = $_POST["country"];
		$postFields["zip_code"] = $_POST["postal_code"];
		$postFields["sub_zip_code"] = $_POST["sub_postal"];
		$postFields["mail_type"] = $_POST["mail_type"];
		$postFields["lists"] = $_POST['lists'];
		
	
		$contactXML = $ccContactOBJ->createContactXML(null,$postFields);
		if (!$ccContactOBJ->addSubscriber($contactXML)) {
			$error = true;
		} else {
			$error = false;
			$_POST = array();
		}
		
	}
	
	if(!$_POST['email_address']){
		$_POST['email_address'] = urldecode(trim($_GET['email']));
	}
	//get all available lists for the current CC account.
	$allLists = $ccListOBJ->getLists();
	//get all available states
	$allStates = $ccContactOBJ->getStates();
	//get all available countries
	$allCountries = $ccContactOBJ->getCountries();
	?>
<?php  include_once('header.php'); ?>
<div align="center" style="width: 900px;">
<!--h2>Add a new Subscriber - Simplified form</h2-->
<?php 
	//
	// Here we add an area where messages  are displayed (error or success messages).
	//
	
	if (isset($error)) {
		
		if ($error === true) {
			$class = "error";
			$message = $ccContactOBJ->lastError;
		} else {
			$class = "success";
			$message = "Contact ".htmlspecialchars($postFields["email_address"], ENT_QUOTES, 'UTF-8')." Added.";
		}
		echo '<div class="'.$class.'">';
		echo $message;
		echo '</div>';
	}
	?>
<form action="" method="post">

	<h3>Contact information</h3>	
	<table width="199" border="0" cellpadding="2" cellspacing="0">
		<tr>
			<td align="left">Email Address:</td>
			<td align="left"><input type="text" name="email_address" value="<?php  echo htmlspecialchars($_POST['email_address'], ENT_QUOTES, 'UTF-8') ?>" maxLength="30" /></td>
			<td align="left">&nbsp;</td>
	      	<td align="left">&nbsp;</td>
	 	</tr>
		<tr>
			<td align="left">First Name:</td>
            
			<td align="left"><input type="text" name="first_name" maxLength="30"  value="<?php  echo htmlspecialchars($_POST['first_name'], ENT_QUOTES, 'UTF-8') ?>" /></td>
	 	</tr>
		<tr>
			<td align="left">Last Name:</td>
			<td align="left"><input type="text" name="last_name" maxLength="30"  value="<?php  echo htmlspecialchars($_POST['last_name'], ENT_QUOTES, 'UTF-8') ?>" /></td>
	    </tr>
		<tr>
			<td align="left">City:</td>
			<td align="left"><input type="text" name="city" maxLength="30"  value="<?php  echo htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8') ?>" /></td>
	 	</tr>
		<tr>
			<td align="left">State:</td>
			<td align="left">
				<select name="state">
				<option value="">&nbsp;</option>
				<?php 
	foreach ($allStates as $stateCode=>$stateName) {
		$selected = '';
		
		if ($stateCode == $_POST['state']) {
			$selected = ' selected ';
		}
		echo '<option value="'.$stateCode.'" '.$selected.'>'.$stateName.'</option>';
	}
	?>
				</select>
			</td>
	    </tr>
		<tr>
			<td align="left">E-Mail Type:</td>
			<td align="left" colspan="3">
				<input type="radio" class="checkbox" name="mail_type" id="mt1" value="HTML" <?php 
	echo ($_POST['mail_type']=='HTML' || empty($_POST['mail_type']))?' checked ':
	'';
	?> />
				<label for="mt1">HTML</label>
				&nbsp;or&nbsp;
				<input type="radio" class="checkbox" name="mail_type" id="mt2" value="Text" <?php 
	echo ($_POST['mail_type']=='Text')?' checked ':
	'';
	?> />
				<label for="mt2">Text</label>
			</td>			
	    </tr>
        
        <tr>
        	<td align="center" colspan="4">
            
            
            	
			<?php 
            if($ccContactOBJ->contact_lists && !$ccContactOBJ->show_contact_lists && $ccContactOBJ->force_lists){
                foreach ($allLists as $k=>$item) {
                    echo '<input type="hidden" name="lists[]" value="'.$item['id'].'" id="chk_'.$k.'" />';
                }
            } else {
            ?>
            <div style="float: right; text-align: left; overflow: auto; height: auto; width:250px;">
                <fieldset>
                    <legend> Interests list </legend>
                <?php
                foreach ($allLists as $k=>$item) {
                    $checked = '';
                    if($_POST['lists']){	
                        if (in_array($item['id'],$_POST['lists'])) {
                            $checked = ' checked ';
                        }
                    }
                    
                    if($ccContactOBJ->force_lists && $ccContactOBJ->show_contact_lists){	
                        echo '<input type="hidden" name="lists[]" value="'.$item['id'].'" id="chk_'.$k.'" /><label for="chk_'.$k.'">'.$item['title'].'</label><br />';
                    }
                    else {	
                        echo '<input type="checkbox" '.$checked . $disabled .' class="checkbox" name="lists[]" value="'.$item['id'].'" id="chk_'.$k.'" /> <label for="chk_'.$k.'">'.$item['title'].'</label><br/>';
                    }
                }
                ?>	
                </fieldset>
            </div>
            <?php } ?>
            <div>
            
            </td>
		<tr>
			<td align="center" colspan="4">				 
			    <input type="submit" name="submit" value="Add Contact" />
		    </td>
		</tr>
	</table>
</div>
</form>
</div>
<?php include_once('footer.php'); ?>