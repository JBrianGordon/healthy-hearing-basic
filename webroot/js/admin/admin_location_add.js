import './admin_common';

var importsLocationAdd = {
	init: function() {
		var addObj = this;
		$('#submitBtn').click(function() { addObj.disableSubmit(this); });
	},
	disableSubmit: function(btn) {
		if ($(btn).attr('disabled') == 'disabled') { return false; }
		$(btn).attr('disabled', 'disabled');
		$(btn).parents('form').submit();
		console.log('form submitted.');
	}
};

importsLocationAdd.init();

//Change title and subtitle labels (US only)
if($("meta[name='application-name']").attr("content") == "Healthy Hearing"){
	$("label[for='ImportLocationTitle']").html("Practice Name");
	$("label[for='ImportLocationSubtitle']").html("Location Name");
}