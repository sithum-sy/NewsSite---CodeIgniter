<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-News</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background-color: #f4f6f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        .news-content {
            margin: 0;
            padding: 0;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .dashboard {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .user-details {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .profile-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .profile-details {
            padding: 20px;
        }

        .detail-label {
            font-weight: bold;
            color: #6c757d;
        }

        .btn-back {
            margin-bottom: 15px;
        }

        .user-edit {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .form-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .form-body {
            padding: 20px;
        }

        .btn-back {
            margin-bottom: 15px;
        }

        .admin-dashboard {
            padding-top: 30px;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .table-actions .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .status-badge {
            font-size: 0.8em;
            padding: 0.3em 0.6em;
        }

        @media (max-width: 768px) {
            .admin-dashboard .row {
                flex-direction: column;
            }

            .create-user-section,
            .user-management-section {
                width: 100%;
                margin-bottom: 20px;
            }
        }

        .table-actions .btn {
            margin-right: 5px;
        }

        .header-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Hide the buttons when printing */
        @media print {

            .header-buttons,
            .footer-button,
            .header-buttons button,
            .header-buttons a {
                display: none;
            }
        }

        .dashboard-heading {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="main-content">

            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
                <div class="container-fluid">
                    <a class="navbar-brand text-uppercase fw-bold" href="<?php echo site_url('home'); ?>">
                        <i class="fas fa-newspaper"></i> X News
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo site_url('news/category/world'); ?>"><i class="fas fa-globe"></i> World</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('news/category/business'); ?>"><i class="fas fa-briefcase"></i> Business</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('news/category/technology'); ?>"><i class="fas fa-laptop"></i> Technology</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('news/category/sports'); ?>"><i class="fas fa-futbol"></i> Sports</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('about'); ?>"><i class="fas fa-info-circle"></i> About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('contact'); ?>"><i class="fas fa-envelope"></i> Contact</a>
                            </li>
                            <?php if ($this->session->userdata('logged_in')): ?>
                                <li class="nav-item">
                                    <a class="nav-link text-success" href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-user"></i> Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger" href="<?php echo site_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link text-primary" href="<?php echo site_url('login'); ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="<?php echo site_url('register'); ?>"><i class="fas fa-user-plus"></i> Register</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>