<?php
require_once 'lib/common.php';
session_start();
$conn = getConnectionInst();
if (!isLoggedIn()) {
    redirectAndExit('');
}
$result = getAllPosts($conn);

if ($_POST) {
    $element = $_POST['delete-post'];
    if ($element) {
        deletePostById(getConnectionInst(), array_keys($element)[0]);
        redirectAndExit('list-posts.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>A blog application | Blog posts</title>
    <?php require 'templates/head.php' ?>
</head>

<body>
    <?php require 'templates/top-menu.php' ?>
    <h1>Post list</h1>
    <p>You have <?php echo getPostsCount($conn); ?> : </p>
    <form method="post">
        <table id="post-list">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Creation date</th>
                    <th>Comments</th>
                    <th />
                    <th />
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $post) : ?>
                    <tr>
                        <td><a href="view-post.php?id=<?php echo $post['id'] ?>"><?php echo htmlEscape($post['title']) ?> </a></td>
                        <td>
                            <?php echo htmlEscape($post['created_at']) ?>
                        </td>
                        <td><?php echo htmlEscape($post['comment_count']) ?> </td>
                        <td>
                            <a href="edit-post.php?id=<?php echo htmlEscape($post['id']) ?>">Edit</a>
                        </td>
                        <td>
                            <input type="submit" name="delete-post[<?php echo $post['id'] ?>]" value="Delete" />
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </form>
</body>

</html>