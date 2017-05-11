function validate() {
	validator = $("#workorderForm").bootstrapValidator({
				fields: {
					visitType: {
						validators: {
							notEmpty: {
								message: "Izberite tip obiska"
							}
						}
					},
					patient: {
						validators: {
							notEmpty: {
								message: "Izberite pacienta"
							}
						}
					},
					newborn: {
						validators: {
							notEmpty: {
								message: "Izberite novorojenčka"
							}
						}
					},
					firstVisit: {
						validators: {
							notEmpty: {
								message: "Izberite datum prvega obiska"
							}
						}
					},
					mandatory: {
						validators: {
							notEmpty: {
								message: "Izberite obveznost datuma"
							}
						}
					},
					visits: {
						validators: {
							notEmpty: {
								message: "Vnesite število obiskov"
							}
						}
					},
					intervalDays: {
						validators: {
							notEmpty: {
								message: "Vnesite število dni med obiski"
							}
						}
					},
					finalDate: {
						validators: {
							notEmpty: {
								message: "Vnesite datum zadnjega obiska"
							}
						}
					},
					medicine: {
						validators: {
							notEmpty: {
								message: "Izberite zdravila"
							}
						}
					},
					red: {
						validators: {
							notEmpty: {
								message: "Vnesite število epruvet"
							}
						}
					},
					green: {
						validators: {
							notEmpty: {
								message: "Vnesite število epruvet"
							}
						}
					},
					blue:  {
						validators: {
							notEmpty: {
								message: "Vnesite število epruvet"
							}
						}
					},
					yellow:  {
						validators: {
							notEmpty: {
								message: "Vnesite število epruvet"
							}
						}
					},
					sum: {
						excluded: false,
						validators: {
							between: {
								min: 1,
								max: 200,
								message: "Izbrana mora biti vsaj ena epruveta"
							}
						}
					}

				}
			});
}

function toggleField (form, hidden) {
	if(hidden){
		form.removeClass('hidden');
	}
	else{
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

$("#visitType").on("change", function() {
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

$("#red").on("change", function() {
	var summation = parseInt($("#red").val()) + parseInt($("#blue").val()) + parseInt($("#green").val()) + parseInt($("#yellow").val());
	sum.val(summation);
	$("#workorderForm").bootstrapValidator("revalidateField", "sum");
});

$("#blue").on("change", function() {
	var summation = parseInt($("#red").val()) + parseInt($("#blue").val()) + parseInt($("#green").val()) + parseInt($("#yellow").val());
	sum.val(summation);
	$("#workorderForm").bootstrapValidator("revalidateField", "sum");
});

$("#green").on("change", function() {
	var summation = parseInt($("#red").val()) + parseInt($("#blue").val()) + parseInt($("#green").val()) + parseInt($("#yellow").val());
	sum.val(summation);
	$("#workorderForm").bootstrapValidator("revalidateField", "sum");
});

$("#yellow").on("change", function() {
	var summation = parseInt($("#red").val()) + parseInt($("#blue").val()) + parseInt($("#green").val()) + parseInt($("#yellow").val());
	sum.val(summation);
	$("#workorderForm").bootstrapValidator("revalidateField", "sum");
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
var sum=$('#sum');;

var body = document.getElementsByTagName("BODY")[0];
body.onload = function(){
	validate();
	
};