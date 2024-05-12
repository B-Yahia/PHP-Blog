<?php

require_once "common.php";

function getPostRow(mysqli $conn, $id)
{
    $stmt = $conn->prepare(
        'SELECT
            title, created_at, body
        FROM
            post
        WHERE
            id = ?'
    );
    if ($stmt === false) {
        throw new Exception('There was a problem preparing this query');
    }
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result === false) {
        throw new Exception('There was a problem running this query');
    }
    return $stmt->get_result()->fetch_assoc();
}

function addCommentToPost(mysqli $conn, array $commentData, $id)
{
    $errors = array();
    // Data validation
    if (empty($commentData['name'])) {
        $errors['name'] = 'A name is required';
    }
    if (empty($commentData['text'])) {
        $errors['text'] = 'A comment is required';
    }
    // If we are error free, try writing the comment
    if (!$errors) {
        $sql = "
            INSERT INTO
                comment
            (name, website, text, created_at,post_id)
            VALUES(?, ?, ?,?, ?)
        ";

        $stmt = $conn->prepare($sql);
        $createdTimestamp = getSqlDateForNow();
        if ($stmt === false) {
            throw new Exception('Cannot prepare statement to insert comment');
        }
        $stmt->bind_param("ssssi", $commentData['name'], $commentData['website'], $commentData['text'], $createdTimestamp, $id);
        $result = $stmt->execute();
        if ($result === false) {
            $errorInfo = $stmt->error;
            if ($errorInfo) {
                $errors[] = $errorInfo;
            }
        }
        $stmt->close();
    }
    return $errors;
}

function deleteComment(mysqli $conn, $postId, $commentId)
{
    // The comment id on its own would suffice, but post_id is a nice extra safety check
    $sql = "
        DELETE FROM
            comment
        WHERE
            post_id = ?
            AND id = ?
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('There was a problem preparing this query');
    }
    $stmt->bind_param("ii", $postId, $commentId);
    $result = $stmt->execute();
}
function handleDeleteComment(mysqli $conn, $postId, $response)
{
    if (isLoggedIn()) {
        deleteComment($conn, $postId, array_keys($response)[0]);
        redirectAndExit('view-post.php?id=' . $postId);
    }
}
