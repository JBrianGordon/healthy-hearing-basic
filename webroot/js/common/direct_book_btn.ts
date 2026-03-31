/*** TODO: check this on city page, there's likely more that needs to be updated in that ticket ***/
//import 'bootstrap-sass/assets/javascripts/bootstrap/modal';

export function directBookBtn(): void {
  // Global variable for direct book clinic id
  let directBookClinicId = 0;

  const onMessage = (e: MessageEvent): void => {
    // Check sender origin to be trusted
    if (e.origin !== "https://booking.myearq.com") return;
    // Do not save appointment if no clinic id
    if (directBookClinicId === 0) return;

    if (e.data.func === "goThankYouAppointment") {
      fetch(`/ca_calls/ajax_add_earq_appt/${directBookClinicId}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
      })
        .then(response => response.json())
        .then((data: string) => {
          if (data === "error") {
            console.log(`Failed to save EarQ appointment for ${directBookClinicId}`);
          }
          directBookClinicId = 0;
        })
        .catch((error: Error) => {
          console.log(`Failed to save EarQ appointment for ${directBookClinicId}`, error);
        });
    }
  };

  // Blueprint/EarQ direct book modal
  const directBookButtons = document.querySelectorAll<HTMLElement>('.directBookBtn');
  directBookButtons.forEach(button => {
    button.addEventListener('click', function () {
      const clinicId = button.dataset.button;
      const modalId = button.dataset.bsTarget;

      if (!modalId) return;

      // Remove comments from direct-book-body element
      const directBookBody = document.querySelector<HTMLElement>(`${modalId} .direct-book-body`);
      if (directBookBody) {
        directBookBody.innerHTML = directBookBody.innerHTML.replace('<!--', '').replace('-->', '');
      }

      const modalElement = document.querySelector<HTMLElement>(modalId);
      if (modalElement) {
        const modal = new (window as any).bootstrap.Modal(modalElement);
        modal.show();
      }

      // Update the outer scope variable
      if (clinicId) {
        directBookClinicId = parseInt(clinicId, 10);
      }

      // Event listener for EarQ appointment confirmation
      window.addEventListener("message", onMessage, false);
    });
  });
}