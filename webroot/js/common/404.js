function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

var mainPanel = document.getElementsByClassName("col-md-12 mt20")[0],
	sidePanel = document.getElementsByClassName("col-md-3 noprint")[0],
	sliderPanel = document.getElementById("hh-sticky-panel");

//remove slider panel from 404 pages
if(sliderPanel) {
	sliderPanel.remove();
}

mainPanel.classList.remove("col-md-12");
mainPanel.classList.add("col-md-9","panel-parent");
insertAfter(sidePanel, mainPanel);
sidePanel.setAttribute("style", "margin-top:20px");
