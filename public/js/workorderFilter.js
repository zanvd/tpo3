var filters = [ [], [], [], [], [], [], []] ;

$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody'),
            $titles = $panel.find('tr[id="noFilter"]');
        if ($filters.prop('disabled') == true) {
            $filters.show();
            $filters.prop('disabled', false);
            $titles.hide();
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $filters.hide();
            $titles.show();
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });

        filters[$input.attr('id')-1] = $filteredRows;
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        
        for(var i=0; i<7; i++) {
            if(filters[i].length != 0){
                filters[i].hide();

            }
        }
        $hiddenRows = $table.find('tbody tr[style="display: none;"]');
        /* Prepend no-result row if all rows are filtered */
        if ($hiddenRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});