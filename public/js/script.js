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
	document.getElementsByClassName("dependantArea")[0].appendChild(dependantArea.cloneNode(true));
	$('#dependant').collapse();
	document.getElementById('dependant').id = id;
	var newField= $('#' + id).find("input");
	var newField2= $('#' + id).find("select");
	id +=1;
	 $("#registrationForm").bootstrapValidator('addField', newField);
	 $("#registrationForm").bootstrapValidator('addField', newField2);
}

function removeSelf(node){
	var child = node.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
	var element = $('#' + child.id);
	element.collapse('hide');
}

function validate() {
	validator = $("#registrationForm").bootstrapValidator({
				fields: {
					email : {
						message: "Potreben je email naslov",
						validators : {
							notEmpty : {
								message: "Vnesite email naslov"
							},
							emailAddress: {
								message: "Email naslov naslov ni pravilne oblike"
							}
						}
					},
					password : {
						validators: {
							notEmpty: {
								message: "Vnesite geslo"
							},
							stringLength: {
								min: 8,
								max: 64,
								message: "Geslo mora biti dolgo vsaj 8 znakov"
							},
							regexp: {
								message: "Geslo mora vsebovati črke in številke"
							}
						}
					},
					password_confirmation: {
						validators: {
							notEmpty: {
								message: "Ponovno vnesite geslo"
							},
							identical: {
								field: "password",
								message: "Gesli se morata ujemati"
							}
						}
					},
					firstname: {
						validators: {
							notEmpty: {
								message: "Vnesite ime"
							},
							regexp: {
								message: "Ime lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					contactName: {
						validators: {
							notEmpty: {
								message: "Vnesite ime"
							},
							regexp: {
								message: "Ime lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					surname:{
						validators: {
							notEmpty: {
								message: "Vnesite priimek"
							},
							regexp: {
								message: "Priimek lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					contactSurname: {
						validators: {
							notEmpty: {
								message: "Vnesite priimek"
							},
							regexp: {
								message: "Priimek lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					sex: {
						validators: {
							notEmpty: {
								message: "Izberite spol"
							}
						}
					},
					birthDate: {
						validators: {
							notEmpty: {
								message: "Vnesite datum"
							}/*
							date: {
								message: "Datum mora biti veljaven",
								format: "DD-MM-YYYY"
								//max: moment().format("DD.MM.YYYY")
							}*/
						}
					},
					postNumber: {
						validators: {
							notEmpty: {
								message: "Izberite poštno številko"
							}
						}
					},
					contactPost: {
						validators: {
							notEmpty: {
								message: "Izberite poštno številko"
							}
						}
					},
					region: {
						validators: {
							notEmpty:  {
								message: "Izberite šifro okoliša"
							}
						}
					},
					phoneNumber: {
						validators: {
							notEmpty: {
								message: "Vnesite telefonsko številko"
							}
						},
						regexp: {
							message: "Telefonska številka je lahko dolga 7 ali 8 znakov"
						}
					},
					contactPhone: {
						validators: {
							notEmpty: {
								message: "Vnesite telefonsko številko"
							}
						},
						regexp: {
							message: "Telefonska številka je lahko dolga 7 ali 8 znakov"
						}
					},
					insurance: {
						validators: {
							notEmpty: {
								message: "Vnesite številko zdravstvene kartice"
							},
							regexp: {
								message: "Številka mora vsebovati 9 števk"
							}
						}
					},
					relationship: {
						validators: {
							notEmpty: {
								message: "Izberite sorodstveno razmerje"
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: "Vnesite naslov"
							}
						}
					},
					contactAddress: {
						validators: {
							notEmpty: {
								message: "Vnesite naslov"
							}
						}
					},
					"dependantRelationship[]": {
						validators: {
							notEmpty: {
								message: "Izberite sorodstveno razmerje"
							}
						}
					},
					"dependantName[]": {
						validators: {
							notEmpty: {
								message: "Vnesite ime"
							}
						}
					},
					"dependantSurname[]": {
						validators: {
							notEmpty: {
								message: "Vnesite priimek"
							},
							regexp: {
								message: "Priimek lahko vsebuje le črke"
							},
							stringLength: {
								min: 2,
								max: 20,
								message: "Priimek je lahko dolg najmanj 2 in največ 20 znakov."
							}
						}
					},
					"dependantGender[]": {
						validators: {
							notEmpty: {
								message: "Izberite spol"
							}
						}
					},
					"dependantBirthDate[]": {
						validators: {
							notEmpty: {
								message: "Vnesite datum"
							}
							/*
							callback: {
								message: "Datum mora biti veljaven",
								callback: function(value, validator, $field) {
		                            if (value === '') {
		                                return true;
		                            }

		                            return moment(value, 'DD.MM.YYYY', true).isValid() && moment.format("dd.mm.yyyy").isBefore(value);
		                        }
							}*/
						}
					},
					"dependantAddress[]": {
						validators: {
							notEmpty: {
								message: "Vnesite naslov"
							}
						}
					},
					"dependantPostNumber[]": {
						validators: {
							notEmpty: {
								message: "Izberite poštno številko"
							}
						}
					},
					"dependantRegion[]": {
						validators: {
							notEmpty:  {
								message: "Izberite šifro okoliša"
							}
						}
					},
					"dependantInsurance[]": {
						validators: {
							notEmpty: {
								message: "Vnesite številko zdravstvene kartice"
							},
							regexp: {
								message: "Številka mora vsebovati 9 števk"
							}
						}
					}


				}
			});
}

var id = 0;
var buttonText = "Odstrani kontaktno osebo";
var buttonText2 = "Dodaj kontaktno osebo";
$('#addContactPerson')[0].addEventListener("click", toggleContactField, false);
$('#addDependantPerson')[0].addEventListener("click", addDependantField, false);
var body = document.getElementsByTagName("BODY")[0];
var contactField;
var dependantArea;
var validator;
body.onload = function(){

    
    dependantArea = document.createElement('div');
	dependantArea.innerHTML = document.getElementsByClassName("dependantArea")[0].innerHTML;
	document.getElementsByClassName("dependantArea")[0].innerHTML ="";
};


