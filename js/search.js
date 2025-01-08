document.querySelector('.clear-query').addEventListener('click', function(e) {
    e.preventDefault();
    fetch('ajax/clear_search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'clear=true'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.querySelector('.search-bar input[name="query"]').value = '';
            document.querySelector('.search-query').remove();
            const productsGrid = document.querySelector('.products-grid');
            productsGrid.innerHTML = '';
            data.products.forEach(product => {
                const productCard = `
                    <article class="product-card" data-category-id="${product.category_id}">
                        <div class="product-content">
                            <span class="product-tag hidden">Best Seller</span>
                            <a class="product-image-wrapper" href="productpage.php">
                                <img class="product-image" src="${product.images}" alt="${product.title}">
                            </a>
                            <div class="product-details">
                                <h3 class="product-title">${product.title}</h3>
                                <p class="product-keywords">${product.tagline}</p>
                                <div class="product-specifications">
                                    <p class="specifications-outside">${product.alcohol}%</p>
                                    <p class="specification-middle">${product.category_name}</p>
                                    <p class="specifications-outside">${product.volume}ml</p>
                                </div>
                            </div>
                            <div class="product-cta">
                                <p class="product-price">From <span id="price-unit">€${product.price}</span> per can</p>
                                <div class="product-btns">
                                    <a class="btn-primary" href="productpage.php?id=${product.id}">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </article>
                `;
                productsGrid.insertAdjacentHTML('beforeend', productCard);
            });
        }
    });
});

document.querySelector('.search-bar input[name="query"]').addEventListener('input', function() {
    const query = this.value;
    fetch('ajax/search_products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'query=' + encodeURIComponent(query)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const productsGrid = document.querySelector('.products-grid');
            productsGrid.innerHTML = '';
            data.products.forEach(product => {
                const productCard = `
                    <article class="product-card" data-category-id="${product.category_id}">
                        <div class="product-content">
                            <span class="product-tag hidden">Best Seller</span>
                            <a class="product-image-wrapper" href="productpage.php">
                                <img class="product-image" src="${product.images}" alt="${product.title}">
                            </a>
                            <div class="product-details">
                                <h3 class="product-title">${product.title}</h3>
                                <p class="product-keywords">${product.tagline}</p>
                                <div class="product-specifications">
                                    <p class="specifications-outside">${product.alcohol}%</p>
                                    <p class="specification-middle">${product.category_name}</p>
                                    <p class="specifications-outside">${product.volume}ml</p>
                                </div>
                            </div>
                            <div class="product-cta">
                                <p class="product-price">From <span id="price-unit">€${product.price}</span> per can</p>
                                <div class="product-btns">
                                    <a class="btn-primary" href="productpage.php?id=${product.id}">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </article>
                `;
                productsGrid.insertAdjacentHTML('beforeend', productCard);
            });
        }
    });
});