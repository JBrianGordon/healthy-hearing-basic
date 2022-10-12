import './appt_request';
import './location_review';
import {directBookBtn} from './direct_book_btn';
import './common';

directBookBtn();

//Create clinic object
$.Clinic = {
	time: null,
	/**
	* Start the timer on the current time
	*/
	start_time: function(){
		this.time = new Date;
	},
	/**
	* Get the diff time
	*/
	diff_time: function(){
		var now = new Date;
		var retval = Math.round((now - this.time) * .001);
		return retval;
	}
}
//Start the timer by default
$.Clinic.start_time();

$(document).ready(function(){
	$(window).on('hashchange', function(){
		var offset = $(window).scrollTop();
		$(window).scrollTop(offset-70);
	});
	
	//Rearrange clinic elements on mobile
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$("#disclaimer").before($("#callClinic"));
	}
	
	//EarQ and ida link functionality
	 $(".earq-link, .ida-link").on("click", function(e){
		 e.preventDefault();
		 let targetDiv = $(this).attr("href");
		 $(".closing-animation").removeClass("closing-animation");
	     $([document.documentElement, document.body]).animate({
	        scrollTop: $(targetDiv).offset().top
	     }, 1000);
	 })
	
	//Add Google Maps link to Get Directions button
	var clinicAddr = $(".address").text().trim().replace(/ /g, "+").replace("#","");	
	$(".directions-link").attr("href", ("https://www.google.com/maps/dir//" + clinicAddr));
	
	//Add recaptcha script on form click
	$("#CaCallApptRequestForm input").on("focus",function(){
		if(!$("#CaCallApptRequestForm").hasClass("focused")) {
			$("#CaCallApptRequestForm").addClass("focused");
			var recaptchaScript = document.createElement('script');
			recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js');
			document.head.appendChild(recaptchaScript);
			$("#CaCallApptRequestForm input").off("focus");
		}
	})

	$("#more-reviews > div").addClass("hidden-review");
	var hiddenRevNum = $(".hidden-review").length;
	$("#more-reviews-button").on("click",function(){
		$("#fewer-reviews-button").show();
		for(var i =0; i < 5; i++){
			$(".hidden-review").first().removeClass("hidden-review");
			hiddenRevNum--;
			if(hiddenRevNum == 0){
				$("#more-reviews-button").hide();
				break;
			}
		}
		$("#more-reviews").slideDown();
		return false;
	});
	
	$("#fewer-reviews-button").on("click",function(){
		$("#more-reviews").slideUp(1000);
		$(this).hide();
		$("#more-reviews-button").show();
		$('html, body').animate({
		    scrollTop: ($(".panel-section.reviews").offset().top - 114)
		}, 1000);
		setTimeout(function(){
			$("#more-reviews > div").addClass("hidden-review");
			hiddenRevNum = $(".hidden-review").length;
		},1100);
		return false;
	})
	
	var newestArr = $(".well"),
		ratingArr = [];
	
	var sortReviews = function(chosenArray){
		for(var i = 0; i < chosenArray.length; i++){
			if($("#more-reviews").length > 0){
				if(i < 5){
					chosenArray[i].classList.remove("hidden-review");
					$("#more-reviews").before(chosenArray[i]);
				} else {
					chosenArray[i].classList.add("hidden-review");
					$("#more-reviews").append(chosenArray[i]);
				}
			} else {
				$(".panel-section.reviews").append(chosenArray[i]);
			}
		}
		$("#more-reviews-button").show();
		$("#fewer-reviews-button").hide();
	},
	sortByRating = function(chosenRating){
		var ratingArray = [],
			fiveStar = [],
			fourHalfStar = [],
			fourStar = [],
			threeHalfStar = [],
			threeStar = [],
			twoHalfStar = [],
			twoStar = [],
			oneHalfStar = [],
			oneStar = [];
		for(var i = 0; i < newestArr.length; i++){
			if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 5){
				fiveStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 4 && newestArr[i].getElementsByClassName("hh-icon-half-star").length === 1) {
				fourHalfStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 4) {
				fourStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 3 && newestArr[i].getElementsByClassName("hh-icon-half-star").length === 1) {
				threeHalfStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 3) {
				threeStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 2 && newestArr[i].getElementsByClassName("hh-icon-half-star").length === 1) {
				twoHalfStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 2) {
				twoStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 1 && newestArr[i].getElementsByClassName("hh-icon-half-star").length === 1) {
				oneHalfStar.push(newestArr[i]);
			} else if(newestArr[i].getElementsByClassName("hh-icon-full-star").length === 1) {
				oneStar.push(newestArr[i]);
			}
		}
		if(chosenRating == "lowestRating"){
			ratingArray.push(oneStar.concat(oneHalfStar.concat(twoStar.concat(twoHalfStar.concat(threeStar.concat(threeHalfStar.concat(fourStar.concat(fourHalfStar.concat(fiveStar)))))))));
		} else {
			ratingArray.push(fiveStar.concat(fourHalfStar.concat(fourStar.concat(threeHalfStar.concat(threeStar.concat(twoHalfStar.concat(twoStar.concat(oneHalfStar.concat(oneStar)))))))));
		}
		var sortedRatingArray = sortReviews(ratingArray[0]);
		return sortedRatingArray;
	}
	
	$("#sortSelect").on("change", function(){
		if($(this).val() == "newestArr"){
			sortReviews(newestArr);
		} else {
			sortByRating($(this).val());
		}
	})
	//End button code
	
	//Date checker for hours of operation
	var clinicIsOpen = $(".hours span").hasClass("open"),
		currentDate = new Date,
		currentDay = currentDate.getDay(),
		dayArray = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
		dayElement = $("tr:contains('" + dayArray[currentDay] + "')");
	
	if(clinicIsOpen){
		dayElement.css({"color":"#065903","background-color":"#eff5f5","font-weight":"bold"});
	}
	//End hours of operation check
	
	$("#CaCallGroupEmail").on('change', function(){
		var pattern = new RegExp('[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}');
		if (pattern.test(this.value) === true) {
			this.setCustomValidity('');
		} else {
			this.setCustomValidity('Please enter a valid email address.');
		}
	});

	$("#CaCallGroupCallerPhone").on('change', function(){
		// Phone number must be at least 10 numerical digits
		var digits = this.value.replace(/\D/g, '');
		if (digits.length < 10) {
			this.setCustomValidity('Please enter a valid phone number.');
		} else {
			this.setCustomValidity('');
		}
	});
	
	//Add cred popup on hover for clinicians
	var credList = {
		"AuD":"Doctor of Audiology",
		"BC-HIS":"Board Certified in Hearing Instrument Sciences",
		"CCC-A/SLP":"Certificate of Clinical Competence in Audiology/Speech Language Pathology",
		"CCC-A":"Certificate of Clinical Competence in Audiology",
		"FAAA":"Fellow of the American Academy of Audiology",
		"HAD":"Hearing Aid Dispenser/Dealer",
		"HIS":"Hearing Instrument Specialist",
		"LHIS":"Licensed Hearing Instrument Specialist",
		"MA":"Master of Arts",
		"MD":"Medical Doctor",
		"MS":"Master of Science",
		"PhD":"Doctor of Philosophy"
	};
	for (var i = 0; i < $(".provider-qualifications").length; i++) {
		var credArray = $(".provider-qualifications").eq(i).html().replace(/\s+/g, '').replace(/\./g, '').split(",");
		var popoverData = '';
		for (var j = 0; j < credArray.length; j++) {
			var currentCred = credArray[j];
			if (credList[currentCred] !== undefined) {
				popoverData += "<span class='cred-text'>"+currentCred+' - '+credList[currentCred]+'</span><br>';
			}
		}
		if(popoverData != "") {
			$(".cred-popover-"+i).attr("data-content", popoverData);
		} else {
			$(".cred-popover-"+i).remove();
		}
	}
	$(".provider-qualifications a[data-content='']").remove();
	
	//Function to check if videos are in viewport
	var isInViewport = function (el) {
	    var elementTop = $(el).offset().top,
	    	elementBottom = elementTop + $(el).outerHeight(),
			viewportTop = $(window).scrollTop(),
			viewportBottom = viewportTop + $(window).height();
	
	    return elementBottom > viewportTop && elementTop < viewportBottom;
	};
	
	if($(".video-frame").length >= 1) {
		
		if($(".video-frame").length > 2) {
			
			//Scroll function to detect if gallery div is in view
			$(window).scroll(function () {
			    if (isInViewport($(".video-gallery"))) {
			        for(var i = 0; i < $(".video-frame").length; i++) {
			        	$(".video-frame").eq(i).attr("src",$(".video-frame").eq(i).attr("data-src"));
			        }
			        //Turn scroll function off once video sources are loaded
			        $(window).off("scroll");
			    }
			});
			
			$(".video-gallery").after("<button id='videoGalleryButton' class='btn btn-light mt20 show-videos' style='margin:20px auto; display:block; clear:both'>View more videos</button><div id='moreVideos' style='display:none'></div>");

			$(document).on("click", "#videoGalleryButton", function(){
				if($(this).hasClass('show-videos')) {
					$(this).toggleClass('show-videos').text('View fewer videos');
					$("#moreVideos").slideDown();
					return false;
				} else{
					$(this).toggleClass('show-videos').text('View more videos');
					$("#moreVideos").slideUp(1000);
					$('html, body').animate({
					    scrollTop: ($("#videoGallery").offset().top - 114)
					}, 1000);
					return false;
				}
			})
			
			for(var i = 2; i < $(".video-frame").length; i++) {
				$(".video-frame").eq(2).appendTo($("#moreVideos"));
			}
			
		} else{
			$(window).scroll(function () {
			    if (isInViewport($("#videoGallery"))) {
			        for(var i = 0; i < $(".video-frame").length; i++) {
			        	$(".video-frame").eq(i).attr("src",$(".video-frame").eq(i).attr("data-src"));
			        }
			        $(window).off("scroll");
			    }
			});
		}
	}
	
	//photo gallery functions
	if($(".photo-gallery").length > 0){
		
		for(var i=0;i < $(".photo-button").length; i++){
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				$(".photo-button").eq(i).attr("disabled","disabled");
			}
			if ($(".photo-button").length == 1) {
				$(".photo-button").addClass("col-xs-12 col-sm-6 offset-sm-3").attr("disabled","disabled");
				break;
			} else if ($(".photo-button").length == 2) {
				$(".photo-button").eq(i).addClass("col-xs-12 col-sm-6").attr("disabled","disabled");
			} else if ($(".photo-button").length == 3) {
				$(".photo-button").eq(i).attr("disabled","disabled");
			} else if(i < 3){
				$(".photo-button").eq(i).addClass("col-xs-12 col-sm-4");
			} else {
				$(".photo-button").eq(i).addClass("hidden");
			}
		}
    
		if($(".photo-button").length > 3){
			$(".photo-gallery").after("<button id='galleryButton' class='btn btn-secondary mt20' style='margin:20px auto; display:block; clear:both' data-target='#photoModal'>View more photos</button>");

			$(document).on("click", "#galleryButton", function(){
				if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(".photo-button.hidden").length < 1 ) {
					for(var i=3;i < $(".photo-button").length; i++){
						$(".photo-button").eq(i).addClass("hidden");
					}
					$("#galleryButton").text("View more photos");
				} else if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(".photo-button").length >= 4) {
					for(var i=0;i < $(".photo-button.hidden").length; i++){
						$(".photo-button.hidden").removeClass("hidden");
					}
					$("#galleryButton").text("View fewer photos");
				} else {
					$("#photoModal").addClass("in").show();
				}
			})

			$(document).on("click", "#photoModal .close", function(){
				$("#photoModal").removeClass("in").hide();
			})
		}
		
		$(".modal-body .photo.gallery").css({"width":"100%","margin":"0"});
		
		//Reset photo gallery in case of orientation change
		$(window).on("orientationchange",function(){
			setTimeout(function(){
				setArrow(".photo-gallery");
			},200);
		})
		
		$("#photoModal").on("click", function(){
			setTimeout(function(){
				if(!$("body").hasClass("modal-open")){
					$(".photo-button").removeAttr("disabled");
					if(/Android|webOS|iPhone|iPad/i.test(navigator.userAgent)) {
						$(".sticky-footer").show();
					}
					
					//send user back to gallery
					if($(".video-gallery").length > 0) {
						$([document.documentElement, document.body]).animate({
							scrollTop: $(".video-gallery").offset().top
						});
					}
				}
			},500)
		});	
	}
	
	$('[data-toggle="popover"]').popover();
});
$(window).on('load', function(){
	// The '__utmzz' cookie should be present when the page is fully loaded
	// It should contain 'utmcsr=(xxx)' and 'utmcmd=(xxx)'
	var source = 'unknown';
	var match = document.cookie.match(new RegExp('utmcsr=(.*?)[|]'));
	if (match) {
		source = match[1];
		source = source.replace(/[()]/g, '');
	}
	var medium = 'unknown';
	match = document.cookie.match(new RegExp('utmcmd=(.*?)[|]'));
	if (match) {
		medium = match[1];
		medium = medium.replace(/[()]/g, '');
	}
	$("#CaCallGroupTrafficSource").val(source);
	$("#CaCallGroupTrafficMedium").val(medium);
});
