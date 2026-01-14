import 'jquery-ui/ui/effects/effect-slide'; var hhstickypanel = document.getElementById('hh-sticky-panel');

var scrollHandler = function () {
  var isOpen = hhstickypanel.classList.contains("open");
  var threshold = window.innerHeight / 2;

  if (!isOpen && (window.pageYOffset > threshold)) {
    hhstickypanel.classList.add("open"); //Open it
  } else if (isOpen && (window.pageYOffset < threshold)) {
    hhstickypanel.classList.remove("open"); //Close it
    document.getElementById("ui-id-A").style.display = 'none';
  }
};

document.querySelector(".sticky-panel-handle").addEventListener("click", function (e) {
  e.preventDefault();

  if (hhstickypanel.classList.contains("open")) {
    hhstickypanel.classList.remove("open"); //Close it

    window.removeEventListener("scroll", scrollHandler); //Unbind scroll
    document.cookie = "overlay_FAP=1; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/"; //Add the cookie to set as closed.
  } else {
    hhstickypanel.classList.add("open"); //Open it

    return false;
  }
});

//Add the sliding. Only slide if we havent set the cookie.
if (!document.cookie.split('; ').find(row => row.startsWith('overlay_FAP'))) {
  window.addEventListener("scroll", scrollHandler);
} else {
  // If the cookie is set, remove the 'open' class to ensure the panel is closed
  hhstickypanel.classList.remove("open");
}