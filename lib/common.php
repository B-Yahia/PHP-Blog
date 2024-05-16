<?php
function dd(mixed $value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}
function getAllPosts(mysqli $conn)
{
    $stmt = "SELECT id,title,created_at,body,(SELECT count(*) FROM comment WHERE comment.post_id=post.id)comment_count FROM post";
    $resultSet = $conn->query($stmt);
    return $resultSet->fetch_all(MYSQLI_ASSOC);
}

function getPostsCount(mysqli $conn)
{
    return count(getAllPosts($conn));
}

function getPostComments(mysqli $conn, $id)
{
    $sql = "select * from comment where post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
function convertNewlinesToParagraphs($text)
{
    $escaped = htmlEscape($text);
    return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
}

function redirectAndExit($script)
{
    // Get the domain-relative URL (e.g. /blog/whatever.php or /whatever.php) and work
    // out the folder (e.g. /blog/ or /).
    $relativeUrl = $_SERVER['PHP_SELF'];
    $urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
    // Redirect to the full URL (http://myhost/blog/script.php)
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location: ' . $fullUrl);
    exit();
}
function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}
function createUser(mysqli $conn, array $userData)
{
    $errors = array();
    //Validate user data
    if (empty($userData['username'])) {
        array_push($errors, "Username can not be empty");
    }
    if (empty($userData['password'])) {
        array_push($errors, "Password can not be empty");
    }

    if (!$errors) {
        $sql = "INSERT INTO user (username,password,created_at) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Cannot prepare statement to insert comment');
        }
        $createdTimestamp = getSqlDateForNow();

        $stmt->bind_param("sss", $userData['username'], $userData['password'], $createdTimestamp);
        try {
            $result = $stmt->execute();
        } catch (Exception $e) {
            array_push($errors, $e->getMessage());
            echo $e->getMessage();
        }

        if ($result === false) {
            array_push($errors, "User " . $userData["username"] . " has not been created");
        }
    }
    return $errors;
}

function tryLogin(mysqli $mysqli, string $username, string $password)
{
    $sql = "SELECT password FROM user WHERE username = ? and is_enabled = 1";
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Cannot prepare statement to insert comment');
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return password_verify($password, $result['password']);
}

function login($username)
{
    session_regenerate_id();
    $_SESSION['logged_in_username'] = $username;
}

function isLoggedIn()
{
    return isset($_SESSION['logged_in_username']);
}

function logout()
{
    unset($_SESSION['logged_in_username']);
}
function getAuthUser()
{
    return isLoggedIn() ? $_SESSION['logged_in_username'] : null;
}

function getAuthUserId(mysqli $mysqli)
{
    if (!isLoggedIn()) {
        return null;
    }
    $sql = "SELECT id FROM user WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Cannot prepare statement to insert comment');
    }
    $username = getAuthUser();
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['id'];
}

function deletePostById(mysqli $mysqli, int $id)
{
    $queries = array("DELETE FROM comment WHERE post_id=?", "DELETE FROM post WHERE id = ?");
    foreach ($queries as $query) {
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
    }
}
