import './common';
import './responsive_slider';

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
twitterButton.addEventListener('click', function(e) {
  e.preventDefault();
  window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
});

// Add 'noprint' class to all wistia videos in report pages
const wistiaEmbed = document.querySelectorAll('.wistia_embed');
wistiaEmbed.forEach(embed => {
  embed.classList.add('noprint');
});