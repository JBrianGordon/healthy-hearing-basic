import '../common/common';
import '../common/provider';
import './nav_tabs';
import './datepicker';


var locationsAdminEdit = {
	init: function() {
		var editObj = this;
		$('body').on('change', '.video-url', function() { editObj.addVideoRow(this); return false; });
		$('body').on('click', '.js-video-add', function() { editObj.addVideoRow(this); return false; });
		$('body').on('click', '.js-video-delete', function() { editObj.removeVideoRow(this); return false; });
		$('body').on('click', '.js-link-delete', function() { editObj.deleteLink(this); return false; });
		$('body').on('click', '.js-photo-delete', function() { editObj.removePhotoRow(this, "photo"); return false; });
		$('body').on('click', '.js-logo-delete', function() { editObj.removePhotoRow(this, "logo"); return false; });
		$('body').on('click', '.js-ad-delete', function() { editObj.removePhotoRow(this, "ad"); return false; });
		$('body').on('click', '.js-show-coupon-library', function() { editObj.showCouponLibrary(); return false; });
		$('body').on('click', '.js-choose-own-coupon', function() { editObj.chooseOwnCoupon(); return false; });
		$('body').on('click', '.js-coupon-select', function() { editObj.addCoupon(this); return false; });
		$('body').on('click', '.is-closed-checkbox', function() { editObj.onClickHoursClosed(this); });
		var textLength = $('td.body:contains("yhn")').length,
			importTextLength = $('u:contains("YHN Import")').length;
		if($('.navbar-logo.CA').length > 0 && (textLength > 0 || importTextLength > 0)){
			if(textLength > 0){
				$('td.body:contains("yhn")').html($('td.body:contains("yhn")').html().replace(/yhn[_]?/g, ''));
			}
			if(importTextLength > 0){
				$('u:contains("YHN Import")').html('Import');
			}
		}
		$('.js-import-select').on('change',function() {
			var importId = $(this).val();
			editObj.selectImport(importId);
		}).trigger('change');
		$('.js-cqp-import-select').on('change',function() {
			var cqpImportId = $(this).val();
			editObj.selectCqpImport(cqpImportId);
		}).trigger('change');
		$('body').on('change', 'input[type="file"]', function() {
			if (this.id == "LocationAdFile") {
				editObj.onChangeLocationAdFile(this);
			} else {
				editObj.onChangeFileInput(this);
			}
		});
		$('body').on('change', '#LocationDirectBookType', function() {
			editObj.onChangeDirectBookType(this.value);
		});
		$('#LocationDirectBookType').trigger('change');
		$('body').on('change', '#LocationIsListingTypeFrozen', function() {
			editObj.onChangeIsListingTypeFrozen(this.checked);
		});
		$('#LocationIsListingTypeFrozen').trigger('change');
		$('body').on('change', '#LocationFeatureContentLibrary', function() {
			editObj.onChangeFeatureContentLibrary(this.checked);
		});
		$('#LocationFeatureContentLibrary').trigger('change');
		$('body').on('change', '#LocationFeatureSpecialAnnouncement', function() {
			editObj.onChangeFeatureSpecialAnnouncement(this.checked);
		});
		$('#LocationFeatureSpecialAnnouncement').trigger('change');
		$('body').on('change', '#LocationHourIsClosedLunch', function() {
			editObj.onChangeIsClosedLunch(this.checked);
		});
		$('#LocationHourIsClosedLunch').trigger('change');
		$('body').on('change', '#LocationIsMobile', function() {
			editObj.onChangeIsMobile(this.checked);
		});
		$('#LocationIsMobile').trigger('change');
		editObj.locationAutocomplete();
		// Initialize the "Special Announcements" section.
		// Coupon Library is currently only available to CQ Premier clinics
		editObj.initSpecialAnnouncements();
	},
	selectImport: function(importId) {
		$('div.import').hide();
		$('div.import[import=' + importId + ']').show();
	},
	selectCqpImport: function(cqpImportId) {
		$('div.cqpImport').hide();
		$('div.cqpImport[import=' + cqpImportId + ']').show();
	},
	addVideoRow: function(obj) {
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
	},
	removeVideoRow: function(obj) {
		var row = $(obj).parents('tr');
		var key = $(obj).data('key');
		$("#LocationVideo"+key+"VideoUrl").val('');
		row.hide();
	},
	removePhotoRow: function(obj, type) {
		var row = $(obj).parents('tr');
		var key = $(obj).data('key');
		if(type === "photo") {
			$("#LocationPhoto"+key+"PhotoUrl").val('');
			if ($("#LocationPhoto"+key+"File").get(0) !== undefined) {
				$("#LocationPhoto"+key+"File").get(0).value = "";
			}
			row.hide();
		}
		if(type === "logo"){
			$("#LocationLogo0Url").val('');
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
			this.initSpecialAnnouncements();
		}
	},
	onChangeFileInput: function(obj) {
		var id = obj.id;
		var row = $('#'+id).parents('tr');
		var keyMatch = id.match(/LocationPhoto|LocationLogo|Provider(\d+)(.+)/);
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
			if(keyMatch[0] == "LocationLogo0Url") {
				$("#photo-add-error-logo").show();
			} else if(keyMatch[0].match(/Provider/)) {
				$("#provider-photo-add-error-"+key).show();
			} else {
				$("#photo-add-error-"+key).show();
			}
			$(".form-actions input").attr("disabled","disabled");
			return false;
		} else {
			// Remove the error style from the input and enable submit button
			$(obj).css('background', '');
			$(".form-actions input").removeAttr("disabled");
			for(var i = 0;i < $(".help-block.text-danger[style='']").length;i++){
				$(".help-block.text-danger[style='']").eq(i).hide();
			}
			$("help-block text-danger").hide();
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
	},
	onChangeLocationAdFile: function(obj) {
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
			$(".form-actions input").attr("disabled","disabled");
			return false;
		} else {
			$(".form-actions input").removeAttr("disabled");
			// Remove the error style from the input
			$('#LocationAdPhotoUrl').css('background', '');
			$("#location-ad-error").hide();
		}
	},
	addLink: function(locationId, key) {
		var editObj = this;
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
					editObj.locationAutocomplete();
				}
			},
			error: function(data, textStatus) {
				$(newLink).css('background', 'rgba(200,100,100,.5)');
				$("#link-error-"+key).html('Error. Unable to add linked location.');
				$("#link-error-"+key).show();
			},
		});
	},
	deleteLink: function(obj) {
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
	},
	onChangeDirectBookType: function(directBookType) {
		if ((directBookType == 'Blueprint') || (directBookType == 'EarQ')) {
			$('#direct-book-links').show();
		} else {
			$('#direct-book-links').hide();
		}
	},
	onChangeIsListingTypeFrozen: function(isListingTypeFrozen) {
		if (isListingTypeFrozen) {
			$('#frozen-expiration').show();
			$('#LocationFrozenExpiration').prop("required", true);
		} else {
			$('#LocationFrozenExpiration').prop("required", false);
			$('#frozen-expiration').hide();
		}
	},
	onChangeFeatureContentLibrary: function(isFeatureContentLibary) {
		if (isFeatureContentLibary) {
			$('#content-library-expiration').show();
			$('#LocationContentLibraryExpiration').prop("required", true);
		} else {
			$('#LocationContentLibraryExpiration').prop("required", false);
			$('#content-library-expiration').hide();
		}
	},
	onChangeFeatureSpecialAnnouncement: function(isFeatureSpecialAnnouncement) {
		if (isFeatureSpecialAnnouncement) {
			$('#special-announcement-expiration').show();
			$('#LocationSpecialAnnouncementExpiration').prop("required", true);
		} else {
			$('#LocationSpecialAnnouncementExpiration').prop("required", false);
			$('#special-announcement-expiration').hide();
		}
	},
	onChangeIsMobile: function(isMobile) {
		if (isMobile) {
			$('#radius').show();
			$('#LocationRadius').prop("required", true);
		} else {
			$('#LocationRadius').prop("required", false);
			$('#radius').hide();
		}
	},
	locationAutocomplete: function() {
		var editObj = this;
		var locationId = $("input.linked-location").data('id');
		var key = $("input.linked-location").data('key');
		$("input.linked-location").autocomplete({
			source: "/caautocomplete",
			minLength: "2",
			select: function(event, ui){
				if (ui.item.id) {
					$("#LocationLinkedLocationId").val(ui.item.id);
					editObj.addLink(locationId, key);
				}
			}
		});
	},
	initSpecialAnnouncements: function() {
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
	},
	scrollTo: function(selector, offset) {
		offset = offset || 90;
		if ($(selector)) {
			$('html,body').animate({scrollTop: $(selector).offset().top - offset});
			return true;
		}
		return false;
	},
	chooseOwnCoupon: function() {
		$('#couponLibrary').hide();
		$('#couponSelected').hide();
		$('#uploadCoupon').show();
		this.scrollTo("#specialAnnouncements");
	},
	showCouponLibrary: function() {
		$('#couponLibrary').show();
		$('#couponSelected').hide();
		$('#uploadCoupon').hide();
		this.scrollTo("#specialAnnouncements");
	},
	addCoupon: function(obj) {
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
		this.scrollTo("#specialAnnouncements");
	},
	onClickHoursClosed: function(obj) {
		//Populate Hours when user selects/deselects the "closed" button
		var day = $(obj).data("day");
		if ($(obj).is(":checked")) {
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
	},
	onChangeIsClosedLunch: function(isClosedLunch) {
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
	}
};

locationsAdminEdit.init();

//EarQ 4y toggle switch
$("#LocationIsEarq4y, .provider .checkbox label input").after("<span class='slider' style='margin-left:265px'></span>");

//ida checkbox toggle switch
$("#LocationIsIdaVerified, .provider .checkbox label input").after("<span class='slider' style='margin-left:235px'></span>");
$('.provider .checkbox .ida-verified').before('<label class="col col-md-3 pr30 control-label"><strong>Ida verified provider</strong></label>');
$('.provider .checkbox .show-npi').before('<label class="col col-md-3 pr30 control-label"><strong>Show NPI number</strong></label>');
$('.provider .checkbox .show-license').before('<label class="col col-md-3 pr30 control-label"><strong>Show licenses</strong></label>');

//special announcement border selection
$(".border-radio").on("click",function(){
	$(".selected-border").removeClass("selected-border");
	$(this).addClass("selected-border");
})

//Vidscrip validation
$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").on("blur",function(){
	if($("#LocationVidscripsVidscrip").val() == "" && $("#LocationVidscripsEmail").val() == ""){
		$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").prop("required",false);
	} else {
		$("#LocationVidscripsVidscrip, #LocationVidscripsEmail").prop("required",true);
	}
})

//Prevent enter button from submitting form in inputs
$("input").on("keydown", function(e){
	if(e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});
