var filters = [ [], [], [], [], [], [], []] ;
var dates,
    prescribers,
    preformers,
    visitTypes,
    patients,
    subistitutions;

var dateFrom = "",
    dateTo = "",
    prescribers = "",
    preformers = "",
    visitTypes = "",
    patients = "",
    subistitutions = "";

$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 })

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
        console.log(min + " " + date2);
        console.log(min > date2);


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
            "zeroRecords": "Ni delovnih nalogov",
            "info": "Prikazana stran _PAGE_ od _PAGES_",
            "infoEmpty": "Ni delovnih nalogov.",
            "infoFiltered": "(Filtrirano od _MAX_ delovnih nalogov)",
            "paginate": {
              "previous": "Prejšnja",
              "next": "Naslednja",
            }
        },
        initComplete: function () {
            this.api().columns( 6 ).every( function () {

                var column = this;
                var select = $('select[name="subistitutions"]')
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
                var select = $('select[name="preformers"]')
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
            this.api().columns( 3 ).every( function () {

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
            this.api().columns( 2 ).every( function () {

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
    $('select[name=preformers]').change(function() {
        preformers = $(this).val();
    });
    $('select[name=visitTypes]').change(function() {
        visitTypes = $(this).val();
    });
    $('select[name=patients]').change(function() {
        patients = $(this).val();
    });
    $('select[name=subistitutions]').change(function() {
        subistitutions = $(this).val();
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