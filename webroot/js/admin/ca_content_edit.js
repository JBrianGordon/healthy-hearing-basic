import './admin_common';
import './nav_tabs';
import './ca_ckpackage';

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