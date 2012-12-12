<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Panda Power</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script type="text/javascript" src="http://www.mymobimanager.com/flickr/cycle.lite.js"></script>
        <script type="application/javascript" language="javascript">
            $(document).ready(function(){
                $.ajax({
                    url: "http://api.flickr.com/services/rest/?method=flickr.panda.getPhotos&api_key=6ca5f5e309b1213d8b1a36db7858f81d&panda_name=ling+ling&format=json",
                    data: "format=json",
                    jsonp: "jsoncallback",
        			timeout: 5000,
                    dataType: "jsonp",
					 statusCode: {
					 },
					success: function(returned) {	
						$.each(returned.photos.photo, function (i, set) {
							var imageUrl = "http://farm" + set.farm + ".staticflickr.com/" + set.server + "/" + set.id + "_" + set.secret + ".jpg";
							$(document.createElement("img")).attr({ "src": imageUrl, "style": "position: relative; margin: auto" }).appendTo('#imageHolder');
						}); //end each
						$('#imageHolder').cycle({ fx: 'fade',speed: 'fast',timeout: 0, next: '#next', prev: '#prev', pager:  '#imageNav' }); 
						$('#imageInfo').html(returned.photos.photo.title);
                   },
					error: function( jqXHR, textStatus, exception ) {
							if (jqXHR.status === 0) {
								$("#errorManager").append('Not connected.\n Verify Network.');
							} else if (jqXHR.status == 404) {
								$("#errorManager").append('Requested page not found. [404]');
							} else if (jqXHR.status == 500) {
								$("#errorManager").append('Internal Server Error [500].');
							} else if (exception === 'parsererror') {
								$("#errorManager").append('Requested JSON parse failed.');
							} else if (exception === 'timeout') {
								$("#errorManager").append('Time out error.');
							} else if (exception === 'abort') {
								$("#errorManager").append('Ajax request aborted.');
							} else {
								$("#errorManager").append('Uncaught Error.\n' + jqXHR.responseText);
							}
					} //end error handling
                }); //end                   
            });    
        </script>
        <style>
			body{
				height: 100%;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3c3c3c-+-+', endColorstr='#fff'); /* for IE */
				background: -webkit-gradient(linear, left top, left bottom, from(#3c3c3c), to(#fff)); /* for webkit browsers */
				background: -moz-linear-gradient(top,  #3c3c3c,  #fff 100%) ; /* for firefox 3.6+ */	
			}
		    #imageHolder { height: 300px; width: 300px; padding:0; overflow: hidden; postion: relative; margin: auto;}
    		#imageHolder img {border:none;}
			#imageNav {width: 100%; text-align:center;position:relative; margin: auto;}
			#imageNav a{color: #800000; }
			#errorManager { font-size: 20px; color: red; position: relative; text-align:center; top: 70px;  }
		</style>
    </head>
    <body>
    	<div id="errorManager"></div>
	    <ul id="imageHolder"></ul>  
        <div id="imageNav"> 
        	<a href="#" id="prev">Prev</a> | <a href="#" id="next">Next</a>
        </div>  
        <div id="imageInfo"></div>
    </body>
</html>
