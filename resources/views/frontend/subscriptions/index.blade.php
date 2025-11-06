@extends('frontend.layout')

@section('content')
<div class="container py-4">

    <!-- ✅ Search + Filter Row -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search service...">
        </div>
        <div class="col-md-3">
            <select id="filterCategory" class="form-select">
                <option value="">All Categories</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary w-100" id="filterBtn">Filter</button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">Subscriptions</h4>
        <button class="btn btn-primary btn-sm" id="addBtn">➕ Add Subscription</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Service</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Billing Cycle</th>
                    <th>Next Renewal</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="subscriptionBody">
                <tr>
                    <td colspan="6" class="text-center py-4">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ✅ Pagination Controls -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <button class="btn btn-outline-secondary btn-sm" id="prevBtn" disabled>Prev</button>

        <span id="paginationNumbers"></span>

        <button class="btn btn-outline-secondary btn-sm" id="nextBtn" disabled>Next</button>
    </div>

</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="modalTitle">Add Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="subscriptionForm">
                    <input type="hidden" id="subId">

                    <div class="mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" id="service_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select id="category" class="form-select" required>
                            <option value="" disabled selected>Select Category</option>
                        </select>
                    </div>
                  

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" id="amount" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Billing Cycle</label>
                        <select id="billing_cycle" class="form-select" required>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Next Renewal Date</label>
                        <input type="date" id="next_renewal_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="saveBtn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const body = document.getElementById("subscriptionBody");
    let currentPage = 1;
    let totalPages = 1;

    const modal = new bootstrap.Modal(document.getElementById("subscriptionModal"));
    const modalTitle = document.getElementById("modalTitle");
    const form = document.getElementById("subscriptionForm");

    async function loadSubscriptions(page = 1) {
        const search = document.getElementById("searchInput").value;
        const category = document.getElementById("filterCategory").value;

        body.innerHTML = `<tr><td colspan="6" class="text-center">Loading...</td></tr>`;

        const res = await API.listSubscriptions({ page, search, category });

    if (!res.status) {
        body.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Failed to load</td></tr>`;
        return;
    }

    const items = res.data?.data?.data || [];
    totalPages = res.data?.data?.last_page || 1;
    currentPage = res.data?.data?.current_page || 1;


    if (items.length === 0) {
        body.innerHTML = `<tr><td colspan="6" class="text-muted text-center">No matching results</td></tr>`;
        return;
    }

    body.innerHTML = "";
    items.forEach(item => {
        body.innerHTML += `
            <tr>
                <td>${item.service_name}</td>
                <td>${item.category ?? '-'}</td>
                <td>${item.amount}</td>
                <td>${item.billing_cycle}</td>
                <td>${item.next_renewal_date}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary me-2" data-action="edit" data-id="${item.id}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${item.id}">Delete</button>
                </td>
            </tr>
        `;
    });

    updatePaginationUI();

}

    window.loadSubscriptions = loadSubscriptions;


    currentPage = 1;
    loadSubscriptions(1);

        function updatePaginationUI() {
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const pages = document.getElementById("paginationNumbers");

        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= totalPages;

        pages.innerHTML = "";
        for (let i = 1; i <= totalPages; i++) {
            pages.innerHTML += `
                <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-light'} mx-1"
                    onclick="loadSubscriptions(${i})">
                    ${i}
                </button>`;
        }
    }


    document.getElementById("prevBtn").addEventListener("click", () => {
        if (currentPage > 1) loadSubscriptions(currentPage - 1);
    });

    document.getElementById("nextBtn").addEventListener("click", () => {
        if (currentPage < totalPages) loadSubscriptions(currentPage + 1);
    });



    // Add New
    document.getElementById("addBtn").addEventListener("click", () => {
        form.reset();
        document.getElementById("subId").value = "";
        modalTitle.innerText = "Add Subscription";
        modal.show();
    });

    // Edit OR Delete via table button click
    body.addEventListener("click", async (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const id = btn.getAttribute("data-id");
        const action = btn.getAttribute("data-action");

        if (action === "edit") {
            const res = await API.getSubscription(id);

            if (res.success && res.data?.subscription) {
                const s = res.data.subscription;
                document.getElementById("subId").value = s.id;
                document.getElementById("service_name").value = s.service_name;
                document.getElementById("category").value = s.category;
                document.getElementById("amount").value = s.amount;
                document.getElementById("billing_cycle").value = s.billing_cycle;
                document.getElementById("next_renewal_date").value = s.next_renewal_date;

                modalTitle.innerText = "Edit Subscription";
                modal.show();
            } else {
                Swal.fire("Error", "Failed to load data", "error");
            }
        }

        if (action === "delete") {
            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete subscription",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Delete"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const response = await API.deleteSubscription(id);
                    if (response.success) {
                        Swal.fire("Deleted!", "Subscription removed", "success");
                        loadSubscriptions();
                    }
                }
            });
        }
    });

    // Save (Add/Update)
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const payload = {
            service_name: document.getElementById("service_name").value,
            category: document.getElementById("category").value, 
            amount: document.getElementById("amount").value,
            billing_cycle: document.getElementById("billing_cycle").value,
            next_renewal_date: document.getElementById("next_renewal_date").value,
        };

        const id = document.getElementById("subId").value;
        const res = id
            ? await API.updateSubscription(id, payload)
            : await API.createSubscription(payload);

        if (res.success) {
            Swal.fire("Success", id ? "Updated Successfully" : "Added Successfully","success");
            modal.hide();
            loadSubscriptions();
        } else {
            Swal.fire("Error", "Failed to save", "error");
        }
    });

        async function loadCategories() {
        const res = await API.getCategories();
        const select = document.getElementById("category");

        select.innerHTML = `<option disabled selected>Select Category</option>`;
        res.data.categories.forEach(cat => {
            select.innerHTML += `<option value="${cat}">${cat}</option>`;
        });
    }

    loadCategories();

        async function loadFilterCategories() {
        const res = await API.getCategories();
        const select = document.getElementById("filterCategory");

        res.data.categories.forEach(cat => {
            select.innerHTML += `<option value="${cat}">${cat}</option>`;
        });
    }

    loadFilterCategories();

    document.getElementById("filterBtn").addEventListener("click", () => {
    currentPage = 1;   
    loadSubscriptions(1);});

});
</script>
@endsection
