<?PHP
	$apiKey = "6ca5f5e309b1213d8b1a36db7858f81d";
	$url = "http://api.flickr.com/services/rest/?method=flickr.panda.getList&api_key=" . $apiKey;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>


<script id="flickrPandasTemplate" type="text/x-jquery-tmpl">
	<li>
		<h2>${title}</h2>
		<dvi>${id}</div>
	</li>
</script>
<script id="flickrPandasTemplate" type="text/x-jquery-tmpl">
	<li>
		<h2>${title}</h2>
		<dvi>${id}</div>
	</li>
</script>
<script type="application/javascript" language="javascript">
$(document).ready(function()
    {
		var result;
		
        $.ajax({
			type: "POST",       
			dataType: "json",
			contentType: "application/x-www-form-urlencoded",
            url: "http://www.addresstwo.com/cf/function_api.asp",
            data: "txtUserName=\"groots\", txtPassword=\"letmein\"",
			error: function(request,error) {
			  $("#loading").addClass("hide");
			  if (error == "timeout") {
			   $("#error").append("The request timed out, please resubmit");
			  }
			  else {
			   $("#error").append("ERROR: " + print(request));
			  }
			  },
			complete: function(){
				alert("did it still");
			},
			success: function(result) {
				
		alert("here");
		exit;
				for (var i=0, len=result.photos.photo.length; i < len; i++) 
				{
					
				}

			//$('#placeholder').append( print(response.photos.photo) );
			//$("#flickrPandasTemplate").tmpl(response.photos.photo).appendTo("#placeholder");
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
<div class="result"></div>
<div id="error"></div>
<form action="aweber.php" method="post">
<input type="submit" />
</form>
</body>
</html>
