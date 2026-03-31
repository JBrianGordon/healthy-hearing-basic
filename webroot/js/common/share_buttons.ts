document.addEventListener('DOMContentLoaded', () => {
    // Open facebook and twitter share links in a small window
    const facebookLink = document.querySelector < HTMLAnchorElement > ('#fbBtn a');
    const twitterButton = document.querySelector < HTMLAnchorElement > ('.twitter-share-button');

    function openInPopup(el: HTMLAnchorElement | null): void {
        if (el) {
            el.addEventListener('click', function (e: MouseEvent) {
                e.preventDefault();
                window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            });
        }
    }

    openInPopup(facebookLink);
    openInPopup(twitterButton);

    // Add href to Pinterest button for Lighthouse SEO
    const observer = new MutationObserver(function (mutations: MutationRecord[]) {
        const pinterestButton = document.querySelector < HTMLAnchorElement > ('.btn-pinterest');
        if (pinterestButton) {
            pinterestButton.href = '';
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    // Simulate click on lower share buttons when upper ones are clicked
    const facebookTopBtn = document.querySelector < HTMLElement > ('.btn-facebook.top-btn');
    const twitterTopBtn = document.querySelector < HTMLElement > ('.btn-twitter.top-btn');
    const linkedinTopBtn = document.querySelector < HTMLElement > ('.btn-linkedin.top-btn');
    const pinterestTopBtn = document.querySelector < HTMLElement > ('.btn-pinterest.top-btn');

    if (facebookTopBtn && facebookLink) {
        facebookTopBtn.addEventListener('click', () => {
            facebookLink.click();
        });
    }

    if (twitterTopBtn && twitterButton) {
        twitterTopBtn.addEventListener('click', () => {
            twitterButton.click();
        });
    }

    if (linkedinTopBtn) {
        linkedinTopBtn.addEventListener('click', () => {
            const linkedinWidget = document.querySelector < HTMLButtonElement > ('.IN-widget button');
            if (linkedinWidget) {
                linkedinWidget.click();
            }
        });
    }

    if (pinterestTopBtn) {
        pinterestTopBtn.addEventListener('click', () => {
            const pinterestBtn = document.querySelector < HTMLElement > ('.btn-pinterest[data-pin-href]');
            if (pinterestBtn) {
                pinterestBtn.click();
            }
        });
    }
});