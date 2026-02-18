import './admin_common';

const body = document.querySelector('body');

if (body) {
  body.addEventListener('click', function (e: MouseEvent) {
    const target = e.target as HTMLElement;
    if (target.matches('.js-unlink')) {
      if (!confirm('Are you sure you want to unlink this Location?')) {
        e.preventDefault();
      }
    }
  });
}