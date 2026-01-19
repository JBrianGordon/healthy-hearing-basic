import './common';

const copyButtons: HTMLCollectionOf<Element> = document.getElementsByClassName("copy");
for (const copyButton of copyButtons) {
  copyButton.addEventListener('click', function (this: HTMLElement) {
    const previousElement = this.previousElementSibling as HTMLElement;
    if (previousElement) {
      navigator.clipboard.writeText(previousElement.innerText);
      this.innerText = "Copied!";
    }
  });
}

const input = document.getElementById("liveLibraryItemSearch") as HTMLInputElement;

function liveLibraryItemUpdate(): void {
  if (!input) return;

  let filter: string;
  let libraryItems: HTMLCollectionOf<Element>;
  let libraryItemsTitles: string;
  let libraryItemsAltTitles: string;
  let libraryItemsTitleHeads: string;
  let libraryItemSubTitles: string;

  filter = input.value.toLowerCase();

  const itemsContainer = document.getElementById("items-container");
  if (!itemsContainer) return;

  libraryItems = itemsContainer.getElementsByClassName("library-item");

  for (let i = 0; i < libraryItems.length; i++) {
    const libraryItem = libraryItems[i] as HTMLElement;

    const titleElement = libraryItem.getElementsByClassName("item-title")[0] as HTMLElement;
    const altTitleElement = libraryItem.getElementsByClassName("item-alt-title")[0] as HTMLElement;
    const titleHeadElement = libraryItem.getElementsByClassName("item-title-head")[0] as HTMLElement;
    const subTitlesElement = libraryItem.getElementsByClassName("item-sub-titles")[0] as HTMLElement;

    if (!titleElement || !altTitleElement || !titleHeadElement || !subTitlesElement) {
      continue;
    }

    libraryItemsTitles = titleElement.innerHTML;
    libraryItemsAltTitles = altTitleElement.innerHTML;
    libraryItemsTitleHeads = titleHeadElement.innerHTML;
    libraryItemSubTitles = subTitlesElement.innerHTML;

    // Replace apostrophe type if wrong
    if (libraryItemSubTitles.indexOf("'") > -1) {
      libraryItemSubTitles = libraryItemSubTitles.replace(/'/g, "'");
    }

    libraryItemsTitles = libraryItemsTitles.concat(
      libraryItemsAltTitles,
      libraryItemsTitleHeads,
      libraryItemSubTitles
    );

    if (libraryItemsTitles.toLowerCase().indexOf(filter) > -1) {
      libraryItem.style.display = "";
    } else {
      libraryItem.style.display = "none";
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const modalLinks = document.querySelectorAll<HTMLElement>('[data-bs-toggle]');

  modalLinks.forEach(link => {
    link.addEventListener('click', function (this: HTMLElement) {
      const modalTarget = this.getAttribute('data-bs-target');
      if (!modalTarget) return;

      const modal = document.querySelector<HTMLElement>(modalTarget);
      if (!modal) return;

      const modalImage = modal.querySelector<HTMLImageElement>('img');
      if (!modalImage) return;

      const dataSrc = modalImage.getAttribute('data-src');
      if (dataSrc) {
        modalImage.setAttribute('src', dataSrc);
      }
    });
  });
});

if (input) {
  input.addEventListener("keyup", liveLibraryItemUpdate);
}