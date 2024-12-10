<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View News Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .dashboard {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid px-0">
            <a class="navbar-brand ms-3" href="#">
                <i class="fas fa-tachometer-alt"></i> Journalist Dashboard
            </a>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home'); ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('logout'); ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $news_item['title']; ?></h2>
                        <p class="text-muted">Category: <?php echo $news_item['category_name']; ?></p>
                        <p class="text-muted">Published on: <?php echo $news_item['created_at']; ?></p>
                        <hr>
                        <p><?php echo $news_item['content']; ?></p>
                        <hr>
                        <?php if (!empty($news_item['tags'])): ?>
                            <p><strong>Tags:</strong> <?php echo $news_item['tags']; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($news_item['image_path'])): ?>
                            <img src="<?php echo base_url('uploads/' . $news_item['image_path']); ?>" class="img-fluid mt-3" alt="News Image">
                        <?php endif; ?>

                        <!-- Display Publish button if the status is 'approved' -->
                        <?php if ($news_item['status'] == 'approved'): ?>
                            <form action="<?php echo site_url('journalist/publish/' . $news_item['id']); ?>" method="POST">
                                <button type="submit" class="btn btn-success mt-3">Publish Article</button>
                            </form>
                        <?php endif; ?>

                        <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-primary mt-3">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>