	<?php
    require_once 'lib/common.php';
    require_once "env.php";
    require_once 'lib/edit-post.php';
    require_once 'lib/view-post.php';

    session_start();
    if (!isLoggedIn()) {
        redirectAndExit('index.php');
    }
    $conn = getConnectionInst();
    $title = $body = '';
    $errors = array();

    if (isset($_GET['id'])) {
        $post = getPostRow($conn, $_GET['id']);
        if ($post) {
            $title = $post['title'];
            $body = $post['body'];
        }
    }

    if ($_POST) {
        $title = $_POST['post-title'];
        if (!$title) {
            $errors[] = 'The post must have a title';
        }
        $body = $_POST['post-body'];
        if (!$body) {
            $errors[] = 'The post must have a body';
        }
        if (!$errors) {
            if (isset($_GET['id'])) {
                editPost($conn, $title, $body, $_GET['id']);
                $postId = $_GET['id'];
            } else {
                $userId = getAuthUserId($conn);
                $postId = addPost($conn, $title, $body, $userId);
                if ($postId === false) {
                    $errors[] = 'Post operation failed';
                }
            }
        }
        if (!$errors) {
            redirectAndExit('edit-post.php?id=' . $postId);
        }
    }
    ?>
	<!DOCTYPE html>
	<html>

	<head>
	    <title>A blog application | New post</title>
	    <?php require 'templates/head.php' ?>
	</head>

	<body>
	    <?php require 'templates/top-menu.php' ?>
	    <?php if (isset($_GET['id'])) : ?>
	        <h1>Edit post</h1>
	    <?php else : ?>
	        <h1>New post</h1>
	    <?php endif ?>
	    <?php if ($errors) : ?>
	        <div class="error box">
	            <ul>
	                <?php foreach ($errors as $error) : ?>
	                    <li><?php echo $error ?></li>
	                <?php endforeach ?>
	            </ul>
	        </div>
	    <?php endif ?>
	    <form method="post" class="post-form user-form">
	        <div>
	            <label for="post-title">Title:</label>
	            <input id="post-title" name="post-title" type="text" value="<?php echo $title ?>" />
	        </div>
	        <div>
	            <label for="post-body">Body:</label>
	            <textarea id="post-body" name="post-body" rows="12" cols="70"><?php echo $body ?></textarea>
	        </div>
	        <div>
	            <input type="submit" value="Save post" />
	            <a href="index.php">Cancel</a>
	        </div>
	    </form>
	</body>

	</html>