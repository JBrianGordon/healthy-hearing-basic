window.submitApptRequest = () => {
  const form = document.getElementById("CaCallApptRequestForm");
  if (form.reportValidity()) {
    const submitBtn = document.getElementById("apptRequestSubmitBtn");
    submitBtn.disabled = true;

    const formData = new FormData(form);
    const serializedData = new URLSearchParams(formData).toString();

    fetch("/ca_calls/appt_request", {
      method: "POST",
      body: serializedData,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      dataType: "json"
    })
      .then(response => response.json())
      .then(data => {
        submitBtn.disabled = false;
        
        if (data.success === true) {
          document.getElementById("apptRequestModal").style.display = "none";
          document.getElementById("apptRequestThankYouModal").style.display = "block";
        } else {
          let errorMessage = "Error";
          if (data.errorMessage) {
            errorMessage = data.errorMessage;
          }
          document.getElementById("apptRequestSubmitErrorMessage").innerHTML = errorMessage;
          document.getElementById("apptRequestSubmitError").style.display = "block";
        }

        if (typeof grecaptcha !== "undefined" && typeof grecaptcha.reset === "function") {
          grecaptcha.reset();
        }
      })
      .catch(error => {
        console.error(error);
        submitBtn.disabled = false;
      });
  }
};

window.onSubmit = e => {
  e.preventDefault();

  const appReqPanel = document.getElementById("apptRequestPanel");
  const modalThankYou = document.getElementById("apptRequestThankYouModal");
  const closeModalButtons = modalThankYou.querySelectorAll("[data-dismiss='modal']");
  const pageBody = document.getElementsByTagName("body");

  if (!grecaptcha.getResponse()) {
    grecaptcha.execute();
  }

  if (appReqPanel !== null && appReqPanel.classList.contains("fixed")) {
    appReqPanel.classList.remove("fixed");
  }

  modalThankYou.classList.remove("fade");

  closeModalButtons.forEach(button => {
    button.addEventListener("click", () => {
      modalThankYou.remove();
      pageBody[0].classList.remove("modal-open");
    });
  });
};

window.addSubmitListener = () => {
	const form = document.getElementById('CaCallApptRequestForm');
	form.addEventListener('submit', onSubmit);
}

//Highlight Appt req form on link click
if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
	const formLink = document.querySelector("#requestFormHighlight");
	const apptReqForm = document.querySelector("#apptRequestPanel");
	const expandContract = () => {
		  	apptReqForm.classList.toggle("contracted");
			apptReqForm.classList.toggle("expanded");
			setTimeout(() => {
				apptReqForm.classList.toggle("contracted");
				apptReqForm.classList.toggle("expanded");
			}, 500);
		  };
		  
	if(formLink != null) {
		formLink.addEventListener("click", expandContract);
	}
}

document.addEventListener("DOMContentLoaded", function() {
  const apptRequestBtns = document.querySelectorAll(".apptRequestBtn");
  const apptRequestPanel = document.getElementById("apptRequestPanel");
  const apptRequestThankYouModal = document.getElementById("apptRequestThankYouModal");
  const apptRequestModal = document.getElementById("apptRequestModal");

  function addSubmitListener() {
    // Add submit listener code here
  }

  function scrollToApptRequestModal() {
    if (apptRequestModal) {
      window.scrollTo({
        top: apptRequestModal.offsetTop - 70,
        behavior: "smooth"
      });
    }
  }

  apptRequestBtns.forEach(btn => {
    btn.addEventListener("click", function() {
      const locationId = this.getAttribute("data-id");

      if (locationId) {
        fetch("/locations/ajax_appt_request_modal/" + locationId)
          .then(response => response.text())
          .then(data => {
            document.getElementById("ajaxModals").innerHTML = data;
            if (apptRequestModal) {
              const closeModalButton = apptRequestModal.querySelector(".close");
              closeModalButton.addEventListener("click", function() {
                apptRequestPanel.classList.remove("fixed");
              });
              addSubmitListener();
              $("#apptRequestModal").modal("show");
            }
          })
          .catch(error => console.error(error));
      } else if (apptRequestPanel) {
        scrollToApptRequestModal();
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
