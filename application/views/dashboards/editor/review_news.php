<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review News Article</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .review-container {
            margin-top: 20px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .status-badge {
            font-size: 0.9em;
            padding: 0.5em 1em;
        }

        .header-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Hide the buttons when printing */
        @media print {

            .header-buttons,
            .footer-button,
            .header-buttons button,
            .header-buttons a {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container review-container">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3>Review News Article</h3>
                <div class="header-buttons">
                    <button onclick="window.print();" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="<?php echo site_url('editor/news/download_pdf/' . $news_item['id']); ?>" class="btn btn-secondary">
                        <i class="fas fa-file-pdf"></i> Download as PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Title: <?php echo $news_item['title']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Id: <?php echo $news_item['id']; ?></h6>
                <h6 class="card-subtitle mb-2 text-muted">Category: <?php echo $news_item['category_name']; ?></h6>
                <p><strong>Tags:</strong> <?php echo $news_item['tag_names']; ?></p>
                <p><strong>Journalist:</strong> <?php echo $news_item['first_name'] . ' ' . $news_item['last_name']; ?></p>
                <p><strong>Submission Date:</strong> <?php echo $news_item['updated_at']; ?></p>
                <hr>
                <p class="card-text"><strong>Content:</strong></p>
                <p><?php echo $news_item['content']; ?></p>
                <hr>
                <p>
                    <span class="badge bg-<?php echo ($news_item['status'] == 'pending') ? 'warning' : (($news_item['status'] == 'approved') ? 'success' : 'danger'); ?>">
                        Current Status: <?php echo $news_item['status']; ?>
                    </span>
                </p>
                <form action="<?php echo site_url('editor/news/review'); ?>" method="POST">
                    <input type="hidden" name="news_id" value="<?php echo $news_item['id']; ?>">
                    <button type="submit" name="action" value="approve" class="btn btn-success footer-button">Approve</button>
                    <button type="submit" name="action" value="reject" class="btn btn-danger footer-button">Reject</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>