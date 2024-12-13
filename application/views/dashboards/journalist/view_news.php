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