import './common';

const copyButton = document.querySelector("#copyLink");

if (copyButton !== null) {
  copyButton.addEventListener("click", () => {
    navigator.clipboard.writeText(copyButton.value)
      .then(() => {
        copyButton.innerHTML = "Copied!";
        copyButton.classList.add("btn-success");
        copyButton.classList.remove("btn-light");
      })
      .catch((error) => {
        console.error("Failed to copy text: ", error);
      });
  });
}