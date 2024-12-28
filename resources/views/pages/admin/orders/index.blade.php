@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Kasir</h1>

        <!-- Live Search Input -->
        <div class="form-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
        </div>

        <!-- Tabel Produk -->
        <h3>Daftar Produk</h3>
        <table id="productTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produk akan ditampilkan di sini -->
            </tbody>
        </table>

        <!-- Tabel Keranjang -->
        <h3>Keranjang Belanja</h3>
        <table id="cartTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produk yang dipilih akan muncul di sini -->
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        // Data Produk dengan Attributes yang Berisi Harga dan Ukuran
        const products = [{
                id: 1,
                name: 'Produk A',
                attributes: [{
                        price: 10000,
                        size: 'XL'
                    },
                    {
                        price: 7000,
                        size: 'L'
                    }
                ]
            },
            {
                id: 2,
                name: 'Produk B',
                attributes: [{
                        price: 15000,
                        size: 'M'
                    },
                    {
                        price: 17000,
                        size: 'L'
                    }
                ]
            },
            {
                id: 3,
                name: 'Produk C',
                attributes: [{
                    price: 20000,
                    size: 'XL'
                }]
            }
        ];

        // Menampilkan produk dan ukurannya di tabel produk
        function renderProductTable(productsToRender) {
            $('#productTable tbody').empty();

            productsToRender.forEach(product => {
                product.attributes.forEach((attribute, index) => {
                    $('#productTable tbody').append(`
                        <tr class="product-row" data-product-id="${product.id}" data-product-name="${product.name}" data-size="${attribute.size}" data-price="${attribute.price}">
                            ${index === 0 ? `<td>${product.name}</td>` : `<td></td>`}
                            <td>${attribute.size}</td>
                            <td>${attribute.price}</td>
                        </tr>
                    `);
                });
            });
        }

        // Menampilkan semua produk awal
        $(document).ready(function() {
            renderProductTable(products);
        });

        // Live search untuk produk
        $('#searchInput').on('input', function() {
            const searchQuery = $(this).val().toLowerCase();

            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(searchQuery)
            );

            renderProductTable(filteredProducts);
        });

        // Mengelola keranjang
        let cart = [];

        // Fungsi untuk menambah produk ke keranjang
        $(document).on('click', '.product-row', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const size = $(this).data('size');
            const price = $(this).data('price');

            // Cek apakah produk sudah ada di keranjang
            const existingProductIndex = cart.findIndex(item => item.productId === productId);

            if (existingProductIndex >= 0) {
                // Jika produk sudah ada, cek apakah ukuran sudah ada di dalam keranjang
                const existingSizeIndex = cart[existingProductIndex].attributes.findIndex(attr => attr.size ===
                    size);

                if (existingSizeIndex >= 0) {
                    // Jika ukuran sudah ada, update jumlah
                    cart[existingProductIndex].attributes[existingSizeIndex].quantity++;
                } else {
                    // Jika ukuran belum ada, tambahkan ukuran baru
                    cart[existingProductIndex].attributes.push({
                        size: size,
                        price: price,
                        quantity: 1
                    });
                }
            } else {
                // Jika produk belum ada, tambahkan produk baru beserta ukuran dan harga
                cart.push({
                    productId: productId,
                    productName: productName,
                    attributes: [{
                        size: size,
                        price: price,
                        quantity: 1
                    }]
                });
            }

            // Menampilkan produk di tabel keranjang
            renderCart();
        });

        // Fungsi untuk merender keranjang
        function renderCart() {
            $('#cartTable tbody').empty();

            cart.forEach(item => {
                let firstRow = true; // Penanda untuk baris pertama produk
                item.attributes.forEach(attr => {
                    $('#cartTable tbody').append(`
                        <tr class="cart-row" data-product-id="${item.productId}" data-size="${attr.size}">
                            ${firstRow ? `<td>${item.productName}</td>` : `<td></td>`}
                            <td>${attr.size}</td>
                            <td>${attr.price}</td>
                            <td><input type="number" class="form-control quantity" value="${attr.quantity}" min="1" data-product-id="${item.productId}" data-size="${attr.size}"></td>
                            <td>${attr.price * attr.quantity}</td>
                            <td><button class="btn btn-danger remove-item" data-product-id="${item.productId}" data-size="${attr.size}" ${firstRow ? 'data-remove-group="true"' : ''}>Hapus</button></td>
                        </tr>
                    `);
                    firstRow = false; // Ubah penanda setelah baris pertama produk
                });
            });

            // Menghitung total harga
            let total = 0;
            cart.forEach(item => {
                item.attributes.forEach(attr => {
                    total += attr.price * attr.quantity;
                });
            });
            console.log('Total Harga: ', total);
        }

        // Mengupdate jumlah produk di keranjang
        $(document).on('input', '.quantity', function() {
            const productId = $(this).data('product-id');
            const size = $(this).data('size');
            const newQuantity = $(this).val();

            // Temukan produk yang ingin diupdate
            const productIndex = cart.findIndex(item => item.productId === productId);
            if (productIndex >= 0) {
                const sizeIndex = cart[productIndex].attributes.findIndex(attr => attr.size === size);
                if (sizeIndex >= 0) {
                    cart[productIndex].attributes[sizeIndex].quantity = newQuantity;
                }
            }

            renderCart();
        });

        // Menghapus item dari keranjang
        $(document).on('click', '.remove-item', function() {
            const productId = $(this).data('product-id');
            const size = $(this).data('size');
            const removeGroup = $(this).data('remove-group');

            if (removeGroup) {
                // Hapus semua item dengan ID produk yang sama
                cart = cart.filter(item => item.productId !== productId);
            } else {
                // Hapus hanya item ukuran tertentu
                const productIndex = cart.findIndex(item => item.productId === productId);
                if (productIndex >= 0) {
                    cart[productIndex].attributes = cart[productIndex].attributes.filter(attr => attr.size !==
                    size);
                    // Jika sudah tidak ada ukuran untuk produk, hapus produk
                    if (cart[productIndex].attributes.length === 0) {
                        cart.splice(productIndex, 1);
                    }
                }
            }

            renderCart();
        });
    </script>
@endpush
