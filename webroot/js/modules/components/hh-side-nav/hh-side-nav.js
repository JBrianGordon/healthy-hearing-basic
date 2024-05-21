let htmlDiv = document.getElementsByTagName('html'),
sideNavTrigger = document.getElementById('desktopSideNavTrigger'),
sideNavLinks = document.getElementsByClassName('side-nav-links'),
stickyFooter = document.getElementsByClassName('sticky-footer'),
sideNavDropDown = document.getElementsByClassName('side-nav-dropdown'),
sideNavLinksLis = [];

Array.from(sideNavLinks).forEach((element) => {
    let childLiElements = Array.from(element.children).filter(child => child.tagName === 'LI');
    sideNavLinksLis.push(...childLiElements);
});

let hideSide = () => {
    htmlDiv[0].classList.remove('show-side-nav');
    document.removeEventListener('click', sideClickCheck);
},
sideClickCheck = e => {
    if(e.target.closest('[data-hh-side-nav-trigger]') || e.target.closest('[data-hh-side-nav]')){
        return;
    } else {
        hideSide();
    }
},
showSide = () => {
    htmlDiv[0].classList.add('show-side-nav');
    document.addEventListener('click', sideClickCheck);
},
toggleSideNavLis = sideNavLinksLis => {
  sideNavLinksLis.forEach((li) => {
    li.addEventListener("click", () => {
      li.classList.toggle("show");
    });

    const nestedUl = li.querySelector("ul");

    if (nestedUl) {
      li.addEventListener("click", (e) => {
        e.stopPropagation();
        nestedUl.classList.toggle("show");
      });
    }
  });
}

if(sideNavTrigger){
    sideNavTrigger.addEventListener('click', e => {
        e.preventDefault();
        htmlDiv[0].classList.contains('show-side-nav') ? hideSide() : showSide();
    });
    for(var i=0;i<sideNavDropDown.length;i++){
	    sideNavDropDown[i].addEventListener('click', function(){
		    this.parentElement.classList.toggle('open');
	    });
    }
    if(stickyFooter.length > 0){
	    sideNavLinks[0].classList.add('fac-present');
    };

    toggleSideNavLis(sideNavLinksLis);
}
