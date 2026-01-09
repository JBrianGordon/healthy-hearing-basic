// CKBox modal creation if class #facebook-imageUpload0 or #logo-imageUpload0 element exists
const logoImagePathInput = document.getElementById("logo-imageUpload0");
const logoImageUrl = document.getElementById("logoUrl");
const logoImagePreview = document.getElementById("logo-imagePreview0");
const facebookImagePathInput = document.getElementById("facebook-imageUpload0");
const facebookImageUrl = document.getElementById("facebookImageUrl");
const facebookImagePreview = document.getElementById("facebook-imagePreview0");

// Function to adjust input width
function adjustInputWidth(inputElement) {
    const tempSpan = document.createElement('span');
    tempSpan.style.visibility = 'hidden';
    tempSpan.style.whiteSpace = 'nowrap';
    tempSpan.style.font = window.getComputedStyle(inputElement).font;
    tempSpan.textContent = inputElement.value;

    document.body.appendChild(tempSpan);
    inputElement.style.width = `${tempSpan.offsetWidth + 70}px`;
    document.body.removeChild(tempSpan);
}

// Function to mount CKBox for a given input and preview (logos have min dimensions)
function mountCKBox(inputElement, previewElement, urlElement, widthElement = null, heightElement = null, minWidth = null) {
    inputElement.addEventListener('click', e => {
        e.preventDefault();
        const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor-endpoint`;

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
                    ckboxDiv.remove();
                }
            },
            assets: {
                onChoose: assets => {
                    assets.forEach(asset => {
                        const assetUrl = asset.data.url;
                        const assetName = asset.data.name;
                        const assetWidth = asset.data.metadata.width;
                        const assetHeight = asset.data.metadata.height;

                        // I.e., if logo with no min width or facebook image greater than or equal to min width
                        if (minWidth === null || assetWidth >= minWidth) {
                            previewElement.src = assetUrl;
                            previewElement.classList.remove('d-none');
                            inputElement.value = assetName;
                            inputElement.setAttribute('value', assetName);
                            inputElement.classList.remove('w-50');
                            urlElement.value = assetUrl;

                            // Only set width and height if the elements exist
                            if (widthElement) widthElement.value = assetWidth;
                            if (heightElement) heightElement.value = assetHeight;

                            urlElement.classList.remove('d-none');
                            adjustInputWidth(inputElement);
                        } else {
                            alert(`The selected image must be at least ${minWidth}px wide. This image is ${assetWidth}px wide.`);
                        }
                    });
                }
            }
        });
    });
}

// Mount CKBox for Facebook elements if they exist
if (facebookImagePathInput) {
    const facebookImageWidth = document.getElementById("facebook-image-width");
    const facebookImageHeight = document.getElementById("facebook-image-height");
    mountCKBox(facebookImagePathInput, facebookImagePreview, facebookImageUrl, facebookImageWidth, facebookImageHeight, 800);
}

// Mount CKBox for Logo elements if they exist
if (logoImagePathInput) {
    const logoImageWidth = document.getElementById("logo-image-width");
    const logoImageHeight = document.getElementById("logo-image-height");
    mountCKBox(logoImagePathInput, logoImagePreview, logoImageUrl, logoImageWidth || null, logoImageHeight || null);
}