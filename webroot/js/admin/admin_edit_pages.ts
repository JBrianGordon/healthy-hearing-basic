import './admin_common';
import './ckpackage';

const titleUnlock = document.querySelector<HTMLElement>('#titleUnlock');
const pageTitle = document.querySelector<HTMLInputElement>('#PageTitle');

if (titleUnlock && pageTitle) {
	titleUnlock.addEventListener('click', () => {
		pageTitle.toggleAttribute('disabled');
		titleUnlock.innerHTML = pageTitle.hasAttribute('disabled') ? 'Unlock title field' : 'Lock title field';
	});
}