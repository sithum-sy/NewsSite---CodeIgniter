<div class="content">
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="mb-4">Register a New User</h2>
            <form action="/register_user" method="POST">
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
                    <label for="role_id" class="form-label">Role</label>
                    <select class="form-select" id="role_id" name="role_id" required>
                        <!-- Populate options dynamically from the 'roles' table in your database -->
                        <option value="" disabled selected>Select Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Editor</option>
                        <option value="3">Subscriber</option>
                        <!-- Add other roles as per your system -->
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Register User</button>
            </form>
        </div>
    </div>