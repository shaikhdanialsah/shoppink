//DOM Elements
const circles = document.querySelectorAll(".circle"),
  progressBar = document.querySelector(".indicator");
  statusOrder =document.getElementById("status").innerHTML;

if(statusOrder=="Waiting for seller to approve")
{
    currentStep=0;
}
else if(statusOrder=="Delivering")
{
    currentStep=1;
} else
{
    currentStep=2;
}

function updateProgressBar() {
    progressBar.style.width = `${((currentStep - 1) / (circles.length - 1)) * 100}%`;
}

// Call this function to animate the progress bar width
function animateProgressBar() {
    currentStep++;
    updateProgressBar();
}

// Simulate the progress bar animation
setTimeout(animateProgressBar, 80); // Adjust timing as needed

