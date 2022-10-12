if(document.getElementById("cookieFooter")){
	let cookieFooter = document.getElementById("cookieFooter"),
		closeFooter = document.getElementById("closeFooter"),
		readMoreCookies = document.getElementById("readMoreCookies"),
		stickyFooter = document.getElementById('stickyFooter'),
		hiddenText = cookieFooter.querySelector(".hidden"),
		showCookieText = () => hiddenText.classList.remove("hidden"),
		removeCookieFooter = () => {
			document.cookie = "isCookieFooterClosed=1; path=/; secure";
			cookieFooter.remove();
		}
		
	closeFooter.addEventListener('click', removeCookieFooter);
	readMoreCookies.addEventListener('click', showCookieText);
}