<!-- Main Dashboard Content -->
<div class="container-fluid px-3 admin-dashboard">
    <div class="row mb-4">
        <div class="col text-start">
            <h1 class="dashboard-heading">Admin Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <!-- Create User Section -->
        <div class="col-md-2 create-user-section mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">User Management</h4>
                    <a href="<?php echo site_url('register'); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Create New User
                    </a>
                </div>
            </div>
        </div>

        <!-- User Management Section -->
        <div class="col-md-10 user-management-section">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> User List
                    </h3>
                    <a href="<?php echo site_url('users/export_users_to_excel'); ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Download Spreadsheet
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['id']; ?></td>
                                        <td>
                                            <?= $user['first_name'] . ' ' . $user['last_name']; ?>
                                        </td>
                                        <td><?= $user['role']; ?></td>
                                        <td>
                                            <?= $user['email']; ?><br>
                                        </td>
                                        <td>
                                            <?= $user['contact_number']; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $user['is_active'] == 1 ? 'bg-success' : 'bg-danger'; ?> status-badge">
                                                <?= $user['is_active'] == 1 ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td class="table-actions">
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('users/view_user/' . $user['id']); ?>" class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= site_url('users/edit_user/' . $user['id']); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= site_url('users/delete_user/' . $user['id']); ?>" class="btn btn-danger btn-sm" title="Delete" onClick="if(!confirm('Are you sure?')) { event.preventDefault(); }">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form action="<?= site_url('users/toggle_user_status/' . $user['id']); ?>" method="post" style="display:inline;">
                                                    <input type="hidden" name="current_status" value="<?= $user['is_active']; ?>">
                                                    <button type="submit"
                                                        class="btn <?= $user['is_active'] == 1 ? 'btn-warning' : 'btn-success'; ?> btn-sm">
                                                        <?= $user['is_active'] == 1 ? 'Deactivate' : 'Activate'; ?>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>