<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employees</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Employee Records</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin/payroll" class="btn btn-outline-dark rounded-pill fw-bold">
                    <i class="fas fa-money-check-alt me-2"></i> Payroll
                </a>
                <button class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#employeeModal">
                    <i class="fas fa-plus me-2"></i> Add Employee
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3">Employee added successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-info border-0 shadow-sm rounded-3">Employee updated successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning border-0 shadow-sm rounded-3">Employee deleted (and their payroll records).</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3">
                <?php echo $_GET['error'] === 'duplicate' ? 'That employee number is already in use.' : 'Could not save the employee. Please check the details and try again.'; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo ROOT; ?>/admin/employees" method="GET" class="mb-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                <span class="input-group-text border-0 bg-transparent ps-4"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search by name, code, position, department or email..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <?php if (!empty($search)): ?>
                    <a href="<?php echo ROOT; ?>/admin/employees" class="btn border-0 bg-transparent text-muted py-2 d-flex align-items-center" title="Clear Search"><i class="fas fa-times"></i></a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary px-4 fw-bold">Search</button>
            </div>
        </form>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Emp. No.</th>
                                <th>Name</th>
                                <th>Position / Dept</th>
                                <th>Contact</th>
                                <th>Basic Salary</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr><td colspan="7" class="text-center py-5 text-muted"><?php echo !empty($search) ? 'No employees match your search.' : 'No employees yet.'; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($items as $e): ?>
                                    <tr>
                                        <td class="ps-4 small text-muted"><?php echo htmlspecialchars($e['employee_code']); ?></td>
                                        <td class="fw-bold"><?php echo htmlspecialchars($e['full_name']); ?></td>
                                        <td class="small">
                                            <?php echo htmlspecialchars($e['position'] ?? ''); ?>
                                            <span class="text-muted d-block"><?php echo htmlspecialchars($e['department'] ?? ''); ?></span>
                                        </td>
                                        <td class="small">
                                            <?php echo htmlspecialchars($e['email'] ?? ''); ?>
                                            <span class="text-muted d-block"><?php echo htmlspecialchars($e['phone'] ?? ''); ?></span>
                                        </td>
                                        <td class="small">GH₵ <?php echo number_format($e['basic_salary'], 2); ?></td>
                                        <td>
                                            <span class="badge <?php echo $e['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>"><?php echo ucfirst($e['status']); ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light border-0 me-1" onclick="editEmployee(<?php echo htmlspecialchars(json_encode($e), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/employees_delete/<?php echo $e['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete this employee and all their payroll records?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="employeeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="empModalTitle">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/employees" method="POST" id="employeeForm">
                <input type="hidden" name="id" id="empId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Employee Number *</label>
                            <input type="text" name="employee_code" id="empCode" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Full Name *</label>
                            <input type="text" name="full_name" id="empName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" id="empEmail" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone</label>
                            <input type="text" name="phone" id="empPhone" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Position</label>
                            <input type="text" name="position" id="empPosition" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Department</label>
                            <input type="text" name="department" id="empDepartment" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Date Hired</label>
                            <input type="date" name="date_hired" id="empHired" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Basic Salary (GH₵) *</label>
                            <input type="number" step="0.01" min="0" name="basic_salary" id="empBasic" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Allowances (GH₵)</label>
                            <input type="number" step="0.01" min="0" name="allowances" id="empAllowances" class="form-control" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" id="empStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Bank Name</label>
                            <input type="text" name="bank_name" id="empBank" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Bank Account No.</label>
                            <input type="text" name="bank_account" id="empAccount" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">SSNIT Number</label>
                            <input type="text" name="ssnit_number" id="empSsnit" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">TIN Number</label>
                            <input type="text" name="tin_number" id="empTin" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_employee" id="empSubmit" class="btn btn-primary rounded-pill px-5 fw-bold">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editEmployee(e) {
        document.getElementById('empModalTitle').innerText = 'Edit Employee';
        var map = {empId: 'id', empCode: 'employee_code', empName: 'full_name', empEmail: 'email', empPhone: 'phone',
            empPosition: 'position', empDepartment: 'department', empHired: 'date_hired', empBasic: 'basic_salary',
            empAllowances: 'allowances', empStatus: 'status', empBank: 'bank_name', empAccount: 'bank_account',
            empSsnit: 'ssnit_number', empTin: 'tin_number'};
        for (var id in map) document.getElementById(id).value = e[map[id]] || '';
        document.getElementById('empSubmit').name = 'edit_employee';
        document.getElementById('empSubmit').innerText = 'Update Employee';
        new bootstrap.Modal(document.getElementById('employeeModal')).show();
    }

    document.getElementById('employeeModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('employeeForm').reset();
        document.getElementById('empId').value = '';
        document.getElementById('empModalTitle').innerText = 'Add Employee';
        document.getElementById('empSubmit').name = 'add_employee';
        document.getElementById('empSubmit').innerText = 'Save Employee';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
