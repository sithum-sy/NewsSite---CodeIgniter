<div class="container dashboard">
    <div class="row mb-4">
        <div class="col text-start">
            <h1 class="dashboard-heading">Journalist Dashboard
        </div>
        <div class="row mb-4">
            <div class="col text-end">
                <a href="<?php echo site_url('news/create'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create News
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <h4>Your Articles</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($news_articles as $article): ?>
                                    <tr>
                                        <td><?php echo $article['id']; ?></td>
                                        <td><?php echo $article['title']; ?></td>
                                        <td><?php echo $article['category']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo ($article['status'] === 'pending') ? 'warning' : (($article['status'] === 'approved') ? 'info' : (($article['status'] === 'published') ? 'success' : 'danger')); ?>">
                                                <?php echo ucfirst($article['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $article['created_at']; ?></td>
                                        <td class="table-actions">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo site_url('journalist/news/' . $article['id']); ?>" class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= site_url('news/edit_news_form/' . $article['id']); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= site_url('news/delete_news_article/' . $article['id']); ?>" class="btn btn-danger btn-sm" title="Delete" onClick="if(!confirm('Are you sure?')) { event.preventDefault(); }">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>