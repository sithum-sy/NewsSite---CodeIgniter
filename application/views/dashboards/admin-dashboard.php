<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for additional icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .admin-dashboard {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .table-actions .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .status-badge {
            font-size: 0.8em;
            padding: 0.3em 0.6em;
        }

        @media (max-width: 768px) {
            .admin-dashboard .row {
                flex-direction: column;
            }

            .create-user-section,
            .user-management-section {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid px-0">
            <a class="navbar-brand ms-3" href="#">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </a>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home'); ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('logout'); ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <div class="container-fluid px-3 admin-dashboard">
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
                                                    <a href="<?= site_url('users/delete_user/' . $user['id']); ?>" class="btn btn-danger btn-sm" title="Delete">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>