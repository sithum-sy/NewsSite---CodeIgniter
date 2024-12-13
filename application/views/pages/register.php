<div class="container mt-5">
    <h2 class="mb-4">Register a New User</h2>
    <?php if (validation_errors()): ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?php echo site_url('registerUser'); ?>" method="POST">
        <div class="mb-3">
            <label for="id" class="form-label">Role</label>
            <select class="form-select" id="id" name="id" required>
                <option value="" disabled selected>Select Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id']; ?>"><?= $role['role']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="" required>
        </div>

        <button type="submit" class="btn btn-primary">Register User</button>
    </form>
</div>