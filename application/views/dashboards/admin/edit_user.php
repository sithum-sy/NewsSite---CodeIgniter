<div class="container user-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary btn-back">
                <i class="fas fa-arrow-left"></i> Back to User List
            </a>
            <?php if (isset($validation_errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo $validation_errors; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="form-header text-center">
                    <h2>Edit User</h2>
                </div>

                <div class="form-body">
                    <form action="<?= site_url('users/update_user/' . $user['id']); ?>" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-select" id="role_id" name="role_id">
                                <!-- Check if role_id is NULL, only set selected if it has a valid role -->
                                <option value="" <?php echo ($user['role_id'] == NULL) ? 'selected' : ''; ?>>Select Role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id']; ?>" <?php echo ($role['id'] == $user['role_id']) ? 'selected' : ''; ?>>
                                        <?= $role['role']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="current_status" value="<?php echo $user['is_active']; ?>">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>