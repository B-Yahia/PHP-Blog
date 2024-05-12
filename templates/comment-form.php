<?php if ($errors) : ?>
    <div class="box error comment-margin">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
<h3>Add your comment</h3>
<form method="post" class="comment-form user-form" action="view-post.php?action=add-comment&amp;id=<?php echo $id ?>">
    <div>
        <label for="comment-name">
            Name:
        </label>
        <input type="text" id="comment-name" name="comment-name" value="<?php echo $commentData['name'] ?>" />
    </div>
    <div>
        <label for="comment-website">
            Website:
        </label>
        <input type="text" id="comment-website" name="comment-website" value="<?php echo $commentData['website'] ?>" />
    </div>
    <div>
        <label for="comment-text">
            Comment:
        </label>
        <textarea id="comment-text" name="comment-text" rows="8" cols="70"> <?php echo $commentData['text'] ?></textarea>
    </div>
    <div>
        <input type="submit" value="Submit comment" />
    </div>
</form>