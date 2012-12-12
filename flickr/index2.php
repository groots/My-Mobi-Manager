<?php
    $apiKey = "6ca5f5e309b1213d8b1a36db7858f81d";
    
    /**
     * Checks whether the call to the API returned an error
     *
     * @param SimpleXMLElement $xml
     */
    function api_call_returned_error($xml) {
        return (string) $xml["stat"] == "fail";
    }
?>

<html>
  <head>
  <title>Hello world</title>
    <title>Example using World Bank API</title>
    <script>
		window.document.title="Goodbye World";
	</script>
  </head>
  <body>    
    <?php
      // set url to make country query into the API
      $url = "http://api.flickr.com/services/rest/?method=flickr.panda.getList&api_key=" . $apiKey;
      
      // make the call to the API, which returns valid XML
      $xml = simplexml_load_file($url);
      
      // check if the API call failed
      if(api_call_returned_error($xml)) {
        echo "Could not fetch country list. Error #" . $xml->err["code"] . " - " . $xml->err["msg"];
      }
	  print_r($xml);
	  
	  echo "<br/><br/>======================================================================================<br/><br />";
	  
	  echo $xml->pandas->panda[0];
	  $firstPanda =  $xml->pandas->panda[0];
	  
	  $url2 = "http://api.flickr.com/services/rest/?method=flickr.panda.getPhotos&api_key=" . $apiKey . "&panda_name=" . $firstPanda;
	  $pandaPhotos = simplexml_load_file($url2);
	  
	  echo "<br/><br/>======================================================================================<br/><br />";
	  print_r($pandaPhotos);
	  
	  
	  echo "<br/><br/>======================================================================================<br/><br />";
	  
    ?>
    
    <table width = "70%" align="right" b>
    	<tr style="res">
        	<td><em>test</em></td>
            </tr>
    </table>
    <style>
		div#id {
			res	
		}
	</style>
  </body>
</html>