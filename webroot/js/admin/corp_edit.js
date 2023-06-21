import './admin_common';
import './nav_tabs';

/*** TODO: update this code when view is built: ***
$(document).ready(function() {
	if($('#CorpIsActive').prop('checked')) {
		//active is checked, is this a draft???
		if($('#CorpDraftParentId').val() > 0) {
			//yep, it's a draft.
			$("datepicker_future").datepicker({
				minDate: new Date(Date.now()+24*60*60*1000)
			});
		}
	}
	$(document).on("change", "#CorpIsActive", function() {
		if($('#CorpDraftParentId').val() > 0) {
			$('.datepicker_future').datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
		}
	});
	$('.datepicker_future').datepicker({
		//dateFormat: 'yy-mm-dd',
		dateFormat: 'mm/dd/yy',
		minDate: new Date(Date.now()+24*60*60*1000)
	});
});*/