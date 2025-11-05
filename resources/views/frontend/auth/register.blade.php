<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Subscribely</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- API Helper -->
    <script src="/js/api.js"></script>
</head>

<body class="auth-bg">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card auth-card shadow-soft border-0" style="max-width:520px;">
            <div class="card-body p-4">

                <div class="text-center mb-3">
                    <div class="fw-bold fs-4 primary-text">Subscribely</div>
                </div>
                <h3 class="text-center fw-bold mb-2" style="color:#0f172a">Create Account ✨</h3>
                <p class="text-center text-muted mb-4">Start tracking your subscriptions</p>

                <form id="registerForm">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Register</button>

                </form>

                <p class="text-center mt-3">
                    Already have an account?
                    <a href="/login" class="accent-text fw-semibold">Login Now</a>
                </p>

            </div>
        </div>
    </div>


<script>
document.getElementById('registerForm').addEventListener("submit", async function(event) {
    event.preventDefault();

    // Get form button to show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';

    let formData = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
        password_confirmation: document.getElementById("password_confirmation").value
    };

    try {
        const response = await API.register(formData.name, formData.email, formData.password, formData.password_confirmation);
        const data = response.data || {};
        if (response.success && (data.access_token || data.token)) {
            const token = data.access_token || data.token;
            localStorage.setItem('token', token);
            localStorage.setItem('token_type', data.token_type || 'Bearer');
            Swal.fire({ icon: 'success', title: 'Registered Successfully!', text: 'Redirecting...', timer: 1200, showConfirmButton: false });
            setTimeout(() => { window.location.href = '/dashboard'; }, 1200);
        } else {
            let errorMessage = data?.message || 'Registration failed!';
            if (data?.errors) errorMessage = Object.values(data.errors).flat().join('<br>');
            Swal.fire({ icon: 'error', title: 'Registration Failed', html: errorMessage });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Network error. Please try again.',
        });
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
});
</script>

</body>
</html>
