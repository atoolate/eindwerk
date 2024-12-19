document.addEventListener("DOMContentLoaded", () => {
    const quantityRows = document.querySelectorAll(".quantity-row");
    const totalPriceElement = document.querySelector(".total-price");

    // Function to calculate the total price
    function calculateTotalPrice() {
        let totalPrice = 0;

        quantityRows.forEach(row => {
            const quantity = parseInt(row.querySelector(".quantity-value").textContent); // Current quantity
            const pricePerItem = parseFloat(
                row.querySelector(".price").textContent.replace("€", "").trim()
            ); // Price per item

            totalPrice += quantity * pricePerItem; // Add to total price
        });

        // Update the total price in the DOM
        totalPriceElement.textContent = `€${totalPrice.toFixed(2)}`;
    }

    // Attach event listeners to quantity buttons
    quantityRows.forEach(row => {
        const decrementButton = row.querySelector(".decrement");
        const incrementButton = row.querySelector(".increment");
        const quantityValue = row.querySelector(".quantity-value");

        // Remove existing event listeners (optional safety check)
        decrementButton.replaceWith(decrementButton.cloneNode(true));
        incrementButton.replaceWith(incrementButton.cloneNode(true));

        // Attach updated event listeners
        row.querySelector(".decrement").addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            if (currentValue > 0) { // Ensure quantity doesn't go below 0
                quantityValue.textContent = currentValue - 1; // Update DOM
                calculateTotalPrice(); // Recalculate after update
            }
        });

        row.querySelector(".increment").addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            quantityValue.textContent = currentValue + 1; // Update DOM
            calculateTotalPrice(); // Recalculate after update
        });
    });

    // Initial calculation
    calculateTotalPrice();
});
