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
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i> Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-globe"></i> World</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-briefcase"></i> Business</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-laptop"></i> Technology</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-futbol"></i> Sports</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('about'); ?>"><i class="fas fa-info-circle"></i> About</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('contact'); ?>"><i class="fas fa-envelope"></i> Contact</a></li>
                        <li class="nav-item">
                            <a class="nav-link text-success" href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-user"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?php echo site_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- News View Section -->
        <div class="container my-5">
            <div class="row">
                <!-- Print and Download Buttons -->
                <div class="col-12 text-end mb-3">
                    <button class="btn btn-outline-primary me-2" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="<?php echo site_url('editor/news/download_pdf/' . $news_item['id']); ?>" class="btn btn-outline-success">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>

                <!-- News Content -->
                <div class="col-md-12">
                    <h1 class="display-4 text-center"><?php echo $news_item['title']; ?></h1>
                    <p class="text-muted text-center">
                        <i class="fas fa-calendar-alt"></i> Published on: <span><?php echo $news_item['updated_at']; ?></span> |
                        <i class="fas fa-tags"></i> Tags: <span><?php echo $news_item['tag_names']; ?></span> |
                        <i class="fas fa-folder"></i> Category: <span><?php echo $news_item['category_name']; ?></span>
                    </p>

                    <p class="text-muted text-center">
                        <i class="fas fa-user"></i> Author: <span><?php echo $news_item['first_name'] . ' ' . $news_item['last_name']; ?></span>

                    </p>
                    <hr>
                    <img src="<?php echo base_url($news_item['image']); ?>" class="img-fluid rounded mb-4" alt="News Image">
                    <div class="news-content">
                        <p><?php echo nl2br($news_item['content']); ?></p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo site_url('home'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to News</a>
                        <button class="btn btn-primary"><i class="fas fa-share-alt"></i> Share</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>