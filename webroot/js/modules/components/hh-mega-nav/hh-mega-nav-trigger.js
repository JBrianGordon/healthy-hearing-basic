export let navTriggers = document.querySelectorAll('[data-hh-mega-nav-trigger]'),
megaNavs  = document.querySelectorAll('[data-hh-mega-nav]');

export let hideNav = () => {
	for(let megaNav of megaNavs) {
		megaNav.setAttribute('style', 'height:0;max-height:0');
		megaNav.classList.remove('show');
	};
	for(let navTrigger of navTriggers){
		navTrigger.classList.remove('active');
	}
	document.removeEventListener('click',autoClose);
},

autoClose = e => {
	if(e.keyCode === 27){
		hideNav();
	}
	else if(e.target.closest('[data-hh-mega-nav]') || e.target.closest('[data-hh-mega-nav-trigger]')){
		return;
	}
	else{
		hideNav();
	}
},

showNav = thisTrigger => {
	let thisMegaNav;
	for(let megaNav of megaNavs){
		megaNav.setAttribute('style', 'height:0;max-height:0');
		megaNav.classList.remove('show');
		if(megaNav.getAttribute('data-hh-mega-nav') == thisTrigger.getAttribute('data-hh-mega-nav-trigger')){
			thisMegaNav = megaNav;
		}
	}
	for(let navTrigger of navTriggers){
		navTrigger.classList.remove('active');
	}
	
	thisTrigger.classList.add('active');
	setTimeout(() => {
		let ddHeight = thisMegaNav.childNodes[1].offsetHeight;
		thisMegaNav.setAttribute('style', `height:${ddHeight}px;max-height:${ddHeight}px`);
		thisMegaNav.classList.add('show');
	},300);
	
	document.addEventListener('click', autoClose);
	document.addEventListener('keyup', autoClose);
};

for(let navTrigger of navTriggers) {
	navTrigger.addEventListener('click', e => {
		e.preventDefault();
		navTrigger.classList.contains('active') ? hideNav() : showNav(navTrigger);
	})
};