// dont allow add to cart if the quantity is lower than 1

const addToCartButton = document.getElementById('add-to-cart');
const quantityInput = document.getElementById('quantity-input');

addToCartButton.addEventListener('click', function(event) {
    if (parseInt(quantityInput.value) < 1) {
        event.preventDefault();
        alert('Please select a quantity of at least 1');
    }
});
