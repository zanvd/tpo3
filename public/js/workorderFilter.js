
$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 })

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-uk-pre": function ( a ) {
    var ukDatea = a.split('.');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
},

"date-uk-asc": function ( a, b ) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-uk-desc": function ( a, b ) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}

} );

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var minStr = $('input[name=dateFrom]').val();
        var maxStr = $('input[name=dateTo]').val();
        var min,max;
        
        var date = data[2] || 0; 
        
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
        /*
        console.log(min + " " + date2);
        console.log(min > date2);
        */

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
            },

        },
        "aoColumns": [
            { "bSortable": false },
            { "bSortable": false },
            { "sType": "date-uk" },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true }
        ],
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        initComplete: function () {
            this.api().columns( 7 ).every( function () {

                var column = this;
                var select = $('select[name="subistitutions"]')
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search(val.toString())
                            .draw();
                    } );
                
                column.data().unique().sort().each( function ( d, j ) {
                    //console.log(d);
                    var tmp = d.split(/<br>/);
                    //console.log(tmp);
                    if(tmp.length > 1) {
                        var i;
                        for (i in tmp){
                            if($("#subistitutions option[value='" + tmp[i].trim() + "']").length == 0){
                                select.append( '<option value="'+tmp[i].trim()+'">'+tmp[i].trim()+'</option>' )
                            }
                        }

                    }
                    else 
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns( 6 ).every( function () {

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
                    select.append( '<option value="'+d.trim()+'">'+d.trim()+'</option>' )
                    //console.log(d.trim());
                    
                    if( d.trim() === $('#employeeName').val().trim()){
                        employeeHasWorkOrder = true;
                    }
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
        }
    });

var employeeHasWorkOrder;

var employeeName = $('#employeeName').val().trim();

$(document).ready(function(){

    if(employeeHasWorkOrder){
        $('select[name=prescribers]').val(employeeName).change();
    }

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


    $('input[name=dateFrom]').change(function() {
        table.draw();
    });
    $('input[name=dateTo]').change(function() {
        table.draw();
    });

    $('.dataTables_filter').hide();

});