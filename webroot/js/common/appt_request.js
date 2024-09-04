window.submitApptRequest = () => {
  const form = document.getElementById("CaCallApptRequestForm");
  if (form.reportValidity()) {
    const submitBtn = document.getElementById("apptRequestSubmitBtn");
    submitBtn.disabled = true;

    const formData = new FormData(form);
    const serializedData = new URLSearchParams(formData).toString();
    try {
      fetch("/ca-calls/ajax-appt-request", {
        method: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/x-www-form-urlencoded',
        },
        body: serializedData,
      })
      .then(response => response.json())
      .then(data => {
        submitBtn.disabled = false;
        
        if (data.success === true) {
          const apptRequestPanel = document.getElementById("apptRequestPanel");
          const apptRequestModal = document.getElementById("apptRequestModal");
          const modalThankYou = document.getElementById("apptRequestThankYouModal");
          const pageBody = document.getElementsByTagName("body");
          if (apptRequestPanel !== null) {
            if (apptRequestPanel.classList.contains("fixed")) {
              apptRequestPanel.classList.remove("fixed");
            }
            apptRequestPanel.style.display = "none";
          }
          if (apptRequestModal !== null) {
            apptRequestModal.style.display = "none";
          }
          if (modalThankYou !== null) {
            const closeModalButtons = modalThankYou.querySelectorAll("[data-dismiss='modal']");
            modalThankYou.classList.remove("fade");
            modalThankYou.style.display = "block";
            closeModalButtons.forEach(button => {
              button.addEventListener("click", () => {
                modalThankYou.remove();
                pageBody[0].classList.remove("modal-open");
              });
            });
          }
        } else {
          let errorMessage = "Error";
          if (data.errorMessage) {
            errorMessage = data.errorMessage;
          }
          document.getElementById("apptRequestSubmitErrorMessage").innerHTML = errorMessage;
          document.getElementById("apptRequestSubmitError").style.display = "block";
        }

        //TODO: Recaptcha
        //if (typeof grecaptcha !== "undefined" && typeof grecaptcha.reset === "function") {
        //  grecaptcha.reset();
        //}
      });
    } catch (error) {
      console.log('ajaxApptRequest error:');
      console.error(error);
      submitBtn.disabled = false;
    }
  }
};

//Highlight Appt req form on link click
if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
	const formLink = document.querySelector(".requestFormHighlight");
  const apptRequestPanel = document.querySelector("#apptRequestPanel");
  const expandContract = () => {
    apptRequestPanel.classList.toggle("contracted");
    apptRequestPanel.classList.toggle("expanded");
    setTimeout(() => {
      apptRequestPanel.classList.toggle("contracted");
      apptRequestPanel.classList.toggle("expanded");
    }, 500);
  };
  if (formLink != null) {
    formLink.addEventListener("click", expandContract);
  }
}

document.addEventListener("DOMContentLoaded", function() {
  const apptRequestBtns = document.querySelectorAll(".apptRequestBtn");
  const apptRequestPanel = document.getElementById("apptRequestPanel");
  var apptRequestThankYouModal = document.getElementById("apptRequestThankYouModal");
  var apptRequestModal = document.getElementById("apptRequestModal");

  function addSubmitListener() {
    const apptRequestSubmitBtn = document.getElementById("apptRequestSubmitBtn");
    apptRequestSubmitBtn.addEventListener('click', submitApptRequest);
  }

  function scrollToApptRequestPanel() {
    if (apptRequestPanel) {
      window.scrollTo({
        top: apptRequestPanel.offsetTop - 70,
        behavior: "smooth"
      });
    }
  }

  apptRequestBtns.forEach(btn => {
    btn.addEventListener("click", function() {
      const locationId = btn.dataset.id;
      if (locationId) {
        fetch("/locations/ajax_appt_request_modal/" + locationId)
          .then(response => response.text())
          .then(data => {
            document.getElementById("ajaxModals").innerHTML = data;
            apptRequestModal = document.getElementById("apptRequestModal");
            apptRequestThankYouModal = document.getElementById("apptRequestThankYouModal");
            if (apptRequestModal) {
              const closeModalButton = apptRequestModal.querySelector(".close");
              closeModalButton.addEventListener("click", function() {
                $("#apptRequestModal").modal('hide');
              });
              addSubmitListener();
              $("#apptRequestModal").modal("show");
            }
          })
          .catch(error => console.error(error));
      } else if (apptRequestPanel) {
        scrollToApptRequestPanel();
      } else if (apptRequestThankYouModal.style.display !== "none") {
        apptRequestPanel.classList.add("fixed");
        const closeModalButton = document.querySelector(".fixed .close");
        closeModalButton.addEventListener("click", function() {
          apptRequestPanel.classList.remove("fixed");
        });
      }
    });
  });

  if (apptRequestModal) {
    addSubmitListener();
  }
});
