document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('alert').innerText;
    var toast = document.querySelector(".toast");
    var closeIcon = document.querySelector(".close");
    var progress = document.querySelector(".progress");
  
    let timer1, timer2;
  
      if (alert === 'success') 
        {
          document.getElementById('toastMessage').innerHTML = "Welcome, ADMIN";
          showToast();
        } 
      else if (alert === 'productEdit')
        {
            document.getElementById('toastMessage').innerHTML = "Update succesful";
            showToast();
        }
       else if (alert === 'verify')
            {
                document.getElementById('toastMessage').innerHTML = "Verification succesful";
                showToast();
            }
     else if (alert === 'delete')
            {
                document.getElementById('toastMessage').innerHTML = "Product succesfully deleted";
                showToast();
            }
    else if (alert === 'memberUpdate')
            {
                document.getElementById('toastMessage').innerHTML = "Customer's membership updated";
                showToast();
            }
    else if (alert === 'productAdd')
            {
                document.getElementById('toastMessage').innerHTML = "Product successfully added";
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