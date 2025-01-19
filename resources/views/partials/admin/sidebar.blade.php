<nav class="sidebar" id="sidebar">
    <h2>Toko Azka</h2>
    <hr>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">POS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">Financial Report</a>
        </li>
        <li class="nav-item">
            <a href="#" class="menu-toggle" data-target="submenu-product-reports">Product Report</a>
            <div class="submenu" id="submenu-product-reports">
                <a href="#" class="text-nowrap">Incoming</a>
                <a href="#" class="text-nowrap">Outgoing</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="#" class="menu-toggle" data-target="submenu-employees">Employees Management</a>
            <div class="submenu" id="submenu-employees">
                <a href="#" class="text-nowrap">Employee List</a>
                <a href="#" class="text-nowrap">Role List</a>
            </div>
        </li>
    </ul>

    {{-- <div>
        <a href="#" class="menu-toggle" data-target="submenu-products">Products</a>
        <div class="submenu" id="submenu-products">
            <a href="#">Add Product</a>
            <a href="#">View Products</a>
        </div>
    </div>
    <div>
        <a href="#" class="menu-toggle" data-target="submenu-orders">Orders</a>
        <div class="submenu" id="submenu-orders">
            <a href="#">New Orders</a>
            <a href="#">Order History</a>
        </div>
    </div> --}}
    <hr>
    <ul class="navbar-nav mr-auto sidebar-settings">
        <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>

        </li>
    </ul>
</nav>
