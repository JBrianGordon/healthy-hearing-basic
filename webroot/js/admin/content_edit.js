import './admin_common';
import './nav_tabs';
import './ckeditor';

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
		
		$('.datepicker_future').datepicker({
			//dateFormat: 'yy-mm-dd',
			dateFormat: 'mm/dd/yy',
			minDate: new Date(Date.now()+24*60*60*1000)
		});
		
		$(".datepicker").datepicker();
		
});