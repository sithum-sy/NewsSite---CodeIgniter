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
                            <a class="nav-link" href="<?php echo site_url('about'); ?>">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('news/create'); ?>">Create News</a>
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
                            <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('login'); ?>">Login/Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Headline Section -->
        <header class="bg-primary text-white text-center py-5">
            <div class="container">
                <h1 class="display-4">Breaking News: Major Event Happening Right Now!</h1>
                <p class="lead">Stay updated with the latest news and headlines from around the world.</p>
            </div>
        </header>

        <!-- News Articles Section -->
        <div class="container my-5">
            <div class="row">
                <?php foreach ($news as $news_item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Article Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $news_item['title']; ?></h5>
                                <p class="card-text"><?php echo $news_item['text']; ?></p>
                                <a href="<?php echo site_url('news/' . $news_item['slug']); ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>