import 'jquery-ui/ui/effects/effect-slide';

const hhstickypanel = document.getElementById('hh-sticky-panel');

const scrollHandler = (): void => {
  if (!hhstickypanel) return;

  const isOpen = hhstickypanel.classList.contains("open");
  const threshold = window.innerHeight / 2;

  if (!isOpen && (window.pageYOffset > threshold)) {
    hhstickypanel.classList.add("open"); // Open it
  } else if (isOpen && (window.pageYOffset < threshold)) {
    hhstickypanel.classList.remove("open"); // Close it
    const uiElement = document.getElementById("ui-id-A");
    if (uiElement) {
      uiElement.style.display = 'none';
    }
  }
};

const stickyPanelHandle = document.querySelector<HTMLElement>(".sticky-panel-handle");

if (stickyPanelHandle && hhstickypanel) {
  stickyPanelHandle.addEventListener("click", function (e: MouseEvent) {
    e.preventDefault();

    if (hhstickypanel.classList.contains("open")) {
      hhstickypanel.classList.remove("open"); // Close it

      window.removeEventListener("scroll", scrollHandler); // Unbind scroll

      // Add the cookie to set as closed
      const expiryDate = new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000);
      document.cookie = `overlay_FAP=1; expires=${expiryDate.toUTCString()}; path=/`;
    } else {
      hhstickypanel.classList.add("open"); // Open it
    }

    return false;
  });
}

// Add the sliding. Only slide if we haven't set the cookie.
if (hhstickypanel) {
  const hasCookie = document.cookie.split('; ').find(row => row.startsWith('overlay_FAP'));

  if (!hasCookie) {
    window.addEventListener("scroll", scrollHandler);
  } else {
    // If the cookie is set, remove the 'open' class to ensure the panel is closed
    hhstickypanel.classList.remove("open");
  }
}