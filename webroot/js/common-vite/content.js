import './common';
import './responsive_slider';
import './share_buttons';

// Modify image source
const images = document.querySelectorAll('#content_body img');
images.forEach(image => {
  const src = image.getAttribute('src');
  const index = src.indexOf('/files');
  if (index !== -1) {
    image.setAttribute('src', src.substr(index, src.length));
  }
});

// Add 'noprint' class to all wistia videos in report pages
const wistiaEmbed = document.querySelectorAll('.wistia_embed');
wistiaEmbed.forEach(embed => {
  embed.classList.add('noprint');
});

//Add blank href to disabled pagination buttons
const disabledPagination = document.querySelector('.page-item.disabled a');
if(disabledPagination) {
  disabledPagination.href = '';
}