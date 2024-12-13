<!-- User Details Content -->
<div class="container user-details">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary btn-back">
                <i class="fas fa-arrow-left"></i> Back to User List
            </a>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="profile-header text-center">
                    <i class="fas fa-user-circle fa-5x mb-3"></i>
                    <h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
                    <span class="badge 
                            <?php echo $user['is_active'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo $user['is_active'] == 1 ? 'Active' : 'Inactive'; ?>
                    </span>
                </div>

                <div class="profile-details">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="detail-label">First Name</span>
                            <p><?php echo $user['first_name']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <span class="detail-label">Last Name</span>
                            <p><?php echo $user['last_name']; ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="detail-label">Email Address</span>
                            <p><?php echo $user['email']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <span class="detail-label">Contact Number</span>
                            <p><?php echo $user['contact_number']; ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="detail-label">Role</span>
                            <p><?php echo $user['role']; ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <a href="<?php echo site_url('users/edit_user/' . $user['id']);
                                            ?>" class="btn btn-warning me-2">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                <form action="<?php echo site_url('users/toggle_user_status/' . $user['id']); ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="current_status" value="<?php echo $user['is_active']; ?>">
                                    <button type="submit" class="btn <?php echo $user['is_active'] == 1 ? 'btn-danger' : 'btn-success'; ?>">
                                        <?php echo $user['is_active'] == 1 ? 'Deactivate' : 'Activate'; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>