<?php

/**
 * Library that's used to make requests to the FormSpring API
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

class FormSpring {

    static $api_url = 'https://www.formspring.com/api';

    /**
    * Utility function to use cURL to make API requests
    */
    public static function request($api_key, $method, $arguments = array()) {
        
        $arguments['api_key'] = $api_key;
        $arguments['type']    = 'php';
            
        // Use CURL to make the request and POST vars
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api_url . '/' . $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        
        // Error if we didn't get any response
        if (empty($res))
            die("Unexpected Error");
        
        // Since we requested a response in PHP format, unserialize into an array
        $php_res = unserialize($res);
        
        // Error if there was a problem
        if ($php_res['status'] == 'error')
            die('API Error: '.$php_res['error']);
            
        // Return the response
        return $php_res['response'];
    }

}
