<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Subscribely' }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- App Shell with Sidebar -->
    <div class="app-shell d-none" id="appShell">
        <aside class="app-sidebar">
            <div class="brand px-3 py-3">
                <a href="/dashboard" class="text-decoration-none fw-semibold">Subscribely</a>
            </div>
            <nav class="nav flex-column sidebar-nav">
                <a class="nav-link" href="/dashboard" data-nav="/dashboard">
                    <span class="me-2">🏠</span> Dashboard
                </a>
                <a class="nav-link" href="/subscriptions" data-nav="/subscriptions">
                    <span class="me-2">📦</span> Subscriptions
                </a>
                <a class="nav-link" href="/profile" data-nav="/profile">
                    <span class="me-2">👤</span> Profile
                </a>
            </nav>
            <div class="mt-auto p-3">
                <button class="btn btn-outline-danger w-100" id="logoutBtn">Logout</button>
            </div>
        </aside>
        <main class="app-main">
            <div class="app-topbar d-flex align-items-center justify-content-between">
                <button class="btn btn-light btn-sm d-lg-none" id="sidebarToggle">☰</button>
                <div></div>
            </div>
            <div class="app-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="/js/api.js"></script>
    <script src="/js/auth-check.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // App shell visibility and nav active state (auth pages won't use this layout)
        document.addEventListener('DOMContentLoaded', function() {
            const shell = document.getElementById('appShell');
            if (shell) shell.classList.remove('d-none');

            const links = document.querySelectorAll('.sidebar-nav .nav-link');
            links.forEach(l => {
                const path = l.getAttribute('data-nav');
                if (window.location.pathname.startsWith(path)) {
                    l.classList.add('active');
                }
            });

            const btn = document.getElementById('sidebarToggle');
            if (btn) {
                btn.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-open');
                });
            }

            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function () {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                });
            }
        });
    </script>

</body>
</html>
