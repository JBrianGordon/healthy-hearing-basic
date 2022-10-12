import './common';
import '../modules/wordcount';

$('form').on('submit',function() {
	$('input:submit').prop('disabled',true);
	$('input:submit').val('Sending...');
});
$('#ContactHearingCareProfessional').on('click',function(){
	if($(this).is(':checked')){
		$('#ContactCompany').slideDown();
	}
	else {
		$('#ContactCompany').slideUp();
	}
});

//Add recaptcha script on form click
$("#PageContactUsForm input").on("focus",function(){
	if(!$("#PageContactUsForm").hasClass("focused")) {
		$("#PageContactUsForm").addClass("focused");
		var recaptchaScript = document.createElement('script');
		recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js');
		document.head.appendChild(recaptchaScript);
		$("#PageContactUsForm input").off("focus");
		var recaptchaCheck = setInterval(function(){
			if($(".grecaptcha-badge").length > 0) {
				$("#PageContactUsForm input[data-callback='onSubmit']").after($(".grecaptcha-badge"));
				clearInterval(recaptchaCheck);
			}
		},250);
	}
});

window.onSubmit = token => {
	document.getElementById("g-recaptcha-response").value = token;
	document.getElementById("PageContactUsForm").submit();
}
