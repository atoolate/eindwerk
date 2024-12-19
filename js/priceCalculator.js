document.addEventListener("DOMContentLoaded", () => {
    const quantityRows = document.querySelectorAll(".quantity-row");
    const totalPriceElement = document.querySelector(".total-price");

    // Function to calculate and display the total price
    function priceCalculator() {
        let totalPrice = 0;

        // Loop through each quantity row to calculate the total price
        quantityRows.forEach(row => {
            const quantity = parseInt(row.querySelector(".quantity-value").textContent); // Current quantity
            const pricePerItem = parseFloat(
                row.querySelector(".price").textContent.replace("€", "").trim()
            ); // Price per item

            totalPrice += quantity * pricePerItem; // Add to the total price
        });

        // Update the total price in the DOM
        totalPriceElement.textContent = `€${totalPrice.toFixed(2)}`;
    }

    // Initial calculation on page load
    priceCalculator();

    // Recalculate total price whenever the quantity changes
    quantityRows.forEach(row => {
        const decrementButton = row.querySelector(".decrement");
        const incrementButton = row.querySelector(".increment");

        // Recalculate price when decrement or increment buttons are clicked
        decrementButton.addEventListener("click", priceCalculator);
        incrementButton.addEventListener("click", priceCalculator);
    });
});
