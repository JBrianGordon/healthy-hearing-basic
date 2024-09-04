//Add href to Pinterest button for Lighthouse SEO
document.addEventListener('DOMContentLoaded', () => {
    let observer = new MutationObserver(function(mutations) {
        let pinterestButton = document.querySelector('.btn-pinterest');
        if (pinterestButton) {
            pinterestButton.href = '';
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
});