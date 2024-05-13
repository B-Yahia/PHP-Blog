<?php
require_once 'lib/common.php';
$username = '';

session_start();
if (isLoggedIn()) {
    redirectAndExit('index.php');
}

if ($_POST) {
    $conn = getConnectionInst();
    $username = $_POST['username'];
    $ok = tryLogin($conn, $username, $_POST['password']);
    if ($ok) {
        login($username);
        redirectAndExit('index.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        A blog application | Login
    </title>
    <?php require 'templates/head.php' ?>
</head>

<body>
    <?php require 'templates/title.php' ?>
    <?php if ($username) : ?>
        <div class="error box">
            The username or password is incorrect, try again
        </div>
    <?php endif ?>
    <p>Login here:</p>
    <form method="post">
        <div>
            <label for="username">
                Username:
            </label>
            <input type="text" name="username" id="username" />
        </div>
        <div>
            <label for="password">
                Password:
            </label>
            <input type="password" name="password" id="password" />
        </div>
        <input type="submit" name="submit" value="Login" />
    </form>
</body>

</html>