function enableInteractiveMap(mapName) {
  const element = document.getElementById(mapName + 'Map');

  // Verify this map exists on this page.
  if (!element) {
    return false;
  }

  if (element.getSVGDocument() == null) {
    setTimeout(() => enableInteractiveMap(mapName), 500);
    return false;
  }

  const svgDoc = element.contentDocument;
  const svgRoot = svgDoc.documentElement;

  // Prevent the Map from being initialized twice.
  if (element.getAttribute('data-enabled') == '1') {
    return false;
  }
  element.setAttribute('data-enabled', '1');

  // Mouseover CSS
  const canadaRegions = svgRoot.querySelectorAll('g.Canada g');
  canadaRegions.forEach(region => {
    region.addEventListener('mouseover', () => {
      region.style.fill = '#78afc9';
      region.style.cursor = 'pointer';
    });

    region.addEventListener('mouseout', () => {
      region.style.fill = '#d3d3d3';
    });

    region.addEventListener('click', () => {
      const province = region.getAttribute('province');
      window.location = '/hearing-aids/' + province;
    });
  });
}

window.addEventListener('load', () => {
  enableInteractiveMap('interactive');
  enableInteractiveMap('header');
});

window.addEventListener('pageshow', (event) => {
  if (event.persisted) {
    const cachedMaps = document.querySelectorAll("object[data-enabled='1']");
    cachedMaps.forEach((map) => {
      map.setAttribute('data-enabled', '0');
    });

    const enlargeMap = document.getElementById('enlargeMap');
    if (enlargeMap.style.display !== 'none') {
      enlargeMap.style.display = 'none';
    }

    setTimeout(() => {
      enableInteractiveMap('interactive');
      enableInteractiveMap('header');
    }, 700);
  }
});

const enlargeMapModal = document.getElementById('enlargeMap');

if(enlargeMapModal){
  enlargeMapModal.addEventListener('shown.bs.modal', () => {
    enableInteractiveMap('big');
  });

  enlargeMapModal.addEventListener('hidden.bs.modal', () => {
    const bigMap = document.getElementById('bigMap');
    bigMap.setAttribute('data-enabled', '0');
  });
}
