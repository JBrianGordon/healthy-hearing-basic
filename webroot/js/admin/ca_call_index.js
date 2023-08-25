import '../common/common';
import './search_toggle';

const exportBtnClick = () => {
  const count = document.querySelector('#hiddenCount').value;
  const exportUrl = document.querySelector('#hiddenExport').value;
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

document.getElementById("exportBtn").addEventListener("click", exportBtnClick);

document.addEventListener("DOMContentLoaded", function() {
  console.debug('ready');
  
  // Delete Button
  document.body.addEventListener("click", function(event) {
    if (event.target.matches("#deleteBtn")) {
      // The "delete" button was clicked. Display the confirmation modal.
      const callId = event.target.getAttribute("data-id");
      const callGroupId = event.target.getAttribute("data-group-id");
      document.querySelector("span#deleteCallBtn").innerHTML = `<a href="/admin/ca_calls/delete/${callId}" class="btn btn-danger">Delete Call</a>`;
      document.querySelector("span#deleteCallGroupBtn").innerHTML = `<a href="/admin/ca_call_groups/delete/${callGroupId}" class="btn btn-danger">Delete Call Group</a>`;
      document.querySelector("#delete-modal").modal("show");
    }
  });
});
