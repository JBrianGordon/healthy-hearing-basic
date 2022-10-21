//import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal';

export function directBookBtn() {
	// Global variable for direct book clinic id
	let directBookClinicId = 0;

	const onMessage = event => {
		// Check sender origin to be trusted
		if (event.origin !== "https://booking.myearq.com") return;
		// Do not save appointment if no clinic id
		if (directBookClinicId == 0) return;
		if (event.data.func == "goThankYouAppointment") {
			$.ajax({
				url:"/ca_calls/ajax_add_earq_appt/"+directBookClinicId,
				type:"post",
				dataType: 'json',
				success: function(data, textStatus) {
					if (data == "error") {
						console.log('Failed to save EarQ appointment for '+directBookClinicId);
					}
					directBookClinicId = 0;
				},
			});
		}
	}

	// Blueprint/EarQ direct book modal
	$('.directBookBtn').on('click', function() {
		directBookClinicId = $(this).attr('data-button');
		let modalId = '#directBookModal-' + directBookClinicId;
		$(modalId + ' .direct-book-body').html($(modalId + ' .direct-book-body').html().replace('<!--','').replace('-->',''));
		$(modalId).modal("show");
		// Event listener for EarQ appointment confirmation
		window.addEventListener("message", onMessage, false);
	});
} 