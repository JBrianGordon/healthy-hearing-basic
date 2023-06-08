import './common';
import './responsive_slider';

// Add "mobile_table" class to each table
document.querySelectorAll('table').forEach(table => {
  table.classList.add('mobile_table');
  table.querySelectorAll('table.mobile_table span').forEach(span => {
    span.removeAttribute('style');
  });
});

// Open social media links in a new window
document.querySelectorAll('.btn-share').forEach(btn => {
  btn.addEventListener('click', function(event) {
    event.preventDefault();
    window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
  });
});

// Add "noprint" class to all wistia videos in help pages
const wistiaEmbeds = document.querySelectorAll('.wistia_embed');
wistiaEmbeds.forEach(embed => {
  embed.classList.add('noprint');
});

// Accordion functionality
const accordionHandles = document.querySelectorAll('.accordion-handle');
accordionHandles.forEach(handle => {
  handle.addEventListener('click', function() {
    const accordionId = "#" + this.getAttribute("rel");
    const accordionContent = document.querySelector(accordionId);

    if (accordionContent.classList.contains('hidden')) {
      const visibleAccordion = document.querySelector("#accordion ul:not(.hidden)");
      visibleAccordion.style.display = 'none';
      visibleAccordion.classList.add('hidden');
      
      accordionContent.style.display = 'block';
      accordionContent.classList.remove('hidden');
      document.querySelector(accordionId + "-icon").classList.remove('icon-chevron-right');
      document.querySelector(accordionId + "-icon").classList.add('icon-chevron-down');
    } else {
      accordionContent.style.display = 'none';
      accordionContent.classList.add('hidden');
      document.querySelector(accordionId + "-icon").classList.remove('icon-chevron-down');
      document.querySelector(accordionId + "-icon").classList.add('icon-chevron-right');
    }

    return false;
  });
});