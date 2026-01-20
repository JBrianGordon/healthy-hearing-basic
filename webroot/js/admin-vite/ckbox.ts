// CKBox modal creation if class #facebook-imageUpload0 or #logo-imageUpload0 element exists

interface CKBoxAsset {
  data: {
    url: string;
    name: string;
    metadata: {
      width: number;
      height: number;
    };
  };
}

interface CKBoxConfig {
  tokenUrl: string;
  dialog: {
    width: number;
    height: number;
    onClose: () => void;
  };
  assets: {
    onChoose: (assets: CKBoxAsset[]) => void;
  };
}

declare module 'global' {
  global {
    interface Window {
      CKBox: {
        mount: (element: HTMLElement, config: CKBoxConfig) => void;
      };
    }
  }
}

const logoImagePathInput = document.getElementById("logo-imageUpload0") as HTMLInputElement | null;
const logoImageUrl = document.getElementById("logoUrl") as HTMLInputElement | null;
const logoImagePreview = document.getElementById("logo-imagePreview0") as HTMLImageElement | null;
const facebookImagePathInput = document.getElementById("facebook-imageUpload0") as HTMLInputElement | null;
const facebookImageUrl = document.getElementById("facebookImageUrl") as HTMLInputElement | null;
const facebookImagePreview = document.getElementById("facebook-imagePreview0") as HTMLImageElement | null;

// Function to adjust input width
function adjustInputWidth(inputElement: HTMLInputElement): void {
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
function mountCKBox(
  inputElement: HTMLInputElement,
  previewElement: HTMLImageElement,
  urlElement: HTMLInputElement,
  widthElement: HTMLInputElement | null = null,
  heightElement: HTMLInputElement | null = null,
  minWidth: number | null = null
): void {
  inputElement.addEventListener('click', (e: MouseEvent) => {
    e.preventDefault();
    const ckTokenUrl = `${window.location.origin}/endpoints/ckeditor-endpoint`;

    const ckboxDiv = document.createElement('div');
    const firstContainer = document.querySelector<HTMLElement>(".site-body > .row > .container");

    if (!firstContainer) {
      console.error('Container not found for CKBox mount');
      return;
    }

    ckboxDiv.id = 'ckbox';
    firstContainer.appendChild(ckboxDiv);

    window.CKBox.mount(ckboxDiv, {
      tokenUrl: ckTokenUrl,
      dialog: {
        width: 700,
        height: 500,
        onClose: () => {
          ckboxDiv.remove();
        }
      },
      assets: {
        onChoose: (assets: CKBoxAsset[]) => {
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
              if (widthElement) widthElement.value = assetWidth.toString();
              if (heightElement) heightElement.value = assetHeight.toString();

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
if (facebookImagePathInput && facebookImagePreview && facebookImageUrl) {
  const facebookImageWidth = document.getElementById("facebook-image-width") as HTMLInputElement | null;
  const facebookImageHeight = document.getElementById("facebook-image-height") as HTMLInputElement | null;
  mountCKBox(facebookImagePathInput, facebookImagePreview, facebookImageUrl, facebookImageWidth, facebookImageHeight, 800);
}

// Mount CKBox for Logo elements if they exist
if (logoImagePathInput && logoImagePreview && logoImageUrl) {
  const logoImageWidth = document.getElementById("logo-image-width") as HTMLInputElement | null;
  const logoImageHeight = document.getElementById("logo-image-height") as HTMLInputElement | null;
  mountCKBox(logoImagePathInput, logoImagePreview, logoImageUrl, logoImageWidth, logoImageHeight);
}