export let searchWrapper = document.getElementById('searchWrapper'),
searchInput  = document.getElementById('ContentSearch'),
searchLink  = document.getElementById('searchLink'),
nav  = document.getElementById('navContainer'),
navParent  = document.getElementById('navParent'),
openButton  = document.getElementById("openSearch"),
closeButton  = document.getElementById("closeSearch");

if(openButton){
    openButton.addEventListener('click', (e) => {
        e.preventDefault();

        searchWrapper.setAttribute('style',`width:${window.outerWidth - (nav.offsetLeft + navParent.offsetLeft)}px`);
        searchWrapper.classList.add('show');
        openButton.setAttribute('style','display:none');
        setTimeout(function () {
            searchInput.focus();
        }, 200);
    });
    closeButton.addEventListener('click', (e) => {
        e.preventDefault();

        searchWrapper.classList.remove('show');
        openButton.setAttribute('style','display:block');
    })
}