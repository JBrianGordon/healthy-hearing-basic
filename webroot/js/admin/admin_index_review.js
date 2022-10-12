import '../common/common';
import './search_toggle';

$(document).ready(function() {
	// Check IP Address Button
	$('body').on('click', '.ipCheckBtn', function() {
		var reviewId = $(this).data('id');
		$.ajax({
			url:"/reviews/check_ip/"+reviewId,
			dataType: 'json',
			success: function(data, textStatus) {
				if (data['ipWarningsFound'] === true) {
					$('#ipSuccess'+reviewId).hide();
					$('#ipWarning'+reviewId).show();
				} else {
					$('#ipSuccess'+reviewId).show();
					$('#ipWarning'+reviewId).hide();
				}
			}
		});
	});
		
	$('.checkall').on('click', function () {
		$('.checkbox').attr('checked', this.checked);
	});
	$('#mass_delete').on('click', function() {
		$('#mass_delete_bool').val('1');
		$('#ReviewForm').trigger('submit');
	});
	$('#mass_approve').on('click', function() {
		$('#mass_delete_bool').val('0');
		$('#ReviewForm').trigger('submit');
	});
	
});
