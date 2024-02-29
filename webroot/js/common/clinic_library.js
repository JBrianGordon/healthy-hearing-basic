import './common'

const copyButtons = document.getElementsByClassName("copy");
for (const copyButton of copyButtons) {
	copyButton.addEventListener('click', function () {
		navigator.clipboard.writeText(this.previousElementSibling.innerText);
		this.innerText = "Copied!";
	})
};

let input = document.getElementById("liveLibraryItemSearch");

function liveLibraryItemUpdate() {

    let i, filter, libraryItems, libraryItemText, libraryItemsTitles, libraryItemsAltTitles, libraryItemsTitleHeads, libraryItemSubTitles;
    
    filter = input.value.toLowerCase();

    libraryItems = document.getElementById("items-container").getElementsByClassName("library-item");

    for (i = 0; i < libraryItems.length; i++) {
		libraryItemsTitles = libraryItems[i].getElementsByClassName("item-title")[0].innerHTML;
	    libraryItemsAltTitles = libraryItems[i].getElementsByClassName("item-alt-title")[0].innerHTML;
	    libraryItemsTitleHeads = libraryItems[i].getElementsByClassName("item-title-head")[0].innerHTML;
	    libraryItemSubTitles = libraryItems[i].getElementsByClassName("item-sub-titles")[0].innerHTML;
	    //Replace apostrophe type if wrong
	    if(libraryItemSubTitles.indexOf("’") > -1) {
		    libraryItemSubTitles = libraryItemSubTitles.replace(/’/g, "'");
	    }
	    libraryItemsTitles = libraryItemsTitles.concat(libraryItemsAltTitles,libraryItemsTitleHeads,libraryItemSubTitles);
        if (libraryItemsTitles.toLowerCase().indexOf(filter) > -1) {
            libraryItems[i].style.display = "";
        } else {
            libraryItems[i].style.display = "none";
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
  const modalLinks = document.querySelectorAll('[data-bs-toggle]');

  modalLinks.forEach(link => {
    link.addEventListener('click', function () {
      const modalTarget = this.getAttribute('data-bs-target');
      const modal = document.querySelector(modalTarget);
      const modalImage = modal.querySelector('img');
      const dataSrc = modalImage.getAttribute('data-src');
      modalImage.setAttribute('src', dataSrc);
    });
  });
});

input.addEventListener("keyup", liveLibraryItemUpdate);