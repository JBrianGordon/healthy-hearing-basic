export function directBookBtn() {
  // Global variable for direct book clinic id
  let directBookClinicId = 0;

  const onMessage = e => {
    // Check sender origin to be trusted
    if (e.origin !== "https://booking.myearq.com") return;
    // Do not save appointment if no clinic id
    if (directBookClinicId == 0) return;
    if (e.data.func == "goThankYouAppointment") {
      fetch(`/ca_calls/ajax_add_earq_appt/${directBookClinicId}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
      })
        .then(response => response.json())
        .then(data => {
          if (data === "error") {
            console.log(`Failed to save EarQ appointment for ${directBookClinicId}`);
          }
          directBookClinicId = 0;
        })
        .catch(error => {
          console.log(`Failed to save EarQ appointment for ${directBookClinicId}`, error);
        });
    }
  };

  // Blueprint/EarQ direct book modal
  const directBookButtons = document.querySelectorAll('.directBookBtn');
  directBookButtons.forEach(button => {
    button.addEventListener('click', function() {
      directBookClinicId = this.getAttribute('data-button');
      const modalId = `#directBookModal-${directBookClinicId}`;
      const directBookBody = document.querySelector(`${modalId} .direct-book-body`);
      directBookBody.innerHTML = directBookBody.innerHTML.replace('<!--','').replace('-->','');
      const modal = document.querySelector(modalId);
      modal.modal("show");
      // Event listener for EarQ appointment confirmation
      window.addEventListener("message", onMessage, false);
    });
  });
}
