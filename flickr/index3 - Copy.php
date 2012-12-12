<?PHP
	$apiKey = "6ca5f5e309b1213d8b1a36db7858f81d";
	$url = "http://api.flickr.com/services/rest/?method=flickr.panda.getList&api_key=" . $apiKey;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" language="javascript"
        type="text/javascript"></script>


<script type="application/javascript" language="javascript">
	$(document).ready(function(){
	var result;
        $.ajax({
            url: "http://api.flickr.com/services/rest/?method=flickr.panda.getPhotos&api_key=6ca5f5e309b1213d8b1a36db7858f81d&panda_name=ling+ling&format=json",
            data: "format=json",
            jsonp: "jsoncallback",
            dataType: "jsonp",
			success: function(returned) {
				
				$.each(returned.photos.photo, function (i, set) {
					$('#placeholder').append( "<img src='http://farm" + set.farm + ".staticflickr.com/" + set.server + "/" + set.id + "_" + set.secret + ".jpg' /> <br />");
					
				});
				/*for (var i=0, len=response.photos.photo.length; i < len; i++) 
				{
					
					exit;
					var shortenPic = response.photos.photo;
					var picId = response.photos.photo[i].id;
					$.ajax({
						url:"http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=6ca5f5e309b1213d8b1a36db7858f81d&photo_id=" + response.photos.photo[i].id+ "&format=json",
						data: "format=json",
						jsonp: "jsoncallback",
						dataType: "jsonp",
						success: function(photo_input){
							var imageurl = photo_input.photo.urls.url[0].photopage;
							
							
							$.each(photo_input.photo.urls.url, function (i, set) {
								if (i == 0) {
									var newImage = $(document.createElement("img")).attr({ src: set._content})

									//$(document.createElement("img")).attr('src': set._content);
									
									$('#placeholder').append( "<img src='" + set._content + "' />" + set._content + "<br />" );
								}
							});
								
						}
						
					});
					
					$('#myLink').click(function(){

					var newParagraph = $('<p />').text("Goodbye world...");

					$('#myDiv').append(newParagraph);

				}); 
					//alert(response.photos.photo[i].id);	
				}
*/
			//$('#placeholder').append( print(response.photos.photo) );
		   }
        });
			
			});
	var print = function(o){
    var str='';

    for(var p in o){
        if(typeof o[p] == 'string'){
            str+= p + ': ' + o[p]+'; </br>';
        }else{
            str+= p + ': { </br>' + print(o[p]) + '}';
        }
    }

    return str;
}

</script>
</head>

<body>

<ul id="placeholder"></ul>

</body>
</html>
