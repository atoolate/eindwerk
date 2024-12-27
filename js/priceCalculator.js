document.addEventListener("DOMContentLoaded", () => {
    const quantityRows = document.querySelectorAll(".quantity-row");
    const quantityInput = document.getElementById("quantity-input");
    const totalPriceElement = document.querySelector(".total-price");

    function calculateTotalPrice() {
        let totalPrice = 0;

        quantityRows.forEach(row => {
            const quantity = parseInt(row.querySelector(".quantity-value").textContent); // Get the current quantity
            const pricePerItem = parseFloat(
                row.querySelector(".price").textContent.replace("€", "").trim()
            ); // Parse price

            totalPrice += quantity * pricePerItem; // Calculate total price
        });

        totalPriceElement.textContent = `€${totalPrice.toFixed(2)}`; // Update total price display
    }

    quantityRows.forEach(row => {
        const decrementButton = row.querySelector(".decrement");
        const incrementButton = row.querySelector(".increment");
        const quantityValue = row.querySelector(".quantity-value");

        decrementButton.addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent);
            if (currentValue > 0) {
                quantityValue.textContent = currentValue - 1;
                quantityInput.value = currentValue - 1;
                calculateTotalPrice();
            }
        });

        incrementButton.addEventListener("click", () => {
            let currentValue = parseInt(quantityValue.textContent);
            quantityValue.textContent = currentValue + 1;
            quantityInput.value = currentValue + 1;
            calculateTotalPrice();
        });
    });

    calculateTotalPrice(); // Initial calculation
});
