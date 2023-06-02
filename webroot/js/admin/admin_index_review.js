import '../common/common';
//import './search_toggle';
// TO-DO: /\ /\ Do we need this here?
// Main toggling doable with bootrap only?
// Not all functions may be review-specific?

document.addEventListener('DOMContentLoaded', () => {
	// Check IP Address Button
	document.body.addEventListener('click', (e) => {
		if (e.target.classList.contains('ipCheckBtn')) {
			const reviewId = e.target.dataset.id;
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
				});
		}
	});
		
	document.querySelector('.checkall').addEventListener('click', () => {
		const checkboxes = document.querySelectorAll('.checkbox');
		checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
	});
	document.querySelector('#mass_delete').addEventListener('click', () => {
		document.querySelector('#mass_delete_bool').value = '1';
		document.querySelector('#ReviewForm').dispatchEvent(new Event('submit'));
	});
	document.querySelector('#mass_approve').addEventListener('click', () => {
		document.querySelector('#mass_delete_bool').value = '0';
		document.querySelector('#ReviewForm').dispatchEvent(new Event('submit'));
	});
});
