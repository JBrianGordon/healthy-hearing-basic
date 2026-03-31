import './admin_common';

const exportBtnClick = (): void => {
  const countElement = document.getElementById("count");
  const exportUrlElement = document.getElementById("exportUrl");

  if (!countElement || !exportUrlElement) {
    console.error("Required elements not found");
    return;
  }

  const count = parseInt(countElement.innerHTML, 10);
  const exportUrl = exportUrlElement.innerHTML;

  if (count < 100000) {
    // Small file. Download immediately.
    if (confirm(`Downloading export file with ${count} entries. This may take up to 30 seconds. Stay on this page until download is complete.`)) {
      window.location.replace(exportUrl);
    }
  } else {
    // Large file
    // TODO - Large files take over 30 seconds and page times out. Send to queue when queue is working.
    alert("Export is too large. Please narrow your results to 100,000 or less.");
  }
};

const exportBtn = document.getElementById("exportBtn");

if (exportBtn) {
  exportBtn.addEventListener("click", exportBtnClick);
}