{{-- <!DOCTYPE html>
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
                <td><button class="btn btn-sm btn-primary" onclick="addProduct(${product.id}, '${product.name}', '${size.size}', ${size.price}, ${size.stock}, ${size.id})">Add</button></td>
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
                    entity_name: '-',
                    entity_type: 'Customer',
                    type: 'Out',
                    details: selectedProducts,
                    // totalPrice: selectedProducts.reduce((sum, product) => sum + product.total, 0),
                    // totalQuantity: selectedProducts.reduce((sum, product) => sum + product.quantity, 0)
                };
                const response = await fetch('{{ route('orders.store') }}', {
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
                    const errorData = await response.json(); // Mengonversi ke JSON
                    alert(errorData.message.join('\n')); // Menampilkan pesan error
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

        function addProduct(id, product_name, size, price, stock, product_size_id) {
            console.log(product_size_id);


            const existingProduct = selectedProducts.find(product => product.id === id && product.size === size);
            if (existingProduct) {
                // if (existingProduct.quantity + 1 > stock) {
                //     alert(`The maximum stock for this product is ${stock}`);
                //     return;
                // }

                existingProduct.quantity++;
                existingProduct.total = existingProduct.quantity * existingProduct.price;
            } else {
                selectedProducts.push({
                    id,
                    product_name,
                    size,
                    price,
                    stock,
                    quantity: 1,
                    total: price,
                    product_size_id
                });
            }
            renderSelectedProducts();
        }

        function updateQuantity(id, size, newQuantity) {
            newQuantity = parseInt(newQuantity, 10);

            // Cek jika quantity valid
            if (isNaN(newQuantity) || newQuantity < 1) {
                alert('Quantity must be at least 1');
                return;
            }

            const product = selectedProducts.find(product => product.id === id && product.size === size);

            if (product) {
                if (newQuantity > product.stock) {
                    alert(`The maximum stock for this product is ${product.stock}`);
                    return;
                }

                product.quantity = newQuantity;
                product.total = product.quantity * product.price;

                renderSelectedProducts();
            }
        }

        function removeProduct(id, size) {
            const productIndex = selectedProducts.findIndex(product => product.id === id && product.size === size);

            if (productIndex !== -1) {
                selectedProducts.splice(productIndex, 1);
                renderSelectedProducts();
            }
        }

        document.getElementById('search').addEventListener('input', (e) => {
            searchQuery = e.target.value;
            fetchProducts(1, searchQuery);
        });
    </script>

</body>

</html> --}}

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .product-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            height: 100%;
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            box-shadow: -4px 0 6px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease-in-out;
            z-index: 1050;
            padding: 20px;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-card {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: popIn 0.4s ease-in-out;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .action-buttons button {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Product List -->
            <div class="col-md-8">
                <h3 class="mb-3">Product List</h3>
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-list" class="product-list">
                        <!-- Products will be dynamically added here -->
                    </tbody>
                </table>
            </div>

            <!-- Open Cart Button -->
            <button class="btn btn-primary" id="cart-btn">
                <span class="me-2">🛒</span> View Cart
            </button>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div>
            <h4 class="cart-header">Current Order</h4>
            <div id="selected-products">
                <!-- Selected products will go here -->
            </div>
            <hr>
            <div>
                <h5>Total: $<span id="total-price">0.00</span></h5>
            </div>
            <div class="mt-3">
                <input type="text" class="form-control mb-2" placeholder="Entity Name" id="entity-name">
                <select class="form-select mb-2" id="payment-method">
                    <option value="cash">Cash</option>
                    <option value="debit">Debit</option>
                </select>
                <select class="form-select mb-2" id="order-type">
                    <option value="in">In</option>
                    <option value="out">Out</option>
                </select>
                <select class="form-select mb-2" id="entity-type">
                    <option value="customer">Customer</option>
                    <option value="supplier">Supplier</option>
                </select>
                <button class="btn btn-success w-100">Place Order</button>
            </div>
        </div>
    </div>

    <script>
        const products = [{
                id: 1,
                name: 'Product A',
                size: 'M',
                price: 20.5,
                stock: 10
            },
            {
                id: 2,
                name: 'Product B',
                size: 'L',
                price: 15.0,
                stock: 5
            },
            {
                id: 3,
                name: 'Product C',
                size: 'S',
                price: 10.75,
                stock: 8
            },
        ];

        const productList = document.getElementById('product-list');
        const selectedProducts = document.getElementById('selected-products');
        const totalPriceElem = document.getElementById('total-price');
        const cartSidebar = document.getElementById('cart-sidebar');
        const cartBtn = document.getElementById('cart-btn');

        let selected = [];

        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.toggle('open');
        });

        function renderProductList() {
            productList.innerHTML = '';
            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
          <td>${product.id}</td>
          <td>${product.name}</td>
          <td>${product.size}</td>
          <td>$${product.price.toFixed(2)}</td>
          <td>${product.stock}</td>
          <td>
            <button class="btn btn-success btn-sm" onclick="addToCart(${product.id})">Add</button>
          </td>
        `;
                productList.appendChild(row);
            });
        }

        function addToCart(id) {
            const product = products.find(p => p.id === id);
            if (product.stock <= 0) {
                alert('Out of stock!');
                return;
            }

            const existing = selected.find(p => p.id === id);
            if (existing) {
                existing.qty++;
            } else {
                selected.push({
                    ...product,
                    qty: 1
                });
            }

            product.stock--;
            updateUI();
        }

        function updateUI() {
            productList.innerHTML = '';
            renderProductList();

            selectedProducts.innerHTML = '';
            let total = 0;

            selected.forEach(product => {
                const div = document.createElement('div');
                div.className = 'product-card d-flex justify-content-between align-items-center';
                div.innerHTML = `
          <span>${product.name} (${product.size})</span>
          <div class="action-buttons">
            <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${product.id}, -1)">-</button>
            <span>${product.qty}</span>
            <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${product.id}, 1)">+</button>
            <button class="btn btn-sm btn-danger" onclick="removeFromCart(${product.id})">Delete</button>
          </div>
          <span>$${(product.price * product.qty).toFixed(2)}</span>
        `;
                selectedProducts.appendChild(div);

                total += product.price * product.qty;
            });

            if (selected.length === 0) {
                selectedProducts.innerHTML = '<p>No products selected.</p>';
            }

            totalPriceElem.textContent = total.toFixed(2);
        }

        function updateQuantity(id, change) {
            const product = selected.find(p => p.id === id);
            if (!product) return;

            product.qty += change;
            if (product.qty <= 0) {
                removeFromCart(id);
            } else {
                const original = products.find(p => p.id === id);
                original.stock -= change;
            }
            updateUI();
        }

        function removeFromCart(id) {
            const index = selected.findIndex(p => p.id === id);
            if (index === -1) return;

            const product = selected[index];
            const original = products.find(p => p.id === id);
            original.stock += product.qty;

            selected.splice(index, 1);
            updateUI();
        }

        renderProductList();
    </script>
</body>

</html> --}}
