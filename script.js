
// Navbar handling 


 // Navbar hamburger menu
    function toggleMenu() {
      var links = document.getElementById('navbarLinks');
      var menu = document.getElementById('navbarMenu');
      links.classList.toggle('open');
      menu.classList.toggle('open');
    }
    // Animated underline - mark active link on click
    document.querySelectorAll('.navbar-link').forEach(link => {
      link.addEventListener('click', function() {
        document.querySelectorAll('.navbar-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        // For mobile, auto-close the menu on link click
        document.getElementById('navbarLinks').classList.remove('open');
        document.getElementById('navbarMenu').classList.remove('open');
      });
    });

// Navbar ends here 

// script for character counter in textarea 


var textarea = document.getElementById("message");
var counter = document.getElementById("char-count");

if (textarea && counter) {
  textarea.addEventListener("input", () => {
    const length = textarea.value.length;
    const maxAttr = textarea.getAttribute("maxlength");
    const max = maxAttr ? parseInt(maxAttr, 10) : 0;
    counter.textContent = max ? `${length} / ${max}` : `${length}`;

    if (max && length > max * 0.9) {
      counter.style.color = "red";
    } else {
      counter.style.color = "green";
    }
    if (length == 0) {
      counter.style.color = "white";
    }
  });
}

// display dynamically Highlight tabs 

document.addEventListener("DOMContentLoaded", function() {
  var links = document.querySelectorAll('.navbar-link');
  var currentUrl = window.location.pathname;

  links.forEach(function(link) {
    if (link.pathname === currentUrl) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
});