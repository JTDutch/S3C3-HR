<!-- Main Content -->
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Employee On/Offboarding</h1>
            <p class="text-muted">Manage employee onboarding and offboarding processes</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary btn-lg me-2" data-bs-toggle="modal" data-bs-target="#onboardModal">
                <span class="me-2">+</span>New Onboarding
            </button>
            <button class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#offboardModal">
                <span class="me-2">-</span>Initiate Offboarding
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <svg width="24" height="24" fill="currentColor" class="text-success" viewBox="0 0 16 16">
                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active Employees</h6>
                            <h2 class="mb-0"><?=$onboarded_employees_count?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <svg width="24" height="24" fill="currentColor" class="text-warning" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Offboarded</h6>
                            <h2 class="mb-0"><?=$offboarded_employees_count?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="onboarding-tab" data-bs-toggle="tab" data-bs-target="#onboarding" type="button" role="tab">
                Onboared (<?=$onboarded_employees_count?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="offboarding-tab" data-bs-toggle="tab" data-bs-target="#offboarding" type="button" role="tab">
                Offboarded (<?=$offboarded_employees_count?>)
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Onboarding Tab -->
        <div class="tab-pane fade show active" id="onboarding" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 mt-5">Active Employees</h5>
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th class="w-20">Name</th>
                                    <th class="w-20">Email</th>
                                    <th class="w-20">Department</th>
                                    <th class="w-10">Onboarding date</th>
                                    <th class="w-20">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($onboarded_employees as $employee):?>
                                <tr>
                                    <td><?=$employee->name?></td>
                                    <td><?=$employee->email?></td>
                                    <td><?=$employee->department_name?></td>
                                    <td>
                                        <span class="badge bg-success fs-6 py-2 px-3">
                                            <?= date('d/m/Y', strtotime($employee->created_at)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/start-offboarding/<?=$employee->id?>" class="btn btn-sm btn-danger me-2">Start Offboarding</a>
                                        <a href="/employee/<?=$employee->id?>" class="btn btn-sm btn-outline-secondary">View Details</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Offboarding Tab -->
        <div class="tab-pane fade" id="offboarding" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 mt-5">Offboarded</h5>
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th class="w-20">Name</th>
                                    <th class="w-20">Email</th>
                                    <th class="w-20">Department</th>
                                    <th class="w-10">Offboarding date</th>
                                    <th class="w-20">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($offboarded_employees as $employee):?>
                                <tr>
                                    <td><?=$employee->name?></td>
                                    <td><?=$employee->email?></td>
                                    <td><?=$employee->department_name?></td>
                                    <td>
                                        <span class="badge bg-danger fs-6 py-2 px-3">
                                            <?= date('d/m/Y', strtotime($employee->updated_at)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/employee/<?=$employee->id?>" class="btn btn-sm btn-outline-secondary">View Details</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Onboard Modal -->
<div class="modal fade" id="onboardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Employee Onboarding</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/onboarding/create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Start Onboarding</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Offboard Modal -->
<div class="modal fade" id="offboardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Initiate Offboarding</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/offboarding/create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="offboard_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="offboard_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="offboard_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="offboard_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="offboard_department" class="form-label">Department</label>
                        <select class="form-select" id="offboard_department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Sales">Sales</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="offboard_position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="offboard_position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastDay" class="form-label">Last Working Day</label>
                        <input type="date" class="form-control" id="lastDay" name="last_day" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Initiate Offboarding</button>
                </div>
            </form>
        </div>
    </div>
</div>

