import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal';

window.submitApptRequest = () => {
    if ($("#CaCallApptRequestForm").get(0).reportValidity()) {
        $("#apptRequestSubmitBtn").prop("disabled", !0);
        let t = $("#CaCallApptRequestForm").serialize();
        $.ajax({
            type: "POST",
            url: "/ca_calls/appt_request",
            data: t,
            dataType: "json",
            success: function(t) {
                if ($("#apptRequestSubmitBtn").prop("disabled", !1), !0 === t.success) $("#apptRequestModal").hide(), $("#apptRequestThankYouModal").show();
                else {
                    let e = "Error";
                    t.errorMessage && (e = t.errorMessage), $("#apptRequestSubmitErrorMessage").html(e), $("#apptRequestSubmitError").show()
                }
                grecaptcha.reset();
            }
        })
    }
}

window.onSubmit = e => {
	e.preventDefault();
	var appReqPanel = document.getElementById("apptRequestPanel"),
		modalThankYou = document.getElementById("apptRequestThankYouModal"),
		closeModalButtons = modalThankYou.querySelectorAll("[data-dismiss='modal']"),
		pageBody = document.getElementsByTagName("body");
	if (!grecaptcha.getResponse()) {
		grecaptcha.execute();
	}
	if (appReqPanel != null && appReqPanel.classList.contains("fixed")) {
		appReqPanel.classList.remove("fixed");
	}
	modalThankYou.classList.remove("fade");
	for(var i = 0;i < closeModalButtons.length; i++) {
		closeModalButtons[i].addEventListener("click", function(){
			modalThankYou.remove();
			pageBody[0].classList.remove("modal-open");
		})
	}
}

window.addSubmitListener = () => {
	var form = document.getElementById('CaCallApptRequestForm');
	form.addEventListener('submit', onSubmit);
}

//Highlight Appt req form on link click
if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
	const formLink = document.querySelector("#requestFormHighlight");
	const apptReqForm = document.querySelector("#apptRequestPanel");
	const expandContract = () => {
		  	apptReqForm.classList.toggle("contracted");
			apptReqForm.classList.toggle("expanded");
			setTimeout(() => {
				apptReqForm.classList.toggle("contracted");
				apptReqForm.classList.toggle("expanded");
			}, 500);
		  };
		  
	if(formLink != null) {
		formLink.addEventListener("click", expandContract);
	}
}

$(document).ready(function() {
	$('.apptRequestBtn').on('click', function() {
		var locationId = $(this).attr('data-id'),
			apptReqPanel = $("#apptRequestPanel");
			
		if (locationId) {
			$.ajax({
				url:"/locations/ajax_appt_request_modal/"+locationId,
				success: function(data, status) {
					$('#ajaxModals').html(data);
					$('#apptRequestModal').modal("show");
					addSubmitListener();
				}
			});
		} else if (apptReqPanel) {
			$('html, body').animate({scrollTop: $("#apptRequestModal").offset().top -70}, 1000);
		} else if($("#apptRequestThankYouModal").attr("style") != "") {
			$("#apptRequestPanel").addClass("fixed");
			$(".fixed .close").on("click",function(){
				$("#apptRequestPanel").removeClass("fixed");
			})
		}
	});
	if($('#apptRequestModal').length > 0) {
		addSubmitListener();
	}
});
