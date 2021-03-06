
function toggleContactField(){
	document.getElementById("addContactPerson").innerHTML = buttonText;
	var temp = buttonText;
	buttonText = buttonText2;
	buttonText2 = temp;
	var inputs= $('#contactField').find("input");
	var selects= $('#contactField').find("select");
	var buttons= $('#contactField').find("button");
	if(!disabled) {
		$("#registrationForm").data('bootstrapValidator').resetForm();
		for(var i = 0;i < inputs.length; i++) {
		    inputs[i].disabled = true;
		}
		for(var i = 0;i < selects.length; i++) {
		    selects[i].disabled = true;
		}
		for(var i = 0;i < buttons.length; i++) {
			$(buttons[i]).addClass('disabled');
			$(buttons[i]).parent().addClass('disabled');
		}
	}
	else {
		for(var i = 0;i < inputs.length; i++) {
		    inputs[i].disabled = false;
		}
		for(var i = 0;i < selects.length; i++) {
		    selects[i].disabled = false;
		}
		for(var i = 0;i < buttons.length; i++) {
			$(buttons[i]).removeClass('disabled');
			$(buttons[i]).parent().removeClass('disabled');
		}
	}

	disabled = !disabled;
}

/*
function addDependantField(){
	document.getElementsByClassName("dependantArea")[0].appendChild(dependantArea.cloneNode(true));
	$('#dependant').collapse();
	document.getElementById('dependant').id = id;
	var newField= $('#' + id).find("input");
	var newField2= $('#' + id).find("select");
	id +=1;
	 $("#registrationForm").bootstrapValidator('addField', newField);
	 $("#registrationForm").bootstrapValidator('addField', newField2);
}*/
/*
function addDependantField(){
	$(".cloneDefault").clone(true).insertBefore(".dependantArea > div:last-child");
    $(".dependantArea > .cloneDefault").removeClass("hidden");
    $(".dependantArea > .cloneDefault").removeClass("cloneDefault");
    $('#dependant').collapse();
    document.getElementById('dependant').id = id;
    $('#dependant').addClass("hidden cloneDefault")
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
*/
function validate() {
	validator = $("#registrationForm").bootstrapValidator({
				excluded: [':disabled'],
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
					birthDate: {validators: {
							notEmpty: {
								message: "Izberite datum prvega obiska"
							},
							callback: {
								message: "Datum mora biti manjši od današnjega",
								callback: function (value, validator, $field) {
									moment.locale('sl');
									var n = moment().format('L');
									var ne = moment(n,'L');
									moment.locale('sl');
									visitDate = value;
									var k = moment(value,'L');
									if(!k.isValid()){
										return false;
									}

									if(k.diff(ne) < 0) {
										return true;
									}
									return false;

								}

							}
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
					}
				}
			});
}

var id = 0;
var buttonText = "Odstrani kontaktno osebo";
var buttonText2 = "Dodaj kontaktno osebo";
var disabled= true;
$('#addContactPerson')[0].addEventListener("click", toggleContactField, false);
var body = document.getElementsByTagName("BODY")[0];
var contactField;
var validator;

$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 }).on('changeDate', function(e) {
            $('#registrationForm').bootstrapValidator('revalidateField', 'birthDate');
        });

body.onload = function(){

 	
    /*
    dependantArea = document.createElement('div');
	dependantArea.innerHTML = document.getElementsByClassName("dependantArea")[0].innerHTML;
	document.getElementsByClassName("dependantArea")[0].innerHTML ="";
	*/
};


