        // hidethe products section when on the add product page
        // show the products section and hide the add product form when on the manage products page
        const addProductSelector = document.getElementById('addProductSelector');
        const manageProductsSelector = document.getElementById('manageProductsSelector');
        const addProductForm = document.getElementById('addProduct');
        const productsGrid = document.querySelector('.products-grid');

        addProductSelector.addEventListener('click', () => {
            addProductForm.style.display = 'flex';
            productsGrid.style.display = 'none';
        });

        manageProductsSelector.addEventListener('click', () => {
            addProductForm.style.display = 'none';
            productsGrid.style.display = 'grid';
        });

