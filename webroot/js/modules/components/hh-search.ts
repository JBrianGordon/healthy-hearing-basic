export const searchWrapper = document.getElementById('searchWrapper') as HTMLElement | null;
export const searchInput = document.getElementById('ContentSearch') as HTMLInputElement | null;
export const searchLink = document.getElementById('searchLink') as HTMLAnchorElement | null;
export const nav = document.getElementById('navContainer') as HTMLElement | null;
export const navParent = document.getElementById('navParent') as HTMLElement | null;
export const openButton = document.getElementById("openSearch") as HTMLButtonElement | null;
export const closeButton = document.getElementById("closeSearch") as HTMLButtonElement | null;

if (openButton && searchWrapper && searchInput && nav && navParent && closeButton) {
  openButton.addEventListener('click', (e: MouseEvent) => {
    e.preventDefault();

    const width = window.outerWidth - (nav.offsetLeft + navParent.offsetLeft);
    searchWrapper.setAttribute('style', `width:${width}px`);
    searchWrapper.classList.add('show');
    openButton.setAttribute('style', 'display:none');

    setTimeout(() => {
      searchInput.focus();
    }, 200);
  });

  closeButton.addEventListener('click', (e: MouseEvent) => {
    e.preventDefault();

    searchWrapper.classList.remove('show');
    openButton.setAttribute('style', 'display:block');
  });
}