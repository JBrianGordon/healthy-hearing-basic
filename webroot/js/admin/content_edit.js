import './admin_common';
import './nav_tabs';
import './ckpackage';

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
	//toggleContentShow(document.querySelector('#type').value);

	document.addEventListener('change', e => {
	  if (e.target.matches('#type')) {
	    toggleContentShow(event.target.value);
	  }
	});

	document.addEventListener('click', e => {
	  if (e.target.matches('#facebook-image-width-override')) {
	    if (e.target.checked) {
	      document.querySelector('#facebook-image-width').removeAttribute('required');
	      document.querySelector('#facebook-image-width').parentElement.parentElement.classList.remove('required');
	    } else {
	      document.querySelector('#facebook-image-width').setAttribute('required', 'required');
	      document.querySelector('#facebook-image-width').parentElement.parentElement.classList.add('required');
	    }
	  } else if (e.target.matches('#ApproveLink')) {
	    document.querySelector('#facebook-image-width').removeAttribute('required');
	    document.querySelector('#facebook-image-width').parentElement.parentElement.classList.remove('required');
	  }
	});

	document.addEventListener('change', e => {
	  if (e.target.matches('#date')) {
	    document.querySelector('#last-modified').value = document.querySelector('#date').value;
	  } else if (e.target.matches('#last-modified')) {
	    if (document.querySelector('#date').value === '') {
	      document.querySelector('#date').value = document.querySelector('#last-modified').value;
	    }
	  }
	});
		
		$('.datepicker_future').datepicker({
			//dateFormat: 'yy-mm-dd',
			dateFormat: 'mm/dd/yy',
			minDate: new Date(Date.now()+24*60*60*1000)
		});
		
		$(".datepicker").datepicker();
		
});

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

document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'ContentDate') {
        document.getElementById('ContentLastModified').value = e.target.value;
    }
});

document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'ContentLastModified') {
        if (document.getElementById('ContentDate').value === '') {
            document.getElementById('ContentDate').value = e.target.value;
        }
    }
});


document.addEventListener('DOMContentLoaded', () => {
    setupImageUpload('facebook-imageUpload0', '#facebook-imagePreview0');
});