import './common';

const copyButton = document.querySelector<HTMLButtonElement>("#copyLink");

if (copyButton !== null) {
  copyButton.addEventListener("click", () => {
    const textToCopy = copyButton.value || '';

    if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
      navigator.clipboard.writeText(textToCopy)
        .then(() => {
          copyButton.innerHTML = "Copied!";
          copyButton.classList.add("btn-success");
          copyButton.classList.remove("btn-light");
        })
        .catch((error: Error) => {
          console.error("Failed to copy text: ", error);
        });
    } else {
      //NOTE: Clipboard functionality does not work locally as it requires HTTPS
      console.error("Clipboard API not supported in this browser. HTTPS is required.");
    }
  });
}