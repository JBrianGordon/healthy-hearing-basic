import $ from 'jquery';

// Import Popper (Bootstrap 4 dependency)
import Popper from 'popper.js';

// Make Popper global (Bootstrap expects it)
(window as any).Popper = Popper;

// Import Bootstrap JS (which includes popover functionality)
import 'bootstrap';


//import 'jquery-ui/ui/widgets/autocomplete';

$(window).ready(function () {

	//Homepage dropdown and slider dropdown use same ul but need to have different styling. Changing id on pages with responsive slider to remedy this
	if ($("#hh-sticky-panel").length > 0) {
		//change the ID to use a letter to avoid messing up jQuery UI id's
		$("#ui-id-3").attr("id", "ui-id-A");
	}
	//hide FAC dropdown on keyboard hide on Android
	if (/(android)/i.test(navigator.userAgent)) {
		var threeFourthsHeight = ($(window).height() as number) * 0.75;
		$(window).on("resize", function () {
			const windowHeight = $(window).height();
			if (windowHeight !== undefined && windowHeight > threeFourthsHeight) {
				$(".ui-menu.ui-autocomplete").hide();
			}
		})
	}

	//Attach popovers to all elements that need it
	$('[data-toggle="popover"]').popover({ html: true });

	// Set default scroll position for hash links to clear navbar
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			const hash = this.getAttribute('href');
			if (hash === '#') {
				e.preventDefault();
				window.scrollTo({ top: 0, left: 0 });
			} else {
				const target = document.querySelector(hash);
				if (target) {
					e.preventDefault();
					window.setTimeout(function () {
						const rect = target.getBoundingClientRect();
						window.scrollTo({ top: window.scrollY + rect.top - 70, left: rect.left });
					}, 0);
				}
			}
		});
	});


});