function validate() {
    validator = $("#planForm").bootstrapValidator({
        fields: {
            planDate: {
                validators: {
                    notEmpty: {
                        message: "Izberite datum"
                    },
                    callback: {
                        message: "Datum mora biti večji ali enak današnjemu",
                        callback: function (value, validator, $field) {
                            moment.locale('sl');
                            var n = moment().format('L');
                            var ne = moment(n,'L');
                            moment.locale('sl');
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
            }
        }
    });
}

jQuery.fn.dataTableExt.oApi.fnFindCellRowIndexes = function ( oSettings, sSearch, iColumn )
{
    var
        i,iLen, j, jLen, val,
        aOut = [], aData,
        columns = oSettings.aoColumns;
 
    for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
    {
        aData = oSettings.aoData[i]._aData;
 
        if ( iColumn === undefined )
        {
            for ( j=0, jLen=columns.length ; j<jLen ; j++ )
            {
                val = this.fnGetData(i, j);
 
                if ( val == sSearch )
                {
                    aOut.push( i );
                }
            }
        }
        else if (this.fnGetData(i, iColumn) == sSearch )
        {
            aOut.push( i );
        }
    }
 
    return aOut;
};

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

var visitsPt2 = "";
var visitIDs = $("#visitIDs");
var removedVisitIDs = $("#removedVisitIDs");
var planIDs = $("#planIDs");
var planVisitID="";
var planID="";
var removedVisits="";

function updateVisits(){
    visitsPt2="";
    $( "table#datatable tr" ).each(function( index ) {
        if($(this).attr('id') != undefined)
            visitsPt2+=$(this).attr('id') + "-";
    });
    visitsPt2 = visitsPt2.slice(0, -1);

    if(removedVisits.length > 0){
        removedVisits = removedVisits.slice(0, -1);
    }
    joinVisits();
}

function joinVisits() {
    if(visitsPt2.length == 0) {
        visitIDs.val(visitsPt1.slice(0,-1));
    }
    else {
        visitIDs.val(visitsPt1 + visitsPt2);
    }
    removedVisitIDs.val(removedVisits);
    planIDs.val(planID);
    /*
    console.log("visits: " + visitIDs.val());
    console.log("removed: " + removedVisitIDs.val());
    console.log("planID: " + planIDs.val());
    */
}

$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 }).on('changeDate', function(e) {
    $('#planForm').bootstrapValidator('revalidateField', 'planDate');
});



var table = $('#datatable').DataTable({
        "bFilter": true,
        "bPaginate": false,
        "language": {
            "lengthMenu": "Prikaži _MENU_ rezultatov na stran",
            "zeroRecords": "Ni obiskov.",
            "info": "Prikazana stran _PAGE_ od _PAGES_",
            "infoEmpty": "Ni obiskov.",
            "infoFiltered": "(Filtrirano od _MAX_ delovnih nalogov)",
            "paginate": {
              "previous": "Prejšnja",
              "next": "Naslednja",
            }
        },
        "aoColumns": [
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false }
        ],
        "createdRow" : function ( row, data, index ) {
            if ( data[2].trim() === "Ne" && row.className.split(" ")[0] != "okvirni" ) {
                $(row).addClass("okvirni2");
                $(row).attr('id', planVisitID );
            }
        }
    });

var table2 = $('#datatable2').DataTable({
        "bFilter": true,
        "language": {
            "lengthMenu": "Prikaži _MENU_ rezultatov na stran",
            "zeroRecords": "Ni obiskov.",
            "info": "Prikazana stran _PAGE_ od _PAGES_",
            "infoEmpty": "Ni obiskov.",
            "infoFiltered": "(Filtrirano od _MAX_ delovnih nalogov)",
            "paginate": {
              "previous": "Prejšnja",
              "next": "Naslednja",
            }
        },
        "aoColumns": [
            { "bSortable": false },
            { "sType": "date-uk" },
            { "bSortable": false },
            null,
            { "bSortable": false }
        ]
    });


var dataOkvirniPlan = Array();
var dataObvezni = Array();
var dataObvezniPlan = Array();

var visitsPt1="";

$("table#okvirni2 tr").each(function(i, v){
    dataOkvirniPlan[i] = Array();
    $(this).children('td').each(function(ii, vv){
        dataOkvirniPlan[i][ii] = $(this).text();
    }); 

})

$("table#obvezni tr").each(function(i, v){
    dataObvezni[i] = Array();
    $(this).children('td').each(function(ii, vv){
        dataObvezni[i][ii] = $(this).text();
    }); 

})

$("table#obvezni2 tr").each(function(i, v){
    dataObvezniPlan[i] = Array();
    $(this).children('td').each(function(ii, vv){
        dataObvezniPlan[i][ii] = $(this).text();
    }); 

})

$(document).ready(function(){
    validate();
    moment.locale('sl');
    
    //dodamo okvirne v trenutni plan ob kliku
    $('#datatable2 tbody').on( 'click', '.okvirni', function () {
        table2.row($(this)).remove().draw();
        table.row.add( $(this) ).draw();
        updateVisits();
    } );

    //odstranimo iz trnutnega plana nazaj v seznam okvirnih
    $('#datatable tbody ').on( 'click', '.okvirni', function () {
        table.row($(this)).remove().draw();
        table2.row.add( $(this) ).draw();
        updateVisits();
    } );

    //odstranimo okvirnega ki je ze v planu iz trenutnega
    $('#datatable tbody ').on( 'click', '.okvirni2', function () {

            removedVisits += $(this).attr("id") + "-";
            table.row($(this)).remove().draw();
            updateVisits();
    } );
    

    $('input[name=planDate]').change(function() {
        visitsPt1="";
        visitsPt2="";
        planID="";
        removedVisits="";


        //damo nazaj okvirne
        var rowsDelete = $('#datatable').DataTable().rows('.okvirni');
        while (rowsDelete[0].length > 0) {
            var temp = table.row(rowsDelete[0][0]).node();
            table.row(temp).remove().draw();
            table2.row.add(temp).draw();
            rowsDelete = $('#datatable').DataTable().rows('.okvirni');
        }

        //zbrisemo vse ostale
        table.clear().draw();




        //dodamo vse obvezne tega datuma
        var i = 0;
        for(i=0; i<dataObvezni.length ; i++) {
            
            if(String(dataObvezni[i][1]).trim() === String($(this).val()).trim()) {
                table.row.add(
                     [
                    "<a href='/obisk/" + dataObvezni[i][0].trim()+ "'>Odpri obisk<a>",
                    dataObvezni[i][1],
                    dataObvezni[i][2],
                    dataObvezni[i][3],
                    "<a href='/delovni-nalog/" + dataObvezni[i][4].trim()+ "'>Odpri delovni nalog<a>"
                    ])
                .draw();
                visitsPt1 +=dataObvezni[i][0].trim() + "-";
            }
        }

        i = 0;
        for(i=0; i<dataObvezniPlan.length ; i++) {
            
            if(String(dataObvezniPlan[i][1]).trim() === String($(this).val()).trim()) {
                table.row.add(
                     [
                    "<a href='/obisk/" + dataObvezniPlan[i][0].trim()+ "'>Odpri obisk<a>",
                    dataObvezniPlan[i][1],
                    dataObvezniPlan[i][2],
                    dataObvezniPlan[i][3],
                    "<a href='/delovni-nalog/" + dataObvezniPlan[i][4].trim()+ "'>Odpri delovni nalog<a>"
                    ])
                .draw();
                visitsPt1 +=dataObvezniPlan[i][0].trim() + "-";
                planID = dataObvezniPlan[i][5];
                
            }
        }
        
        //ce obstaja plan za ta datum nafilamo se vse okvirne za ta datum
        if( planID != "") {
            i = 0;
            for(i=0; i<dataOkvirniPlan.length ; i++) {
                
                if(String(dataOkvirniPlan[i][5]).trim() === String(planID).trim()) {
                    planVisitID = dataOkvirniPlan[i][0].trim(); 
                    table.row.add(
                         [
                        "<a href='/obisk/" + dataOkvirniPlan[i][0].trim()+ "'>Odpri obisk<a>",
                        dataOkvirniPlan[i][1],
                        dataOkvirniPlan[i][2],
                        dataOkvirniPlan[i][3],
                        "<a href='/delovni-nalog/" + dataOkvirniPlan[i][4].trim()+ "'>Odpri delovni nalog<a>"
                        ])
                    .draw();
                    planVisitID=""; 
                }
            }
            updateVisits();
        }

        joinVisits();




    });
    
    $('.dataTables_filter').hide();

});