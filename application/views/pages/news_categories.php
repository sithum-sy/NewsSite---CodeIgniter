<!-- Main Headline Section -->
<header class="bg-primary text-white text-center py-5">
    <div class="container">
        <h4 id="headline-title" class="display-4">Breaking News: <?php echo $category; ?></h4>
        <!-- <p id="headline-summary" class="lead">Stay updated with the latest news and headlines from around the world.</p> -->
    </div>
</header>


<!-- News Articles Section -->
<div class="container my-5">
    <div class="row">
        <?php if (!empty($news)): ?>
            <?php foreach ($news as $news_item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo base_url($news_item['image']); ?>" class="card-img-top" alt="Article Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $news_item['title']; ?></h5>
                            <p class="card-text"><?php echo word_limiter($news_item['content'], 20); ?></p>
                            <a href="<?php echo site_url('news/' . $news_item['slug']); ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No news available in this category.</p>
        <?php endif; ?>
    </div>
</div>