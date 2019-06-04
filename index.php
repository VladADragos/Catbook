<?php session_start(); ?>
<?php

if (isset($_SESSION["isLoggedIn"]) && isset($_SESSION["isLoggedIn"])) {
    header('Location: logged.php');
} ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Catbook - The Feline Social Network </title>
        <?php require "./partials/_head.php"; ?>
        <script type="text/javascript" src="./JavaScript/validation.js"></script>
    </head>

    <body>
        <div class="login">
            <!-- Navbar -->
            <?php require "./partials/navbar.php"; ?>
            <!-- Body -->
            <?php require "./partials/login-main.php"; ?>
            <!-- Footer -->
            <?php require "./partials/footer.php"; ?>

        </div>
    </body>

</html>
