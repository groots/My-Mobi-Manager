<?PHP

			/* ***************************************************** */
			
			$api_key = $fStackAPIKey;
			$form_id = $row['fStackFormId'];

			print <<<END
<form method="post" action="{$Seourl}">
<input type="hidden" name="api_key" value="$api_key" />
<input type="hidden" name="form_id" value="$form_id" />
END;

	
	
	
        // Get form info
$form = Formstack::request($api_key, 'form', array( 'id' => $form_id ));
	
	// Display fields
	$fields = array();
	foreach ($form['fields'] as $field) {
		
		$label = htmlspecialchars($field['label']);
		$name  = htmlspecialchars($field['name']);
		
		$type = htmlspecialchars($field['type']);
		$default = $field['default'];
		$options = $field['options'];
		if ($type =="textarea") {
			echo "<div>$label <br /><textarea name='field_{$field['id']}'>$default</textarea></div>";	
		} elseif($type == "checkbox") {
			if ($field['options'] != "") {
				foreach ($field['options'] as $opt => $value) {
					if($value['label'] != "") {
						echo "<input type='checkbox' name='field_{$field['id']}' value='". $value['value'] . "' /> " . $value['label'] . "<br />";
					}
				}
			}
		} elseif($type == "select") {
			if ($field['options'] != "") {
				echo "<div>$label <br /><select name='field_{$field['id']}'>";
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
						echo "<input type='$type' name='field_{$field['id']}' value='". $value['value'] . "' /> " . $value['label'] . "<br />";
					}
				}
				echo "</div>";
			}
		} elseif ($type == 'datetime'){
			echo $label;
			echo $field['options'];
		} elseif ($type != "section") {
			echo "<div>" . $label . " <input type='$type' name='field_{$field['id']}' value='$default' /> </div>";	
		}
	}	
	
	    // Print form footer
        print <<<END
<p><input type="submit" name="submit" value="Save" /></p>
</form>
END;
?>