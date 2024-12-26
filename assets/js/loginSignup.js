// Toggle Form
const container = document.querySelector(".container");
const title = document.getElementById("title");
const inputs = document.querySelectorAll(".form-box input[type = 'password']");
const icons = [...document.querySelectorAll(".form-icon")];
const spans = [...document.querySelectorAll(".form-box .top span")];
const spanss = [...document.querySelectorAll(".form-box .bottom span")];
const section = document.querySelector("section");

spans.map((span) => {
  span.addEventListener("click", (e) => {
    const color = e.target.dataset.id;
    container.classList.toggle("active");
    section.classList.toggle("active");
    document.querySelector(":root").style.setProperty("--custom", color);
    document.getElementById("title").innerHTML="Shoppink | Register";
  });
});

spanss.map((span) => {
  span.addEventListener("click", (e) => {
    const color = e.target.dataset.id;
    container.classList.toggle("active");
    section.classList.toggle("active");
    document.querySelector(":root").style.setProperty("--custom", color);
    document.getElementById("title").innerHTML="Shoppink | Login";
  });
});

Array.from(inputs).map((input) => {
  icons.map((icon) => {
    icon.innerHTML = `<img src="/shoppink/assets/images/eye.svg" alt="" />`;

    icon.addEventListener("click", () => {
      const type = input.getAttribute("type");
      if (type === "password") {
        input.setAttribute("type", "text");
        icon.innerHTML = `<img src="/shoppink/assets/images/hide.svg" alt="" />`;
      } else if (type === "text") {
        input.setAttribute("type", "password");
        icon.innerHTML = `<img src="/shoppink/assets/images/eye.svg" alt="" />`;
      }
    });
  });
});

function checkValue() {
  var username = document.getElementById('email').value;
  var password = document.getElementById('password').value;
  var isValid = true;

  if (!username) {
      document.getElementById('emailError').innerHTML = "Email is required!";
      isValid = false;
  } else {
      document.getElementById('emailError').innerHTML = "&nbsp;";
  }

  if (!password) {
      document.getElementById('passwordError').innerHTML = "Password is required!";
      isValid = false;
  } else {
      document.getElementById('passwordError').innerHTML = "&nbsp;";
  }

  return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
const plans = document.querySelectorAll('.plan-card');
const radioButtons = document.querySelectorAll('.form-check-input');

radioButtons.forEach((radio) => {
radio.addEventListener('change', () => {
  plans.forEach((plan) => {
      plan.classList.remove('blue-text');
  });
  radio.closest('.plan-card').classList.add('blue-text');
});
});
});

document.addEventListener('DOMContentLoaded', function() {
  const phoneInput = document.getElementById('phoneInput');
  
  phoneInput.addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const nameInput = document.getElementById('nameInput');
  
  nameInput.addEventListener('input', function() {
      this.value = this.value.replace(/[0-9]/g, '');
  });
});
