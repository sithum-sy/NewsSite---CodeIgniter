<div class="container admin-dashboard">
    <h2 class="my-4">Manage News Articles</h2>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Journalist</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news_articles as $article): ?>
                    <tr>
                        <td><?php echo $article['id']; ?></td>
                        <td><?php echo $article['title']; ?></td>
                        <td><?php echo $article['category_name']; ?></td>
                        <td><?php echo $article['tag_names']; ?></td>
                        <td><?php echo $article['first_name'] . ' ' . $article['last_name']; ?></td>
                        <td><?php echo $article['updated_at']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($article['status'] == 'pending') ? 'warning' : (($article['status'] == 'approved') ? 'success' : 'danger'); ?>">
                                <?php echo ucfirst($article['status']); ?>
                            </span>
                        </td>
                        <td class="table-actions">
                            <a href="<?php echo site_url('editor/news/' . $article['id']); ?>" class="btn btn-success btn-sm">Review</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>