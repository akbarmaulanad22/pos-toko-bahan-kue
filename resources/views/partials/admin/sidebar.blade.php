<nav class="sidebar" id="sidebar">
    <h2>Toko Azka</h2>
    <hr>
    <ul class="navbar-nav mr-auto overflow-y-auto">
        @if (auth()->user()->role_id &&
                (auth()->user()->role &&
                    (auth()->user()->role->name == 'Super Admin' || auth()->user()->role->name == 'Admin')))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('staffs.index') }}">Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('financial-reports') }}">Laporan keuangan</a>
            </li>
            <li class="nav-item">
                <a href="#" class="menu-toggle" data-target="submenu-log">Log</a>
                <div class="submenu" id="submenu-log">
                    <a href="{{ route('log.roles') }}" class="text-nowrap">Roles</a>
                    <a href="{{ route('log.products') }}" class="text-nowrap">Staff</a>
                    <a href="{{ route('log.products') }}" class="text-nowrap">Categories</a>
                    <a href="{{ route('log.products') }}" class="text-nowrap">Products</a>
                    <a href="{{ route('log.products') }}" class="text-nowrap">Expenses</a>
                    <a href="{{ route('log.products') }}" class="text-nowrap">Orders</a>
                </div>
            </li>
        @endif


        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pos.index') }}">POS</a>
        </li>

    </ul>


    <hr>
    <ul class="navbar-nav mr-auto sidebar-settings">
        <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>

        </li>
    </ul>
</nav>
