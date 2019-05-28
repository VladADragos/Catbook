<?php

session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name                    = $_SESSION["username"];
$_SESSION["isSearching"] = true;
$id                      = $_SESSION["userId"];

if (isset($_POST['search-button'])) {

    try {
        require "./connect.php";
        $connection = connect();

        $username = htmlentities($_POST['search-input']);

        $searchParameter = "username";
        if (isset($_POST["email"])) {
            $searchParameter = "email";
        } elseif (isset($_POST["phoneNumber"])) {
            $searchParameter = "phoneNumber";
        }

        $sql = "SELECT * FROM users WHERE $searchParameter LIKE :username";

        $stmt = $connection->prepare($sql);
        $stmt->execute(['username' =>
            "$username%"]);
        $users      = $stmt->fetchAll();
        $connection = null;

    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php require "./partials/_head.php"; ?>
    <script src="./JavaScript/searchFunction.js">
    </script>
    <title>Logged in</title>

  </head>
  <body>
  <?php require "./partials/navbar.php" ?>
  <div class="users">

  <section class="searched-user">

    <label for="username">username</label><input form="search-form" name="username" id="username" type="checkbox">
    <label for="phoneNumber">phone number</label><input form="search-form" name="phoneNumber" id="phoneNumber" type="checkbox">
    <label for="email">email</label><input form="search-form" name="email" id="email" type="checkbox">
    <?php if (isset($_POST['all'])) {
    echo "all";
} elseif (isset($_POST['some'])) {
    echo "some";
}

?>
        </section>
    <?php if (isset($_POST['search-button']) && isset($users)) { ?>
        <?php foreach ($users as $user) { ?>

        <section class="searched-user">
            <img class="searched-user__image" src="https://picsum.photos/80/80/?random">
            <a class="searched-user__link" href="user.php/<?php echo $user->username; ?>"><?php echo $user->username; ?></a>
            <form action="./process.php" method="POST" name="befriend-form" id="befriend-form">


            <input type="hidden" name="userId" value=<?php echo "$id"; ?>> <!-- userId -->
            <input type="hidden" name="friendId" value=<?php echo "$user->id"; ?>> <!-- friendId -->
            <input type="hidden" name="friendName" value=<?php echo "$user->username"; ?>> <!-- friendName -->
            <button name="befriend-button" type="submit" from="befriend-form">

            <?php require "./images/add-friend.svg"; ?>
            </button >
            </form>


        </section>






        <?php } ?>
    <?php } ?>


    </div>
  </body>
</html>
