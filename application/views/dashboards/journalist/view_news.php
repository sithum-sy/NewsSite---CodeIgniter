<div class="container my-5 dashboard">
    <div class="row">
        <div class="col-12 text-end mb-3">
            <a href="<?= site_url('news/edit_news_form/' . $news_item['id']); ?>" class="btn btn-outline-dark">
                <i class="fa-regular fa-pen-to-square"></i> Edit
            </a>
            <button class="btn btn-outline-primary me-2" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="<?= site_url('editor/news/download_pdf/' . $news_item['id']); ?>" class="btn btn-outline-success">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>

            <?php if ($news_item['status'] == 'approved'): ?>
                <form action="<?= site_url('journalist/publish/' . $news_item['id']); ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Publish
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <h1 class="display-4 text-center"><?= $news_item['title']; ?></h1>
            <p class="text-muted text-center">
                <i class="fas fa-calendar-alt"></i> Published on: <span><?= $news_item['updated_at']; ?></span> |
                <i class="fas fa-tags"></i> Tags: <span><?= $news_item['tag_names']; ?></span> |
                <i class="fas fa-folder"></i> Category: <span><?= $news_item['category_name']; ?></span>
            </p>

            <hr>
            <img src="<?= base_url($news_item['image']); ?>" class="img-fluid rounded mb-4" alt="News Image">
            <div class="news-content">
                <p><?= nl2br($news_item['content']); ?></p>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>