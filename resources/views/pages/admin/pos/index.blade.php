<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            /* max-width: 1200px; */
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .left-section {
            width: 100%;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-right: 400px;
        }

        .search-box {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th,
        .product-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .product-table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .add-cart-btn {
            padding: 0.5rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-cart-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding: 1rem 0;
        }

        .pagination button {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            padding: 1.5rem;
            box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar.active {
            right: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .header-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .clear-cart-btn {
            color: #ff4444;
            border: none;
            background: none;
            cursor: pointer;
        }

        .close-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #666;
        }

        .cart-item {
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .cart-item-header {
            display: flex;
            justify-content: space-between;
            /* margin-bottom: 0.5rem; */
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            padding: 0.25rem 0.5rem;
            border: 1px solid #ddd;
            background: #f8f8f8;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-item-btn {
            color: #ff4444;
            border: none;
            background: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .radio-group {
            display: flex;
            gap: 1rem;
        }

        .total-price {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .submit-order {
            width: 100%;
            padding: 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
            font-size: 1rem;
        }

        .submit-order:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff4444;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .mobile-cart-btn {
            display: none;
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            width: 3rem;
            height: 3rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        .table-container {
            overflow-x: auto;
        }

        .product-table {
            white-space: nowrap;
        }

        @media (max-width: 767px) {
            .left-section {
                margin-right: 0;
            }

            .sidebar {
                width: 100%;
                right: -100%;
            }

            .mobile-cart-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media (min-width: 768px) {
            .container {
                display: flex;
                /* flex-direction: column; */
                gap: 1rem;
            }

            .left-section {
                margin-right: 0;
                /* width: 70%; */
            }

            .close-sidebar {
                display: none;
            }

            .sidebar {
                position: static;
                height: 90vh;
            }
        }

        @media (min-width: 1024px) {
            .sidebar {
                width: 40%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-section">
            <input type="text" class="search-box" id="search" placeholder="Search products...">
            <div class="table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="productList"></tbody>
                </table>
            </div>
            <div class="pagination">
                <button id="prevPage">Previous</button>
                <span id="pageInfo">Page 1 of 1</span>
                <button id="nextPage">Next</button>
            </div>
        </div>

        <div class="overlay" id="overlay"></div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2>Current Order</h2>
                <div class="header-controls">
                    <button class="clear-cart-btn" id="clearCart">Delete All</button>
                    <button class="close-sidebar" id="closeSidebar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div id="cartItems"></div>

            <div class="order-form">
                <div class="form-group">
                    <label>Entity Name</label>
                    <input type="text" class="form-control" id="entity_name" name="entity_name">
                </div>

                <div class="form-group">
                    <label>Entity Type</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="entity_type" value="Customer" checked> Customer
                        </label>
                        <label>
                            <input type="radio" name="entity_type" value="Supplier"> Supplier
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status Payment</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="status" value="Completed" checked> Completed
                        </label>
                        <label>
                            <input type="radio" name="status" value="Pending"> Pending
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="payment_method" value="DEBIT" checked> DEBIT
                        </label>
                        <label>
                            <input type="radio" name="payment_method" value="CASH"> CASH
                        </label>
                    </div>
                </div>

                <div class="total-price">
                    Total: <span id="totalPrice">Rp 0</span>
                </div>

                <button class="submit-order" id="submitOrder">Create Order</button>
                <div id="errorMessage" class="error-message"></div>
            </div>
        </div>
    </div>

    <button class="mobile-cart-btn" id="mobileCartBtn">
        <i class="fas fa-shopping-cart"></i>
    </button>

    <script>
        let currentPage = 1;
        let cart = [];

        async function fetchProducts(page = 1, search = '') {
            try {
                const response = await fetch(
                    `http://127.0.0.1:8000/areaorangpadang/products/ajax?page=${page}&search=${search}`);
                const data = await response.json();
                renderProducts(data);
                updatePagination(data);
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        }

        function renderProducts(data) {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';

            if (data.data.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="5" style="text-align: center">No products found</td>';
                productList.appendChild(row);
                return;
            }

            data.data.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.product_name}</td>
                    <td>${product.product_size}</td>
                    <td>Rp ${product.product_price.toLocaleString()}</td>
                    <td>${product.product_stock}</td>
                    <td>
                        <button
                            onclick="addToCart(${JSON.stringify(product).replace(/"/g, '&quot;')})"
                            class="add-cart-btn">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </td>
                `;
                productList.appendChild(row);
            });
        }

        function updatePagination(data) {
            document.getElementById('pageInfo').textContent = `Page ${data.current_page} of ${data.total_page}`;
            document.getElementById('prevPage').disabled = data.current_page <= 1;
            document.getElementById('nextPage').disabled = data.current_page >= data.total_page;
        }

        function addToCart(product) {
            const cartItem = cart.find(item => item.product_size_id === product.product_size_id);
            if (cartItem) {
                // if (product.product_stock > 0) {
                cartItem.quantity++;
                product.product_stock--;
                // }
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
                product.product_stock--;
            }
            renderCart();
            updateTotal();
            // openSidebar();
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';

            cart.forEach(item => {
                const cartItemDiv = document.createElement('div');
                cartItemDiv.className = 'cart-item';
                cartItemDiv.innerHTML = `
                    <div class="cart-item-header">
                        <div>
                            <h3 style="padding-bottom: 0.6rem;">${item.product_name} <span style="font-weight: normal"> - ${item.product_size}</span></h3>
                            <p style="font-size: 0.8rem">Rp ${item.product_price.toLocaleString()}</p>
                        </div>
                        <div class="quantity-controls">
                            <button onclick="updateQuantity(${item.product_size_id}, -1)" class="quantity-btn">-</button>
                            <span>${item.quantity}</span>
                            <button onclick="updateQuantity(${item.product_size_id}, 1)" class="quantity-btn">+</button>
                            <button onclick="removeFromCart(${item.product_size_id})" class="delete-item-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItems.appendChild(cartItemDiv);
            });
        }

        function updateQuantity(productSizeId, change) {
            const cartItem = cart.find(item => item.product_size_id === productSizeId);
            // if (change > 0 && cartItem.product_stock > 0) {
            if (change > 0) {
                cartItem.quantity += change;
                cartItem.product_stock--;
            } else if (change < 0 && cartItem.quantity > 1) {
                cartItem.quantity += change;
                cartItem.product_stock++;
            }
            renderCart();
            updateTotal();
        }

        function removeFromCart(productSizeId) {
            const itemIndex = cart.findIndex(item => item.product_size_id === productSizeId);
            if (itemIndex !== -1) {
                cart.splice(itemIndex, 1);
                renderCart();
                updateTotal();
            }
        }

        function clearCart() {
            cart = [];
            renderCart();
            updateTotal();
        }

        function updateTotal() {
            const total = cart.reduce((sum, item) => sum + (item.product_price * item.quantity), 0);
            document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString()}`;
        }

        function openSidebar() {
            document.getElementById('sidebar').classList.add('active');
            document.getElementById('overlay').classList.add('active');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }

        async function submitOrder() {
            const entityName = document.getElementById('entity_name').value;
            const entityType = document.querySelector('input[name="entity_type"]:checked')?.value;
            const status = document.querySelector('input[name="status"]:checked')?.value;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

            if (!entityName || !entityType || cart.length === 0) {
                document.getElementById('errorMessage').textContent =
                    'Please fill all required fields and add products to cart';
                return;
            }

            const orderData = {
                entity_name: entityName,
                entity_type: entityType,
                status: status,
                payment_method: paymentMethod,
                details: cart.map(item => ({
                    product_name: item.product_name,
                    product_size_id: item.product_size_id,
                    quantity: item.quantity,
                    price: item.product_price
                }))
            };

            try {
                const response = await fetch('http://127.0.0.1:8000/areaorangpadang/orders/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(orderData)
                });

                if (response.ok) {
                    clearCart();
                    document.getElementById('entity_name').value = '';
                    document.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);
                    document.getElementById('errorMessage').textContent = '';
                    alert('Order created successfully!');
                    closeSidebar();
                    fetchProducts();
                } else {
                    const error = await response.json();
                    document.getElementById('errorMessage').textContent = error.message || 'Failed to create order';
                }
            } catch (error) {
                document.getElementById('errorMessage').textContent = 'Network error occurred';
                console.error('Error submitting order:', error);
            }
        }

        // Tambahkan ini ke dalam function setupEventListeners()
        function setupEventListeners() {
            const searchInput = document.getElementById('search');
            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    fetchProducts(currentPage, e.target.value);
                }, 300);
            });

            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchProducts(currentPage, searchInput.value);
                }
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                currentPage++;
                fetchProducts(currentPage, searchInput.value);
            });

            document.getElementById('clearCart').addEventListener('click', clearCart);
            document.getElementById('closeSidebar').addEventListener('click', closeSidebar);
            document.getElementById('submitOrder').addEventListener('click', submitOrder);
            document.getElementById('mobileCartBtn').addEventListener('click', openSidebar);

            document.getElementById('overlay').addEventListener('click', closeSidebar);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            fetchProducts();
            setupEventListeners();
        });
    </script>
</body>
