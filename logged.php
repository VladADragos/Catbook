<?php
session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name   = $_SESSION["username"];
$userId = $_SESSION["userId"];
require "./connect.php";
$connection = connect();
$sql        = "SELECT friendId,friendName FROM friends WHERE userId=$userId";

$stmt = $connection->prepare($sql);

$stmt->execute();
$friends    = $stmt->fetchAll();
$connection = null;
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
        <script>
        const count = (e) => {
            let input = e.target.value;
            let length = input.length;
            return length;
        }

        const write = (target, length) => {

            let output = document.querySelector(`.${target}`);
            output.innerText = length;
        }

        const handleCounting = (e) => {
            let output = `${e.target.name}__counter`;
            let length = count(e);
            write(output, length);
        }


        const logger = (event) => {
            let value = event.target.value;
            console.log(value + " " + (typeof value));
            if (value === "") {
                console.log("nuffin");
            }
            let icon = document.querySelector(".fa-camera");
            icon.style.color = "#067DBD";

        }
        </script>

    </body>

</html>
