import './admin_common';

document.addEventListener("DOMContentLoaded", function() {
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

const searchButton = document.querySelector(".me-3.btn-primary.btn");
const advSearchForm = document.querySelector("#advanced_search form");

advSearchForm.appendChild(searchButton);
