import '../common/common';
import { datepickerFunctions } from './search_toggle';
// TO-DO: /\ /\ Do we need this here?
// Main toggling doable with bootrap only?
// Not all functions may be review-specific?

document.addEventListener('DOMContentLoaded', () => {
	// Check IP Address Button
	document.body.addEventListener('click', async (event) => {
		if (event.target.classList.contains('ipCheckBtn')) {
			const reviewId = event.target.dataset.id;
	        try {
	            const response = await fetch(`/admin/reviews/check_ip/${reviewId}`, {
	                headers: {
						'Accept': 'application/json',
	                },
	                method: 'GET',
	            });

				if (!response.ok) {
					throw new Error();
				}

				let jsonResponse = await response.json();

				if (jsonResponse.ipWarningsFound === true) {
					document.querySelector(`#ipSuccess${reviewId}`).style.display = 'none';
					document.querySelector(`#ipWarning${reviewId}`).style.display = 'inline-block';
				} else {
					document.querySelector(`#ipSuccess${reviewId}`).style.display = 'inline-block';
					document.querySelector(`#ipWarning${reviewId}`).style.display = 'none';
				}
            } catch {
				alert("We're sorry, but there was an error while IP-checking this review. Please contact one of the friendly developers at Healthy Hearing.");
			}
		}
	});

	// Check All Checkbox
	const checkAllCheckbox = document.querySelector('.checkall');
	checkAllCheckbox.addEventListener('click', () => {
		const checkboxes = document.querySelectorAll('.checkbox');
		checkboxes.forEach(checkbox => {
			checkbox.checked = checkAllCheckbox.checked;
		});
	});

	// Mass Delete Button
	const massDeleteButton = document.querySelector('#mass_delete');
	massDeleteButton.addEventListener('click', () => {
		document.querySelector('#mass_delete_bool').value = '1';
		document.querySelector('#ReviewForm').dispatchEvent(new Event('submit'));
	});

	// Mass Approve Button
	const massApproveButton = document.querySelector('#mass_approve');
	massApproveButton.addEventListener('click', () => {
		document.querySelector('#mass_delete_bool').value = '0';
		document.querySelector('#ReviewForm').dispatchEvent(new Event('submit'));
	});
});
