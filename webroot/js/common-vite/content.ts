import './fac';
import './share_buttons';

// Modify image source
const images = document.querySelectorAll<HTMLImageElement>('#content_body img');
images.forEach(image => {
  const src = image.getAttribute('src');
  if (src) {
    const index = src.indexOf('/files');
    if (index !== -1) {
      image.setAttribute('src', src.substring(index));
    }
  }
});

// Add 'noprint' class to all wistia videos in report pages
const wistiaEmbed = document.querySelectorAll<HTMLElement>('.wistia_embed');
wistiaEmbed.forEach(embed => {
  embed.classList.add('noprint');
});

// Add blank href to disabled pagination buttons
const disabledPagination = document.querySelector<HTMLAnchorElement>('.page-item.disabled a');
if (disabledPagination) {
  disabledPagination.href = '';
}