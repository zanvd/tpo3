function validate() {
	validator = $("#workorderForm").bootstrapValidator({
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

function toggleField (form, hidden) {
	if(hidden){
		console.log("test1");
		form.removeClass('hidden');
	}
	else{
		console.log("test2");
		form.addClass('hidden');
	}

	var inputs = form.find("select");
	var selects = form.find("select");
	var buttons = form.find("button");

	if (newbornHidden) {
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
	else {
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
}


$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 });

$("#vistType").on("change", function() {
	console.log(newbornHidden);

	if(!newbornHidden){
		console.log("test3");
		toggleField(newbornForm, newbornHidden);
		newbornHidden=true;
	}
	else if (!medicineHidden){
		toggleField(medicineForm, medicineHidden);
		medicineHidden=true;
	}
	else if (!bloodHidden){
		toggleField(bloodForm, bloodHidden);
		bloodHidden=true;
	}
	console.log(newbornHidden);
	if($(this).val() == 2){
		toggleField(newbornForm, newbornHidden);
		newbornHidden=false;
	}
	else if($(this).val() == 4){
		toggleField(medicineForm, medicineHidden);
		medicineHidden=false;
	}
	else if($(this).val() == 5){
		toggleField(bloodForm, bloodHidden);
		bloodHidden=false;
	}

});

$("#radio1").on("change", function() {
	if(radio) {
		finalDate.prop('disabled', true);
		intervalDays.prop('disabled', false);
		radio=false;
	}
	else {
		finalDate.prop('disabled', false);
		intervalDays.prop('disabled', true);
		radio=true;
	}
	
});

$("#radio2").on("change", function() {
	if(radio) {
		finalDate.prop('disabled', true);
		intervalDays.prop('disabled', false);
		radio=false;
	}
	else {
		finalDate.prop('disabled', false);
		intervalDays.prop('disabled', true);
		radio=true;
	}
	
});

var newbornForm= $('#newbornForm');
var medicineForm= $('#medicineForm');
var bloodForm= $('#bloodForm');
var finalDate = $('#finalDate');
var intervalDays = $('#intervalDays');
var newbornHidden = true;
var medicineHidden = true;
var bloodHidden = true;
var radio = false;

var body = document.getElementsByTagName("BODY")[0];
body.onload = function(){
	//validate();
	
};