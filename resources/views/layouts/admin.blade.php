<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            /* scrollbar-width: thin; */

        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: -250px;
            transition: all 0.3s;
            z-index: 1040;
            display: flex;
            flex-direction: column;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar h2 {
            margin-bottom: 10px;
            text-align: center;
        }

        .sidebar hr {
            border-color: #495057;
            margin: 10px 0;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .submenu {
            margin-left: 15px;
            padding-left: 10px;
            border-left: 2px solid #495057;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .submenu a {
            padding: 5px 10px;
        }

        .submenu.open {
            max-height: 200px;
            /* Adjust based on submenu content */
        }

        .main-content {
            flex-grow: 1;
            margin-left: 0;
            transition: margin-left 0.3s;
            display: flex;
            flex-direction: column;
        }

        .main-content.sidebar-active {
            margin-left: 250px;
        }

        .header,
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #e9ecef;
        }

        .burger-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #000;
            display: inline-block;
        }

        .notification {
            position: relative;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .notification .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 0.75rem;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: -9.5rem;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            z-index: 1050;
        }


        .notification-dropdown ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .notification-dropdown li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .notification-dropdown li:last-child {
            border-bottom: none;
        }

        .logout-form {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sidebar-settings {
            margin-top: auto;
        }

        @media (min-width: 768px) {
            .main-content.sidebar-active {
                margin-left: 250px;
            }
        }
    </style>

    @stack('styles')

</head>

<body>
    <!-- Sidebar -->
    @include('partials.admin.sidebar')

    <!-- Main Content -->
    <div class="main-content w-100" id="mainContent">
        <!-- Header -->
        @include('partials.admin.header')

        <!-- Content -->
        <div class="content">

            <h2>{{ $title }}</h2>
            <br>

            @yield('content')

        </div>

        <!-- Footer -->
        @include('partials.admin.footer')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const burgerButton = document.getElementById('burgerButton');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        // Function to initialize sidebar state based on screen size
        function initializeSidebar() {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('active');
                mainContent.classList.add('sidebar-active');
            } else {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
            }
        }

        // Initialize sidebar on load
        initializeSidebar();

        // Reinitialize sidebar on window resize
        window.addEventListener('resize', initializeSidebar);

        // Toggle sidebar on burger button click
        burgerButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('sidebar-active');
        });

        // Submenu toggle functionality
        document.querySelectorAll('.menu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const target = document.getElementById(this.getAttribute('data-target'));
                if (target) {
                    target.classList.toggle('open');
                }
            });
        });

        const notificationIcon = document.querySelector('.notification');
        const notificationDropdown = document.querySelector('.notification-dropdown');

        // Toggle dropdown on click
        notificationIcon.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent event bubbling
            notificationDropdown.style.display =
                notificationDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            notificationDropdown.style.display = 'none';
        });
    </script>
    @stack('scripts')
</body>

</html>
