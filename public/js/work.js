function addService(){
	numOfServices +=1;
	var orderNumber = document.getElementById("orderNumber").value;
	var orderDesc = document.getElementById("orderDesc").value;
	var orderQuantity = document.getElementById("orderQuantity").value;
	document.getElementById("orderNumber").value = "";
	document.getElementById("orderDesc").value = "";
	document.getElementById("orderQuantity").value = "";
	document.getElementById("serviceContainer").innerHTML += "<div class='tabContainerContent' id='"+ numOfServices +"'><div class='smallCol1-content'>" + orderNumber + "</div><div class='bigCol-content'>" + orderDesc + "</div><div class='smallCol2-content'>" + orderQuantity + "</div></div>";
}

function enableField() {
	document.getElementById("optionalField").setAttribute("disabled", "disabled");
}

function disableField() {
	document.getElementById("optionalField").removeAttribute("disabled");
}

var numOfServices=0;