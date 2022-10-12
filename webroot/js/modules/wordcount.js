//Track character count in message box
let addCharCounter = (textElement, maxCharLength) => {
    let charLimit = null,
        textTarget = document.getElementById(textElement),
		infocus = false,
		charSpan = document.createElement("span");
		charSpan.setAttribute("id","charLimit");
	let	checkLength = () => {
		if (infocus) {
			charLimit = document.getElementById("charLimit");
			if (textTarget.value.length < maxCharLength) {
				if (charLimit.classList.contains('max-chars')) {
					charLimit.classList.remove('max-chars');
				}
				charLimit.innerHTML = maxCharLength-textTarget.value.length + " characters remaining";
				if (textTarget.value.length == 999){
					charLimit.innerHTML = "1 character remaining";
				}
			} else if (textTarget.value.length == maxCharLength) {
				charLimit.classList.add('max-chars');
				charLimit.innerHTML = "0 characters remaining";
			}
		}
	},
	insertAfter = (newNode, referenceNode) => {
	    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}
	insertAfter(charSpan, textTarget);
	textTarget.onfocus = () => {infocus = true;}
	textTarget.onblur = () => {infocus = false;};
	setInterval(checkLength, 100);
}

//pass textarea element id and max character count to function
if(document.getElementById('LocationCovid19Statement') != null){
	addCharCounter('LocationCovid19Statement', 400);
} else if(document.getElementById('ContactMessage') != null){
	addCharCounter('ContactMessage', 1000);
}