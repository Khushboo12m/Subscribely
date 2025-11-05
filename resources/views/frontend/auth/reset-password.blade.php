<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Subscribely</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="/js/api.js"></script>
</head>

<body class="auth-bg">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card auth-card shadow-lg border-0">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-3 primary-text">Reset Password</h3>
                <form id="resetForm">
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Reset Password</button>
                </form>
                <p class="text-center mt-3"><a href="/login" class="accent-text">Back to Login</a></p>
            </div>
        </div>
    </div>

<script>
document.getElementById('resetForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const email = localStorage.getItem('fp_email');
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    if (!email) {
        return Swal.fire({ icon: 'error', title: 'Missing email', text: 'Start again.' }).then(() => window.location.href = '/forgot-password');
    }
    const res = await API.request('/reset-password', 'POST', { email, password, password_confirmation }, false);
    if (res.success) {
        localStorage.removeItem('fp_email');
        Swal.fire({ icon: 'success', title: 'Password reset', text: 'Please login', timer: 1500, showConfirmButton: false });
        setTimeout(() => { window.location.href = '/login'; }, 1500);
    } else {
        let msg = res.data?.message || 'Reset failed';
        if (res.data?.errors) msg = Object.values(res.data.errors).flat().join('\n');
        Swal.fire({ icon: 'error', title: 'Error', text: msg });
    }
});
</script>

</body>
</html>


