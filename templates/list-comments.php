<form action="view-post.php?action=delete-comment&amp;id=<?php echo $id ?>&amp;" method="post" class="comment-list">
    <h3><?php echo count(getPostComments($conn, $id)) ?> comments</h3>
    <?php foreach (getPostComments($conn, $id) as $comment) : ?>
        <div class="comment">
            <div class="comment-meta">
                Comment from
                <?php echo htmlEscape($comment['name']) ?>
                on
                <?php echo $comment['created_at'] ?>
            </div>
            <?php if (isLoggedIn()) : ?>
                <input type="submit" name="delete-comment[<?php echo $comment['id'] ?>]" value="Delete" />
            <?php endif ?>
            <div class="comment-body">
                <?php echo convertNewlinesToParagraphs($comment['text']) ?>
            </div>
        </div>
    <?php endforeach ?>
</form>