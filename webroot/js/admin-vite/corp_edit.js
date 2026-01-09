import './admin_common';
import './nav_tabs';
import './ckpackage';

/*** TODO: update this code when view is built: ***
$(document).ready(function() {
	if($('#CorpIsActive').prop('checked')) {
		//active is checked, is this a draft???
		if($('#CorpDraftParentId').val() > 0) {
			//yep, it's a draft.
			$("datepicker_future").datepicker({
				minDate: new Date(Date.now()+24*60*60*1000)
			});
		}
	}
	$(document).on("change", "#CorpIsActive", function() {
		if($('#CorpDraftParentId').val() > 0) {
			$('.datepicker_future').datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
		}
	});
	$('.datepicker_future').datepicker({
		//dateFormat: 'yy-mm-dd',
		dateFormat: 'mm/dd/yy',
		minDate: new Date(Date.now()+24*60*60*1000)
	});
});*/

// Generic function to handle image upload preview
export function setupImageUpload(inputId, previewSelector) {
    const fileInput = document.getElementById(inputId);

    if (!fileInput) {
        console.error(`File input element with ID ${inputId} not found`);
        return;
    }

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        // Check if a file is selected
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function() {
            const output = document.querySelector(previewSelector);

            if (!output) {
                console.error(`Output element with selector ${previewSelector} not found`);
                return;
            }

            output.src = reader.result;
            output.style.display = 'block';
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupImageUpload('logo-imageUpload0', '#logo-imagePreview0');
    setupImageUpload('facebook-imageUpload0', '#facebook-imagePreview0');
});
