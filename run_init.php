<?php

include 'functions.php';
require_once "lib/common.php";

$error=[];
$msg=[];
    // Create Connection
$conn = getConnectionInst();
$sql = file_get_contents('data/init.sql');
    

if($conn->connect_error){
    array_push($error, "Connection failed: " . $conn->connect_error);
}else{
    array_push($msg,"connection established");
}

$checkIfPostTablesExsitResult = $conn->query("show tables like 'post'");
$checkIfCommentTablesExsitResult = $conn->query("show tables like 'comment'");
$checkIfUserTablesExsitResult = $conn->query("show tables like 'user'");

if($checkIfPostTablesExsitResult->num_rows>0 &&
 $checkIfCommentTablesExsitResult->num_rows>0 && 
 $checkIfUserTablesExsitResult->num_rows>0){

    array_push($error,"Tables are already created");
}else{
    try{
        $conn->multi_query($sql);
        do
        {
            
        } while ($conn->next_result());  
        array_push($msg,"Tables created");
    }catch(Exception $exception){
        echo $exception->getMessage();
    }
    
}
$numOfUsersInUserTable = $conn->query("select count(id) from user");

if ($checkIfUserTablesExsitResult->num_rows>0 && $numOfUsersInUserTable->fetch_assoc()["count(id)"]<2)
{
    array_push($msg,"Admin user account has been created");
    $error = array_merge($error, createUser($conn,array(
        'username' => 'admin1',
        'password' => password_hash('password',PASSWORD_DEFAULT)
    )));
}




?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php if (count($error)>0): ?>
            <?php foreach($error as $e): ?>
            <div class="error box">
                <?php echo $e ?>
            </div>
            <?php endforeach ?>
        <?php  endif?>
        
        <?php if(count($msg)>0): ?>
            <?php foreach($msg as $e): ?>
            <div class="success box">
                <?php echo $e?>
            </div>
            <?php endforeach ?>
        <?php endif ?>
        <p>
            <a href="index.php">View the blog</a>
        </p>
    </body>
</html>