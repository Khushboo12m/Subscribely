@extends('frontend.layout')

@section('content')
<div class="container py-5">

    <div id="loading" class="text-center my-5">
        <div class="spinner-border"></div>
        <p class="mt-2">Loading dashboard...</p>
    </div>

    <div id="dashboardContent" class="dashboard-card mx-auto d-none">
        <h3 class="fw-bold text-primary">👋 Welcome, <span id="username">User</span></h3>
        <p class="text-muted">Your Subscription Details</p>
        <hr>

        <p class="text-secondary">Coming Soon...</p>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", async function () {

    const token = localStorage.getItem("token");

    // ✅ If no token → instantly logout and redirect
    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const response = await fetch(API_BASE_URL + "/profile", {
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            localStorage.removeItem("token");
            window.location.href = "/login";
            return;
        }

        const user = await response.json();

        if (user.name) {
            document.getElementById("username").innerText = user.name;

            // ✅ Hide loader, show dashboard UI
            document.getElementById("loading").classList.add("d-none");
            document.getElementById("dashboardContent").classList.remove("d-none");

            // ✅ Show navbar now that user is authenticated
            const header = document.getElementById("headerNav");
            if (header) header.classList.remove("d-none");
        } else {
            window.location.href = "/login";
        }

    } catch (error) {
        console.log("Error:", error);
        localStorage.removeItem("token");
        window.location.href = "/login";
    }
});
</script>

@endsection
