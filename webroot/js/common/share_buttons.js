document.addEventListener('DOMContentLoaded', () => {
    // Open facebook and twitter share links in a small window
    const facebookLink = document.querySelector('#fbBtn a');
    const twitterButton = document.querySelector('.twitter-share-button');

    function openInPopup(el) {
        if (el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            });
        }
    }

    openInPopup(facebookLink);
    openInPopup(twitterButton);

    //Add href to Pinterest button for Lighthouse SEO
    let observer = new MutationObserver(function(mutations) {
        let pinterestButton = document.querySelector('.btn-pinterest');
        if (pinterestButton) {
            pinterestButton.href = '';
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    // Simulate click on lower share buttons when upper ones are clicked
    document.querySelector('.btn-facebook.top-btn').addEventListener('click', () => {
        facebookLink.click();
    });
    document.querySelector('.btn-twitter.top-btn').addEventListener('click', () => {
        twitterButton.click();
    });
    document.querySelector('.btn-linkedin.top-btn').addEventListener('click', () => {
        document.querySelector('.IN-widget button').click();
    });
    document.querySelector('.btn-pinterest.top-btn').addEventListener('click', () => {
        document.querySelector('.btn-pinterest[data-pin-href]').click();
    });
});