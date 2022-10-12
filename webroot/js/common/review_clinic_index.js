import './common';

const copyButton = document.querySelector("#copyLink");

if(copyButton != null){
	copyButton.addEventListener("click", function(){
		navigator.clipboard.writeText(copyButton.value);
		copyButton.innerHTML = "Copied!";
		copyButton.classList.add('btn-success');
		copyButton.classList.remove('btn-light');
	})
}