$('.datepicker').datepicker({
    format: 'dd.mm.yyyy',
    language: 'sl'
 })


var table = $('#datatable').DataTable({
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
        }
    });

$(document).ready(function(){
    

    $('.dataTables_filter').hide();

});