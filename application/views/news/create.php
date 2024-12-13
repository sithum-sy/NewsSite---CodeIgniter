<div class="container dashboard py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Create News Article</h4>
                    <form method="POST" action="<?php echo site_url('news/store'); ?>" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tag" class="form-label">Tag</label>
                            <select class="form-control" id="tag" name="tag" required>
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mt-3">Submit News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>