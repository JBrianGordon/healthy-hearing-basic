// Import SVG templates as raw strings
import usTemplate from '../../../img/us-map.svg?raw';
import caTemplate from '../../../img/ca-map.svg?raw';

const html = document.getElementsByTagName('html');
const lang = html[0]?.getAttribute('lang');
const mapDivs = document.querySelectorAll<HTMLElement>('[data-hh-map]');
const usedTemplate = (lang === 'en-CA' ? caTemplate : usTemplate);

const zoomFunctions = (zoomElements: HTMLCollectionOf<Element> | NodeListOf<Element>): void => {
  for (const zoomObject of zoomElements) {
    const zoomEl = zoomObject as SVGElement;

    zoomEl.addEventListener('click', () => {
      const parentContainer = zoomEl.parentNode?.parentNode as HTMLElement | null;
      if (!parentContainer) return;

      const map = parentContainer.getElementsByClassName('map')[0] as HTMLElement | undefined;
      const unZoom = parentContainer.getElementsByClassName('map-unzoom')[0] as HTMLElement | undefined;

      if (!map || !unZoom) return;

      window.requestAnimationFrame(() => {
        const svgZoomEl = zoomEl as SVGElement;
        if (svgZoomEl.className.baseVal === 'zoom-box') {
          map.classList.add('zoom');
          unZoom.classList.add('show');
        } else {
          map.classList.remove('zoom');
          unZoom.classList.remove('show');
        }
      });
    });
  }
};

// Insert SVG templates into map containers
for (const mapDiv of mapDivs) {
  mapDiv.innerHTML = usedTemplate;
}

document.addEventListener('DOMContentLoaded', () => {
  const stateButtons = document.getElementsByClassName('state');
  const provinceButtons = document.querySelectorAll<HTMLElement>('[province]');
  const zoomBoxes = document.getElementsByClassName('zoom-box');
  const unZooms = document.getElementsByClassName('map-unzoom');

  if (provinceButtons.length > 0) {
    for (const provinceButton of provinceButtons) {
      const province = provinceButton.getAttribute('province');
      if (province) {
        provinceButton.addEventListener('click', () => {
          document.location.href = `/hearing-aids/${province}`;
        });
      }
    }
  } else {
    for (const stateButton of stateButtons) {
      const stateEl = stateButton as HTMLElement;
      if (stateEl.id) {
        stateEl.addEventListener('click', () => {
          document.location.href = `/hearing-aids/${stateEl.id}`;
        });
      }
    }
  }

  zoomFunctions(zoomBoxes);
  zoomFunctions(unZooms);
});