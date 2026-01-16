function insertAfter(el: HTMLElement, referenceNode: HTMLElement): void {
    if (referenceNode.parentNode) {
        referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
    }
}

const mainPanel = document.getElementsByClassName("col-md-12 mt20")[0] as HTMLElement;
const sidePanel = document.getElementsByClassName("col-md-3 noprint")[0] as HTMLElement;
const sliderPanel = document.getElementById("hh-sticky-panel");

// Remove slider panel from 404 pages
if (sliderPanel) {
    sliderPanel.remove();
}

if (mainPanel && sidePanel) {
    mainPanel.classList.remove("col-md-12");
    mainPanel.classList.add("col-md-9", "panel-parent");
    insertAfter(sidePanel, mainPanel);
    sidePanel.setAttribute("style", "margin-top:20px");
}