<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?    

	require_once '../formstack.php';
	$api_key = $_GET['api'];
	$form_id = $_GET['fid'];
	
	// Get form info
	$form = Formstack::request($api_key, 'form', array( 'id' => $form_id ));
	
	// Display fields
	$fields = array();
	foreach ($form['fields'] as $field) {
		
		$label = htmlspecialchars($field['label']);
		$name  = htmlspecialchars($field['name']);
		
		$type = htmlspecialchars($field['type']);
		echo $type;
		$default = $field['default'];
		$options = $field['options'];
		if ($type =="textarea") {
			echo "<div>$label <br /><textarea name='$name'>$default</textarea></div>";	
		} elseif($type == "checkbox") {
			if ($field['options'] != "") {
				foreach ($field['options'] as $opt => $value) {
					if($value['label'] != "") {
						echo "<input type='checkbox' name='" . $name . "' value='". $value['value'] . "' /> " . $value['label'] . "<br />";
					}
				}
			}
		} elseif($type == "select") {
			if ($field['options'] != "") {
				echo "<div>$label <br /><select name='$name'>";
				foreach ($field['options'] as $opt => $value) {
					if($value['label'] != "") {						
						echo "<option value='". $value['value'] . "' /> " . $value['label'] . "</option>";
					}
				}
				echo "</select></div>";
			}
		} elseif($type == "radio") {
			if ($field['options'] != "") {
				echo "<div> $label <br />";
				foreach ($field['options'] as $opt => $value) {
					if($value['label'] != "") {
						echo "<input type='radio' name='" . $name . "' value='". $value['value'] . "' /> " . $value['label'] . "<br />";
					}
				}
				echo "</div>";
			}
		} elseif ($type == 'datetime'){
			echo $label;
			echo $field['options'];
		} elseif ($type != "section") {
			echo "<div>" . $label . " <input type='text' name='$name' value='$default' /> </div>";	
		}
	}
 ?>       
</body>
</html>
