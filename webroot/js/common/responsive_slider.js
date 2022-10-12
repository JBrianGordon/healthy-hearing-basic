import '../../../node_modules/jquery-ui/ui/effects/effect-slide';
import '../jquery/jquery.cookie';

    var hhstickypanel = jQuery("#hh-sticky-panel");

    jQuery(".sticky-panel-handle").on("click", function(e) {
      e.preventDefault();
      var ga_code_additions = true;
      if (typeof dataLayer === "undefined") {
        ga_code_additions = false;
      }

      if (hhstickypanel.hasClass("open")) {
        hhstickypanel.switchClass("open", ""); //Close it

        if (ga_code_additions) {
          dataLayer.hhTrackEvent("fap_search_pop_up","click_hide");
        }

        jQuery(window).off("scroll"); //Unbind scroll
        jQuery.cookie("overlay_FAP",1,{expires: 30, path: "/"}); //Add the cookie to set as closed.
      } else {
        hhstickypanel.switchClass("", "open"); //Open it

        if (ga_code_additions) {
          dataLayer.hhTrackEvent("fap_search_pop_up", "click_show");
        }
      }
      return false;
    });

    //Add the sliding. Only slide if we havent set the cookie.
    if (!jQuery.cookie("overlay_FAP")) {
      var thewindow = jQuery(window);
      thewindow.on("scroll", function() {
        var isOpen = hhstickypanel.hasClass("open");
        var threshold = thewindow.height() / 2;

        if (!isOpen && (thewindow.scrollTop() > threshold)) {
          hhstickypanel.switchClass("","open"); //Open it
        } else if(isOpen && (thewindow.scrollTop() < threshold)) {
          hhstickypanel.switchClass("open",""); //Close it
          $("#ui-id-A").hide();
        }
      });
    }