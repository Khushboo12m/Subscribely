@extends('frontend.layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Subscriptions</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriptionModal">Add Subscription</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Cycle</th>
                            <th>Renewal Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subsTableBody">
                        <tr><td colspan="5" class="text-center text-muted py-4">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="subscriptionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="subsForm">
                        <input type="hidden" id="subsId">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="subsName" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="subsPrice" step="0.01" min="0" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Cycle</label>
                                <select id="subsCycle" class="form-select" required>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Renewal Date</label>
                            <input type="date" class="form-control" id="subsRenewalDate" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button id="saveSubsBtn" class="btn btn-primary">Save</button>
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

    const body = document.getElementById('subsTableBody');
    const modalEl = document.getElementById('subscriptionModal');
    const modal = new bootstrap.Modal(modalEl);
    const saveBtn = document.getElementById('saveSubsBtn');

    function fillForm(sub) {
        document.getElementById('subsId').value = sub?.id || '';
        document.getElementById('subsName').value = sub?.name || '';
        document.getElementById('subsPrice').value = sub?.price || '';
        document.getElementById('subsCycle').value = sub?.billing_cycle || 'monthly';
        document.getElementById('subsRenewalDate').value = sub?.renewal_date || '';
        document.getElementById('modalTitle').innerText = sub?.id ? 'Edit Subscription' : 'Add Subscription';
    }

    function readForm() {
        return {
            id: document.getElementById('subsId').value || null,
            service_name: document.getElementById('subsName').value,
            amount: parseFloat(document.getElementById('subsPrice').value),
            billing_cycle: document.getElementById('subsCycle').value,
            next_renewal_date: document.getElementById('subsRenewalDate').value
        };
    }

    async function loadSubscriptions() {
        body.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Loading...</td></tr>';
        const res = await API.listSubscriptions();
        const items = Array.isArray(res.data?.data) ? res.data.data : (res.data?.subscriptions || []);
        if (!res.success) {
            body.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Failed to load</td></tr>';
            return;
        }
        if (items.length === 0) {
            body.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No subscriptions found</td></tr>';
            return;
        }
        body.innerHTML = '';
        items.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.name ?? item.service_name}</td>
                <td>${item.price ?? item.amount}</td>
                <td>${item.billing_cycle}</td>
                <td>${item.renewal_date ?? item.next_renewal_date}</td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary me-2" data-action="edit" data-id="${item.id}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${item.id}">Delete</button>
                </td>
            `;
            body.appendChild(tr);
        });
    }

    body.addEventListener('click', async (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        const id = btn.getAttribute('data-id');
        const action = btn.getAttribute('data-action');
        if (action === 'edit') {
            const res = await API.getSubscription(id);
            if (res.success && res.data) {
                fillForm(res.data);
                modal.show();
            }
        } else if (action === 'delete') {
            const c = await Swal.fire({ icon: 'warning', title: 'Delete?', text: 'This cannot be undone.', showCancelButton: true });
            if (c.isConfirmed) {
                const del = await API.deleteSubscription(id);
                if (del.success) {
                    await loadSubscriptions();
                    Swal.fire({ icon: 'success', title: 'Deleted' });
                } else {
                    Swal.fire({ icon: 'error', title: 'Delete failed' });
                }
            }
        }
    });

    saveBtn.addEventListener('click', async () => {
        const payload = readForm();
        let res;
        if (payload.id) {
            res = await API.updateSubscription(payload.id, payload);
        } else {
            res = await API.createSubscription(payload);
        }
        if (res.success) {
            modal.hide();
            await loadSubscriptions();
            Swal.fire({ icon: 'success', title: 'Saved' });
        } else {
            let errorMessage = res.data?.message || 'Save failed';
            if (res.data?.errors) {
                errorMessage = Object.values(res.data.errors).flat().join('<br>');
            }
            Swal.fire({ icon: 'error', title: 'Error', html: errorMessage });
        }
    });

    // Setup for create
    modalEl.addEventListener('show.bs.modal', (ev) => {
        if (!document.getElementById('subsId').value) fillForm(null);
    });

    await loadSubscriptions();
});
</script>
@endsection


