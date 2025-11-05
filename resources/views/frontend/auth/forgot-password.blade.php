<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Subscribely</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="/js/api.js"></script>
</head>

<body class="auth-bg">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card auth-card shadow-lg border-0">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-3 primary-text">Forgot Password</h3>
                <p class="text-center text-muted">Enter your email to receive an OTP.</p>
                <form id="forgotForm">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Send OTP</button>
                </form>
                <p class="text-center mt-3"><a href="/login" class="accent-text">Back to Login</a></p>
            </div>
        </div>
    </div>

<script>
document.getElementById('forgotForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    try {
        const res = await API.request('/forgot-password', 'POST', { email }, false);
        if (res.success) {
            localStorage.setItem('fp_email', email);
            Swal.fire({ icon: 'success', title: 'OTP sent', text: 'Check your email', timer: 1500, showConfirmButton: false });
            setTimeout(() => { window.location.href = '/verify-otp'; }, 1500);
        } else {
            let msg = res.data?.message || 'Failed to send OTP';
            if (res.data?.errors) msg = Object.values(res.data.errors).flat().join('\n');
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Network error' });
    }
});
</script>

</body>
</html>


