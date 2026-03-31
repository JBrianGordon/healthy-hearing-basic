import '../common/common';

interface IpCheckResponse {
	ipWarningsFound: boolean;
}

document.addEventListener('DOMContentLoaded', () => {
	// Check IP Address Button
	document.body.addEventListener('click', async (event: MouseEvent) => {
		const target = event.target as HTMLElement;
		if (target.classList.contains('ipCheckBtn')) {
			const reviewId = target.dataset.id;

			if (!reviewId) {
				console.error('Review ID not found');
				return;
			}

			try {
				const response = await fetch(`/admin/reviews/check_ip/${reviewId}`, {
					headers: {
						'Accept': 'application/json',
					},
					method: 'GET',
				});

				if (!response.ok) {
					throw new Error('Response not ok');
				}

				const jsonResponse: IpCheckResponse = await response.json();

				const ipSuccess = document.querySelector<HTMLElement>(`#ipSuccess${reviewId}`);
				const ipWarning = document.querySelector<HTMLElement>(`#ipWarning${reviewId}`);

				if (!ipSuccess || !ipWarning) {
					console.error('IP status elements not found');
					return;
				}

				if (jsonResponse.ipWarningsFound === true) {
					ipSuccess.style.display = 'none';
					ipWarning.style.display = 'inline-block';
				} else {
					ipSuccess.style.display = 'inline-block';
					ipWarning.style.display = 'none';
				}
			} catch (error) {
				alert("We're sorry, but there was an error while IP-checking this review. Please contact one of the friendly developers at Healthy Hearing.");
				console.error('IP check error:', error);
			}
		}
	});

	// Check All Checkbox
	const checkAllCheckbox = document.querySelector<HTMLInputElement>('.checkall');

	if (checkAllCheckbox) {
		checkAllCheckbox.addEventListener('click', () => {
			const checkboxes = document.querySelectorAll<HTMLInputElement>('.checkbox');
			checkboxes.forEach(checkbox => {
				checkbox.checked = checkAllCheckbox.checked;
			});
		});
	}
});