<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>News Articles</title>
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
    <h1 style="text-align: center;">News Articles</h1>
    <table>
        <thead>
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
                    <td><?php echo ucfirst($article['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>