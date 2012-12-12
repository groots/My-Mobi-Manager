<?php

//classes follow

// Generic container for the complete RSS feed
class rssFeed{
	var $title="";
	var $copyright="";
	var $description="";
	var $image;
	var $stories=array();
	var $url="";
	var $xml="";
	var $link="";
	var $error="";
	var $maxstories=0;
	
	// public methods
	function parse(){
		$parser=xml_parser_create();
		xml_set_element_handler($parser, "startElement", "endElement");
		xml_set_character_data_handler($parser, "characterData");
		xml_parse($parser, $this->xml, true)
			or die(sprintf("XML error: %s at line %d", 
				xml_error_string(xml_get_error_code($parser)), 
				xml_get_current_line_number($parser)));
		xml_parser_free($parser);
	}

	function showHeading($tag=""){
		$tag=$tag?$tag:"h1";
		if($this->title)
			print "<$tag>$this->title</$tag>\n";
	}
/*
	function showImage($align=""){
		$this->image->show($align);
	}
*/
		
	function showDescription(){
		if($this->description)
			print    strip_tags("<p>$this->description</p>",'<p><a>' );
	}

	function showStories(){
		//echo "<dl>\n";
		$n=0;
		foreach($this->stories as $story){
			$n++;
			if ($this->maxstories && $n>$this->maxstories)
				break;
			$story->show();
		}
		//echo "</dl>\n";
	}
	
	// Methods used internally
	// Constructor: Expects one string parameter that is the URI of the RSS feed
	function rssFeed($uri=''){
		//$this->image=new rssImage();
		if($uri){
			$this->url=$uri;
			$this->getFeed();
		} else {
			$this->error="No URL for RSS feed";
		}
	}
	
	// Retrieves the XML from the RSS supplier
	function getFeed(){
		// if we have a URL
		if ($this->url){
			if (extension_loaded('curl')) {
				$this->xml=$this->getRemoteFile($this->url);
			}
		}
	}

	function getRemoteFile($url){
		$s=new gwSocket();
		if($s->getUrl($url)){
			if(is_array($s->headers)){
				$h=array_change_key_case($s->headers, CASE_LOWER);
				if($s->error) // failed to connect with host
					$buffer=$this->errorReturn($s->error);
				elseif(preg_match("/404/",$h['status'])) // page not found
					$buffer=$this->errorReturn("Page Not Found");
				elseif(preg_match("/xml/i",$h['content-type'])) // got XML back
					$buffer=$s->page;
				else // got a page, but wrong content type
					$buffer=$this->errorReturn("The server did not return XML. The content type returned was ".$h['content-type']);
			} else {
				$buffer=$this->errorReturn("An unknown error occurred.");
			}
		}else{
			$buffer=$this->errorReturn("An unknown error occurred.");
		}
		return $buffer;
	}

	function errorReturn($error){
		$retVal="<?xml version=\"1.0\" ?>\n".
			"<rss version=\"2.0\">\n".
			"\t<channel>\n".
			"\t\t<title>Failed to Get RSS Data</title>\n".
			"\t\t<description>An error was ecnountered attempting to get the RSS data: $error</description>\n".
			"\t\t<pubdate>".date("D, d F Y H:i:s T")."</pubdate>\n".
			"\t\t<lastbuilddate>".date("D, d F Y H:i:s T")."</lastbuilddate>\n".
			"\t</channel>\n".
			"</rss>\n";
		return $retVal;
	}

	function addStory($o){
		if(is_object($o))
			$this->stories[]=$o;
		else
			$this->error="Type mismatach: expected object";
	}

}
/*
class rssImage{
	var $title="";
	var $url="";
	var $link="";
	var $width=0;
	var $height=0;
	
	function show($align=""){
		if($this->url){
			if($this->link)
				print "<a href=\"$this->link\">";
			print "<img src=\"$this->url\" style=\"border:none;\"";
			if($this->title)
				print " alt=\"$this->title\"";
			if($this->width)
				print " width=\"$this->width\" height=\"$this->height\"";
			if($align)
				print " align=\"$align\"";
			print ">";	
			if($this->link)
				print "</a>";
		}
	}
}
*/
class newsStory{
	var $title="";
	var $link="";
	var $description="";
	var $pubdate="";
	
	function show(){
		if($this->title){
			if($this->link){
				echo str_replace("&"," ", "<dt><p><a class='linked' rel='external' href=\"$this->link?link=mobi\">$this->title</a></p></dt>\n");
			}elseif($this->title){
				echo str_replace("&"," ","<dt>$this->title</a></dt>\n");
			}
			//echo "<dd style='display: block; padding-bottom: 10px;'>";
			//if($this->pubdate)
				//echo   "<i>$this->pubdate</i> - " ;
			//if($this->description)
				//echo  str_replace("&","",strip_tags($this->description) );
			//echo "</dd>\n\n";
		}
	}
}


class gwSocket{
	var $Name="gwSocket";
	var $Version="0.1";
	var $userAgent="Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
	var $headers;
	var $page="";
	var $result="";
	var $redirects=0;
	var $maxRedirects=3;
	var $error="";

	function getUrl( $url ) {
		$retVal="";
		$url_parsed = parse_url($url);
		$scheme = $url_parsed["scheme"];
		$host = $url_parsed["host"];
		$port = $url_parsed["port"]?$url_parsed["port"]:"80";
		$user = $url_parsed["user"];
		$pass = $url_parsed["pass"];
		$path = $url_parsed["path"]?$url_parsed["path"]:"/";
		$query = $url_parsed["query"];
		$anchor = $url_parsed["fragment"];

		if (!empty($host)){

			// attempt to open the socket
			if($fp = fsockopen($host, $port, $errno, $errstr, 2)){

				$path .= $query?"?$query":"";
				$path .= $anchor?"$anchor":"";

				// this is the request we send to the host
				$out = "GET $path ".
					"HTTP/1.0\r\n".
					"Host: $host\r\n".
					"Connection: Close\r\n".
					"User-Agent: $this->userAgent\r\n";
				if($user)
					$out .= "Authorization: Basic ".
						base64_encode("$user:$pass")."\r\n";
				$out .= "\r\n";

				fputs($fp, $out);
				while (!feof($fp)) {
					$retVal.=fgets($fp, 128);
				}
				fclose($fp);
			} else {
				$this->error="Failed to make connection to host.";//$errstr;
			}
			$this->result=$retVal;
			$this->headers=$this->parseHeaders(trim(substr($retVal,0,strpos($retVal,"\r\n\r\n"))));
			$this->page=trim(stristr($retVal,"\r\n\r\n"))."\n";
			if(isset($this->headers['Location'])){
				$this->redirects++;
				if($this->redirects<$this->maxRedirects){
					$location=$this->headers['Location'];
					$this->headers=array();
					$this->result="";
					$this->page="";
					$this->getUrl($location);
				}
			}
		}
		return (!$retVal="");
	}
	
	function parseHeaders($s){
		$h=preg_split("/[\r\n]/",$s);
		foreach($h as $i){
			$i=trim($i);
			if(strstr($i,":")){
				list($k,$v)=explode(":",$i);
				$hdr[$k]=substr(stristr($i,":"),2);
			}else{
				if(strlen($i)>3)
					$hdr[]=$i;
			}
		}
		if(isset($hdr[0])){
			$hdr['Status']=$hdr[0];
			unset($hdr[0]);
		}
		return $hdr;
	}

}

/*
	end of classes - global functions follow
*/

function startElement($parser, $name, $attrs) {
	global $insideitem, $tag;// $isimage;
	$tag = $name;
/*	if($name=="IMAGE")
		$isimage=true; */
	if ($name == "ITEM") {
		$insideitem = true;
	}
}

function endElement($parser, $name) {
	global $insideitem, $title, $description, $link, $pubdate, $stories, $rss, $globaldata;
	//  $isimage;
	$globaldata=trim($globaldata);
	// if we're finishing a news item
	if ($name == "ITEM") {
		// create a new news story object
		$story=new newsStory();
		// assign the title, link, description and publication date
		$story->title=trim($title);
		$story->link=trim($link);
		$story->description=trim($description);
		$story->pubdate=trim($pubdate);
		// add it to our array of stories
		$rss->addStory($story);
		// reset our global variables
		$title = "";
		$description = "";
		$link = "";
		$pubdate = "";
		$insideitem = false;
	} else {
		switch($name){
		/*	case "TITLE":
				if(!$isimage)
					if(!$insideitem)
						$rss->title=$globaldata;
				break;
			case "LINK":
				if(!$insideitem)
					$rss->link=$globaldata;
				break;*/
			case "COPYRIGHT":
				if(!$insideitem)
					$rss->copyright=$globaldata;
				break;
			case "DESCRIPTION":
				if(!$insideitem)
					$rss->description=$globaldata;
				break;
		}
	}
/*	
	if($isimage){
		switch($name){
			case "TITLE": $rss->image->title=$globaldata;break;
			case "URL": $rss->image->url=$globaldata;break;
			case "LINK": $rss->image->link=$globaldata;break;
			case "WIDTH": $rss->image->width=$globaldata;break;
			case "HEIGHT": $rss->image->height=$globaldata;break;
		}
	}
	if($name=="IMAGE")	
		$isimage=false;
*/		
	$globaldata="";
}

function characterData($parser, $data) {
	global $insideitem, $tag, $title, $description, $link, $pubdate, $globaldata;
	if ($insideitem) {
		switch ($tag) {
			case "TITLE":
				$title .= $data;
				break;
			case "DESCRIPTION":
				$description .= $data;
				break;
			case "LINK":
				$link .= $data;
				break;
			case "PUBDATE":
			case "DC:DATE":
				$pubdate .= $data;
				break;
		}
	} else {
		$globaldata.=$data;
	}
}

?>
