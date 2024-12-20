<div class="container-fluid admin-dashboard">
    <div class="row mb-4">
        <div class="col text-start">
            <a href="<?php echo site_url('dashboard'); ?>" class="dashboard-heading-link">
                <h1 class="dashboard-heading">Admin Dashboard</h1>
            </a>
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
                    <form method="GET" action="<?php echo site_url('users/get_all_journalists'); ?>">
                        <div class="mb-3">
                            <label for="journalist" class="form-label">Journalist</label>
                            <input type="text" name="journalist" id="journalist" class="form-control" placeholder="Search by journalist">
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Submission Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="<?php echo site_url('users/get_all_journalists'); ?>" class="btn btn-secondary">Remove Filters</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content: Table and heading -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="my-4">Journalists Report</h3>
                <div>
                    <a href="<?php echo site_url('users/export_journalists_to_excel') .
                                    ($this->input->get('journalist') ? '?journalist=' . urlencode($this->input->get('journalist')) : '') .
                                    ($this->input->get('date') ? '&date=' . urlencode($this->input->get('date')) : ''); ?>"
                        class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Download Spreadsheet
                    </a>
                    <a href="<?php echo site_url('users/export_journalists_to_pdf') .
                                    ($this->input->get('journalist') ? '?journalist=' . urlencode($this->input->get('journalist')) : '') .
                                    ($this->input->get('date') ? '&date=' . urlencode($this->input->get('date')) : ''); ?>" class="btn btn-warning">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Journalist</th>
                            <th>Article Count</th>
                            <th>Latest Submission Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($journalists as $journalist): ?>
                            <tr>
                                <td><?php echo $journalist['id']; ?></td>
                                <td><?php echo $journalist['first_name'] . ' ' . $journalist['last_name']; ?></td>
                                <td><?php echo $journalist['article_count']; ?></td>
                                <td><?php echo $journalist['latest_submission_date']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($journalist['is_active']) ? 'success' : 'warning'; ?>">
                                        <?php echo ($journalist['is_active']) ? 'Active' : 'Inactive'; ?>
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