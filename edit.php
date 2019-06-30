<?php
session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name   = $_SESSION["username"];
$userId = $_SESSION["userId"];

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Logged in</title>
        <?php require "./partials/_head.php"; ?>



    </head>

    <body>
        <?php require "./partials/navbar.php" ?>

        <main class="login-main">
            <form action="./process.php" method="POST" class="register-form" name="edit-form" autocomplete="off"
                id="register-form">
                <h2 class="register-form__header">Edit <i class="fas fa-cat"></i></h2>
                <div class="input-container margin--top">
                    <label for="username" class="form-label register-form__label">
                        Username
                    </label>

                    <input autocomplete="off" type="text" value="<?php echo ($_SESSION["username"]); ?>" name="username"
                        class="form-input register-form__input" form="register-form" />
                </div>

                <div class="input-container margin--top">
                    <label for="password" class="form-label register-form__label">
                        New password
                    </label>
                    <input autocomplete="off" type="password" name="password" class="form-input register-form__input"
                        form="register-form" />
                </div>
                <input autocomplete="off" type="hidden" value="<?php echo ($_SESSION["userId"]); ?>" name="id"
                    class="form-input register-form__input" form="register-form" />
                <button type="submit" name="edit-button" class="button button--primary button--register">
                    edit
                </button>
            </form>
        </main>

    </body>

</html>
