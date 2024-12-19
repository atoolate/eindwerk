document.addEventListener("DOMContentLoaded", () => {

    // Select all quantity rows
    document.querySelectorAll('.quantity-row').forEach(row => {
        // Get decrement, increment buttons, and quantity value span
        const decrement = row.querySelector('.decrement');
        const increment = row.querySelector('.increment');
        const quantityValue = row.querySelector('.quantity-value');

        // Add event listener for decrement button
        decrement.addEventListener('click', () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            if (currentValue > 0) { // Ensure quantity doesn't go below 0
                quantityValue.textContent = currentValue - 1;
            }
        });

        // Add event listener for increment button
        increment.addEventListener('click', () => {
            let currentValue = parseInt(quantityValue.textContent); // Get current value
            quantityValue.textContent = currentValue + 1; // Increment value
        });
    });
});