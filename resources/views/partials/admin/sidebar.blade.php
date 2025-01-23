<nav class="sidebar" id="sidebar">
    <h2>Toko Azka</h2>
    <hr>
    <ul class="navbar-nav mr-auto overflow-y-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">POS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a href="#" class="menu-toggle" data-target="submenu-financials">Financials</a>
            <div class="submenu" id="submenu-financials">
                <a href="{{ route('financial-trackers.index') }}" class="text-nowrap">Trackers</a>
                <a href="#" class="text-nowrap">Reports</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('stockflow.index') }}">StockFlow</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staffs.index') }}">Staff</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
        </li>
        <li class="nav-item">
            <a href="#" class="menu-toggle" data-target="submenu-log">Log</a>
            <div class="submenu" id="submenu-log">
                <a href="{{ route('log.products') }}" class="text-nowrap">Products</a>
                <a href="{{ route('log.finacial-trackers') }}" class="text-nowrap">Financial Trackers</a>
                <a href="#" class="text-nowrap">Stock Flow</a>
                <a href="#" class="text-nowrap">Emplooyees</a>
            </div>
        </li>
    </ul>


    <hr>
    <ul class="navbar-nav mr-auto sidebar-settings">
        <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>

        </li>
    </ul>
</nav>
