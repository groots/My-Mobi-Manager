////////////done by munny//////////////
function validateForm1(){
	var Pagetitle = document.getElementById("Pagetitle").value;
	if(Pagetitle == ""){
		alert("Page title can't be empty!");
		document.getElementById("Pagetitle").focus();
		return false;
	}
	
	var content = document.getElementById("content").value;
	
	if(content == ""){
		alert("Page content can't be empty!");
		document.getElementById("content").focus();
		return false;
	}
	
	var Seourl = document.getElementById("Seourl").value;	
	if(Seourl == ""){
		alert("Seo url fffasf can't be empty!");
		document.getElementById("Seourl").focus();
		return false;
	}
return true;
}

//  Confirmation for delete.
function confirmDelete(){
    return confirm("Are you sure to delete this entry?");	
}
//////end of munny///////////////////////