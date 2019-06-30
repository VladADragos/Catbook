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
                <a href="user.php?user=<?php echo ($user->id) ?>">
                        <p class="post-username"> <?php echo ($user->username); ?></p>
            </a>
                <p class="post-timestamp"><?php echo (substr($post->timestamp, 0, 10)); ?></p>
            </div>

            <p class="post-text">
                <?php echo ($post->content); ?>
            </p>

        </div>

        <?php if ($post->posterId == $_SESSION['userId']) { ?>

            <div class="more more--post">

                <button class="button--clear more-toggler" onclick="toggle(event)">
                    <i class="material-icons more-toggler__icon">more_vert</i>
                </button>
                <div class="more-panel">

                    <form  name="delete-post-form" action="process.php" method="POST" >
                                <input type="hidden" name="postId" value="<?php echo ($post->id); ?>">
                                <input type="hidden" name="pictureName" value="<?php echo ($post->pictureName); ?>">
                                <button class="button--clear more-option" name="delete-post-button">
                                <i class="material-icons more-option__icon">delete_outline</i> Delete
                                </button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
        <img class="post-image" src="./images/post/<?php echo ($post->pictureName); ?>" alt="">
    </section>



    <?php require "./partials/comments.php"; ?>
</section>
