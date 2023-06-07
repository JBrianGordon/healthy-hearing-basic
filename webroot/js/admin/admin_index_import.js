import './admin_common';

document.querySelector('body').addEventListener('click', function(e) {
  if (e.target.matches('.js-unlink')) {
    if (!confirm('Are you sure you want to unlink this Location?')) {
      e.preventDefault();
    }
  }
});