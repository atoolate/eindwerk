document.addEventListener("DOMContentLoaded", () => {
    const accountCreated = document.getElementById("account-created");
    const loginPage = document.querySelector(".login");
    const popup = document.getElementById("popup");

    if (accountCreated && accountCreated.value === "true") {
        loginPage.style.display = "none"; // Hide the entire login page
        popup.style.display = "block"; // Show the popup
        setTimeout(() => {
            window.location.href = "login.php"; // Redirect to login page after 3 seconds
        }, 3000); // 3 seconds delay
    }
});