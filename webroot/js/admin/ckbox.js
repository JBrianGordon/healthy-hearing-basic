//CKBox modal creation if class #facebook-imageUpload0 element exists
const imagePathInput = document.getElementById("facebook-imageUpload0");
const facebookImageUrl = document.getElementById("facebookImageUrl");
const imagePreview = document.getElementById("facebook-imagePreview0");

if (imagePathInput) {
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
                        const assetWidth = asset.data.metadata.width;
                        const assetHeight = asset.data.metadata.height;
                        const facebookImageWidth = document.getElementById("facebook-image-width");
                        const facebookImageHeight = document.getElementById("facebook-image-height");

                        if (assetWidth >= 800) {
                            imagePreview.src = assetUrl;
                            imagePreview.classList.remove('d-none');
                            imagePathInput.value = assetUrl;
                            imagePathInput.setAttribute('value', assetUrl);
                            imagePathInput.classList.remove('w-25');
                            facebookImageUrl.value = assetUrl;
                            facebookImageWidth.value = assetWidth;
                            facebookImageHeight.value = assetHeight;
                            facebookImageUrl.classList.remove('d-none');
                        } else {
                            alert(`The selected image must be at least 800px wide. This image is ${assetWidth}px wide.`);
                        }
                    });
                }
            }
        });
    });
}