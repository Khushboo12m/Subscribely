<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscribely</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/api.js"></script>
</head>
<body class="auth-bg">
    <div class="container py-5">
        <div class="row align-items-center vh-100">
            <div class="col-lg-6 text-white">
                <h1 class="fw-bold" style="font-size: 3rem;">Track all your subscriptions in one place</h1>
                <p class="lead mt-3">Stay on top of renewals, spending, and upcoming charges with Subscribely.</p>
                <div class="mt-4">
                    <a href="/login" class="btn btn-light btn-lg me-2">Login</a>
                    <a href="/register" class="btn btn-outline-light btn-lg">Create Account</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-soft border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-2">Why Subscribely?</h4>
                        <ul class="mb-0">
                            <li class="mb-2">Dashboard with monthly totals and upcoming renewals</li>
                            <li class="mb-2">Manage subscriptions with ease</li>
                            <li class="mb-2">Clean, modern UI</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (localStorage.getItem('token')) {
            window.location.replace('/dashboard');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
