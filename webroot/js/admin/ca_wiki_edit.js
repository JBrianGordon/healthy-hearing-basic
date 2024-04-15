import './admin_common';
import './nav_tabs';
import './ca_ckpackage';
//Leaving this largely alone due to use of datepicker
$(document).ready(function() {

	$(document).on('click', '#WikiFacebookImageBypass', function(e) {
		if ($('#WikiFacebookImageBypass').prop('checked')) {
			$('#WikiFacebookImageWidth').removeAttr('required');
			$('#WikiFacebookImageWidth').parent().parent().removeClass('required');
		} else {
			$('#WikiFacebookImageWidth').attr('required', 'required');
			$('#WikiFacebookImageWidth').parent().parent().addClass('required');
		}
	});
	$(document).on('click', '#ApproveLink', function(e) {
		$('#WikiFacebookImageWidth').removeAttr('required');
		$('#WikiFacebookImageWidth').parent().parent().removeClass('required');
	});
	if($('#WikiIsActive').prop('checked')) {
		//active is checked, is this a draft???
		if($('#WikiDraftParentId').val() > 0) {
			//yep, it's a draft.
			$("datepicker_future").datepicker({
				minDate: new Date(Date.now()+24*60*60*1000)
			});
		}
	}
	$(document).on("change", "#WikiIsActive", function() {
		if($('#WikiDraftParentId').val() > 0) {
			$('.datepicker_future').datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
		}
	});
	
	//Only allow one reviewer at a time
	var reviewerBoxes = document.getElementsByName("data[Reviewer][Reviewer][]");
    for (var i = 0; i < reviewerBoxes.length; i++) {
        reviewerBoxes[i].onclick = function () {
            for (var i = 0; i < reviewerBoxes.length; i++) {
                if (reviewerBoxes[i] != this && this.checked) {
                    reviewerBoxes[i].checked = false;
                }
            }
        };
    }
    
	$(document).on("click", ".ck_file_browser", function(event) {
		console.log("browser");
		CKFinder.setupCKEditor();
		CKFinder.basePath = '/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
		CKFinder.startupPath = "Images:/";
		CKFinder.resourceType = "Images";
		CKFinder.popup({
			chooseFiles: true,
			resizeImages: false,
			onInit: function( finder ) {
				finder.on( 'files:choose', function( evt ) {
					var file = evt.data.files.first(),
						output = document.getElementById('WikiFacebookImage'),
						span = document.getElementById('facebook_image_span');
						
						output.value = file.getUrl();
						span.innerHTML = file.getUrl();
						let fileUrl = $("#WikiFacebookImage").val();
						if (fileUrl != "") {
							$.ajax({
								url: "/admin/content/get_image_info",
								type: "POST",
								data: {
									uri: fileUrl
								},
								dataType: "json",
								success: function(data) {
									if (data.width) {
										$("#WikiFacebookImageWidth").val(data.width);
										$("#WikiFacebookImageHeight").val(data.height);
									} else {
										alert("Cannot find data for Facebook/Schema image. Please look in the Details tab to update.");
									}
								},
								error: function() {
									alert("Cannot find data for Facebook/Schema image. Please look in the Details tab to update.");
								}
							});
						}
				} );
			}
		});
	});
	
	$('.datepicker_future').datepicker({
		//dateFormat: 'yy-mm-dd',
		dateFormat: 'mm/dd/yy',
		minDate: new Date(Date.now()+24*60*60*1000)
	});
	
	$(".datepicker").datepicker();
    
});