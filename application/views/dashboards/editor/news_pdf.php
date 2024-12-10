<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $news_item['title']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .content {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <h1><?php echo $news_item['title']; ?></h1>
        <p><strong>Category:</strong> <?php echo $news_item['category_name']; ?></p>
        <p><strong>Tags:</strong> <?php echo $news_item['tag_names']; ?></p>
        <p><strong>Journalist:</strong> <?php echo $news_item['first_name'] . ' ' . $news_item['last_name']; ?></p>
        <p><strong>Submission Date:</strong> <?php echo $news_item['updated_at']; ?></p>
        <hr>
        <p><?php echo nl2br($news_item['content']); ?></p>
    </div>
</body>

</html>