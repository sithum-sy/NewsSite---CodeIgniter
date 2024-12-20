<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Journalists</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Journalists Report</h1>
    <table>
        <thead>
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
</body>

</html>