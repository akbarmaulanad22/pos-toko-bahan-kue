<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hidden-table {
            display: none;
        }

        @media (min-width: 768px) {
            .hidden-table {
                display: table;
            }
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .skeleton {
            display: block;
            height: 20px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 class="mb-4">Simple POS System</h1>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <input type="text" id="search" class="form-control w-50" placeholder="Search...">
            <button class="btn btn-primary d-md-none" onclick="toggleSelectedTable()">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Products</h2>
                <div class="table-wrapper">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="products-table">
                            <!-- Data rows or message -->
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination" id="pagination"></ul>
                </nav>
            </div>

            <div class="col-md-6 hidden-table" id="selected-products-container">
                <h2>Selected Products</h2>
                <div class="table-wrapper">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="selected-products">
                            <!-- Selected products or message -->
                        </tbody>
                        <tfoot id="selected-products-footer">
                            <tr>
                                <td colspan="5"><strong>Total Price</strong></td>
                                <td colspan="2" id="total-price">Rp0</td>
                            </tr>
                            <tr>
                                <td colspan="5"><strong>Total Quantity</strong></td>
                                <td colspan="2" id="total-quantity">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button id="order-button" class="btn btn-success w-100 mt-3" onclick="submitOrder()"
                    disabled>Order</button>
            </div>
        </div>
    </div>

    <script>
        const apiUrl = 'http://127.0.0.1:8000/areaorangpadang/products/ajax';
        let currentPage = 1;
        let searchQuery = '';
        const selectedProducts = [];
        const skeletonRow = '<tr><td colspan="6"><div class="skeleton w-100"></div></td></tr>';

        async function fetchProducts(page = 1, query = '') {
            try {
                const productsTable = document.getElementById('products-table');
                productsTable.innerHTML = skeletonRow.repeat(5);

                const response = await fetch(`${apiUrl}?page=${page}&search=${query}`);
                const data = await response.json();
                renderProducts(data.data);
                renderPagination(data.meta);
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        }

        function renderProducts(products) {
            const productsTable = document.getElementById('products-table');
            if (products.length === 0) {
                productsTable.innerHTML = '<tr><td colspan="6" class="text-center">No products available.</td></tr>';
                return;
            }

            productsTable.innerHTML = products.map(product =>
                product.size.length > 0 ?
                product.size.map(size => `
              <tr>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${size.size}</td>
                <td>Rp${size.price.toLocaleString()}</td>
                <td>${size.stock}</td>
                <td><button class="btn btn-sm btn-primary" onclick="addProduct(${product.id}, '${product.name}', '${size.size}', ${size.price}, ${size.stock})">Add</button></td>
              </tr>
            `).join('') :
                `
              <tr>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td colspan="3">Not Available</td>
                <td><button class="btn btn-sm btn-secondary" disabled>Add</button></td>
              </tr>
            `
            ).join('');
        }

        function renderPagination(meta) {
            const pagination = document.getElementById('pagination');
            if (meta.total_pages <= 1) {
                pagination.style.display = 'none';
            } else {
                pagination.style.display = 'flex';
                pagination.innerHTML = meta.links.map(link => `
          <li class="page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(event, '${link.url}')">${link.label}</a>
          </li>
        `).join('');
            }
        }

        function renderSelectedProducts() {
            const selectedProductsTable = document.getElementById('selected-products');
            const totalPrice = selectedProducts.reduce((sum, product) => sum + product.total, 0);
            const totalQuantity = selectedProducts.reduce((sum, product) => sum + product.quantity, 0);
            const footer = document.getElementById('selected-products-footer');
            const orderButton = document.getElementById('order-button');

            if (selectedProducts.length === 0) {
                selectedProductsTable.innerHTML = '<tr><td colspan="7" class="text-center">No products selected.</td></tr>';
                footer.style.display = 'none';
                orderButton.disabled = true;
            } else {
                selectedProductsTable.innerHTML = selectedProducts.map(product => `
          <tr>
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.size}</td>
            <td>Rp${product.price.toLocaleString()}</td>
            <td>
              <input type="number" class="form-control form-control-sm" value="${product.quantity}" min="1" max="${product.stock}" 
                onchange="updateQuantity(${product.id}, '${product.size}', this.value)">
            </td>
            <td>Rp${product.total.toLocaleString()}</td>
            <td><button class="btn btn-sm btn-danger" onclick="removeProduct(${product.id}, '${product.size}')">Remove</button></td>
          </tr>
        `).join('');
                document.getElementById('total-price').textContent = `Rp${totalPrice.toLocaleString()}`;
                document.getElementById('total-quantity').textContent = totalQuantity;
                footer.style.display = '';
                orderButton.disabled = false;
            }
        }

        async function submitOrder() {
            try {
                document.getElementById('order-button').disabled = true

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const dataToSend = {
                    selectedProducts: selectedProducts,
                    totalPrice: selectedProducts.reduce((sum, product) => sum + product.total, 0),
                    totalQuantity: selectedProducts.reduce((sum, product) => sum + product.quantity, 0)
                };
                const response = await fetch('http://127.0.0.1:8000/areaorangpadang/pos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(dataToSend)
                });

                // Check if the response is OK and the content type is JSON
                if (response.ok && response.headers.get('Content-Type').includes('application/json')) {
                    const result = await response.json();
                    alert('Order submitted successfully!');
                    selectedProducts.length = 0;
                    renderSelectedProducts();
                } else {
                    const text = await response.text(); // Get response as text
                    console.error('Error submitting order: Unexpected response', text);
                }
            } catch (error) {
                console.error('Error submitting order:', error);
            }

        }

        fetchProducts();

        function changePage(event, url) {
            event.preventDefault();
            if (url) {
                const urlParams = new URL(url).searchParams;
                currentPage = urlParams.get('page');
                fetchProducts(currentPage, searchQuery);
            }
        }

        function toggleSelectedTable() {
            const container = document.getElementById('selected-products-container');
            container.classList.toggle('hidden-table');
        }

        function addProduct(id, name, size, price, stock) {
            const existingProduct = selectedProducts.find(product => product.id === id && product.size === size);
            if (existingProduct) {
                existingProduct.quantity++;
                existingProduct.total = existingProduct.quantity * existingProduct.price;
            } else {
                selectedProducts.push({
                    id,
                    name,
                    size,
                    price,
                    stock,
                    quantity: 1,
                    total: price
                });
            }
            renderSelectedProducts();
        }

        document.getElementById('search').addEventListener('input', (e) => {
            searchQuery = e.target.value;
            fetchProducts(1, searchQuery);
        });
    </script>

</body>

</html>
