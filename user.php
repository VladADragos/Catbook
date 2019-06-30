<?php
session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
require "./connect.php";

try {
    $connection = connect();
    $id         = $_GET['user'];
    $sql        = "SELECT id,username,profilePicture FROM users WHERE id=:userId";

    $stmt = $connection->prepare($sql);

    $stmt->execute(['userId' => $id]);

    $user = $stmt->fetch();

    $sql = "SELECT * FROM posts WHERE posterId=:userId ORDER BY timestamp DESC";

    $stmt = $connection->prepare($sql);

    $stmt->execute(['userId' => $id]);
    $posts = $stmt->fetchAll();

    $connection = null;
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
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
        <aside class="user-profile">
    <section class="user">
        <img class="user__image" src="./images/defaultProfilePictures/<?php echo ($user->profilePicture); ?>" alt="Profile picture">
        <h2 class="user__header"><?php echo $user->username; ?> </h2>
    </section>

    <section class="friends">
        <h3 class="friends__header">Friends</h3>
        <!-- <?php foreach ($friends as $friend) { ?>

            <?php require "./partials/_friend.php"; ?>
            <?php }
; ?>
        <?php if (count($friends) === 0) {echo ("<p>No friends found<p>");} ?>
 -->



            </section>

</aside>



            <main class="main">
               <section class="posts">
    <?php if (count($posts) == 0) { ?>
    <?php echo ("<p>no posts</p>");} ?>
    <?php foreach ($posts as $post) { ?>
    <?php require "./partials/post.php"; ?>


    <?php }
; ?>
</section>
            </main>
        </div>


    </body>

</html>
