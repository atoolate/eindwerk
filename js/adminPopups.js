document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const message = params.get("message");

    if (message) {
        // Create a popup div
        const popup = document.createElement("div");
        popup.textContent = decodeURIComponent(message);
        popup.style.position = "fixed";
        popup.style.top = "20px";
        popup.style.left = "50%";
        popup.style.transform = "translateX(-50%)";
        if (message.includes("delete")) {
            popup.style.backgroundColor = "#f44336";
        }
        else {
            popup.style.backgroundColor = "#4CAF50";
        }
        popup.style.color = "white";
        popup.style.padding = "10px 20px";
        popup.style.borderRadius = "5px";
        popup.style.boxShadow = "0 4px 12px rgba(0, 0, 0, 0.2)";
        popup.style.zIndex = "1000";

        document.body.appendChild(popup);

        // Remove the popup after 3 seconds
        setTimeout(() => {
            popup.remove();
        }, 3000);
    }

    // Clear the message parameter from the URL
    const newUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, newUrl);

});