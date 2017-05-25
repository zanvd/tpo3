function validate() {
	validator = $("#planForm").bootstrapValidator({
				excluded: [':disabled'],
				fields: {
					planDate: {validators: {
							notEmpty: {
								message: "Izberite datum obiska"
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

									if(k.diff(ne) > 0) {
										return true;
									}
									return false;

								}

							}
						}
					}
				}
			});
}


var body = document.getElementsByTagName("BODY")[0];
$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 }).on('changeDate', function(e) {
            $('#planForm').bootstrapValidator('revalidateField', 'planDate');
        });

$(document).ready(function (){
		
		validate();

});