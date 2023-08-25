import '../common/common';
import { datepickerFunctions } from './search_toggle';
// TO-DO: /\ /\ Do we need this here?
// Main toggling doable with bootrap only?
// Not all functions may be review-specific?

document.addEventListener('DOMContentLoaded', () => {
	// Check IP Address Button
	document.body.addEventListener('click', event => {
		if (event.target.classList.contains('ipCheckBtn')) {
			const reviewId = event.target.dataset.id;
			fetch(`/reviews/check_ip/${reviewId}`)
				.then(response => response.json())
				.then(data => {
					if (data.ipWarningsFound === true) {
						document.querySelector(`#ipSuccess${reviewId}`).style.display = 'none';
						document.querySelector(`#ipWarning${reviewId}`).style.display = 'block';
					} else {
						document.querySelector(`#ipSuccess${reviewId}`).style.display = 'block';
						document.querySelector(`#ipWarning${reviewId}`).style.display = 'none';
					}
				})
				.catch(error => {
					console.error('Error:', error);
				});
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
