document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("register-link").addEventListener("click", function(event) {
        event.preventDefault();
        document.querySelector(".register-form").style.display = "block";
    });
});
