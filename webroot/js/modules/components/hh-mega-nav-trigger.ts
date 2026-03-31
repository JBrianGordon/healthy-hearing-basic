export const navTriggers = document.querySelectorAll<HTMLElement>('[data-hh-mega-nav-trigger]');
export const megaNavs = document.querySelectorAll<HTMLElement>('[data-hh-mega-nav]');

export const hideNav = (): void => {
  for (const megaNav of megaNavs) {
    megaNav.setAttribute('style', 'height:0;max-height:0');
    megaNav.classList.remove('show');
  }
  for (const navTrigger of navTriggers) {
    navTrigger.classList.remove('active');
  }
  document.removeEventListener('click', autoClose);
  document.removeEventListener('keyup', autoClose);
};

export const autoClose = (e: MouseEvent | KeyboardEvent): void => {
  const keyboardEvent = e as KeyboardEvent;

  if (keyboardEvent.keyCode === 27) {
    hideNav();
  } else {
    const target = e.target as HTMLElement;
    if (target.closest('[data-hh-mega-nav]') || target.closest('[data-hh-mega-nav-trigger]')) {
      return;
    } else {
      hideNav();
    }
  }
};

export const showNav = (thisTrigger: HTMLElement): void => {
  let thisMegaNav: HTMLElement | undefined;

  for (const megaNav of megaNavs) {
    megaNav.setAttribute('style', 'height:0;max-height:0');
    megaNav.classList.remove('show');
    if (megaNav.getAttribute('data-hh-mega-nav') === thisTrigger.getAttribute('data-hh-mega-nav-trigger')) {
      thisMegaNav = megaNav;
    }
  }

  for (const navTrigger of navTriggers) {
    navTrigger.classList.remove('active');
  }

  if (!thisMegaNav) return;

  thisTrigger.classList.add('active');

  setTimeout(() => {
    if (!thisMegaNav) return;

    const firstChild = thisMegaNav.childNodes[1] as HTMLElement;
    if (firstChild) {
      const ddHeight = firstChild.offsetHeight;
      thisMegaNav.setAttribute('style', `height:${ddHeight}px;max-height:${ddHeight}px`);
      thisMegaNav.classList.add('show');
    }
  }, 300);

  setTimeout(() => {
    if (thisMegaNav) {
      thisMegaNav.style.overflow = 'visible';
    }
  }, 600);

  document.addEventListener('click', autoClose);
  document.addEventListener('keyup', autoClose);
};

for (const navTrigger of navTriggers) {
  navTrigger.addEventListener('click', (e: MouseEvent) => {
    e.preventDefault();
    navTrigger.classList.contains('active') ? hideNav() : showNav(navTrigger);
  });
}