<?php
$title = "Wrong username or password";
if ($_POST["username"] && $_POST["password"]) {
	if ($_POST["username"] =="jqtouch" && $_POST["password"] == "jqtouch") { 
$title = "Success";
}
}
	require_once 'formstack.php';




?>
<div>
<?php
echo "This form is down currently, but will be back up very soon. Please use your back button to get to the previous page.";
		$api_key = $_POST['api_key']; 
		$form_id = $_POST['form_id'];



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
		echo $row['fStackResponse'];



?>

Thank you!
</div>
