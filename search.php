<?php

session_start();

require_once "./connect.php";
if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name                    = $_SESSION["username"];
$_SESSION["isSearching"] = true;
$id                      = $_SESSION["userId"];
if (isset($_POST['search-button'])) {

    try {
        $connection = connect();

        $username = htmlentities($_POST['search-input']);

        $searchParameter = "username";
        if (isset($_POST["email"])) {
            $searchParameter = "email";
        } elseif (isset($_POST["phoneNumber"])) {
            $searchParameter = "phoneNumber";
        }

        $sql = "SELECT id,username,profilePicture FROM users WHERE $searchParameter LIKE :username";

        $stmt = $connection->prepare($sql);
        $stmt->execute(['username' =>
            "$username%"]);
        $users = $stmt->fetchAll();

        $_SESSION['searchBuffer'] = $users;
        $connection               = null;

    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function isNotFriend($friendId)
{
    $connection = connect();
    $sql        = "SELECT * FROM `friends` WHERE `friends`.`userId` =:friendId AND `friends`.`friendId` =:userId OR `friends`.`userId` =:userId AND `friends`.`friendId` =:friendId";

    $stmt = $connection->prepare($sql);

    $stmt->execute(['userId' => $_SESSION['userId'], 'friendId' => $friendId]);
    $friend = $stmt->fetchAll();

    return $friend == null;
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

<?php if (!isset($_SESSION['searchBuffer'])) { ?>
<h4>No users found</h4>
<?php } ?>

            </section>
            <?php if (isset($_SESSION['searchBuffer'])) { ?>
            <?php foreach ($_SESSION['searchBuffer'] as $user) { ?>







                <?php if ($user->id !== $_SESSION['userId']) { ?>
            <section class="searched-user">
                    <a class="temp" href="./user.php?user=<?php echo ($user->id); ?>">
                    <img class="searched-user__image" src="./images/defaultProfilePictures/<?php echo ($user->profilePicture); ?>">
                    </a>

                    <a href="./user.php?user=<?php echo ($user->id); ?>">
                    <h4 class="searched-user__link"><?php echo $user->username; ?></h4>
                    </a>
                    <?php if (isNotFriend($user->id)) { ?>

                        <form action="./process.php" method="POST" name="befriend-form" id="befriend-form">
                    <input type="hidden" name="userId" value="<?php echo ($_SESSION["userId"]); ?>">
                    <input type="hidden" name="friendId" value=<?php echo "$user->id"; ?>>
                    <input type="hidden" name="friendName" value=<?php echo "$user->username"; ?>>
                    <button name="befriend-button" type="submit" from="befriend-form" class="button button--add-friend">

                        <i class="material-icons searched-user__befreind-icon">person_add</i>
                    </button>
                </form>
                    <?php } else { ?>
                    <p></p>
                <?php } ?>

            </section>
                <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </body>

</html>
