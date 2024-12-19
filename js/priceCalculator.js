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

    // Ensure event listeners are attached only once
    quantityRows.forEach(row => {
        const decrementButton = row.querySelector(".decrement");
        const incrementButton = row.querySelector(".increment");
        const quantityValue = row.querySelector(".quantity-value");

        // Remove any existing event listeners to avoid duplicate bindings
        decrementButton.replaceWith(decrementButton.cloneNode(true));
        incrementButton.replaceWith(incrementButton.cloneNode(true));

        // Add event listener for decrement button
        decrementButton.addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            if (currentValue > 0) { // Ensure quantity doesn't go below 0
                quantityValue.textContent = currentValue - 1;
                calculateTotalPrice(); // Update total price
            }
        });

        // Add event listener for increment button
        incrementButton.addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            quantityValue.textContent = currentValue + 1; // Increment value
            calculateTotalPrice(); // Update total price
        });
    });

    // Initial calculation
    calculateTotalPrice();
});
