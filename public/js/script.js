function disableField() {
	document.getElementById("region").setAttribute("disabled","");
	$('.selectpicker').selectpicker('refresh');
}

function enableField() {
	document.getElementById("region").removeAttribute("disabled");
	$('.selectpicker').selectpicker('refresh');
}
