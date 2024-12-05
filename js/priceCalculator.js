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

    // Recalculate total price whenever quantity changes
    quantityRows.forEach(row => {
        const decrementButton = row.querySelector(".decrement");
        const incrementButton = row.querySelector(".increment");

        decrementButton.addEventListener("click", calculateTotalPrice);
        incrementButton.addEventListener("click", calculateTotalPrice);
    });

    // Initial calculation
    calculateTotalPrice();
});

