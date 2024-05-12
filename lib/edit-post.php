<?php
function addPost(mysqli $mysqli, $title, $body, $userId)
{
    $sql = "INSERT INTO post (title, body, user_id, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $createdTimestamp = getSqlDateForNow();
    if ($stmt === false) {
        throw new Exception('Cannot prepare statement to insert comment');
    }
    $stmt->bind_param("ssis", $title, $body, $userId, $createdTimestamp);
    $result = $stmt->execute();
    if ($result === false) {
        throw new Exception('Could not run post insert query');
    }
    return $mysqli->insert_id;
}

function editPost(mysqli $mysqli, string $title, string $body, int $postId)
{
    $sql = "UPDATE post SET title = ? , body=? WHERE id =?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Cannot prepare statement to insert comment');
    }
    $stmt->bind_param("ssi", $title, $body, $postId);
    $result = $stmt->execute();
    if ($result === false) {
        throw new Exception('Could not run post insert query');
    }
}
