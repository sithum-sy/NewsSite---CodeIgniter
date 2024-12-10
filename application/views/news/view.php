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
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- News View Section -->
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="display-4 text-center"><?php echo $news_item['title']; ?></h1>
                    <p class="text-muted text-center">Published on: <span>Date</span></p>
                    <hr>
                    <img src="https://via.placeholder.com/800x400" class="img-fluid rounded mb-4" alt="News Image">
                    <div class="news-content">
                        <p><?php echo nl2br($news_item['content']); ?></p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo site_url('home'); ?>" class="btn btn-secondary">Back to News</a>
                        <button class="btn btn-primary">Share</button>
                    </div>
                </div>
            </div>
        </div>
    </div>