import './admin_common';

let titleUnlock = document.querySelector('#titleUnlock'),
	pageTitle = document.querySelector('#PageTitle')

titleUnlock.addEventListener('click', () => {
	pageTitle.toggleAttribute('disabled');
	titleUnlock.innerHTML = pageTitle.hasAttribute('disabled') ? 'Unlock title field' : 'Lock title field';
})