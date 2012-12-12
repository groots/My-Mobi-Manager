<?PHP
	
	$googleLink = "http://maps.googleapis.com/maps/api/geocode/xml?address=";
	$googleSensor = "&sensor=false";
	// Initialize delay in geocode speed
	$delay = 0;

	$sqlAddresses = "SELECT * FROM mobilemanager_markers WHERE lat = '' AND mobiSiteId = $siteId";
	$storeAddresses = mysql_query($sqlAddresses);
	while($row = mysql_fetch_array($storeAddresses)){
		$rawAddress = $row['address'];
		$newAddress = str_replace(" ", "+", $rawAddress);
		$completeLink = $googleLink . $newAddress . $googleSensor;
		$geocode_pending = true;
		$id = $row["id"];
		
		while ($geocode_pending) {
		
			$xml = simplexml_load_file($completeLink) or die("url not loading");
		if ($xml->status == "OK") {
		  // Successful geocode
			  $geocode_pending = false;
			$status=$xml->status;
			$lat = $xml->result->geometry->location->lat;
			$lng = $xml->result->geometry->location->lng;
		//echo "here"; exit;
			  $query = "UPDATE mobilemanager_markers " .
					 " SET lat = $lat, lng = $lng " .
					 " WHERE id = $id LIMIT 1;";
			  $update_result = mysql_query($query);
			  if (!$update_result) {
				die("Invalid query: " . mysql_error());
			  }
			} else if ($xml->status == "OVER_QUERY_LIMIT") {
			  // sent geocodes too fast
			  //$delay += 100000;
			  echo "You are over the query limit.  Please contact a My Mobi Manager Administrator";
			} else if ($xml->status == "ZERO_RESULTS") {
			  // failure to geocode
			  $geocode_pending = false;
			  echo "Address " . $address . " failed to geocoded. ";
			  echo "Received status " . $status . "\n";
		}
		usleep($delay);
	  }

	}



?>