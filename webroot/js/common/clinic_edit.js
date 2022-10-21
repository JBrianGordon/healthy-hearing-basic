import '../../../node_modules/jquery-ui/ui/widgets/autocomplete';
//import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/dropdown';
//import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/tooltip';
//import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/popover';
import './provider';
import '../modules/wordcount';

$(document).ready(function() {
	// If there are any errors on the page, scroll down
	if ($('div.has-error').length) {
		$('html, body').animate({
			scrollTop: $('div.has-error').offset().top - 90
		}, 'slow');
	}

	// Initialize the "Special Announcements" section.
	// Coupon Library is currently only available to CQ Premier clinics
	$.initSpecialAnnouncements();
		
	//Clinic profile completion. Currently we are only checking the first provider
	var providerArray = [$("#Provider0FirstName"), $("#Provider0LastName"), $("#Provider0Description"), $("#Provider0ThumbUrl")],
		incompleteArray = [],
		completionPercentage = 100;
	
	if($("#cke_1_contents iframe").contents().find("body").text() == ""){
		completionPercentage -= 25;
		incompleteArray.push("<li><a href='#aboutUs'>- About us</a></li>");
		$("h2:contains('About us')").addClass("red");
	}
	if($("#cke_2_contents iframe").contents().find("body").text() == ""){
		completionPercentage -= 25;
		incompleteArray.push("<li><a href='#services'>- Services</a></li>");
		$("h2:contains('Services')").addClass("red");
	}
	providerArray.forEach(function(input){
		if((input.siblings("#cke_Provider0Description").length == 0 && input.val() == "") || (input.siblings("#cke_Provider0Description").length > 0 && $("#cke_Provider0Description iframe").contents().find("body").text() == "")){
			input.parent().addClass("has-error").siblings("label").addClass("red");
		}
	})
	
	$("#hhtvButton").on("click",function(){
		$('html,body').animate({scrollTop: $('#hhTv').offset().top},900);
	})
	
	//Remove error class if at least one photo field has a value
	if($("#Provider0ThumbUrl").val() != "" || $("#Provider0File").val() != "") {
		$("#Provider0ThumbUrl, #Provider0File").parent().removeClass("has-error").siblings("label").removeClass("red");
	}
	//provider first name
	if($("#Provider0FirstName").val() == "") {
		completionPercentage -= 5;
		incompleteArray.push("<li><a href='#provider0First'>- Provider first name</a></li>");		
	}
	//provider last name
	if($("#Provider0LastName").val() == "") {
		completionPercentage -= 5;
		incompleteArray.push("<li><a href='#provider0Last'>- Provider last name</a></li>");		
	}
	//provider description
	if($("#cke_Provider0Description iframe").contents().find("body").text() == ""){
		completionPercentage -= 5;
		incompleteArray.push("<li><a href='#provider0Desc'>- Provider description</a></li>");		
	}
	//provider photo
	if(($("#Provider0ThumbUrl").val() == "" && $("#Provider0File").val() == "") || $("#Provider0ThumbUrl").val() == undefined){
		completionPercentage -= 10;
		incompleteArray.push("<li><a href='#provider0Photo'>- Provider photo</a></li>");		
	}

	//Hours section check
	var days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var isHoursIncomplete = false;
	days.forEach(function(day){
		if (!isHoursIncomplete) {
			if ($("#LocationHour"+day+"OpenHour").val()=="" &&
				$("#LocationHour"+day+"OpenMin").val()=="" &&
				$("#LocationHour"+day+"OpenMeridian").val()=="" &&
				$("#LocationHour"+day+"CloseHour").val()=="" &&
				$("#LocationHour"+day+"CloseMin").val()=="" &&
				$("#LocationHour"+day+"CloseMeridian").val()=="" &&
				!$("#LocationHour"+day+"IsClosed").is(":checked") &&
				!$("#LocationHour"+day+"IsByappt").is(":checked")) {
				completionPercentage -= 10;
				incompleteArray.push("<li><a href='#hoursOfOperation'>- Hours of operation</a></li>");
				$("h2:contains('Hours of operation')").addClass("red");
				isHoursIncomplete = true;
			}
		}
	});
	//Payment section check
	if(!$("#Payment2").is(":checked")&&!$("#Payment4").is(":checked")&&!$("#Payment8").is(":checked")&&!$("#Payment16").is(":checked")&&!$("#Payment64").is(":checked")&&!$("#Payment128").is(":checked")&&!$("#Payment256").is(":checked")&&!$("#Payment512").is(":checked")&&!$("#Payment1024").is(":checked")&&!$("#Payment2048").is(":checked")){
		completionPercentage -= 10;
		incompleteArray.push("<li><a href='#payment'>- Accepted methods of payment</a></li>");
		$("h2:contains('Accepted methods of payment')").addClass("red");
	}
	//Website url check
	if($("#LocationUrl").val() == ""){
		completionPercentage -= 5;
		incompleteArray.push("<li><a href='#urlAnchor'>- Website URL</a></li>");
		$("#LocationUrl").parent().addClass("has-error").siblings("label").addClass("red");
	}
	//Vidscrip validation
	$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").on("blur",function(){
		if($("#LocationVidscripsVidscrip").val() == "" && $("#LocationVidscripsEmail").val() == ""){
			$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").prop("required",false);
		} else {
			$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").prop("required",true);
		}
	})
	// Only display the completion modal once per session. Display again if the percentage changes.
	if (sessionStorage.getItem("sessionCompletionPercentage") != completionPercentage) {
		if (completionPercentage < 100) {
			$("#completionPercentage").html(completionPercentage);
			$("#completionList").html(incompleteArray);
			$("#incompleteModal").show().addClass("in");
		} else if (completionPercentage == 100) {
			$("#completeModal").show().addClass("in");
		}
		sessionStorage.setItem("sessionCompletionPercentage", completionPercentage);
	}
	$('#LocationHourIsClosedLunch').trigger('change');
	$('#LocationIsMobile').trigger('change');
	
	//Display upsell message for all elements on basic clinics over character limit
	$("span.cke_path_item").each(function(i){
		var node = document.getElementById($("span.cke_path_item").eq(i).attr("id")),
		message = $("span.cke_path_item").eq(i).parentsUntil("form-group").next(".text-danger"),
		callback = function(){
			if(node.classList.contains("cke_wordcountLimitReached")){
				message.show();
			} else {
				message.hide();
			}
		},
		config = {characterData:true,childList:true,subtree:true},
		observer = new MutationObserver(callback);
			
		observer.observe(node, config);
	});
	
	locationAutocomplete();
});

$('input[type=submit]').on('click', function() {
	$('.provider').each(function() {
		var provider = $(this).attr('provider');
		var firstName = $('#Provider' + provider + 'FirstName');
		var lastName = $('#Provider' + provider + 'LastName');
		var description = $('#Provider' + provider + 'Description');
		if (firstName.val().length > 0 || lastName.val().length > 0 || description.val().length > 0) {
			firstName.attr('required', 'required');
			lastName.attr('required', 'required');
		} else {
			firstName.removeAttr('required');
			lastName.removeAttr('required');
		}
	});
});

$(function () {
	$('[data-toggle=\"popover\"]').popover();
});

/* Populate Hours when user selects/deselects the "closed" button */
$(".is-closed-checkbox").on("click", function(){
	var day = $(this).data("day");
	if ($(this).is(":checked")) {
		$("#LocationHour"+day+"OpenHour").val(null);
		$("#LocationHour"+day+"OpenMin").val(null);
		$("#LocationHour"+day+"OpenMeridian").val(null);
		$("#LocationHour"+day+"CloseHour").val(null);
		$("#LocationHour"+day+"CloseMin").val(null);
		$("#LocationHour"+day+"CloseMeridian").val(null);
		return;
	} else {
		$("#LocationHour"+day+"OpenHour").val("08");
		$("#LocationHour"+day+"OpenMin").val("00");
		$("#LocationHour"+day+"OpenMeridian").val("am");
		$("#LocationHour"+day+"CloseHour").val("05");
		$("#LocationHour"+day+"CloseMin").val("00");
		$("#LocationHour"+day+"CloseMeridian").val("pm");
	}
});

$.hhGetFileSize = function(fileid) {
	try {
		var fileSize = 0;
		if (navigator.userAgent.match(/msie/i)) { //For IE
			//before making an object of ActiveXObject,
			//please make sure ActiveX is enabled in your IE browser
			var objFSO = new ActiveXObject("Scripting.FileSystemObject");
			var filePath = $("#" + fileid)[0].value;
			var objFile = objFSO.getFile(filePath);
			fileSize = objFile.size; //size in kb
		}	else if($("#" + fileid)[0].files.length > 0) { //for FF, Safari, Opeara and Others
			fileSize = $("#" + fileid)[0].files[0].size //size in kb
		}
		if (fileSize != 0) {
			fileSize = fileSize / 1048576; //size in mb
		}
		//alert("Uploaded File Size is" + fileSize + "MB");
		return fileSize;
	} catch (e) {
		alert("Error is :" + e);
	}
};

//Form submit
$.hhCanSubmit = function(completeCheck) {
	var totalUpload = 0,
		uploadLimit = 0;
		
	if (typeof UPLOAD_LIMIT !== 'undefined') {
		uploadLimit = UPLOAD_LIMIT;
	} else {
		alert('Error: UPLOAD_LIMIT is not set');
	}
	$(".input_file").each(function(){
		totalUpload += $.hhGetFileSize($(this).attr("id"));
	});
	if (totalUpload > uploadLimit) {
		totalUpload = Math.round(totalUpload * 100) / 100;
		alert("Note - Combined files queued for upload ("+ totalUpload +" MB) are more than the limit allowed ("+ uploadLimit +" MB). We cannot upload your picture(s). Please try again with smaller picture file(s). If you need assistance, please email contactHH@healthyhearing.com.");
		return false;
	}
	return true;
};

//Allow form submission if user clicks modal continue
$("#saveAndContinue").on("click",function(){
	$("#LocationClinicEditForm").attr("onsubmit","return $.hhCanSubmit('Continue');").submit();
})

//Notice on input.
$(".input_file").on("change", function() {
	$.hhCanSubmit();
});

$('body').on('change', '.video-url', function() {
	$.addVideoRow(this);
	return false;
});
$('body').on('click', '.js-video-add', function() {
	$.addVideoRow(this);
	return false;
});
$('body').on('click', '.js-video-delete', function() {
	$.removeVideoRow(this);
	return false;
});
$('body').on('click', '.js-photo-delete', function() {
	$.removePhotoRow(this, 'photo');
	return false;
});
$('body').on('click', '.js-logo-delete', function() {
	$.removePhotoRow(this, 'logo');
	return false;
});
$('body').on('click', '.js-ad-delete', function() {
	$.removePhotoRow(this, 'ad');
	return false;
});
$('body').on('change', 'input[type="file"]', function() {
	if (this.id == "LocationAdFile") {
		$.onChangeLocationAdFile(this);
	} else {
		$.onChangeFileInput(this);
	}
});
$('body').on('change', '#LocationIsMobile', function() {
	$.onChangeIsMobile(this.checked);
});
$('body').on('click', '.js-link-delete', function() {
	$.deleteLink(this);
	return false;
});
$('body').on('click', '.js-coupon-select', function() {
	$.addCoupon(this);
	return false;
});
$('body').on('click', '.js-choose-own-coupon', function() {
	$.chooseOwnCoupon();
	return false;
});
$('body').on('click', '.js-show-coupon-library', function() {
	$.showCouponLibrary();
	return false;
});
$('body').on('change', '#LocationHourIsClosedLunch', function() {
	$.onChangeIsClosedLunch(this.checked);
	return false;
});

//Delete photo button
$('.provider-photo-delete').on('click',function(){
	var target = $(this).attr("data-target"),
	    img = $(this).next().find('img');
	$('#'+target).val('');
	$(img).attr('src','');
})

$.addVideoRow = function(obj) {
	var editObj = this;
	var row = $(obj).parents('tr');
	var newRow = $('<tr>');
	var newVideo = $('.video-url');
	var newVideoValue = $('.video-url').val();
	var newVideoKey = parseInt($('.videoKey').val(), 10);
	$('.videoKey').val(parseInt($('.videoKey').val(), 10) + 1);

	// Check for errors in the inputs.
	var errors = false;
	if (newVideoValue.length === 0) {
		errors = true;
	}
	var pattern = new RegExp("^https?://([da-z.-]+).([a-z.]{2,6})([/w.-=?]*)*/?");
	if (pattern.test(newVideoValue) === false) {
		errors = true;
	}
	if (errors === true) {
		// Apply the error style to the input
		$(newVideo).css('background', 'rgba(200,100,100,.5)');
		$("#video-add-error").show();
		return false;
	} else {
		// Remove the error style from the input.
		$(newVideo).css('background', '');
		$("#video-add-error").hide();
	}

	// Add the new row to the videos table
	newRow.append('<td><div><input name="data[LocationVideo]['+newVideoKey+'][video_url]" class="form-control" maxlength="255" type="text" value="'+newVideoValue+'" id="LocationVideo'+newVideoKey+'VideoUrl"></div></td>');
	newRow.append('<td align="center"><button class="btn btn-md btn-danger js-video-delete" data-key="'+newVideoKey+'">delete</button></td>');
	row.before(newRow);

	// Clear out the input
	newVideo.val('');
};

$.removeVideoRow = function(obj) {
	var row = $(obj).parents('tr');
	var key = $(obj).data('key');
	$("#LocationVideo"+key+"VideoUrl").val('');
	row.hide();
};

$.removePhotoRow = function(obj, type) {
	var row = $(obj).parents('tr');
	var key = $(obj).data('key');
    if(type === "photo") {
      $("#LocationPhoto"+key+"PhotoUrl").val('');
      if ($("#LocationPhoto"+key+"File").get(0) !== undefined) {
        $("#LocationPhoto"+key+"File").get(0).value = "";
      }
      row.hide();
    }
    if(type === "logo") {
      $("#LocationLogoUrl").val('');
      $("#photo-thumb-logo").attr("src","");
      if ($("#LocationLogo0File").get(0) !== undefined) {
        $("#LocationLogo0File").get(0).value = "";
      }
    }
	if (type === "ad") {
		$("#location-ad-preview").hide();
		$("#LocationAdFile").val("");
		$("#LocationAdTitle").val("");
		$("#LocationAdDescription").val("");
		$("#LocationAdPhotoUrl").val("");
		$("#LocationCouponId").val(null);
		$('#specialAnnouncements').data('adid', null);
		$('#specialAnnouncements').data('couponid', null);
		initSpecialAnnouncements();
	}
};

$.validatePhotoAlt = function(key) {
	var pattern = new RegExp("^.*[\\+]?[(]?[0-9]{3}[)]?[-\\s\\.]?[0-9]{3}[-\\s\\.]?[0-9]{4,6}.*$"),
		altInput = $("#LocationPhoto"+key+"Alt");
	if (pattern.test(altInput.val())){
		$("input[type='submit']").attr("disabled","disabled");
		$(".help-block-desc-"+key).show();
		altInput.parent().addClass("has-error");
	} else {
		$("input[type='submit']").removeAttr("disabled");
		$(".help-block-desc-"+key).hide();
		altInput.parent().removeClass("has-error");
	}
}

$.addCoupon = function(obj) {
	var couponId = $(obj).attr("data-coupon-id");
	$("#LocationAdFile").val("");
	$("#LocationAdTitle").val("");
	$("#LocationAdDescription").val("");
	$("#LocationAdPhotoUrl").val("");
	$('#specialAnnouncements').data('adid', null);
	$("#LocationCouponId").val(couponId);
	$('#specialAnnouncements').data('couponid', couponId);
	$("#couponSelected .coupon-image").attr("src", "/img/coupons/coupon-"+couponId+".jpg");
	$('#couponLibrary').hide();
	$('#couponSelected').show();
	$('#uploadCoupon').hide();
	$.scrollTo("#specialAnnouncements");
};

$.chooseOwnCoupon = function() {
	$('#couponLibrary').hide();
	$('#couponSelected').hide();
	$('#uploadCoupon').show();
	$.scrollTo("#specialAnnouncements");
};

$.showCouponLibrary = function() {
	$('#couponLibrary').show();
	$('#couponSelected').hide();
	$('#uploadCoupon').hide();
	this.scrollTo("#specialAnnouncements");
};

$.onChangeFileInput = function(obj) {
	var id = obj.id;
	var row = $('#'+id).parents('tr');
	var keyMatch = id.match(/LocationPhoto|LocationLogo|LocationAd|Provider(\d+)(.+)/);
	var key = parseInt(keyMatch.input.match(/\d+/)[0]);
	var newKey = Number(key)+1;
	var filename = obj.files[0].name;
	var filesize = obj.files[0].size;
	var maxSize = id.match(/LocationLogo/) ? 500000 : 2000000;
	// Check for errors in the inputs
	var errors = false;
	if (filename.length === 0) {
		// File is empty
		errors = true;
		$('.upload-text-'+key).html('Click the button to choose a photo from your computer.');
	} else {
		$('.upload-text-'+key).html(filename);
	}
	var match = filename.match(/\.(.+)/);
	var ext = '';
	if (match && (typeof(match[1]) !== undefined)) {
		ext = match[1].toLowerCase();
	}
	if ($.inArray(ext, ['jpg','jpeg']) == -1) {
		// File is not a jpg
		errors = true;
	}
	if (filesize > maxSize) {
		// File is larger than 500KB for logos, 2MB for photo gallery
		errors = true;
	}
	if (errors) {
		// Apply the error style to the input
		$(obj).css('background', 'rgba(200,100,100,.5)');
		if(keyMatch.input == "LocationLogo0Url") {
			$("#photo-add-error-logo").show();
		} else if (keyMatch[0].match(/Provider/)) {
			$("#provider-photo-add-error-"+key).show();
		} else {
			$("#photo-add-error-"+key).show();
		}
		$("#LocationClinicEditForm input[type='submit']").attr("disabled","disabled");
		return false;
	} else {
		// Remove the error style from the input
		$(obj).css('background', '');
		$("#LocationClinicEditForm input[type='submit']").removeAttr("disabled");
		for(var i = 0;i < $(".help-block.text-danger[style='']").length;i++){
			$(".help-block.text-danger[style='']").eq(i).hide();
		}
		$("#photo-add-error-"+key).hide();
		$("#btn-photo-delete-"+key).show();
		$("#photo-description-"+key).show();
			if(keyMatch[0] == "LocationPhoto") {
				$("#photo-add-error-"+key).hide();
				$("#btn-photo-delete-"+key).show();
				$("#photo-description-"+key).show();
				$("input#LocationPhoto"+key+"Alt").removeAttr('disabled');
				
				// Add a new row to the photos table
				var newRow = $('<tr>');
				newRow.append('<td><div class="row mt5 mb10"><div class="col-md-offset-3 col-md-9"><img id="photo-thumb-'+newKey+'"></div></div>'+
					'<div class="form-group"><label for="LocationPhoto'+newKey+'File" class="col col-md-3 control-label">File name</label><div class="col col-md-9"><input type="file" name="data[LocationPhoto]['+newKey+'][file]" class="form-control photo-url" id="LocationPhoto'+newKey+'File"></div></div>'+
					'<div id="photo-description-'+newKey+'" style="display:none;"><div class="form-group required"><label for="LocationPhoto'+newKey+'Alt" class="col col-md-3 control-label">Description</label><div class="col col-md-9"><input name="data[LocationPhoto]['+newKey+'][alt]" class="form-control" required="required" type="text" maxlength="100" disabled="disabled" id="LocationPhoto'+newKey+'Alt"></div></div></div>'+
					'<span class="help-block text-danger" style="display:none;" id="photo-add-error-'+newKey+'">Photo is invalid. Must be a .jpg or .jpeg</span></td>');
				newRow.append('<td align="center"><button class="btn btn-md btn-danger js-photo-delete" data-key="'+newKey+'" id="btn-photo-delete-'+newKey+'" style="display:none;">Delete</button></td>');
				row.after(newRow);
			}

		// Load the thumbnail image
		var files = event.target.files;
		var reader  = new FileReader();
		reader.onload = function(e)  {
			if(keyMatch.input == "LocationLogo0Url") {
				$('img#photo-thumb-logo').attr('src', e.target.result);
			} else {
				$('img#photo-thumb-'+key).attr('src', e.target.result);
			}
		};
		reader.readAsDataURL(files[0]);
	}
};

$.onChangeLocationAdFile = function(obj) {
	var id = obj.id;
	var row = $('#'+id).parents('tr');
	var filename = obj.files[0].name;
	var filesize = obj.files[0].size;
	// Check for errors in the inputs
	var errors = false;
	if (filename.length === 0) {
		// File is empty
		errors = true;
	} else {
		$('#LocationAdPhotoUrl').val(filename);
	}
	var match = filename.match(/\.(.+)/);
	var ext = '';
	if (match && (typeof(match[1]) !== undefined)) {
		ext = match[1].toLowerCase();
	}
	if ($.inArray(ext, ['jpg','jpeg']) == -1) {
		// File is not a jpg
		errors = true;
	}
	if (filesize > 500000) {
		// File is larger than 2MB
		errors = true;
	}
	if (errors) {
		// Apply the error style to the input
		$('#LocationAdPhotoUrl').css('background', 'rgba(200,100,100,.5)');
		$("#location-ad-error").show();
		$("#LocationClinicEditForm input[type='submit'], #floatingSave").attr("disabled","disabled");
		return false;
	} else {
		$("#LocationClinicEditForm input[type='submit'] #floatingSave").removeAttr("disabled");
		// Remove the error style from the input
		$('#LocationAdPhotoUrl').css('background', '');
		$("#location-ad-error").hide();
	}
};

//Close completion check modal	
$("#incompleteModal .close-modal").on("click", function(){
	$("#incompleteModal").removeClass("in").hide();
});
$("#completeModal .close-modal").on("click", function(){
	$("#completeModal").removeClass("in").hide();
});

//Close new user modal	
$("#newUserModal .close-modal").on("click", function(){
	$("#newUserModal").removeClass("show in").hide();
	$("#faqTab").animate({"bottom":0}, 500);
});

//special announcement border selection
$(".border-radio").on("click",function(){
	$(".selected-border").removeClass("selected-border");
	$(this).addClass("selected-border");
})

$.addLink = function(locationId, key) {
	var newLink = $('.linked-location');
	var linkedLocationId = $('#LocationLinkedLocationId').val();
	// Remove the error style from the input.
	$(newLink).css('background', '');
	$("#link-error-"+key).hide();
	$.ajax({
		url:"/locations/ajax_add_linked_location/"+locationId+"/"+linkedLocationId,
		dataType: 'json',
		success: function(data, textStatus) {
			if (data.error) {
				$(newLink).css('background', 'rgba(200,100,100,.5)');
				$("#link-error-"+key).html(data.error);
				$("#link-error-"+key).show();
			} else {
				$("#div-link-"+key).html(data.locationData);
				$("#div-add-delete-"+key).html('<td style="width:100px;" align="center"><button type="button" class="btn btn-md btn-danger js-link-delete" data-key="'+key+'" data-id="'+locationId+'" data-link="'+linkedLocationId+'">delete</button></td>');
				// Add the new row to the LocationLink table
				var newKey = key+1;
				var newRow = $('<tr id="tr-link-'+newKey+'">');
				newRow.append('<td><div id="div-link-'+newKey+'"><input type="hidden" name="data[Location][linked_location_id]" id="LocationLinkedLocationId"><input class="form-control linked-location" data-key="'+newKey+'" data-id="'+locationId+'" /><span class="help-block text-danger" style="display:none;" id="link-error-'+newKey+'"></span></div></td>');
				newRow.append('<td style="width:100px;" align="center"><div id="div-add-delete-'+newKey+'"></div></td>');
				$("#tr-link-"+key).after(newRow);
				locationAutocomplete();
			}
		},
		error: function(data, textStatus) {
			$(newLink).css('background', 'rgba(200,100,100,.5)');
			$("#link-error-"+key).html('Error. Unable to add linked location.');
			$("#link-error-"+key).show();
		},
	});
};

$.deleteLink = function(obj) {
	var key = $(obj).data('key');
	var locationId = $(obj).data('id');
	var linkedLocationId = $(obj).data('link');
	$.ajax({
		url:"/locations/ajax_delete_linked_location/"+locationId+"/"+linkedLocationId,
		dataType: 'json',
		success: function(data, textStatus) {
			$("#tr-link-"+key).remove();
		},
		error: function(data, textStatus) {
			$("#link-error-"+key).html('Error. Unable to delete linked location.');
			$("#link-error-"+key).show();
		},
	});
};

function locationAutocomplete() {
	var locationId = $("input.linked-location").data('id');
	var key = $("input.linked-location").data('key');
	$("input.linked-location").autocomplete({
		source: "/caautocomplete",
		minLength: "2",
		select: function(event, ui){
			if (ui.item.id) {
				$("#LocationLinkedLocationId").val(ui.item.id);
				$.addLink(locationId, key);
			}
		}
	});
}

$.initSpecialAnnouncements = function() {
	var isCqPremier = $('#specialAnnouncements').data('iscqpremier');
	var adId = $('#specialAnnouncements').data('adid');
	var couponId = $('#specialAnnouncements').data('couponid');
	if (isCqPremier && !adId) {
		if (couponId) {
			$('#couponLibrary').hide();
			$('#couponSelected').show();
			$('#uploadCoupon').hide();
		} else {
			$('#couponLibrary').show();
			$('#couponSelected').hide();
			$('#uploadCoupon').hide();
		}
	} else {
		$('#couponLibrary').hide();
		$('#couponSelected').hide();
		$('#uploadCoupon').show();
	}
};

$.scrollTo = function(selector, offset) {
	offset = offset || 90;
	if ($(selector)) {
		$('html,body').animate({scrollTop: $(selector).offset().top - offset});
		return true;
	}
	return false;
};

$.onChangeIsClosedLunch = function(isClosedLunch) {
	if (isClosedLunch) {
		$("#closedLunch").show();
		$('#LocationHourLunchStartHour').prop("required", true);
		$('#LocationHourLunchStartMin').prop("required", true);
		$('#LocationHourLunchStartMeridian').prop("required", true);
		$('#LocationHourLunchEndHour').prop("required", true);
		$('#LocationHourLunchEndMin').prop("required", true);
		$('#LocationHourLunchEndMeridian').prop("required", true);
	} else {
		$("#closedLunch").hide();
		$('#LocationHourLunchStartHour').prop("required", false);
		$('#LocationHourLunchStartMin').prop("required", false);
		$('#LocationHourLunchStartMeridian').prop("required", false);
		$('#LocationHourLunchEndHour').prop("required", false);
		$('#LocationHourLunchEndMin').prop("required", false);
		$('#LocationHourLunchEndMeridian').prop("required", false);
	}
};

$.onChangeIsMobile = function(isMobile) {
	if (isMobile) {
		$('#radius').show();
		$('#LocationRadius').prop("required", true);
	} else {
		$('#LocationRadius').prop("required", false);
		$('#radius').hide();
	}
};
