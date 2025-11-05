@extends('frontend.layout')

@section('content')
<div class="container py-5">

    <div id="loading" class="text-center my-5">
        <div class="spinner-border"></div>
        <p class="mt-2">Loading dashboard...</p>
    </div>

    <div id="dashboardContent" class="mx-auto d-none">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h3 class="fw-bold text-primary">👋 Welcome, <span id="username">User</span></h3>
                <p class="text-muted mb-0">Your subscription overview</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted">Active Subscriptions</div>
                                <div class="fs-3 fw-semibold" id="statActive">-</div>
                            </div>
                            <span class="badge bg-primary">Total</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted">This Month Spend</div>
                                <div class="fs-3 fw-semibold" id="statMonth">-</div>
                            </div>
                            <span class="badge bg-success">INR</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted">Upcoming Renewals</div>
                                <div class="fs-3 fw-semibold" id="statUpcoming">-</div>
                            </div>
                            <span class="badge bg-warning text-dark">7 days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <strong>Next Renewals</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Renewal Date</th>
                            </tr>
                        </thead>
                        <tbody id="upcomingTableBody">
                            <tr><td colspan="3" class="text-center text-muted py-4">No data</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", async function () {

    const token = localStorage.getItem("token");
    if (!token) return window.location.href = "/login";

    const result = await API.getProfile();

    const user = result.success ? (result.data && result.data.data ? result.data.data.user : null) : null;
    if (!user) {
        return API.handleUnauthorized();
    }

    document.getElementById("username").innerText = user.name;

    // ✅ Hide loader, show dashboard UI
    document.getElementById("loading").classList.add("d-none");
    document.getElementById("dashboardContent").classList.remove("d-none");

    // ✅ Show navbar
    const header = document.getElementById("headerNav");
    if (header) header.classList.remove("d-none");

    // Load dashboard stats
    try {
        const [summary, upcoming] = await Promise.all([
            API.getDashboardSummary(),
            API.getUpcomingRenewals()
        ]);

        if (summary.success && summary.data) {
            const s = summary.data;
            document.getElementById('statActive').innerText = (s.total_subscriptions ?? s.active_subscriptions) ?? '-';
            document.getElementById('statMonth').innerText = (s.total_amount ?? s.current_month_total) ?? '-';
            // upcoming count will be set from upcoming call
        }

        if (upcoming.success && (Array.isArray(upcoming.data) || Array.isArray(upcoming.data?.upcoming_renewals))) {
            const body = document.getElementById('upcomingTableBody');
            body.innerHTML = '';
            const items = Array.isArray(upcoming.data) ? upcoming.data : (upcoming.data?.upcoming_renewals || []);
            document.getElementById('statUpcoming').innerText = items.length ?? '-';
            if (items.length === 0) {
                body.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4">No upcoming renewals</td></tr>';
            } else {
                items.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${item.name ?? item.service_name ?? '-'}</td>
                        <td>${item.price ?? item.amount ?? '-'}</td>
                        <td>${item.renewal_date ?? item.next_renewal_date ?? '-'}</td>
                    `;
                    body.appendChild(tr);
                });
            }
        }
    } catch (e) {
        console.error(e);
    }
});
</script>

@endsection
