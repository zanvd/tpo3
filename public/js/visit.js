function validation() {
	validator = $("#visitEditForm").bootstrapValidator({
				fields: {
					actualDate: {
						validators: {
							notEmpty: {
								message: "Izberite datum"
							},
							callback: {
								message: "Datum mora biti današnji ali včerajšnji",
								callback: function (value, validator, $field) {
									moment.locale('sl');
									var n = moment().format('L');
									var ne = moment(n,'L');
									moment.locale('sl');
									var y = moment().subtract(1, 'day').format('L');
									var ye = moment(y,'L');
									moment.locale('sl');
									var k = moment(value,'L');
									if(!k.isValid()){
										valid = false;
										yesterdays = false;
										return false;
									}

									if(k.diff(ne) == 0) {
										valid = true;
										yesterdays = false;
										return true;
									}
									else if(k.diff(ye) == 0) {
										valid = true;
										yesterdays = true;
										return true;
									}
									yesterdays = false;
									valid = false;
									return false;

								}

							}
					}

				}
			}
	});
}
var valid = false;
var yesterdays = false;
function confirmDate(form) {
	console.log(valid + " " + yesterdays);
	if (valid && yesterdays)
        return confirm('Datum je včerajšnji. Nadaljuj s shranjevanjem?');
    
}
/**
 * Initialize datepicker field.
 */
$('.datepicker').datepicker({
	format: 'dd.mm.yyyy',
	language: 'sl'
}).on('changeDate', function (e) {
	if (typeof $('#actualDate').val() != 'undefined')
		$('#visitEditForm').bootstrapValidator('revalidateField', 'actualDate');
});

$(document).ready(function (){
		moment.locale('sl');
		validation();
});