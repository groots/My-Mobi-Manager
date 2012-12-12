<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>FormSpring API Example</title>
    <style type="text/css">
    body {
        background-color: #ffffff;
        font-family: verdana, arial, sans-serif; 
        font-size: small;
    }
    </style>
</head>
<body>
<?php

/**
 * Example code that edits an existing submission
 *
 * Requires PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to the MIT license that is
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/mit-license.php.
 *
 * @copyright   2007 Recursive Function, LLC
 * @license     http://www.opensource.org/licenses/mit-license.php
 * @link        http://www.formspring.com/api.html
 */ 

require_once 'formspring.php';

/* ***************************************************** */

$api_key = empty($_REQUEST['api_key']) ? '' : $_REQUEST['api_key'];
$form_id = empty($_REQUEST['form_id']) ? '' : $_REQUEST['form_id'];
$submission_id = empty($_REQUEST['submission_id']) ? '' : $_REQUEST['submission_id'];

/* ***************************************************** */


print <<<END
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
<p>API Key: <input type="text" name="api_key" size="50" value="$api_key" /></p>
<p>Form ID: <input type="text" name="form_id" size="50" value="$form_id" /></p>
<p>Submission ID: <input type="text" name="submission_id" size="50" value="$submission_id" /></p>
<p><input type="submit" name="submit" value="Continue" /></p>
</form>
<hr />
END;

if (!empty($_REQUEST['submit'])) {

    if (empty($api_key))
        die('An API key was not supplied');
        
    if (empty($form_id))
        die('An form ID was not supplied');
        
    if (empty($submission_id))
        die('A submission ID was not supplied');
        
    if ($_REQUEST['submit'] == 'Continue') {
        
        // Print form header
        print <<<END
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
<input type="hidden" name="api_key" value="$api_key" />
<input type="hidden" name="form_id" value="$form_id" />
<input type="hidden" name="submission_id" value="$submission_id" />
END;
    
        // Get form info
        $form = FormSpring::request($api_key, 'form', array( 'id' => $form_id ));
        
        // Get submission info
        $submission = FormSpring::request($api_key, 'submission', array( 'id' => $submission_id ));
        
        // Map submission data to field ids
        $values = array();
        foreach ($submission['data'] as $item) {
            $values[$item['field']] = $item['value'];
        }
        
        // Display fields
        $fields = array();
        foreach ($form['fields'] as $field) {
            $label = htmlspecialchars($field['label']);
            $value = $values[$field['id']];
            print "<p>$label = <input type=\"text\" name=\"field_{$field['id']}\" value=\"$value\" size=\"50\" /></p>";
        }
        
        // Print form footer
        print <<<END
<p><input type="submit" name="submit" value="Save" /></p>
</form>
END;
    }
    else if ($_REQUEST['submit'] == 'Save') {
    
        // Get form info
        $form = FormSpring::request($api_key, 'form', array( 'id' => $form_id ));
        
        // Iterate over each field to look for submitted data
        $submit = array( 'id' => $submission_id );
        foreach ($form['fields'] as $field) {
            $var = 'field_'.$field['id'];
            if (!empty($_POST[$var]))
                $submit[$var] = $_POST[$var];
        }
    
        // Submit the new entry
        $submission = FormSpring::request($api_key, 'edit', $submit);
        
        // Display the new submission
        print "<p>Changed submission {$submission['id']}</p>";
    }
}

?>
</body>
</html>