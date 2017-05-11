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
							},
							callback: {
								message: "Datum mora biti večji od današnjega",
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

									if(k.diff(ne) >=0) {
										return true;
									}
									return false;

								}

							}
						}
					},
					finalDate: {
						validators: {
							notEmpty: {
								message: "Izberite datum zadnjega obiska"
							},
							callback: {
								message: "Datum mora biti večji od današnjega in prvega obiska",
								callback: function (value, validator, $field) {
									/*
									if(typeof visitDate.val() == 'undefined')
										return false;*/
									moment.locale('sl');
									var ne = moment(visitDate,'L');
									moment.locale('sl');
									var k = moment(value,'L');
									if(!k.isValid() || !ne.isValid()){
										console.log(visitDate);
										console.log("tole");
										return false;
									}
									else if(k.diff(ne) > 0) {
										return true;
									}
									return false;
									

								}

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
							},
							stringLength: {
								min: 1,
								max: 10,
								message: "Ševilo obiskov mora biti med 1 in 10"
							}
						}
					},
					interval: {
						validators: {
							notEmpty: {
								message: "Vnesite število dni med obiski"
							}
						}
					},
					"medicine[]": {
						validators: {
							notEmpty: {
								message: "Izberite zdravila"
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
 }).on('changeDate', function(e) {
 			if( typeof $('#finalDate').val() != 'undefined')
 				$('#workorderForm').bootstrapValidator('revalidateField', 'finalDate');
            $('#workorderForm').bootstrapValidator('revalidateField', 'firstVisit');
            if( typeof $('#finalDate').val() != 'undefined')
            	$('#workorderForm').bootstrapValidator('revalidateField', 'finalDate');
            $('#workorderForm').bootstrapValidator('revalidateField', 'firstVisit');
            
        });

$("#visitType").on("change", function() {

	if(!newbornHidden){
		$("#newborn").val('default');
		$("#newborn").selectpicker("refresh");
		$("#workorderForm").bootstrapValidator("resetField", "newborn");
		toggleField(newbornForm, newbornHidden);
		newbornHidden=true;
	}
	else if (!medicineHidden){
		$("#medicine").val('default');
		$("#medicine").selectpicker("refresh");
		$("#workorderForm").bootstrapValidator("resetField", "medicine");
		toggleField(medicineForm, medicineHidden);
		medicineHidden=true;
	}
	else if (!bloodHidden){
		$("#red").val(0);
		$("#green").val(0);
		$("#blue").val(0);
		$("#yellow").val(0);
		$("#sum").val(1);
		toggleField(bloodForm, bloodHidden);
		bloodHidden=true;
	}


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
		$("#sum").val(0);
		bloodHidden=false;
	}

});

$("#radio1").on("change", function() {
	if(radio) {
		$("#workorderForm").bootstrapValidator("resetField", "finalDate");
		intervalDays.prop('disabled', false);
		finalDate.prop('disabled', true);
		$("#finalDate").val(undefined);
		radio=false;
	}
	else {
		$("#workorderForm").bootstrapValidator("resetField", "interval");
		$("#intervalDays").val(undefined);
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
		$("#workorderForm").bootstrapValidator("resetField", "interval");
		$("#intervalDays").val(undefined);
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
var sum=$('#sum');
var bootstrapValidatorInstance = $("#workorderForm");
var visitDate;

var body = document.getElementsByTagName("BODY")[0];
body.onload = function(){
	validate();
	moment.locale('sl');
	/*
									var n = moment().format('L');
									var ne = moment(n,'L');
									moment.locale('sl');
									var k = moment('12.05.2017','L');
									console.log(ne.diff(k));
									console.log(k.diff(ne));
									console.log(ne.diff(ne));
									console.log(k.diff(k));
									console.log(ne>k);
									console.log(k<ne);*/
	
};