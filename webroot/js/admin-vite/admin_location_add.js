import './admin_common';

const init = () => {
	const addObj = this;
	document.getElementById('submitBtn').addEventListener('click', function() {
	  addObj.disableSubmit(this);
	});
}
const disableSubmit = btn => {
	if (btn.disabled) {
	  return false;
	}
	btn.disabled = true;
	btn.closest('form').submit();
	console.log('form submitted.');
}

init();

// Change title and subtitle labels (US only)
if (document.querySelector("meta[name='application-name']").getAttribute("content") === "Healthy Hearing") {
  document.querySelector("label[for='ImportLocationTitle']").innerHTML = "Practice Name";
  document.querySelector("label[for='ImportLocationSubtitle']").innerHTML = "Location Name";
}