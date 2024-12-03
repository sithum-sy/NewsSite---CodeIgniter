<div class="content">
    <div class="main-content">

        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo site_url('home'); ?>">NewsSite</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('home'); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">World</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Business</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Technology</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('about'); ?>">About</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
            <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
                <h2 class="text-center mb-4">Login</h2>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <form action="<?= site_url('users/do_login') ?>" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="text-center mt-3">
                        <a href="#" class="small">Forgot password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>