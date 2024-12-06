document.addEventListener("DOMContentLoaded", () => {
    const step1 = document.getElementById("step-1");
    const step2 = document.getElementById("step-2");
    const nextButton = document.getElementById("next-button");
    const prevButton = document.getElementById("prev-button");
    const submitButton = document.getElementById("cta-complete");
    const errorDivStep1 = document.querySelector("#step-1 .error");
    const errorDivStep2 = document.querySelector("#step-2 .error");

    // Step 1: Validate and move to Step 2
    nextButton.addEventListener("click", () => {
        const firstName = document.getElementById("first_name").value.trim();
        const lastName = document.getElementById("last_name").value.trim();
        const email = document.getElementById("email").value.trim();

        // Validate Step 1 fields
        if (!firstName || !lastName || !email) {
            errorDivStep1.textContent = "We need more info. Please fill out all fields.";
            errorDivStep1.style.display = "block"; // Show error div
            return;
        }

        // Clear errors and go to Step 2
        errorDivStep1.textContent = "";
        errorDivStep1.style.display = "none"; // Hide error div
        step1.style.display = "none";
        step2.style.display = "flex";
    });

    // Step 2: Validate and submit the form
    submitButton.addEventListener("click", (event) => {
        const password = document.getElementById("password").value.trim();
        const passwordConfirm = document.getElementById("password_confirm").value.trim();

        // Prevent form submission if validation fails
        if (!password || !passwordConfirm) {
            event.preventDefault();
            errorDivStep2.textContent = "Please fill out all fields.";
            errorDivStep2.style.display = "block";
            return;
        }

        if (password !== passwordConfirm) {
            event.preventDefault();
            errorDivStep2.textContent = "Passwords do not match.";
            errorDivStep2.style.display = "block";
            return;
        }

        // Clear errors and allow form submission
        errorDivStep2.textContent = "";
    });

    // Go back to Step 1
    prevButton.addEventListener("click", () => {
        // Clear errors when navigating back to Step 1
        errorDivStep2.textContent = "";
        errorDivStep2.style.display = "none";
        step2.style.display = "none";
        step1.style.display = "flex";
    });
});