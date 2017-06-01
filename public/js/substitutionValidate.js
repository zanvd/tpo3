function validate() {
    // $('.datepicker').datepicker({ firstDay: 1 });
    validator = $("#newSubstitutionForm").bootstrapValidator({
        fields: {
            absent: {
                validators: {
                    notEmpty: {
                        message: "Izberite odsotno sestro"
                    },
                    different: {
                        field: 'present',
                        message: "izberite različni sestri"
                    }
                }
            },
            present: {
                validators: {
                    notEmpty: {
                        message: "Izberite nadomestno sestro"
                    },
                    different: {
                        field: 'absent',
                        message: "izberite različni sestri"
                    }
                }
            },
            dateFrom: {
                validators: {
                    notEmpty: {
                        message: "Izberite datum začetka odsotnosti"
                    },
                    callback: {
                        message: "Datum mora biti večji ali enak današnjemu",
                        callback: function (value, validator, $field) {
                            moment.locale('sl');
                            var n = moment().format('L');
                            var ne = moment(n,'L');
                            moment.locale('sl');
                            dateFrom = value;
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
            dateTo: {
                validators: {
                    notEmpty: {
                        message: "Izberite datum konca odsotnosti"
                    },
                    callback: {
                        message: "Datum mora biti večji ali enak današnjemu in večji od datuma začetka odsotnosti",
                        callback: function (value, validator, $field) {
                            moment.locale('sl');
                            var ne = moment(dateFrom,'L');
                            moment.locale('sl');
                            var k = moment(value,'L');
                            if(!k.isValid() || !ne.isValid()){
                                return false;
                            }
                            else if(k.diff(ne) >= 0) {
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

$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
}).on('changeDate', function(e) {
    if( $('#dateTo').val() != '')
        $('#newSubstitutionForm').bootstrapValidator('revalidateField', 'dateTo');
    $('#newSubstitutionForm').bootstrapValidator('revalidateField', 'dateFrom');

    if( $('#dateTo').val() != '')
        $('#newSubstitutionForm').bootstrapValidator('revalidateField', 'dateTo');
    $('#newSubstitutionForm').bootstrapValidator('revalidateField', 'dateFrom');
});

$("#newSub").on("click", function() {
    $("#createNew").removeClass('hidden');
});



var dateTo = $('#dateTo');
var dateFrom;

var body = document.getElementsByTagName("BODY")[0];
body.onload = function() {
    validate();
    moment.locale('sl');
};