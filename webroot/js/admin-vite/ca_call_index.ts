import './admin_common';

import $ from 'jquery';

document.addEventListener("DOMContentLoaded", function () {
  // Delete Button
  document.body.addEventListener("click", function (event: MouseEvent) {
    const target = event.target as HTMLElement;

    if (target.matches("#deleteBtn")) {
      // The "delete" button was clicked. Display the confirmation modal.
      const callId = target.getAttribute("data-id");
      const callGroupId = target.getAttribute("data-group-id");

      const deleteCallBtn = document.querySelector<HTMLElement>("span#deleteCallBtn");
      const deleteCallGroupBtn = document.querySelector<HTMLElement>("span#deleteCallGroupBtn");
      const deleteModal = document.querySelector("#delete-modal") as any;

      if (deleteCallBtn && callId) {
        deleteCallBtn.innerHTML = `<a href="/admin/ca_calls/delete/${callId}" class="btn btn-danger">Delete Call</a>`;
      }

      if (deleteCallGroupBtn && callGroupId) {
        deleteCallGroupBtn.innerHTML = `<a href="/admin/ca_call_groups/delete/${callGroupId}" class="btn btn-danger">Delete Call Group</a>`;
      }

      if (deleteModal) {
        $(deleteModal).modal("show");
      }
    }
  });
});

const searchButton = document.querySelector<HTMLElement>(".me-3.btn-primary.btn");
const advSearchForm = document.querySelector<HTMLFormElement>("#advanced_search form");

if (searchButton && advSearchForm) {
  advSearchForm.appendChild(searchButton);
}