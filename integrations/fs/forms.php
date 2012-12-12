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
 * Example code that lists info about forms accessible via the API
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

/* ***************************************************** */


print <<<END
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
<p>API Key: <input type="text" name="api_key" size="50" value="$api_key" /></p>
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<hr />
END;

if (!empty($_REQUEST['submit'])) {

    if (empty($api_key))
        die('An API key was not supplied');
    
    // Get a list of all the forms
    $res = FormSpring::request($api_key, 'forms');

    // Check if we found any
    if (count($res['forms'])) {

        // Iterate over each one
        foreach ($res['forms'] as $form) {
        
            $name = htmlspecialchars($form['name']);
            $created = date('M j, Y', strtotime($form['created']));
            
            // Print information to the browser
            print <<<END
<h3>$name</h3>
<p>
    ID: {$form['id']}<br />
    Created on $created<br />
    {$form['submissions']} Submissions, 
    {$form['views']} Views<br />
    <a href="{$form['url']}">View Form</a>
</p>
<br />
END;
        }
    }
    else {
        print '<p>There were no forms found.</p>';
    }
}

?>
</body>
</html>