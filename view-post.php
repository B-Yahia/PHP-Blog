<?php

declare(strict_types=1);
require_once "lib/common.php";
require_once "lib/view-post.php";


session_start();
$result;
$msgs = [];
$query = "SELECT * FROM post WHERE id = ?";
if (!$conn) {
    $conn = getConnectionInst();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = 0;
}

if ($conn->connect_error) {
    array_push($msgs, $conn->connect_error);
} else {
    $result = getPostRow($conn, $id);
}
// If the post does not exist, let's deal with that here
if (!$result) {
    redirectAndExit('index.php?not-found=1');
}
$errors = null;
if ($_POST) {
    switch ($_GET['action']) {
        case 'add-comment':
            $commentData = array(
                'name' => $_POST['comment-name'],
                'website' => $_POST['comment-website'],
                'text' => $_POST['comment-text'],
            );
            $errors = addCommentToPost(
                $conn,
                $commentData,
                $id
            );
            break;
        case 'delete-comment':
            $element = $_POST["delete-comment"];
            handleDeleteComment($conn, $id, $element);
            break;
    }

    // If there are no errors, redirect back to self and redisplay
    if (!$errors) {
        redirectAndExit('view-post.php?id=' . $id);
    }
} else {
    $commentData = array(
        'name' => "",
        'website' => "",
        'text' => "",
    );
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Post <?php echo htmlEscape($result['title']) ?></title>
    <?php require 'templates/head.php' ?>
</head>

<body>
    <?php foreach ($msgs as $msg) : ?>
        <p><?php echo $msg ?></p>
    <?php endforeach ?>
    <?php require "templates/title.php"; ?>
    <div class="post">
        <h2>Blog title : <?php echo htmlEscape($result['title']) ?></h2>
        <p class="date"><?php echo htmlEscape($result['created_at']) ?></p>
        <p><?php echo convertNewlinesToParagraphs($result['body']) ?></p>
    </div>

    <?php require "templates/list-comments.php" ?>
    <?php require "templates/comment-form.php" ?>
</body>

</html>