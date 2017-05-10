function disableField() {
	document.getElementById("region").setAttribute("disabled","");
	$('.selectpicker').selectpicker('refresh');
}

function enableField() {
	document.getElementById("region").removeAttribute("disabled");
	$('.selectpicker').selectpicker('refresh');
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
					name: {
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
					postNumber: {
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
					address: {
						validators: {
							notEmpty: {
								message: "Vnesite naslov"
							}
						}
					},
					function: {
						validators: {
							notEmpty: {
								message: "Izberite funkcijo"
							}
						}
					}


				}
			});
}
$(document).ready(function (){
	validate();
});