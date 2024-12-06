document.addEventListener("DOMContentLoaded", () => {
        const accountCreated = document.getElementById("account-created");
        const form = document.getElementById("multi-step-form");
        const popup = document.getElementById("popup");

        if (accountCreated && accountCreated.value === "true") {
            form.style.display = "none"; // Hide the for
            popup.style.display = "block"; // Show the popup
            setTimeout(() => {
            }, 1000);
            setTimeout(() => {
                popup.style.display = "none"; // Hide the popup after 3 seconds
                window.location.href = "login.php"; // Redirect to login page
            }, 4000); // 3 seconds delay
        }
    });