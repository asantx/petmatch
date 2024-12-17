
// Helper function to validate email
function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
  }
  
  // Validation for Login Form
  function validateLoginForm(event) {
    event.preventDefault(); // Prevent form submission
  
    const email = document.getElementById("login-email").value.trim();
    const password = document.getElementById("login-password").value.trim();
    const errorDiv = document.getElementById("login-error");
  
    if (!email || !password) {
      errorDiv.textContent = "All fields are required.";
      errorDiv.style.color = "red";
      return false;
    }
  
    if (!validateEmail(email)) {
      errorDiv.textContent = "Please enter a valid email address.";
      errorDiv.style.color = "red";
      return false;
    }
  
    errorDiv.textContent = "Login successful!";
    errorDiv.style.color = "green";
  
    // Simulate submission (replace with AJAX call if needed)
    console.log({ email, password });
    return true;
  }
  
  // Validation for Register Form
  function validateRegisterForm(event) {
    event.preventDefault(); // Prevent form submission
  
    const name = document.getElementById("register-name").value.trim();
    const email = document.getElementById("register-email").value.trim();
    const password = document.getElementById("register-password").value.trim();
    const errorDiv = document.getElementById("register-error");
  
    if (!name || !email || !password) {
      errorDiv.textContent = "All fields are required.";
      errorDiv.style.color = "red";
      return false;
    }
  
    if (!validateEmail(email)) {
      errorDiv.textContent = "Please enter a valid email address.";
      errorDiv.style.color = "red";
      return false;
    }
  
    if (password.length < 6) {
      errorDiv.textContent = "Password must be at least 6 characters.";
      errorDiv.style.color = "red";
      return false;
    }
  
    errorDiv.textContent = "Registration successful!";
    errorDiv.style.color = "green";
  
    // Simulate submission (replace with AJAX call if needed)
    console.log({ name, email, password });
    return true;
  }
  
  // Attach event listeners to forms
  document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
  
    if (loginForm) {
      loginForm.addEventListener("submit", validateLoginForm);
    }
  
    if (registerForm) {
      registerForm.addEventListener("submit", validateRegisterForm);
    }
  });
  
  // Smooth scrolling for navigation
document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll("a.nav-link");
  
    links.forEach(link => {
      link.addEventListener("click", event => {
        const targetId = link.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);
  
        if (targetElement) {
          event.preventDefault();
          targetElement.scrollIntoView({ behavior: "smooth" });
        }
      });
    });
  });

  // Dynamic rotating text in hero section
document.addEventListener("DOMContentLoaded", () => {
    const phrases = ["Adopt a Pet Today!", "Give Love, Get Love!", "Your New Best Friend Awaits!"];
    const heroHeading = document.querySelector(".hero-heading");
    let index = 0;
  
    if (heroHeading) {
      setInterval(() => {
        heroHeading.textContent = phrases[index];
        index = (index + 1) % phrases.length;
      }, 3000); // Change text every 3 seconds
    }
  });

  // Highlight feature cards on hover
document.addEventListener("DOMContentLoaded", () => {
    const featureCards = document.querySelectorAll(".feature-card");
  
    featureCards.forEach(card => {
      card.addEventListener("mouseenter", () => {
        card.classList.add("highlight");
      });
  
      card.addEventListener("mouseleave", () => {
        card.classList.remove("highlight");
      });
    });
  });

  
  // Confirmation alert on successful actions
function showConfirmation(message) {
    alert(message);
  }
  
  // Example usage in validation
  // Replace `console.log` calls in validation functions with `showConfirmation`

  
  