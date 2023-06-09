import './admin_common';
import './nav_tabs';

const toggleContentShow = (type) => {
	const fileElement = document.querySelector("#file");
	const textElement = document.querySelector("#text");
	
	fileElement.style.display = "none";
	textElement.style.display = "none";
	
	switch (type) {
		case "flv":
			fileElement.style.display = "block";
			break;
		default:
			textElement.style.display = "block";
			break;
	}
};

//Leaving this function alone, due to dependence on datepicker
$(document).ready(function() {
		toggleContentShow($('#ContentType').val());
		$(document).on('change', '#ContentType', function(){
				toggleContentShow(this.value);
		});

		$('#ContentCategoryId').trigger("change");

		$(document).on('click', '#ContentFacebookImageWidthOverride', function(e) {
			if($('#ContentFacebookImageWidthOverride').prop('checked')) {
				$('#ContentFacebookImageWidth').removeAttr('required');
				$('#ContentFacebookImageWidth').parent().parent().removeClass('required');
			}
			else {
				$('#ContentFacebookImageWidth').attr('required', 'required');
				$('#ContentFacebookImageWidth').parent().parent().addClass('required');
			}
		});
		$(document).on('click', '#ApproveLink', function(e) {
			$('#ContentFacebookImageWidth').removeAttr('required');
			$('#ContentFacebookImageWidth').parent().parent().removeClass('required');
		});
		$(document).on('change', '#ContentDate', function(e) {
			$('#ContentLastModified').val($('#ContentDate').val());
		});
		$(document).on('change', '#ContentLastModified', function(e) {
			if($('#ContentDate').val() == '') {
				$('#ContentDate').val($('#ContentLastModified').val());
			}

		});
		if($('#ContentIsActive').prop('checked')) {
			//active is checked, is this a draft???
			if($('#ContentDraftParentId').val() > 0) {
				//yep, it's a draft.
				$("datepicker_future").datepicker({
					minDate: new Date(Date.now()+24*60*60*1000)
				});
			}
		}
		$(document).on("change", "#ContentIsActive", function() {
			if($('#ContentDraftParentId').val() > 0) {
				$('.datepicker_future').datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
			}
		});
		
		$(document).on("click", ".ck_file_browser", function(event) {
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
							output = document.getElementById('ContentFacebookImage'),
							span = document.getElementById('facebook_image_span');
							
							output.value = file.getUrl();
							span.innerHTML = file.getUrl();
							let fileUrl = $("#ContentFacebookImage").val();
							if(fileUrl != "") {
								$.ajax({
									url: "/admin/content/get_image_info",
									type: "POST",
									data: {
										uri: fileUrl
									},
									dataType: "json",
									success: function(data) {
										if(data.width) {
											$("#ContentFacebookImageWidth").val(data.width);
											$("#ContentFacebookImageHeight").val(data.height);
										}
										else {
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