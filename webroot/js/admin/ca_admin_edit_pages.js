import './admin_common';
import './ca_ckpackage';

const titleUnlock = document.querySelector('#titleUnlock');
const pageTitle = document.querySelector('#PageTitle');

titleUnlock.addEventListener('click', () => {
	pageTitle.toggleAttribute('disabled');
	titleUnlock.innerHTML = pageTitle.hasAttribute('disabled') ? 'Unlock title field' : 'Lock title field';
})