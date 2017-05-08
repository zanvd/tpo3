function disableField() {
	document.getElementById("region").setAttribute("disabled","");
	$('.selectpicker').selectpicker('refresh');
}

function enableField() {
	document.getElementById("region").removeAttribute("disabled");
	$('.selectpicker').selectpicker('refresh');
}

function toggleContactField(){
	document.getElementById("addContactPerson").innerHTML = buttonText;
	var temp = buttonText;
	buttonText = buttonText2;
	buttonText2 = temp;
}

function addDependantField(){
	document.getElementsByClassName("dependantArea")[0].innerHTML += dependantArea;
	$('#dependant').collapse();
	document.getElementById('dependant').id = id;
	id +=1;
}

function removeSelf(node){
	var child = node.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
	console.log(child.id);
	var element = $('#' + child.id);
	element.collapse('hide');
}

$(function () {
    $('#datetimepicker2').datetimepicker({
        locale: 'sl',
        format: 'DD.MM.YYYY'
    });
});

var id = 0;
var buttonText = "Odstrani kontaktno osebo";
var buttonText2 = "Dodaj kontaktno osebo";
$('#addContactPerson')[0].addEventListener("click", toggleContactField, false);
$('#addDependantPerson')[0].addEventListener("click", addDependantField, false);
var body = document.getElementsByTagName("BODY")[0];
var contactField;
var dependantArea;

body.onload = function(){
	dependantArea = document.getElementsByClassName("dependantArea")[0].innerHTML;
	document.getElementsByClassName("dependantArea")[0].innerHTML ="";
};