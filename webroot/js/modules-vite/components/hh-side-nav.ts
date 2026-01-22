const htmlDiv = document.getElementsByTagName('html');
const sideNavTrigger = document.getElementById('desktopSideNavTrigger') as HTMLElement | null;
const sideNavLinks = document.getElementsByClassName('side-nav-links');
const stickyFooter = document.getElementsByClassName('sticky-footer');
const sideNavDropDown = document.getElementsByClassName('side-nav-dropdown');
const sideNavLinksLis: HTMLElement[] = [];

Array.from(sideNavLinks).forEach((element) => {
  const childLiElements = Array.from(element.children).filter(
    (child): child is HTMLLIElement => child.tagName === 'LI'
  );
  sideNavLinksLis.push(...childLiElements);
});

const hideSide = (): void => {
  if (htmlDiv[0]) {
    htmlDiv[0].classList.remove('show-side-nav');
  }
  document.removeEventListener('click', sideClickCheck);
};

const sideClickCheck = (e: MouseEvent): void => {
  const target = e.target as HTMLElement;
  if (target.closest('[data-hh-side-nav-trigger]') || target.closest('[data-hh-side-nav]')) {
    return;
  } else {
    hideSide();
  }
};

const showSide = (): void => {
  if (htmlDiv[0]) {
    htmlDiv[0].classList.add('show-side-nav');
  }
  document.addEventListener('click', sideClickCheck);
};

const toggleSideNavLis = (sideNavLinksLis: HTMLElement[]): void => {
  sideNavLinksLis.forEach((li) => {
    li.addEventListener("click", () => {
      li.classList.toggle("show");
    });

    const nestedUl = li.querySelector<HTMLUListElement>("ul");

    if (nestedUl) {
      li.addEventListener("click", (e: MouseEvent) => {
        e.stopPropagation();
        nestedUl.classList.toggle("show");
      });
    }
  });
};

if (sideNavTrigger) {
  sideNavTrigger.addEventListener('click', (e: MouseEvent) => {
    e.preventDefault();
    if (htmlDiv[0]) {
      htmlDiv[0].classList.contains('show-side-nav') ? hideSide() : showSide();
    }
  });

  for (let i = 0; i < sideNavDropDown.length; i++) {
    const dropdownElement = sideNavDropDown[i] as HTMLElement;
    dropdownElement.addEventListener('click', function (this: HTMLElement) {
      if (this.parentElement) {
        this.parentElement.classList.toggle('open');
      }
    });
  }

  if (stickyFooter.length > 0) {
    const firstSideNavLink = sideNavLinks[0] as HTMLElement | undefined;
    if (firstSideNavLink) {
      firstSideNavLink.classList.add('fac-present');
    }
  }

  toggleSideNavLis(sideNavLinksLis);
}