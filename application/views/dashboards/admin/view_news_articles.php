<div class="container-fluid admin-dashboard">
    <div class="row mb-4">
        <div class="col text-start">
            <h1 class="dashboard-heading">Admin Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <!-- Left side panel for search and filter -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Filter Articles</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo site_url('users/filter_news_articles'); ?>">
                        <!-- Filter by Name -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Search by title">
                        </div>
                        <!-- Filter by Journalist -->
                        <div class="mb-3">
                            <label for="journalist" class="form-label">Journalist</label>
                            <input type="text" name="journalist" id="journalist" class="form-control" placeholder="Search by journalist">
                        </div>
                        <!-- Filter by Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>">
                                        <?php echo $category['category_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Filter by Date -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Submission Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                        <!-- Filter Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Main content: Table and heading -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="my-4">Manage News Articles</h3>
                <div>
                    <a href="<?php echo site_url('users/export_news_articles_to_excel'); ?>" class="btn btn-success me-2">
                        <i class="fas fa-file-excel"></i> Download Spreadsheet
                    </a>
                    <a href="<?php echo site_url('users/export_news_articles_to_pdf'); ?>" class="btn btn-warning">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Journalist</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news_articles as $article): ?>
                            <tr>
                                <td><?php echo $article['id']; ?></td>
                                <td><?php echo $article['title']; ?></td>
                                <td><?php echo word_limiter($article['content'], 20); ?></td>
                                <td><?php echo $article['first_name'] . ' ' . $article['last_name']; ?></td>
                                <td><?php echo $article['category_name']; ?></td>
                                <td><?php echo $article['tag_names']; ?></td>
                                <td><?php echo $article['updated_at']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($article['status'] == 'pending') ? 'warning' : (($article['status'] == 'approved') ? 'success' : (($article['status'] == 'published') ? 'info' : 'danger')); ?>">
                                        <?php echo ucfirst($article['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>