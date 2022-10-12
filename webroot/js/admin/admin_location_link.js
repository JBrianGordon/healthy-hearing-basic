import './admin_common';

$('#searchBtn').on('click',function() {
	var button = $(this);
	var importType = button.data('import-type');
	var search = $('#ImportLocationSearch').val();
	button.attr('disabled', 'disabled');
	console.log(search);
	$.ajax({
		url: '/admin/imports/location_search/',
		data: {
			search: search,
			importType: importType
		},
		success: function(data) {
			$('#searchResults').html(data);
			button.removeAttr('disabled');
		},
		async: false
	});
	return false;
}).click();

$('#ImportLocationSearch').on('keydown',function(e) {
	if (e.keyCode == 13) {
		$('#searchBtn').click();
		return false;
	}
}).focus();

