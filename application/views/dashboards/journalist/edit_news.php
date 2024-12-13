<div class="container my-5">
    <h2 class="text-center mb-4">Edit News Article</h2>
    <?php if (isset($validation_errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php echo $validation_errors; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo site_url('news/update_news/' . $news_item['id']); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', $news_item['title']); ?>" required>
            <?php echo form_error('title', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="6" required><?php echo set_value('content', $news_item['content']); ?></textarea>
            <?php echo form_error('content', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $news_item['category_id']) ? 'selected' : ''; ?>>
                        <?php echo $category['category']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php echo form_error('category', '<small class="text-danger">', '</small>'); ?>
        </div>

        <div class="mb-3">
            <label for="tag" class="form-label">Tags</label>
            <select class="form-select" id="tag" name="tag[]" multiple>
                <?php
                $selected_tags = explode(',', $news_item['tag_names']); // Convert tags to an array
                foreach ($tags as $tag): ?>
                    <option value="<?php echo $tag['id']; ?>" <?php echo in_array($tag['tag'], $selected_tags) ? 'selected' : ''; ?>>
                        <?php echo $tag['tag']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (Windows) or Command (Mac) button to select multiple tags.</small>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <?php if (!empty($news_item['image'])): ?>
                <div class="mb-2">
                    <img src="<?php echo base_url($news_item['image']); ?>" alt="Current Image" class="img-thumbnail" width="200">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="image" name="image">
            <small class="form-text text-muted">Leave this blank if you don't want to change the image.</small>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
        </div>
    </form>
</div>