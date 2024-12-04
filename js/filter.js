const dropdownContent = document.querySelector('.dropdown-content');
const dropdownTitle = document.querySelector('.dropdown-title');
const totalItems = document.querySelector('.total-items');

dropdownTitle.addEventListener('click', (e) => {
    // prevent default behaviour of the anchor tag
    e.preventDefault();
    dropdownContent.classList.toggle('hidden');
});

    // Filter products on category selection
dropdownContent.addEventListener('click', (e) => {
    if (e.target.tagName === 'LI') {
        const categoryId = e.target.id;

        // prevent default
        e.preventDefault();

        // Function to update the total visible products
        const updateTotalItems = () => {
            const visibleProducts = document.querySelectorAll('.product-card:not([style*="display: none"])').length;
            totalItems.textContent = `${visibleProducts} Items`;
        };

        // Find all product cards
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(product => {
            const productCategoryId = product.dataset.categoryId;

            // Show or hide products based on selected category
            if (productCategoryId === categoryId) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        // Update the total items
        updateTotalItems();

        // Hide the dropdown
        dropdownContent.classList.toggle('hidden');
    }
});
