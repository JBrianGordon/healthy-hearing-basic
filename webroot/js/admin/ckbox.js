//CKBox modal creation if class ck-box element exists
if(document.querySelector('.ck-box') !== null) {
    document.querySelector('.ck-box').addEventListener('click', () => {
        const imagePathInput = document.getElementById("facebook-image");
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
                        console.log(asset);
                        imagePathInput.value = asset.getUrl();
                    });
                }
            }
        });
    });
}