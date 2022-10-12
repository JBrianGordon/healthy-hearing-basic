import './common';
import './appt_request';
import {directBookBtn} from './direct_book_btn';
import './responsive_slider';

directBookBtn();

$(".quickLink").on("click", function(e) {
	let targetDiv = $(this).attr("href");
	$([document.documentElement, document.body]).animate({
		scrollTop: $(targetDiv).offset().top - $(".navbar").outerHeight()
	}, 1000);
});

// Back-to-top button
var windowHeight = window.innerHeight,
	footerContainer = document.getElementById("footerContainer"),
	footerHeight = footerContainer.offsetHeight,
	contentContainer = document.getElementById("top"),
	scrollCheck = setInterval(function() {
		var contentWidth = $(contentContainer).outerWidth();
		var contentOffset = $(contentContainer).offset();
		var backToTopLeftPosition = contentOffset.left + contentWidth - 125;
		var backToTopRightPosition = window.outerWidth + 125;
		if(window.scrollY > windowHeight) {
			$("#backToTop").animate({left: backToTopLeftPosition},100);
		} else {
			$("#backToTop").animate({left: backToTopRightPosition},100);
		}
	}, 1000);
	 
$("#backToTop").css("bottom", footerHeight + 10);

//Add recaptcha script on form click
$(document).on("focus","#CaCallApptRequestForm input",function(){
	if(!$("#CaCallApptRequestForm").hasClass("focused")) {
		$("#CaCallApptRequestForm").addClass("focused");
		var recaptchaScript = document.createElement('script');
		recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js');
		document.head.appendChild(recaptchaScript);
		$("#CaCallApptRequestForm input").off("focus");
	}
})