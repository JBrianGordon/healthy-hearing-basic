// Hide breadcrumb and show ellipses if breadcrumb text is too long on mobile
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
	const breadcrumbElement = document.getElementsByClassName("breadcrumb")[0] as HTMLElement | undefined;

	if (breadcrumbElement) {
		const chopBreadcrumb = (): void => {
			const breadCrumb = breadcrumbElement;
			const breadCrumbWidth = breadCrumb.offsetWidth;
			const ellipses = document.getElementById("ellipses");

			if (breadCrumbWidth > (window.innerWidth * 0.85)) {
				breadCrumb.setAttribute("style", "max-width:85vw");
				if (ellipses) {
					ellipses.setAttribute("style", "display:inline-block");
				}
			} else {
				breadCrumb.removeAttribute("style");
				if (ellipses) {
					ellipses.removeAttribute("style");
				}
			}
		};

		chopBreadcrumb();

		window.addEventListener("orientationchange", () => {
			setTimeout(() => {
				chopBreadcrumb();
			}, 300);
		});
	}
}