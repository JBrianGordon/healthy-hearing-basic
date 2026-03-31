import './fac';
import './share_buttons';

/*** TODO: most or all of this file can likely be deleted ***/

// Add "mobile_table" class to each table
document.querySelectorAll<HTMLTableElement>('table').forEach(table => {
  table.classList.add('mobile_table');
  table.querySelectorAll<HTMLSpanElement>('table.mobile_table span').forEach(span => {
    span.removeAttribute('style');
  });
});

// Add "noprint" class to all wistia videos in help pages
const wistiaEmbeds = document.querySelectorAll<HTMLElement>('.wistia_embed');
wistiaEmbeds.forEach(embed => {
  embed.classList.add('noprint');
});

// Accordion functionality
const accordionHandles = document.querySelectorAll<HTMLElement>('.accordion-handle');
accordionHandles.forEach(handle => {
  handle.addEventListener('click', function (this: HTMLElement) {
    const accordionId = "#" + this.getAttribute("rel");
    const accordionContent = document.querySelector<HTMLElement>(accordionId);

    if (accordionContent) {
      if (accordionContent.classList.contains('hidden')) {
        const visibleAccordion = document.querySelector<HTMLElement>("#accordion ul:not(.hidden)");
        if (visibleAccordion) {
          visibleAccordion.style.display = 'none';
          visibleAccordion.classList.add('hidden');
        }

        accordionContent.style.display = 'block';
        accordionContent.classList.remove('hidden');

        const accordionIcon = document.querySelector<HTMLElement>(accordionId + "-icon");
        if (accordionIcon) {
          accordionIcon.classList.remove('icon-chevron-right');
          accordionIcon.classList.add('icon-chevron-down');
        }
      } else {
        accordionContent.style.display = 'none';
        accordionContent.classList.add('hidden');

        const accordionIcon = document.querySelector<HTMLElement>(accordionId + "-icon");
        if (accordionIcon) {
          accordionIcon.classList.remove('icon-chevron-down');
          accordionIcon.classList.add('icon-chevron-right');
        }
      }
    }

    return false;
  });
});