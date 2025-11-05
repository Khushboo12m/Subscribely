<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Subscribely</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="/js/api.js"></script>
</head>

<body class="auth-bg">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card auth-card shadow-lg border-0">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-3 primary-text">Verify OTP</h3>
                <p class="text-center text-muted">Enter the 6-digit OTP sent to your email.</p>
                <form id="otpForm">
                    <div class="mb-3">
                        <label class="form-label">OTP</label>
                        <input type="text" id="otp" class="form-control" placeholder="Enter OTP" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Verify</button>
                </form>
                <p class="text-center mt-3"><a href="/forgot-password" class="accent-text">Resend OTP</a></p>
            </div>
        </div>
    </div>

<script>
document.getElementById('otpForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const email = localStorage.getItem('fp_email');
    const otp = document.getElementById('otp').value;
    if (!email) {
        return Swal.fire({ icon: 'error', title: 'Missing email', text: 'Start again.' }).then(() => window.location.href = '/forgot-password');
    }
    const res = await API.request('/verify-otp', 'POST', { email, otp }, false);
    if (res.success) {
        Swal.fire({ icon: 'success', title: 'Verified', text: 'Set new password', timer: 1200, showConfirmButton: false });
        setTimeout(() => { window.location.href = '/reset-password'; }, 1200);
    } else {
        Swal.fire({ icon: 'error', title: 'Invalid OTP', text: res.data?.message || 'Please try again' });
    }
});
</script>

</body>
</html>


