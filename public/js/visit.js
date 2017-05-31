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
