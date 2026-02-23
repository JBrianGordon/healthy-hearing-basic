import "./admin_common";

const buttons = document.querySelectorAll<HTMLElement>('[data-toggle="buttons"] .btn');

buttons.forEach(button => {
  button.addEventListener("click", function (this: HTMLElement) {
    const activeBtn = document.querySelector<HTMLElement>('[data-toggle="buttons"] .btn.active');

    if (activeBtn) {
      activeBtn.classList.remove("active");
    }

    this.classList.add("active");
  });
});