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

        <!-- Contact Section -->
        <div class="container my-5">
            <h1 class="text-center mb-4">Contact Us</h1>
            <div class="row">
                <div class="col-md-6">
                    <h4>Get in Touch</h4>
                    <p>If you have any queries, suggestions, or need assistance, feel free to reach out. We'd love to hear from you!</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope"></i> Email: contact@newssite.com</li>
                        <li><i class="bi bi-telephone"></i> Phone: +123 456 789</li>
                        <li><i class="bi bi-geo-alt"></i> Address: 123 News Avenue, Media City</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Send a Message</h4>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>