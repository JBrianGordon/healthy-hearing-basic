//CKBox modal creation if class #facebook-imageUpload0 element exists
const imagePathInput = document.getElementById("facebook-imageUpload0");
const facebookImageUrl = document.getElementById("facebookImageUrl");
const imagePreview = document.getElementById("facebook-imagePreview0");

if(imagePathInput) {
    imagePathInput.addEventListener('click', e => {
        e.preventDefault();
        const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor_endpoint`;

    	const ckboxDiv = document.createElement('div');
    	const firstContainer = document.querySelector(".site-body > .row > .container");
    	ckboxDiv.id = 'ckbox';
    	firstContainer.appendChild(ckboxDiv);

        CKBox.mount(ckboxDiv, {
            tokenUrl: ckTokenUrl,
            dialog: {
                width: 700,
                height: 500,
                onClose: () => {
                    ckboxDiv.remove()
                }
            },
            assets: {
                onChoose: assets => {
                    assets.forEach(asset => {
                        const assetUrl = asset.data.url;
                        imagePreview.src = assetUrl;
                        imagePreview.classList.remove('d-none');
                        facebookImageUrl.innerHTML = assetUrl;
                        facebookImageUrl.classList.remove('d-none');
                    });
                }
            }
        });
    });
}