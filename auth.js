const pass = document.getElementById("password");
const email = document.getElementById("email");
const butText = document.getElementById("togglePassword");
const toggle = () => {
    if (pass.type === "password") {
        pass.type = "text";
        butText.textContent = "Hide";
    } else {
        pass.type = "password";
        butText.textContent = "Show";
    }
}

