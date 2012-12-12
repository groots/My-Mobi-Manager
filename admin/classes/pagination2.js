	var xmlHttp
	
	function pagination2(page)
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}
	
		var url="sitelist_sub.php";
		url = url+"?starting="+page;
		url = url+"&search_text="+document.form2.search_text.value;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	} 
	
	function stateChanged() 
	{ 
		if (xmlHttp.readyState==4)
		{ 
			document.getElementById("page_contents").innerHTML=xmlHttp.responseText;
		}
	}
	
	function GetXmlHttpObject()
	{
	var xmlHttp=null;
	try
	  {
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
	  // Internet Explorer
	  try
		{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e)
		{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	return xmlHttp;
	}