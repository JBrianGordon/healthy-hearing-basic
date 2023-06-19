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

$(document).ready(function() {
	/*** TODO: uncomment when CKEditor updated: ***
	toggleContentShow(document.querySelector('#type').value);*/
	document.addEventListener('change', (event) => {
	  if (event.target.matches('#type')) {
	    toggleContentShow(event.target.value);
	  }
	});

	document.addEventListener('click', (event) => {
	  if (event.target.matches('#facebook-image-width-override')) {
	    if (event.target.checked) {
	      document.querySelector('#facebook-image-width').removeAttribute('required');
	      document.querySelector('#facebook-image-width').parentElement.parentElement.classList.remove('required');
	    } else {
	      document.querySelector('#facebook-image-width').setAttribute('required', 'required');
	      document.querySelector('#facebook-image-width').parentElement.parentElement.classList.add('required');
	    }
	  } else if (event.target.matches('#ApproveLink')) {
	    document.querySelector('#facebook-image-width').removeAttribute('required');
	    document.querySelector('#facebook-image-width').parentElement.parentElement.classList.remove('required');
	  }
	});

	document.addEventListener('change', (event) => {
	  if (event.target.matches('#date')) {
	    document.querySelector('#last-modified').value = document.querySelector('#date').value;
	  } else if (event.target.matches('#last-modified')) {
	    if (document.querySelector('#date').value === '') {
	      document.querySelector('#date').value = document.querySelector('#last-modified').value;
	    }
	  }
	});
	/*** TODO: Check if this code still relevant after CKEditor updated (same with datepicker code at bottom): ***
		if($('#is-active').prop('checked')) {
			//active is checked, is this a draft???
			if($('#id_draft_parent').val() > 0) {
				//yep, it's a draft.
				$("datepicker_future").datepicker({
					minDate: new Date(Date.now()+24*60*60*1000)
				});
			}
		}
		$(document).on("change", "#is-active", function() {
			if($('#id_draft_parent').val() > 0) {
				$('.datepicker_future').datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
			}
		});*/
		/***TODO: rewrite this when CKEditor updated: ***
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
		});*/
		
		$('.datepicker_future').datepicker({
			//dateFormat: 'yy-mm-dd',
			dateFormat: 'mm/dd/yy',
			minDate: new Date(Date.now()+24*60*60*1000)
		});
		
		$(".datepicker").datepicker();
		
});