<?php
session_start();
require_once "./util/errorExists.php";
if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name   = $_SESSION["username"];
$userId = $_SESSION["userId"];
require "./connect.php";
$connection = connect();

$sql = "SELECT * FROM `friends` WHERE `friends`.`userId` =:id OR `friends`.`friendId` =:id;";

$stmt = $connection->prepare($sql);

$stmt->execute(['id' => $userId]);
$friends = $stmt->fetchAll();

$connection = null;

if (!isset($_SESSION['errors'])) {

    $_SESSION['errors'] = ['comment' => false, 'post' => false, 'postImage' => false];
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Logged in</title>
        <?php require "./partials/_head.php"; ?>



    </head>

    <body>
        <?php require "./partials/navbar.php" ?>
        <div class="logged-wrapper">
            <?php require "./partials/user.php"; ?>
            <main class="main">
                <?php require "./partials/post-form.php"; ?>
                <?php require "./partials/posts.php"; ?>
            </main>
        </div>

        <script src="./javascript/toggler.js"></script>
        <script src="./javascript/validation.js"></script>
        <script src="./javascript/counting.js"></script>
    </body>

</html>
