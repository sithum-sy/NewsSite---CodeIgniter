<div class="content">
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('home'); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('logout'); ?>">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Admin Panel Content -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4">
                    <h3>Create New User</h3>
                    <a href="<?php echo site_url('register'); ?>" class="btn btn-primary">Create New User</a>
                </div>

                <div class="col-md-8">
                    <h3>User Management</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>JohnDoe</td>
                                <td>News Editor</td>
                                <td>johndoe@example.com</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>JaneSmith</td>
                                <td>Journalist</td>
                                <td>janesmith@example.com</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- News Section -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Manage News</h3>
                    <a href="/create-news" class="btn btn-primary mb-3">Create News</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Published Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic content will be inserted here -->
                            <tr>
                                <td>Breaking News: Market Update</td>
                                <td>Business</td>
                                <td>2024-12-01</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Tech Innovations of 2024</td>
                                <td>Technology</td>
                                <td>2024-12-02</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>