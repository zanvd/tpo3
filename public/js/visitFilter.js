var filters = [ [], [], [], [], [], [], []] ;
var dates,
    prescribers,
    performers,
    visitTypes,
    patients,
    substitutions,
    visitDone;

var dateFrom = "",
    dateTo = "",
    prescribers = "",
    performers = "",
    visitTypes = "",
    patients = "",
    substitutions = "";

$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
});

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var minStr = $('input[name=dateFrom]').val();
        var maxStr = $('input[name=dateTo]').val();
        var min,max;

        var date = data[1] || 0; // use data for the age column

        var arrDate = date.toString().split('.');

        var date2 = new Date(arrDate[2],arrDate[1],arrDate[0]);

        if(minStr != ""){
            var arrMin = minStr.split('.');
            var min = new Date(arrMin[2],arrMin[1],arrMin[0]);
        }
        if(maxStr != ""){
            var arrMax = maxStr.split('.');
            var max = new Date(arrMax[2],arrMax[1],arrMax[0]);
        }
        // console.log(min + " " + date2);
        // console.log(min > date2);


        if ( ( isNaN( min ) && isNaN( max ) ) ||
            ( isNaN( min ) && date2 <= max ) ||
            ( min <= date2   && isNaN( max ) ) ||
            ( min <= date2   && date2 <= max ) )
        {
            return true;
        }
        return false;

    }
);


var table = $('#datatable').DataTable({
    "bFilter": true,
    "language": {
        "lengthMenu": "Prikaži _MENU_ rezultatov na stran",
        "zeroRecords": "Ni obiskov",
        "info": "Prikazana stran _PAGE_ od _PAGES_",
        "infoEmpty": "Ni obiskov.",
        "infoFiltered": "(Filtrirano od _MAX_ obiskov)",
        "paginate": {
            "previous": "Prejšnja",
            "next": "Naslednja"
        }
    },
    initComplete: function () {
        this.api().columns( 7 ).every( function () {

            var column = this;
            var select = $('select[name="substitutions"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        this.api().columns( 6 ).every( function () {

            var column = this;
            var select = $('select[name="performers"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {

                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        this.api().columns( 5 ).every( function () {

            var column = this;
            var select = $('select[name="patients"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {

                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        this.api().columns( 4 ).every( function () {

            var column = this;
            var select = $('select[name="prescribers"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {

                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        this.api().columns( 3 ).every( function () {

            var column = this;
            var select = $('select[name="visitTypes"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {

                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
        this.api().columns( 2 ).every( function () {

            var column = this;
            var select = $('select[name="visitDone"]')
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );
                    if (val == 'Neopravljen') {
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    } else if (val == 'Opravljen') {
                        // TODO: tuki spremeni neki oz kakor veš
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    } else {
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    }
                } );
            select.append( '<option value="Neopravljen">Neopravljen</option>' );
            select.append( '<option value="Opravljen">Opravljen</option>' );
        } );
    }
});

$(document).ready(function(){




    $('input[name=dateFrom]').change(function() {
        table.draw();
    });
    $('input[name=dateTo]').change(function() {
        table.draw();
    });
    $('select[name=prescribers]').change(function() {
        prescribers = $(this).val();
    });
    $('select[name=performers]').change(function() {
        performers = $(this).val();
    });
    $('select[name=visitTypes]').change(function() {
        visitTypes = $(this).val();
    });
    $('select[name=patients]').change(function() {
        patients = $(this).val();
    });
    $('select[name=substitutions]').change(function() {
        substitutions = $(this).val();
    });
    $('select[name=visitDone]').change(function() {
        visitDone = $(this).val();
    });

    $('.btn').click(function(e){

        if(dateFrom != "") {
            table.columns( 1 ).search( dateFrom ).draw();
        }

        if(dateTo != "") {
            table.columns( 1 ).search( dateTo ).draw();
        }

    });

    $('.dataTables_filter').hide();

});