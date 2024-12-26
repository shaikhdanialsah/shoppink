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

    