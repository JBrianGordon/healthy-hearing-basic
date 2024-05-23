import './common';
import './responsive_slider';
import '../modules/pinterest';

// Modify image source
const images = document.querySelectorAll('#content_body img');
images.forEach(image => {
  const src = image.getAttribute('src');
  const index = src.indexOf('/files');
  if (index !== -1) {
    image.setAttribute('src', src.substr(index, src.length));
  }
});

// Open twitter share links in a small window
const twitterButton = document.querySelector('.twitter-share-button');
if(twitterButton) {
  twitterButton.addEventListener('click', function(e) {
    e.preventDefault();
    window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
  });
}

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