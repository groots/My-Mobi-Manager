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
 * Example code that paginates through data submitted on a form
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

/* ***************************************************** */

print <<<END
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
<p>API Key: <input type="text" name="api_key" size="50" value="$api_key" /></p>
<p>Form ID: <input type="text" name="form_id" size="50" value="$form_id" /></p>
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<hr />
END;

if (!empty($_REQUEST['submit'])) {

    if (empty($api_key))
        die('An API key was not supplied');
        
    if (empty($form_id))
        die('An form ID was not supplied');
    
    // Get form info
    $form = FormSpring::request($api_key, 'form', array( 'id' => $form_id ));
    
    // Map field ids to labels
    $fields = array();
    foreach ($form['fields'] as $field) {
        $fields[$field['id']] = htmlspecialchars($field['label']);
    }
    
    // Determine the current page #
    $page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
    $per_page = 25;
    
    // Get data for the form
    $data = FormSpring::request($api_key, 'data', array( 'id' => $form_id, 'page' => $page, 'per_page' => $per_page ));

    // Check if we found any data
    if (count($data['submissions'])) {
    
        // Display the current result #s and the total number of submissions
        $start = ($page - 1) * $per_page + 1;
        $end = $start + count($data['submissions']) - 1;    
        print "<h4>Viewing $start - $end submissions of {$data['total']}</h4>";

        // Iterate over each one
        foreach ($data['submissions'] as $submission) {
        
            // Print information to the browser
            $timestamp = date('M j, Y H:i:s', strtotime($submission['timestamp']));
            print "<p>ID: {$submission['id']}<br />Submitted on $timestamp<br />";

            // Iterate over each data item
            foreach ($submission['data'] as $item) {
                print $fields[$item['field']] . ' = ' . htmlspecialchars($item['value']) . '<br />';
            }

            print "</p><hr />";
        }
        
        // Add link to view next page
        if ($data['pages'] > $page) {
            $next_page = $page + 1;
            print "<div style=\"float:right\"><a href=\"{$_SERVER['SCRIPT_NAME']}?api_key=$api_key&amp;form_id=$form_id&amp;page=$next_page&amp;submit=1\">Next Page</a></div>";
        }
        
        // Add link to view previous page
        if ($page > 1) {
            $prev_page = $page - 1;
            print "<div><a href=\"{$_SERVER['SCRIPT_NAME']}?api_key=$api_key&amp;form_id=$form_id&amp;page=$prev_page&amp;submit=1\">Previous Page</a></div>";
        }
    }
    else {
        print '<p>There was no data found.</p>';
    }
}

?>
</body>
</html>