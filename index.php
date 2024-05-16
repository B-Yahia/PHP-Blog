<?php
require_once "lib/common.php";
require_once "env.php";

session_start();
$conn = getConnectionInst();
$rslt = getAllPosts($conn);
$notFound = isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html>

<head>
    <title>A blog application</title>
    <?php require "templates/head.php" ?>
</head>

<body>
    <?php require "templates/title.php"; ?>
    <?php if ($notFound) : ?>
        <div class="error box">
            Error: cannot find the requested blog post
        </div>
    <?php endif ?>
    <div class="post-list">
        <?php foreach ($rslt as $row) : ?>
            <div class="post-synopsis">
                <h2><?php echo htmlEscape($row['title']) ?></h2>
                <p class="meta"><?php echo htmlEscape($row['created_at']) ?></p>
                <p class="meta"> Number of comments : <?php echo htmlEscape($row['comment_count']) ?> </p>
                <p class="post-controls">
                    <a href="view-post.php?id=<?php echo htmlspecialchars($row['id']) ?>"> Read more...</a>
                    <?php if (isLoggedIn()) : ?>
                        <a href="edit-post.php?id=<?php echo htmlspecialchars($row['id']) ?>"> Edit</a>
                    <?php endif ?>
                </p>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>