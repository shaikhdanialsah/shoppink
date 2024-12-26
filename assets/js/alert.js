document.addEventListener('DOMContentLoaded', function() {
  var alert = document.getElementById('alert').innerText;
  var toast = document.querySelector(".toast");
  var closeIcon = document.querySelector(".close");
  var progress = document.querySelector(".progress");

  let timer1, timer2;

    if (alert === 'add') {
        document.getElementById('toastMessage').innerHTML = "Item added to cart";
        showToast();
    }
    else if (alert === 'register') {
        document.getElementById('toastMessage').innerHTML = "You have succesfully registered";
        showToast();
    }
     else if (alert === 'delete') {
        document.getElementById('toastMessage').innerHTML = "Item removed from cart";
        showToast();
    } else if (alert === 'ordersuccess') {
        document.getElementById('toastMessage').innerHTML = "Your order was successful";
        showToast();
    } else if (alert === 'error') {
        document.getElementById('toastMessage').innerHTML = "Wrong email address or password";
        document.getElementById('toastTitle').innerHTML = "Login error";
        document.querySelector('.toast-content').classList.add('error');
        document.querySelector('.toast').classList.add('error');
        showToast();
    } else if (alert === 'success') {
        var name = document.getElementById('name').innerHTML;
        document.getElementById('toastMessage').innerHTML = "Welcome back, <span color:black><b>" + name + "</b></span>";
        showToast();
    } else if (alert === 'successlogout') {
        var name = document.getElementById('name').innerHTML;
        document.getElementById('toastMessage').innerHTML = "You have been logged out";
        showToast();
    } else if (alert === 'save') {
        var name = document.getElementById('name').innerHTML;
        document.getElementById('toastMessage').innerHTML = "Edit successful";
        showToast();
    }
    else if (alert === 'subscription') {
        var name = document.getElementById('name').innerHTML;
        document.getElementById('toastMessage').innerHTML = "You have successfully purchased a subscription";
        showToast();
    }

  closeIcon.addEventListener("click", () => {
      hideToast();
      clearTimeout(timer1);
      clearTimeout(timer2);
  });

  function showToast() {
      toast.classList.add("active");
      progress.classList.add("active");
      toast.style.display = "block";

      timer1 = setTimeout(() => {
          hideToast();
      }, 3000); // 3s = 3000 milliseconds

      timer2 = setTimeout(() => {
          progress.classList.remove("active");
          toast.style.display = "none"; // Hide the toast when user clicks close icon
      }, 3300); // 3.3s = 3300 milliseconds
  }

  function hideToast() {
      toast.classList.remove("active");

      setTimeout(() => {
          progress.classList.remove("active");
          toast.style.display = "none"; // Hide the toast when user clicks close icon
      }, 300);
  }

  if (history.replaceState) {
      let url = new URL(window.location);
      url.searchParams.delete("alert");
      history.replaceState(null, "", url);
  }
});