@extends('frontend.layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <strong>My Profile</strong>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100 w-md-auto">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    // Show navbar
    const header = document.getElementById('headerNav');
    if (header) header.classList.remove('d-none');

    const res = await API.getProfile();
    const user = res.success ? (res.data && res.data.data ? res.data.data.user : null) : null;
    if (!user) return API.handleUnauthorized();
    document.getElementById('name').value = user.name || '';
    document.getElementById('email').value = user.email || '';

    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value.trim();
        const upd = await API.updateProfile(name, email, password || null);
        if (upd.success) {
            Swal.fire({ icon: 'success', title: 'Profile updated' });
            document.getElementById('password').value = '';
        } else {
            let errorMessage = upd.data?.message || 'Update failed';
            if (upd.data?.errors) {
                errorMessage = Object.values(upd.data.errors).flat().join('<br>');
            }
            Swal.fire({ icon: 'error', title: 'Error', html: errorMessage });
        }
    });
});
</script>
@endsection


