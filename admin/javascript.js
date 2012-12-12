function validation_registration()
{
var firstName = document.getElementById("firstName").value;

if (firstName==""){
	alert("firstName is Empty");
	document.getElementById("firstName").focus();
	return false;
}
var lastName = document.getElementById("lastName").value;

if (lastName==""){
	alert("lastName is Empty");
	document.getElementById("lastName").focus();
	return false;
}
var userName = document.getElementById("userName").value;

if (userName==""){
	alert("userName is Empty");
	document.getElementById("userName").focus();
	return false;
}
var userType = document.getElementById("userType").value;

if (userType==""){
	alert("userType is Empty");
	document.getElementById("userType").focus();
	return false;
}
var email = document.getElementById("email").value;

if ((email==null)||(email=="")){
	alert("Email is Empty");
	document.getElementById("email").focus();
	return false;
}
if (checkEmail(email)==false){
	alert("This is not a valid Email Address");
	document.getElementById("email").focus();
	return false;

}

return true;
}

//////////email validation////////////////


function checkEmail(email) {

		var at="@"
		var dot="."
		var lat=email.indexOf(at)
		var lemail=email.length
		var ldot=email.indexOf(dot)
		if (email.indexOf(at)==-1){
		  
		   return false
		}

		if (email.indexOf(at)==-1 || email.indexOf(at)==0 || email.indexOf(at)==lemail){
		
		   return false
		}

		if (email.indexOf(dot)==-1 || email.indexOf(dot)==0 || email.indexOf(dot)==lemail){
		  
		    return false
		}

		 if (email.indexOf(at,(lat+1))!=-1){
		  
		    return false
		 }

		 if (email.subemailing(lat-1,lat)==dot || email.subemailing(lat+1,lat+2)==dot){
		 
		    return false
		 }

		 if (email.indexOf(dot,(lat+2))==-1){
		    
		    return false
		 }
		
		 if (email.indexOf(" ")!=-1){
		  
		    return false
		 }

 		 return true					
}


/////////////end of email validation//////




///////////////////check Availability/////////////////////
var xmlhttp;

function CheckUsername(userName){ // This function we will use to check to see if a username is taken or not.
	xmlHttp=GetXmlHttpObject() // Creates a new Xmlhttp object.
	if (xmlHttp==null)
	{ // If it cannot create a new Xmlhttp object.
	alert ("Browser does not support HTTP Request") // Alert Them!
	return // Returns.
	} // End If.

	var url="check_userName.php?userName="+userName // Url that we will use to check the username.
	url=url+"&sid1="+Math.random();
	
	if(userName!="")
	{
	xmlHttp.open("GET",url,true) // Opens the URL using GET
	}
	xmlHttp.onreadystatechange = function () { // This is the most important piece of the puzzle, if onreadystatechange is equal to 4 than that means the request is done.
	if (xmlHttp.readyState == 4) { // If the onreadystatechange is equal to 4 lets show the response text.
	document.getElementById("usernameresult").innerHTML = xmlHttp.responseText; // Updates the div with the response text from check.php
	} // End If.
	}; // Close Function
	xmlHttp.send(null); // Sends NULL instead of sending data.
} // Close Function.
//////////////////////////////////////////////////////////


function CheckSitename(userName){ // This function we will use to check to see if a username is taken or not.
	xmlHttp=GetXmlHttpObject() // Creates a new Xmlhttp object.
	if (xmlHttp==null)
	{ // If it cannot create a new Xmlhttp object.
	alert ("Browser does not support HTTP Request") // Alert Them!
	return // Returns.
	} // End If.

	var url="check_siteName.php?siteName="+userName // Url that we will use to check the username.
	url=url+"&sid1="+Math.random();
	
	if(userName!="")
	{
	xmlHttp.open("GET",url,true) // Opens the URL using GET
	}
	xmlHttp.onreadystatechange = function () { // This is the most important piece of the puzzle, if onreadystatechange is equal to 4 than that means the request is done.
	if (xmlHttp.readyState == 4) { // If the onreadystatechange is equal to 4 lets show the response text.
	document.getElementById("sitenameresult").innerHTML = xmlHttp.responseText; // Updates the div with the response text from check.php
	} // End If.
	}; // Close Function
	xmlHttp.send(null); // Sends NULL instead of sending data.
} // Close Function.
//////////////////////////////////////////////////////////



//////////functon///////////


function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
{
// code for IE7+, Firefox, Chrome, Opera, Safari
return new XMLHttpRequest();
}
if (window.ActiveXObject)
{
// code for IE6, IE5
return new ActiveXObject("Microsoft.XMLHTTP");
}
return null;
}




////end////////



