<?php
try {
    $connection = connect();
    $sql        = "SELECT username,id,profilePicture FROM users WHERE id=:id";

    $stmt = $connection->prepare($sql);
    $id   = $post->posterId;
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}
?>


<section class="post">
    <section class="post-content">
    <div class="post-top">

            <img class="user-image--post" src="./images/defaultProfilePictures/<?php echo ($user->profilePicture) ?>" alt="">


        <div class="post-cont">
            <div class="post-info-text">
                <p class="post-username"> <?php echo ($user->username); ?></p>
                <p class="post-timestamp"><?php echo (substr($post->timestamp, 0, 10)); ?></p>
            </div>

            <p class="post-text">
                <?php echo ($post->content); ?>

            </p>

        </div>

    </div>
        <img class="post-image" src="./images/post/<?php echo ($post->pictureName); ?>" alt="">
    </section>



    <?php require "./partials/comment.php"; ?>
</section>
