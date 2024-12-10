<div class="content">
    <div class="main-content">

        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand text-uppercase fw-bold" href="<?php echo site_url('home'); ?>">
                    <i class="fas fa-newspaper"></i> X News
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#"><i class="fas fa-globe"></i> World</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#"><i class="fas fa-briefcase"></i> Business</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#"><i class="fas fa-laptop"></i> Technology</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#"><i class="fas fa-futbol"></i> Sports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?php echo site_url('about'); ?>"><i class="fas fa-info-circle"></i> About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?php echo site_url('contact'); ?>"><i class="fas fa-envelope"></i> Contact</a>
                        </li>
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-success" href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-user"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="<?php echo site_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="<?php echo site_url('login'); ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="<?php echo site_url('register'); ?>"><i class="fas fa-user-plus"></i> Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Main Headline Section -->
        <header class="bg-primary text-white text-center py-5">
            <div class="container">
                <h1 id="headline-title" class="display-4">Breaking News: Major Event Happening Right Now!</h1>
                <!-- <p id="headline-summary" class="lead">Stay updated with the latest news and headlines from around the world.</p> -->
            </div>
        </header>


        <!-- News Articles Section -->
        <div class="container my-5">
            <div class="row">
                <?php foreach ($news as $news_item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo base_url($news_item['image']); ?>" class="card-img-top" alt="Article Image">

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $news_item['title']; ?></h5>
                                <p class="card-text">
                                    <?php echo word_limiter($news_item['content'], 20); ?>
                                </p>
                                <a href="<?php echo site_url('news/' . $news_item['slug']); ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>