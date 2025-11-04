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

    <!-- 🔥 Navbar for logged-in pages -->
    <nav class="navbar navbar-light bg-white shadow-sm px-3 d-none" id="headerNav">
        <a class="navbar-brand">Subscribely</a>
        <button class="btn btn-outline-danger btn-sm" id="logoutBtn">Logout</button>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="/js/api.js"></script>
    <script src="/js/auth-check.js"></script>

    <script>
        // Logout function for all pages using layout
        if(document.getElementById("logoutBtn")) {
            document.getElementById("logoutBtn").addEventListener("click", function () {
                localStorage.removeItem("token");
                window.location.href = "/login";
            });
        }
    </script>

</body>
</html>
