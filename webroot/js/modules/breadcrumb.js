//hide breadcrumb and show ellipses if breadcrumb text is too long on mobile
if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && document.getElementsByClassName("breadcrumb")[0] != undefined) {
    const chopBreadcrumb = () => {
        let breadCrumb = document.getElementsByClassName("breadcrumb")[0],
		    	breadCrumbWidth = breadCrumb.offsetWidth,
		    	ellipses = document.getElementById("ellipses");
		    
		    if(breadCrumbWidth > (window.innerWidth * 0.85)){
			    breadCrumb.setAttribute("style", "max-width:85vw");
			    ellipses.setAttribute("style", "display:inline-block");
		    } else {
			    breadCrumb.removeAttribute("style");
			    ellipses.removeAttribute("style");
		    }
	};
	
	chopBreadcrumb();
	
	window.addEventListener("orientationchange", () => {
		setTimeout( () => {
			chopBreadcrumb();
		}, 300)
	});
}

//Generate breadcrumb schema
const crumbsElements = document.querySelectorAll('.breadcrumb-item');
const itemList = [];

crumbsElements.forEach((crumbElement, position) => {
  const aElement = crumbElement.querySelector('a');
  if (aElement) {
    const url = aElement.getAttribute('href');
    const name = aElement.textContent;

    itemList.push({
      "@type": "ListItem",
      "position": (position + 1).toString(),
      "name": name,
      "item": url
    });
  }
});

const breadcrumbList = {
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": itemList
};

const ldJsonScript = document.createElement('script');
ldJsonScript.type = 'application/ld+json';
ldJsonScript.textContent = JSON.stringify(breadcrumbList);

document.head.appendChild(ldJsonScript);
