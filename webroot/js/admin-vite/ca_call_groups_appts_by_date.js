import "./admin_common";

const buttons = document.querySelectorAll('[data-toggle="buttons"] .btn');

buttons.forEach(button => {
  button.addEventListener("click", function () {
    let activeBtn = document.querySelector('[data-toggle="buttons"] .btn.active');
    activeBtn.classList.remove("active");
    this.classList.add("active");
  });
});