<div class="container my-5">
    <div id="news-container" class="row">
        <?php foreach ($news as $news_item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo base_url($news_item['image']); ?>" class="card-img-top" alt="Article Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $news_item['title']; ?></h5>
                        <p class="card-text" style="font-size: 12px; color: gray;">
                            <?php echo $news_item['updated_at']; ?>
                        </p>
                        <p class="card-text">
                            <?php echo word_limiter($news_item['content'], 20); ?>
                        </p>
                        <a href="<?php echo site_url('news/' . $news_item['slug']); ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination Links -->
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <?php echo $pagination; ?>
        </div>
    </div>
</div>